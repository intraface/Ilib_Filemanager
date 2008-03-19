<?php
require_once 'config.test.php';

require_once 'PHPUnit/Framework.php';
require_once 'Intraface/Standard.php';
require_once 'Intraface/Kernel.php';
require_once 'Intraface/shared/filehandler/FileHandler.php';
require_once 'Intraface/shared/filehandler/AppendFile.php';

class FakeFileHandler
{
    function get()
    {
        return 1;
    }
}

class FakeAppendFileIntranet
{
    function get() { return 1; }
}

class FakeAppendFileFile
{

    public $id;
    function __construct($id = 1) {
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }
}

class AppendFileTest extends PHPUnit_Framework_TestCase
{
    function setUp()
    {
        $db = MDB2::factory(DB_DSN);
        $db->query('TRUNCATE filehandler_append_file');
    }

    function createAppendFile($id = 0)
    {
        $kernel = new FakeKernel;
        $kernel->session_id = 'notreallyasessionid';
        $kernel->intranet = new FakeAppendFileIntranet;
        return new AppendFile($kernel, 'product', 1, $id);
    }

    /////////////////////////////////////////////////////////

    function testConstruction()
    {
        $append = $this->createAppendFile();
        $this->assertTrue(is_object($append));
    }

    function testAddFileAsInteger()
    {
        $append = $this->createAppendFile();
        $this->assertTrue($append->addFile(new FakeAppendFileFile) > 0);
    }

    function testAddFilesAsArray()
    {
        $append = $this->createAppendFile();
        $this->assertTrue($append->addFiles(array(new FakeAppendFileFile)));
    }

    function testDeleteReturnsTrue()
    {
        $append = $this->createAppendFile();
        $id = $append->addFile(new FakeAppendFileFile);
        $this->assertTrue($append->delete($id));
    }

    function testUnDeleteReturnsTrue()
    {
        $append = $this->createAppendFile();
        $id = $append->addFile(new FakeAppendFileFile);
        $append->delete($id);
        $this->assertTrue($append->undelete(1));
    }

    function testCreateDBQuery()
    {
        $append = $this->createAppendFile();
        $append->createDBQuery();

        $this->assertTrue(isset($append->dbquery));
    }

    function testGetList()
    {
        $append = $this->createAppendFile();
        $append->addFile(new FakeAppendFileFile(1));
        $append->addFile(new FakeAppendFileFile(2));
        $append->addFile(new FakeAppendFileFile(3));

        $append->createDBQuery();

        $expected = array(
            0 => array(
                'id' => 1,
                'file_handler_id' => 1,
                'description' => ''),
            1 => array(
                'id' => 2,
                'file_handler_id' => 2,
                'description' => ''),
            2 => array(
                'id' => 3,
                'file_handler_id' => 3,
                'description' => '')
        );


        $this->assertEquals($expected, $append->getList());

    }
}