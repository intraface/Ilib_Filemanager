<?php
/**
 * @package Ilib_Filehandler
 */
class Ilib_Filehandler_ImageRandomizer
{
    /**
     * @var object $file_manager file handler
     */
    private $file_manager;

    /**
     * @var object $error
     */
    public $error;

    /**
     * @var array $file_list to find image from
     */
    private $file_list;

    /**
     * @var array $file_list to find image from
     */
    private $dbquery;

    /**
     * constructor
     *
     * @param object $file_manager file handler
     * @param array $keywords array with keywords
     */
    public function __construct($file_manager, $keywords)
    {
        $this->file_manager = $file_manager;

        $this->error = new Ilib_Error;

        if (!is_array($keywords)) {
            trigger_error('second parameter should be an array with keywords', E_USER_ERROR);
            return false;
        }

        $keyword_ids = array();
        foreach ($keywords as $keyword) {
            $keyword_object = new Keyword($this->file_manager);
            /**
             * @todo: This is not really good, but the only way to identify keyword on name!
             */
            $keyword_ids[] = $keyword_object->save(array('keyword' => $keyword));
        }

        $this->getDBQuery()->setKeyword((array)$keyword_ids);

        $filetype = new Ilib_Filehandler_FileType();
        $types = $filetype->getList();
        $keys = array();
        foreach ($types as $key => $mime_type) {
            if ($mime_type['image'] == 1) {
                $keys[] = $key;
            }
        }

        $this->getDBQuery()->setCondition("file_handler.file_type_key IN (".implode(',', $keys).")");

        $this->file_list = array();
        $db = $this->getDBQuery()->getRecordset("file_handler.id", "", false);

        while($db->nextRecord()) {
            $this->file_list[] = $db->f('id');
        }

        if (count($this->file_list) == 0) {
            throw new Exception('No images found with the keywords: '.implode(', ', $keywords));
        }
    }

    /**
     * returns dbquery
     *
     * @return object dbquery
     */
    private function getDBQuery()
    {
        if ($this->dbquery) {
            return $this->dbquery;
        }
        $dbquery = new Ilib_DBQuery("file_handler", "file_handler.temporary = 0 AND file_handler.active = 1 AND file_handler.intranet_id = ".$this->file_manager->getKernel()->intranet->get('id'));
        $dbquery->useErrorObject($this->error);
        return ($this->dbquery = $dbquery);
    }


    /**
     * return an file object with random image
     *
     * @return object file_manager with random image loaded
     */
    public function getRandomImage()
    {
        $key = rand(0, count($this->file_list)-1);
        return new Ilib_Filehandler($this->file_manager->getKernel(), $this->file_list[$key]);

    }
}