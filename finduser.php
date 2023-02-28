<?php
// This Demo goes with the altorouter.php and the AltoRouter class.
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

$S->preheadcomment = "<!-- Part of AltoRoute Demo -->";
$S->title = 'Find User Demo';
$S->banner = "<h1>$S->title</h1>";

[$top, $footer] = $S->getPageTopBottom();

$users = [['Barton', 1], ['Bonnie', 2]];

$result = "Sorry we did not fine person '$name' with id '$id'";

foreach($users as [$k, $v]) {
  if($k == $name && $v == $id) {
    $result = "We found 'name'=$name and 'id'=$id";
    break;
  }
}
echo <<<EOF
$top
<hr>
<h1>$result</h1>
<hr>
$footer
EOF;
               
                  