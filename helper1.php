<?php
// This file is part of the index.php. We actually use altorouter.php via the .htaccess file. See
// .htaccess ReWriteRulls.
// We get here from the selectIt.ph which does a bunch of call to this file. See selectIt.php.
// This file is very simple, it does the ximage.js and then start the images. The $name and $extra
// are supplied via autorouter.php. See autorouter.php.

$_site = require_once getenv("SITELOADNAME");
ErrorClass::setDevelopment(true);

$S = new SiteClass($_site);

$S->h_script =<<<EOF
  <script src="/ximage.js"></script>
  <script>dobanner("images/*.png", "Bonnie & Me", {recursive: 'no', size: '100', mode: "rand"});</script>
EOF;

//error_log("helper1.php: name=$name, extra=$extra");

[$top, $bottom] = $S->getPageTopBottom();

echo <<<EOF
$top
<h1>Helper1</h1>
$title
<div>$name</div>
<div>$extra</div>
<div id='show'></div>
$bottom
EOF;