<?php
require_once 'config.test.php';

class FakeFileManagerIntranet
{
    function get()
    {
        return 1;
    }
}

class FakeFileManagerUser
{
    function get()
    {
        return 1;
    }
}

class FakeFilemanagerKernel
{
    function getSessionId()
    {
        return 'thisissomething';
    }
}

class FileManagerTest extends PHPUnit_Framework_TestCase
{
    private $file_name = 'tester.jpg';
    protected $backupGlobals = false;

    function createKernel()
    {
        $kernel = new FakeFilemanagerKernel;
        $kernel->session_id = 'notreallyasessionid';
        $kernel->intranet = new FakeFileManagerIntranet;
        $kernel->user = new FakeFileManagerUser;
        return $kernel;
    }

    function createFileManager()
    {
        return new Ilib_Filehandler_Manager($this->createKernel());
    }

    function createFile()
    {
        $data = array('file_name' => $this->file_name);
        $filemanager = $this->createFileManager();
        $this->assertTrue($filemanager->update($data) > 0);
        return $filemanager;
    }

    ////////////////////////////////////////////////////////////////

    function testConstruction()
    {
        $filemanager = $this->createFileManager();
        $this->assertTrue(is_object($filemanager));
    }

    function testCreateDBQuery() {
        $filemanager = $this->createFileManager();
        $filemanager->getDBQuery();
        $this->assertTrue(is_object($filemanager->getDBQuery()));
    }
}