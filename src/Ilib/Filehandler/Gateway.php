<?php
class Ilib_Filehandler_Gateway
{
    private $kernel;
    
    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }
    
    public function findFromId($id)
    {
        return new Ilib_Filehandler();
    }
}