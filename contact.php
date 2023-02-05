<?php
// Used by AltoRouter Demo '/test' (test.php).
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

echo <<<EOF
<!-- AltoRouter Demo. No SiteClass -->
<!DOCTYPE html>
<html>
<head>
<title>Contact</title>
</head>
<body>
<h1>This is Contact</h1>
<div>Subject: $subject</div>
</body>
</html>
EOF;
