<?php namespace ProcessWire;

//https://www.php.net/manual/en/function.rmdir.php#117354
function rrmdir($src) {
    $dir = opendir($src);
    while(false !== ( $file = readdir($dir)) ) {
        if (( $file != '.' ) && ( $file != '..' )) {
            $full = $src . '/' . $file;
            if ( is_dir($full) ) {
                rrmdir($full);
            }
            else {
              unlink($full);
            }
        }
    }
    closedir($dir);
    rmdir($src);
}
