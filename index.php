<?php
// This is for the bartonlp.org domain.

$_site = require_once(getenv("SITELOADNAME"));
ErrorClass::setDevelopment(true);
$S = new $_site->className($_site);

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
</style>
EOF;  

[$top, $footer] = $S->getPageTopBottom($h);

echo <<<EOF
$top
<p class="item">Our main Home Page is at <a href="https://www.bartonphillips.com">www.bartonphillips.com</a>.<br>
Please visit us there.</p>
$footer
EOF;

