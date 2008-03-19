<?php
require_once 'PHPUnit/Framework.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

class AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Intraface_FileHandler');

        $tests = array('FileViewer', 'FileHandler', 'AppendFile', 'InstanceHandler', 'InstanceManager', 'TemporaryFile', 'ImageHandler', 'ImageRandomizer', 'FileManager');

        foreach ($tests AS $test) {
            require_once $test . 'Test.php';
            $suite->addTestSuite($test . 'Test');
        }

        return $suite;
    }
}
?>