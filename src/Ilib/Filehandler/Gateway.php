<?php
/**
 * Basically a gateway to get a list of files
 *
 * @package Intraface_FileManager
 */
require_once dirname(__FILE__) . '/functions.php';

class Ilib_Filehandler_Gateway
{
    /**
     * @var array
     */
    protected $accessibility_types = array(
            0 => '_invalid_',
            1 => 'user',
            2 => 'intranet',
            3 => 'public');

    /**
     * @var object
     */
    protected $keywords;

    /**
     * @var object
     */
    protected $dbquery;

    /**
     * @var string
     */
    protected $fileviewer_path;
    
    /**
     * @var string
     */
    private $www_path;

    /**
     * @var object
     */
    protected $kernel;

    /**
     * @var object
     */
    protected $error;

    /**
     * @var array
     */
    protected $file_types;

    /**
     * Constructor
     *
     * @param object  $kernel  Kernel object
     *
     * @return void
     */
    public function __construct($kernel)
    {
        $this->fileviewer_path = FILE_VIEWER;
        $this->www_path = PATH_WWW;
        $this->kernel = $kernel;
    }

    function getKernel()
    {
    	return $this->kernel;
    }

    /**
     * Gets a filehandler from an id
     *
     * @deprecated
     * @param integer $id file id
     *
     * @return object
     */
    public function getFromId($id = 0)
    {
        return new Ilib_Filehandler($this->kernel, $id);
    }

    public function findById($id)
    {
        return new Ilib_Filehandler($this->kernel, $id);
    }

    function findByAccessKey($access_key)
    {
        $access_key = safeToDb($access_key);

        $db = new DB_Sql;
        $db->query("SELECT id FROM file_handler WHERE intranet_id = ".$this->kernel->intranet->get('id')." AND active = 1 AND access_key = '".$access_key."'");
        if (!$db->nextRecord()) {
            return false;
        }
        return $this->findById($db->f('id'));

    }

    /**
     * Gets the dbquery object so it can be used in the class
     *
     * @return object
     */
    public function getDBQuery()
    {
        if ($this->dbquery) {
            return $this->dbquery;
        }
        $this->dbquery = new Ilib_DBQuery("file_handler", "file_handler.temporary = 0 AND file_handler.active = 1 AND file_handler.intranet_id = ".$this->kernel->intranet->get("id"));
        $this->dbquery->createStore($this->getKernel()->getSessionId(), 'intranet_id = '.intval($this->getKernel()->intranet->get('id')));
        $this->dbquery->useErrorObject($this->getError());
        return $this->dbquery;
    }

    public function getError()
    {
    	if ($this->error) {
            return $this->error;
        }
        return ($this->error = new Ilib_Error());
    }

    /**
     * Gets the keywords object
     *
     * @return object
     */
    public function getKeywords()
    {
        return ($this->keywords = new Ilib_Keyword($this->getFromId(0)));
    }

    /**
     * Gets the keywords appender
     *
     * @todo Dette kan ikke lade sig gøre, da keywordappenderen skal bruge et
     * id.
     *
     * @return object
     */
    public function getKeywordAppender()
    {
        return new Ilib_Keyword_Appender($this->getFromId(0));
    }

    protected function getMimeTypes()
    {
        $filetype = new Ilib_Filehandler_FileType();
        return $filetype->getList();
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
        $this->file_types = $this->getMimeTypes();

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
            foreach($this->file_types as $key => $mime_type) {
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
                $file[$i]['icon_uri'] = $this->www_path.'/images/mimetypes/'.$file[$i]['file_type']['icon'];
                $file[$i]['icon_width'] = 75;
                $file[$i]['icon_height'] = 75;
            }
            $i++;
        }
        return $file;
    }

    protected function _getMimeType($key, $from = 'key')
    {
        if (empty($this->file_types)) {
            $this->loadMimeTypes();
        }

        if ($from == 'key') {
            if (!is_integer($key)) {
                trigger_error("Når der skal findes mimetype fra key (default), skal første parameter til FileHandler->_getMimeType være en integer", E_USER_ERROR);
            }
            return $this->file_types[$key];
        }

        if (in_array($from, array('mime_type', 'extension'))) {
            foreach ($this->file_types as $file_key => $file_type) {
                if ($file_type[$from] == $key) {
                    // Vi putter lige key med i arrayet
                    $file_type['key'] = $file_key;
                    return $file_type;
                }
            }
        }

        return false;
    }

    public function getMimeType($key, $from = 'key')
    {
        return $this->_getMimeType($key, $from);
    }

    function deleteAllInstances()
    {
        foreach ($this->getList() as $file) {
            $filehandler = new Ilib_Filehandler($this->kernel, $file['id']);
            if (!$filehandler->isImage()) {
                continue;
            }
            $filehandler->getInstance()->deleteAll();
        }
        return true;
    }
}