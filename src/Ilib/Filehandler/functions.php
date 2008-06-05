<?php   
// Dynamic global functions
if (!function_exists('safeToDb')) {
    /**
     * This function is dynamically redefinable.
     * @see $GLOBALS['_global_function_callback_e']
     */
    function safeToDb($args) 
    {
        $args = func_get_args();
        return call_user_func_array($GLOBALS['_global_function_callback_safetodb'], $args);
    }
    if (!isset($GLOBALS['_global_function_callback_safetodb'])) {
        $GLOBALS['_global_function_callback_safetodb'] = NULL;
    }
}
$GLOBALS['_global_function_callback_safetodb'] = 'ilib_filehandler_safetodb';

/**
 * Function to be called before putting data in the database
 *
 * @author  Lars Olesen <lars@legestue.net>
 */
function ilib_filehandler_safetodb($data) 
{
    if(is_array($data)){
        return array_map('safeToDb',$data);
    }

    if (get_magic_quotes_gpc()) {
        $data = stripslashes($data);
    }

    return mysql_escape_string(trim($data));
}


// Dynamic global functions
if (!function_exists('filesize_readable')) {
    /**
     * This function is dynamically redefinable.
     * @see $GLOBALS['_global_function_callback_e']
     */
    function filesize_readable($args) 
    {
        $args = func_get_args();
        return call_user_func_array($GLOBALS['_global_function_callback_filesize_readable'], $args);
    }
    if (!isset($GLOBALS['_global_function_callback_filesize_readable'])) {
        $GLOBALS['_global_function_callback_filesize_readable'] = NULL;
    }
}
$GLOBALS['_global_function_callback_filesize_readable'] = 'ilib_filehandler_filesize_readable';

/*
 * Function to convert filesize to readable sizes.
 * from: http://us3.php.net/filesize
 */
function ilib_filehandler_filesize_readable($size, $retstring = null) 
{
        // adapted from code at http://aidanlister.com/repos/v/function.size_readable.php
        $sizes = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        if ($retstring === null) { $retstring = '%01.2f %s'; }
        $lastsizestring = end($sizes);
        foreach ($sizes as $sizestring) {
                if ($size < 1024) { break; }
                if ($sizestring != $lastsizestring) { $size /= 1024; }
        }
        if ($sizestring == $sizes[0]) { $retstring = '%01d %s'; } // Bytes aren't normally fractional
        return sprintf($retstring, $size, $sizestring);
}