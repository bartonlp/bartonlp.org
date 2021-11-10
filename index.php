<?php
// This is for the bartonlp.org domain.

$_site = require_once(getenv("SITELOADNAME"));
ErrorClass::setDevelopment(true);
$S = new $_site->className($_site);

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

[$top, $footer] = $S->getPageTopBottom($h);

echo <<<EOF
$top
<div class="item">
<h3>This file is at <b>/var/www/html</b></h3>

<div class="desktop">We think you are using a mouse as your pointer device.</div>
<div class="phone">We think you are using a phone or tablet with a touch screen.</div>
<div>Our main Home Page is at <a href="https://www.bartonphillips.com">www.bartonphillips.com</a> Please visit us there.</div>.
</div>
$footer
EOF;

