<?php
$_site = require_once(getenv("SITELOADNAME"));
ErrorClass::setDevelopment(true);
//vardump("site", $_site);
$S = new $_site->className($_site);
//vardump("S", $S);
$h->css = <<<EOF
<style>
@font-face {
  font-family: liberation;
  src: url("https://bartonphillips.net/fonts/allnatural/truetype/liberation/LiberationSans-Regular.woff"),
    url("https://bartonphillips.net/fonts/allnatural/truetype/liberation/LiberationSans-Regular.ttf");
  font-weight: normal;
  font-style: normal;
}

/* Font Face for the Menu ICON */
@font-face {
  font-family: 'icomoon';
  src: url("https://bartonphillips.net/fonts/icomoon.eot");
  src: url("https://bartonphillips.net/fonts/icomoon.woff") format('woff'),
    url("https://bartonphillips.net/fonts/icomoon.eot") format('embedded-opentype'),
    url("https://bartonphillips.net/fonts/icomoon.ttf") format('truetype'),
    url("https://bartonphillips.net/fonts/icomoon.svg") format('svg');
  font-weight: normal;
  font-style: normal;
}
/* FontAwesome for twitter, facebook icons */
@font-face {
  font-family: 'FontAwesome';
  src: 
    url('https://bartonphillips.net/css/allnatural/social/font/fontawesome-webfont.woff') format('woff'),
    url('https://bartonphillips.net/css/allnatural/social/font/fontawesome-webfont.ttf') format('truetype'),
    url('https://bartonphillips.net/css/allnatural/social/font/fontawesome-webfont.svg#fontawesomeregular') format('svg');
  font-weight: normal;
  font-style: normal;
}
  
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
</style>
EOF;  

[$top, $footer] = $S->getPageTopBottom($h);

echo <<<EOF
$top
<p class="item">Our main Home Page is at <a href="https://www.bartonphillips.com">www.bartonphillips.com</a>.<br>
Please visit us there.</p>
$footer
EOF;

