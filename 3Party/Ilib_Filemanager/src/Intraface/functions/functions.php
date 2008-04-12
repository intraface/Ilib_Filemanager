<?php
if(!function_exists('mime_content_type')) {
    // mime_content_type først fra PHP 4.3
    // Taget fra http://dk.php.net/manual/en/function.mime-content-type.php
    function mime_content_type($f) {
        return exec(trim('file -bi '.escapeshellarg($f)));
    }
}

/**
 * Function to be called before putting data in the database
 *
 * @author	Lars Olesen <lars@legestue.net>
 */
function safeToDb($data) {
    if(is_array($data)){
        return array_map('safeToDb',$data);
    }

    if (get_magic_quotes_gpc()) {
        $data = stripslashes($data);
    }

    return mysql_escape_string(trim($data));
}

/*
 * Function to convert filesize to readable sizes.
 * from: http://us3.php.net/filesize
 */
function filesize_readable ($size, $retstring = null) {
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