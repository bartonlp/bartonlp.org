<?php
// BLP 2022-09-28 - NOTE this can live in https://bartonphillips.net because it does not do any
// cookie interaction! That is it does not instansiate SiteClass.
//
// BLP 2022-09-09 - used by ximage.js to get the images for the rpi or hpenvy.
// The index.php file on the rpi uses the local mysitemap.json but all of the other resources are
// on this server. Therefore, I can load the page with fromrpi.php as a secure resource from
// https://www.bartonphillips.com/fromrpi.php.

// A function to do a recursive glob()

if (!function_exists('glob_recursive')) {
  function glob_recursive($pattern, $flags = 0) {
    $files = glob($pattern, $flags);
        
    foreach(glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT|GLOB_MARK) as $dir) {
      $files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
    }
        
    return $files;
  }
}

$path = $_POST['path'];
//error_log("glob.proxy.php: $path");
if(empty($path)) {
  echo "No Path<br>";
  error_log("glob.proxy.php: N0 PATH");
}

if($_POST['recursive'] == 'yes') {
  $x = glob_recursive($path);
} else {
  $x = glob($path);
}

if($_POST['mode'] == 'rand') {
  shuffle($x);
}

if($_POST['size']) {
  $x = array_slice($x, 0, $_GET['size']); // get from zero to size only.
}

// Turn the array into a string of lines with a \n
// The photos are on bartonphillips.net where we have a symlink to my home directory on this
// server. There I have an rsync copy of all the photos at Pictures on the HPenvy.

foreach($x as $v) {
  $banner_photos .= "/$v\n";
}

$banner_photos = rtrim($banner_photos, "\n");

// Send this back to the Ajax function

echo $banner_photos;
exit();
