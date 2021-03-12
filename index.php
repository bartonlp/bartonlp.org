<?php
$_site = require_once(getenv("SITELOADNAME"));
ErrorClass::setDevelopment(true);
ErrorClass::setNoEmailErrs(true);
//vardump("site", $_site);
$S = new $_site->className($_site);
//vardump("S", $S);
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
<p class="item">This is 'bartonlp.org'.</p>
$footer
EOF;

