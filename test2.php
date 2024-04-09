<?php
// Because this is 'required()' in altorouter.php the variable are available here.

$_site = require_once(getenv("SITELOADNAME"));

$S = new SiteClass($_site);
$S->banner = "<h1>This is test2.php</h1>";

[$top, $footer] = $S->getPageTopBottom();

echo <<<EOF
$top
<h1>test2</h1><p>TEST</p>
$footer
EOF;


