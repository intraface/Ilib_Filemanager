<?php
require_once 'config.test.php';


if(!function_exists('iht_deltree')) {
function iht_deltree( $f ){

    if( is_dir( $f ) ){
        foreach( scandir( $f ) as $item ){
            if( !strcmp( $item, '.' ) || !strcmp( $item, '..' ) )
                continue;
            iht_deltree( $f . "/" . $item );
        }
        @rmdir( $f );
    }
    else{
        @unlink( $f );
    }
}
}


class FakeTemporaryFileKernel {
    public $intranet;
    public $user;

    function randomKey() {
        return 'thisisnotreallyarandomkey'.microtime();
    }
}


class FakeTemporaryFileIntranet
{
    function get()
    {
        return 1;
    }
}

class FakeTemporaryFileUser
{
    function get()
    {
        return 1;
    }
}

class FakeTemporaryFileFileHandler {

    public $upload_path;
    public $tempdir_path;

    function __construct() {
        $this->upload_path = PATH_UPLOAD.'1'. DIRECTORY_SEPARATOR;
        $this->tempdir_path = $this->upload_path.PATH_UPLOAD_TEMPORARY;
    }

}

class TemporaryFileTest extends PHPUnit_Framework_TestCase
{

    function createFileHandler()
    {
        $kernel = new FakeTemporaryFileKernel;
        $kernel->intranet = new FakeTemporaryFileIntranet;
        $kernel->user = new FakeTemporaryFileUser;
        return new FakeTemporaryFileFileHandler($kernel);
    }


    function setUp()
    {
        $db = MDB2::factory(DB_DSN);
        $db->query('TRUNCATE file_handler');
        $db->query('TRUNCATE file_handler_instance');
        $db->query('TRUNCATE file_handler_instance_type');
        iht_deltree(PATH_UPLOAD);
        mkdir(PATH_UPLOAD);
    }

    function tearDown()
    {
        iht_deltree(PATH_UPLOAD);
        mkdir(PATH_UPLOAD);
    }

    //////////////////////////////////////////////////

    function testConstruct() 
    {
        $tf = new Ilib_Filehandler_TemporaryFile($this->createFileHandler());
        $this->assertTrue(is_object($tf));
    }

    function testConstructWithFileNameWithSpacesAndSlashes() 
    {
        $tf = new Ilib_Filehandler_TemporaryFile($this->createFileHandler(), 'this is a very\ wrong name/.jpg');
        $this->assertEquals('this_is_a_very__wrong_name_.jpg', $tf->getFileName());
    }

    function testConstructWithTooLongFileName() 
    {
        $tf = new Ilib_Filehandler_TemporaryFile($this->createFileHandler(), '123456789012345678901234567890123456789012345678901234567890.jpg');
        $this->assertEquals('1234567890123456789012345678901234567890123456.jpg', $tf->getFileName());
    }

    function testGetFilePath() 
    {
        $tf = new Ilib_Filehandler_TemporaryFile($this->createFileHandler(), 'file_name.jpg');

        $this->assertEquals(PATH_UPLOAD.'1'.DIRECTORY_SEPARATOR.PATH_UPLOAD_TEMPORARY, substr($tf->getFilePath(), 0, strlen(PATH_UPLOAD) + 1 + strlen(DIRECTORY_SEPARATOR) + strlen(PATH_UPLOAD_TEMPORARY)));
        $this->assertEquals(strlen(PATH_UPLOAD) + 1 + strlen(DIRECTORY_SEPARATOR) + strlen(PATH_UPLOAD_TEMPORARY) + 13 + strlen(DIRECTORY_SEPARATOR) + strlen('file_name.jpg'), strlen($tf->getFilePath()));
        $this->assertEquals('file_name.jpg', substr($tf->getFilePath(), -strlen('file_name.jpg')));

        // ereg('^'.PATH_UPLOAD.'1(/|\\\\)'.PATH_UPLOAD_TEMPORARY.'([a-zA-Z0-9]{13})(/|\\\\)file_name.jpg$', str_replace('\\', '\\\\', $tf->getFilePath()), $regs);
        // $this->assertEquals(PATH_UPLOAD.'1'.$regs[1].PATH_UPLOAD_TEMPORARY.$regs[2].$regs[3].'file_name.jpg', $tf->getFilePath());
    }

    function testGetFileDir() 
    {
        $tf = new Ilib_Filehandler_TemporaryFile($this->createFileHandler(), 'file_name.jpg');

        $this->assertEquals(PATH_UPLOAD.'1'.DIRECTORY_SEPARATOR.PATH_UPLOAD_TEMPORARY, substr($tf->getFilePath(), 0, strlen(PATH_UPLOAD) + 1 + strlen(DIRECTORY_SEPARATOR) + strlen(PATH_UPLOAD_TEMPORARY)));
        $this->assertEquals(strlen(PATH_UPLOAD) + 1 + strlen(DIRECTORY_SEPARATOR) + strlen(PATH_UPLOAD_TEMPORARY) + 13 + strlen(DIRECTORY_SEPARATOR), strlen($tf->getFileDir()));

        // ereg('^'.PATH_UPLOAD.'1(/|\\\\)'.PATH_UPLOAD_TEMPORARY.'([a-zA-Z0-9]{13})(/|\\\\)$', str_replace('\\', '\\\\', $tf->getFilePath()), $regs);
        // $this->assertEquals(PATH_UPLOAD.'1'.$regs[1].PATH_UPLOAD_TEMPORARY.$regs[2].$regs[3], $tf->getFileDir());
    }

    function testGetFilePathIsUnique() 
    {
        $tf = new Ilib_Filehandler_TemporaryFile($this->createFileHandler(), 'file_name.jpg');
        $file_path1 = $tf->getFilePath();

        $tf->setFileName('file_name.jpg');
        $file_path2 = $tf->getFilePath();

        $this->assertNotEquals($file_path1, $file_path2);
    }
}
