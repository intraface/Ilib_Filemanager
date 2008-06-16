<?php
require_once 'Ilib/ClassLoader.php';

define('DB_DSN', 'mysql://sune:@localhost/intraface');
define('PATH_UPLOAD', '/var/lib/www/IntrafaceLib_test/upload/');
define('PATH_UPLOAD_TEMPORARY', 'temp/');
define('FILE_VIEWER', 'http://svnprojects.asterix/IntrafaceLib/Ilib_FileManager/tests/');
define('PATH_WWW', 'http://svnprojects.asterix/IntrafaceLib/Ilib_FileManager/tests/');

set_include_path('.'.PATH_SEPARATOR.'../src/'.PATH_SEPARATOR.get_include_path());
?>
