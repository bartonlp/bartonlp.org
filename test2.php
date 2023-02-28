<?php
// Because this is 'required()' in altorouter.php the variable are available here.

$_site = require_once(getenv("SITELOADNAME"));
$S = new SiteClass($_site);
$S->banner = "<h1>This is test2.php</h1>";
if($title) $S->banner = $title;

[$top, $footer] = $S->getPageTopBottom();

$msg = $name ? "$subject, $name" : $subject;
echo <<<EOF
$top
<h1>test2</h1><p>$msg</p>
$footer
EOF;
