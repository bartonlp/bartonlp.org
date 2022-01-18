<?php
// This is for the bartonlp.org domain.

$_site = require_once(getenv("SITELOADNAME"));
ErrorClass::setDevelopment(true);
$S = new $_site->className($_site);

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

// AJAX GET

if($_GET['path']) {
  $path = $_GET['path'];

  if(!$path) {
    // If no path supplied start at the top of Pictures and get every jpg.

    $x = glob_recursive("*.JPG"); // we are looking for JPG
    array_push($x, glob_recursive("*.jpg")); // and also jpg
  } else {
    if($_GET['recursive'] == 'yes') {
      $x = glob_recursive($path);
    } else {
      $x = glob($path);
    }
  }
  if($_GET['mode'] == 'rand') {
    shuffle($x);
  }

  if($_GET['size']) {
    $x = array_slice($x, 0, $_GET['size']); // get from zero to size only.
  }

  // Turn the array into a string of lines with a \n

  foreach($x as $v) {
    $banner_photos .= "http://bartonlp.org/$v\n";
  }

  $banner_photos = rtrim($banner_photos, "\n");

  // Send this back to the Ajax function

  echo $banner_photos;
  exit();
}

// BLP 2021-06-08 -- Set the DOCTYPE to have a message before the type

$h->doctype =<<<EOF
<!-- This is bartonlp.org at /var/www/html -->
<!DOCTYPE html>
EOF;

$h->css = <<<EOF
<style>
.item { text-align: center; }
/* This is like <hr> */
.item::after {
  content: '';
  width: 100%;
  height: 1px;
  margin: 10px 0 10px;
  display: block;
  background-color: black;
}
#show {
  width: 500px;
  margin: auto;
}
#show img {
  width: 500px;
}
@media (hover: none) and (pointer: coarse) {
  .desktop {
    display: none;
  }
}
@media (hover: hover) and (pointer: fine) {
  .phone {
    display: none;
  }
}
</style>
EOF;  

$h->script =<<<EOF
  <!-- USE ximage.js which understands http://bartonphillips.org:8080 -->
  <script src="https://bartonphillips.net/js/yimage.js"></script>
  <!-- PasoRobles2011 is symlinked to /storage/Pictures/PasoRobles2011 -->
  <script>dobanner("PasoRobles2011/*.JPG", {recursive: 'no', size: '100', mode: "rand"});</script>
EOF;

[$top, $footer] = $S->getPageTopBottom($h);

echo <<<EOF
$top
<div class="item">
<h3>This file is at <b>/var/www/html</b></h3>

<div class="desktop">We think you are using a mouse as your pointer device.</div>
<div class="phone">We think you are using a phone or tablet with a touch screen.</div>
<div>Our main Home Page is at <a href="https://www.bartonphillips.com">www.bartonphillips.com</a> Please visit us there.</div>.
</div>
<div id="show"></div>
$footer
EOF;

