<?php
// Used by AltoRouter Demo  '/test' (test.php).
// To make altorouter work you need to add the following to the .htaccess
//  # This group is for altorouter. The first rewrite is so '/' goes to altorouter.
//  RewriteRule ^$ altorouter.php [L]
//  # Then everything that isn't a file, line /test goes to altorouter.
//  RewriteRule ^$ altorouter.php [L]
//  RewriteCond %{REQUEST_FILENAME} !-f
//  RewriteRule . altorouter.php [L]
// Get AltoRouter from github or composer.
// composer require altorouter/altorouter
// https://github.com/dannyvankooten/AltoRouter

$_site = require_once(getenv("SITELOADNAME"));
$S = new SiteClass($_site);

$S->preheadcomment = "<!-- Part of AltoRouter Demo. Using SiteClass -->";
$S->title = "Get Ip";
$S->banner = "<h1>Get My Ip</h1>";
[$top, $footer] = $S->getPageTopBottom();

$ip = $_SERVER['REMOTE_ADDR'];
echo <<<EOF
$top
<hr>
<p>Your IP Address is: $ip</p>
<hr>
$footer
EOF;

