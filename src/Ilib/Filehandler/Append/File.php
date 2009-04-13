<?php
/**
 * @package Ilib_Filehandler
 */
class Ilib_Filehandler_Append_File
{
    /**
     * @var integer
     */
    protected $id;

    /**
     * Constructor
     *
     * @param integer $id
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = intval($id);

    }

    /**
     * @param object $db
     */
    function getPosition($db)
    {
        return new Ilib_Position($db, "filehandler_append_file", intval($this->id), "intranet_id=".$this->kernel->intranet->get('id')." AND debtor_id=".$this->debtor->get('id')." AND active = 1", "position", "id");
    }

}