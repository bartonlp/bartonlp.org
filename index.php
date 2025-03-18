<?php
// This is for the bartonlp.org domain.
// I am using AltoRouter which routes '/' to altorouter.php which maps '/' to index.php.
// You can always enter /index.php which will load the file directly.
// For this to run under 'apache' we would need to edit our '.htaccess' file and add:
//  # This group is for altorouter. The first rewrite is so '/' goes to altorouter.
//  RewriteRule ^$ altorouter.php [L]
//  # Then everything that isn't a file, line /test goes to altorouter.
//  RewriteCond %{REQUEST_FILENAME} !-f
//  RewriteRule . altorouter.php [L]
// Get it with 'composer require altorouter/altorouter'
// Get it at https://github.com/dannyvankooten/AltoRouter

$_site = require_once(getenv("SITELOADNAME"));
ErrorClass::setDevelopment(true);
$S = new SiteClass($_site);

// preheadcomment goes before DOCTYPE.
$S->preheadcomment = <<<EOF
<!-- This is bartonlp.org at /var/www/html -->
<!-- This uses AltoRouter. https://github.com/dannyvankooten/AltoRouter -->
EOF;

$S->css = <<<EOF
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
EOF;  

$S->h_script =<<<EOF
  <script src="/ximage.js"></script>
  <script>dobanner("images/*.png", "Bonnie & Me", {recursive: 'no', size: '100', mode: "rand"});</script>
EOF;

$S->banner = "<h1>Something New</h1>";

$class = "{$S->__toString()} Version: {$S->getVersion()}, engine={$S->dbinfo->engine}, PHP Version: " . PHP_VERSION;

[$top, $bottom] = $S->getPageTopBottom();
//error_log("bartonlp.org index: $top");

echo <<<EOF
$top
<div class="item">
<h3>This file is at <b>/var/www/html</b></h3>
<p>$class</p>
<div class="desktop">We think you are using a mouse as your pointer device.</div>
<div class="phone">We think you are using a phone or tablet with a touch screen.</div>
<div>Our main Home Page is at <a href="https://www.bartonphillips.com">www.bartonphillips.com</a> Please visit us there.</div>.
<p>I am using AltoRouter. Try <a href="/test">https://bartonlp.org/test</a><br>
There are several pages you can also try from the locatin bar: <b>/getip</b>, <b>/contactus/{name}</b>, <b>/finduser/{name}/{id}</b>.<br>
There are two names and ids in the database they are: <b>Barton</b> with id <b>1</b> and <b>Bonnie</b> with id <b>2</b>.</p>
</div>
<div id="show"></div>
$bottom
EOF;

