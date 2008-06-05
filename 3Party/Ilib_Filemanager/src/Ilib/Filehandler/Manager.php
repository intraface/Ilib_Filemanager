<?php
/**
 * @package Intraface_FileManager
 */
class Ilib_Filehandler_Manager extends Ilib_Filehandler
{
    /**
     * @var object
     */
    public $keywords;

    /**
     * @var object
     */
    protected $dbquery;

    /**
     * @var string
     */
    public $fileviewer_path;

    /**
     * Constructor
     *
     * @param object  $kernel  Kernel object
     * @param integer $file_id Specific file id
     *
     * @return void
     */
    public function __construct($kernel, $file_id = 0)
    {
        parent::__construct($kernel, $file_id);
        $this->fileviewer_path = FILE_VIEWER;
    }

    /**
     * Creates the dbquery object so it can be used in the class
     *
     * @return void
     */
    public function getDBQuery()
    {
        if ($this->dbquery) return $this->dbquery;
        $this->dbquery = new Ilib_DBQuery("file_handler", "file_handler.temporary = 0 AND file_handler.active = 1 AND file_handler.intranet_id = ".$this->kernel->intranet->get("id"));
        $this->dbquery->createStore($this->kernel->getSessionId(), 'intranet_id = '.intval($this->kernel->intranet->get('id')));
        $this->dbquery->useErrorObject($this->error);
        return $this->dbquery;
    }


    /**
     * Creates the keywords object
     *
     * @return object
     */
    public function getKeywords()
    {
        return ($this->keywords = new Keyword($this));
    }

    public function getKeywordAppender()
    {
        return new Intraface_Keyword_Appender($this);
    }


    /**
     * Gets a list
     *
     * @param string $debug Can be nothing or debug
     *
     * @return array
     */
    public function getList($debug = '')
    {
        // we load the mime types as they are going to be used a couple of times
        $this->loadMimeTypes();

        if ($this->getDBQuery()->checkFilter("uploaded_from_date")) {
            $date_parts = explode(" ", $this->getDBQuery()->getFilter("uploaded_from_date"));
            // Der kontrolleres ikke for gyldig tidsformat
            if (isset($date_parts[1]) && $date_parts[1] != "") $time = " ".$date_parts[1];
            $date = new Ilib_Date($date_parts[0]);
            if ($date->convert2db()) {
                $this->getDBQuery()->setCondition("file_handler.date_created >= \"".$date->get().$time."\"");
            } else {
                $this->error->set("error in uploaded from date");
            }
        }

        if ($this->getDBQuery()->checkFilter("uploaded_to_date")) {
            $date_parts = explode(" ", $this->dbquery->getFilter("uploaded_to_date"));
            // Der kontrolleres ikke for gyldig tidsformat
            if (isset($date_parts[1]) && $date_parts[1] != "") $time = " ".$date_parts[1];
            $date = new Ilib_Date($date_parts[0]);
            if ($date->convert2db()) {
                $this->getDBQuery()->setCondition("file_handler.date_created <= \"".$date->get().$time."\"");
            } else {
                $this->error->set("error in uploaded to date");
            }
        }

        if ($this->getDBQuery()->checkFilter("edited_from_date")) {
            $date_parts = explode(" ", $this->dbquery->getFilter("edited_from_date"));
            // Der kontrolleres ikke for gyldig tidsformat
            if (isset($date_parts[1]) && $date_parts[1] != "") $time = " ".$date_parts[1];
            $date = new Ilib_Date($date_parts[0]);
            if ($date->convert2db()) {
                $this->getDBQuery()->setCondition("file_handler.date_changed >= \"".$date->get().$time."\"");
            } else {
                $this->error->set("error in edited from date");
            }
        }

        if ($this->getDBQuery()->checkFilter("edited_to_date")) {
            $date_parts = explode(" ", $this->dbquery->getFilter("edited_to_date"));
            // Der kontrolleres ikke for gyldig tidsformat
            if (isset($date_parts[1]) && $date_parts[1] != "") $time = " ".$date_parts[1];
            $date = new Ilib_Date($date_parts[0]);
            if ($date->convert2db()) {
                $this->getDBQuery()->setCondition("file_handler.date_changed <= \"".$date->get().$time."\"");
            } else {
                $this->error->set("error in edited to date");
            }
        }

        if ($this->getDBQuery()->checkFilter("accessibility")) {
            $accessibility_key = array_search($this->dbquery->getFilter("accessibility"), $this->accessibility_types);
            if ($accessibility_key !== false) {
                $this->getDBQuery()->setCondition("file_handler.accessibility_key = ".intval($accessibility_key)."");
            }
        }

        if ($this->getDBQuery()->checkFilter("text")) {
            $this->getDBQuery()->setCondition("file_handler.file_name LIKE \"%".safeToDb($this->getDBQuery()->getFilter("text"))."%\" OR file_handler.description LIKE \"%".safeToDb($this->getDBQuery()->getFilter("text"))."%\"");
        }

        if ($this->getDBQuery()->checkFilter('images')) {
            $keys = array();
            foreach($this->file_types AS $key => $mime_type) {
                if ($mime_type['image'] == 1) {
                    $keys[] = $key;
                }
            }

            if (count($keys) > 0) {
                $this->getDBQuery()->setCondition("file_handler.file_type_key IN (".implode(',', $keys).")");
            }
        }


        if (!$this->getDBQuery()->checkSorting()) {
            $this->getDBQuery()->setSorting('file_handler.file_name');
        }

        $file = array();
        $i = 0;


        if ($debug == 'debug') {
            $debug = true;
        } else {
            $debug = false;
        }

        $db = $this->getDBQuery()->getRecordset("file_handler.*, DATE_FORMAT(file_handler.date_created, '%d-%m-%Y') AS dk_date_created", "", $debug);

        //$db->query("SELECT * FROM file_handler WHERE intranet_id = ".$this->kernel->intranet->get('id')." AND active = 1 AND tmp = 0 ORDER BY date_created DESC");
        while($db->nextRecord()) {

            $file[$i]['id'] = $db->f('id');
            $file[$i]['date_created'] = $db->f('date_created');
            $file[$i]['dk_date_created'] = $db->f('dk_date_created');
            $file[$i]['description'] = $db->f('description');
            //$file[$i]['date_updated'] = $db->f('date_updated');
            $file[$i]['file_name'] = $db->f('file_name');
            $file[$i]['server_file_name'] = $db->f('server_file_name');
            $file[$i]['file_size'] = $db->f('file_size');
            $file[$i]['file_type'] = $this->_getMimeType((int)$db->f('file_type_key'));
            $file[$i]['is_picture'] = $this->file_types[$db->f('file_type_key')]['image'];
            if ($file[$i]['file_size'] >= 1000000) {
                $file[$i]['dk_file_size'] = number_format(($file[$i]['file_size']/1000000), 2, ",",".")." Mb";
            } else if ($file[$i]['file_size'] >= 1000) {
                $file[$i]['dk_file_size'] = number_format(($file[$i]['file_size']/1000), 2, ",",".")." Kb";
            } else {
                $file[$i]['dk_file_size'] = number_format($file[$i]['file_size'], 2, ",",".")." byte";
            }
            $file[$i]['file_uri'] = $this->fileviewer_path.'?/'.$this->kernel->intranet->get('public_key').'/'.$db->f('access_key').'/'.urlencode($db->f('file_name'));

            $file[$i]['accessibility'] = $this->accessibility_types[$db->f('accessibility_key')];


            if ($file[$i]['is_picture'] == 1) {
                $file[$i]['icon_uri'] = $this->fileviewer_path.'?/'.$this->kernel->intranet->get('public_key').'/'.$db->f('access_key').'/system-square/'.urlencode($db->f('file_name'));
                $file[$i]['icon_width'] = 75;
                $file[$i]['icon_height'] = 75;
            } else {
                $file[$i]['icon_uri'] = '/images/mimetypes/'.$file[$i]['file_type']['icon'];
                $file[$i]['icon_width'] = 75;
                $file[$i]['icon_height'] = 75;
            }
            $i++;
        }
        return $file;
    }
}