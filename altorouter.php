<?php
// For this to run under 'apache' we would need to edit our '.htaccess' file and add:
//  # This group is for altorouter. The first rewrite is so '/' goes to altorouter.
//  RewriteRule ^$ altorouter.php [L]
//  # Then everything that isn't a file, line /test goes to altorouter.
//  RewriteRutle ^$ altorouter.php [L]
//  RewriteCond %{REQUEST_FILENAME} !-f
//  RewriteRule . altorouter.php [L]
// Which means everything will go through 'altorouts.php' that is not a file including '/'.
// Get it with 'composer require altorouter/altorouter'
// Get it at https://github.com/dannyvankooten/AltoRouter
// Pug is also worthwile, though I don't use it here.
// https://github.com/pug-php/pug
// 'composer require pug-php/pug:^3.0'

// This file DOES NOT DO a require_onece getenv("SITELOADNAME"); or set $S.
// The $router->map() functions can do it via the require(...) to set up $_site etc.

// Do the standard autoload.php from vendor. Not via SITELOADNAME!
// The standard composer autoload.php will load all of the classes.

require_once("/var/www/vendor/autoload.php");

$router = new AltoRouter();

// GET routines.

// Get my index.php

$router->map('GET', '/', function() {
  require('index.php');
});

// Get my getmyip.php

$router->map('GET', '/getip', function() {
  require('getmyip.php');
});

// Get my contact.php

$router->map('GET', '/contactus', function() {
  $subject = "NO INFO PASSED";
  require("contact.php");
});

// Get my contact.php with $subject

$router->map('GET', '/contactus/[a:subject]', function($y) {
  $subject = urldecode($y['subject']);
  require("contact.php");
});

// Get my selectIt.php. This has all of the GET and POST logic. See selectIt.php

$router->map('GET', '/test', function() {
  require("selectIt.php"); 
});

// This GET just echos the text with my $subject

$router->map('GET', '/test/[*:subject]', function($y) {
  //$data = file_get_contents("php://input");
  $subject = urldecode($y['subject']);
  echo "<h1>This is test</h1><p>{$subject}</p>";
});

// This GET echos the text from subject and name.

$router->map('GET', '/test/[*:subject]/[*:name]', function($y) {
  //$data = file_get_contents("php://input");
  $subject = urldecode($y['subject']);
  $name = urldecode($y['name']);
  echo "<h1>This is test</h1><p>{$subject}, {$name}</p>";
});

// This GET passes name and id to my finduser.php.

$router->map('GET', '/finduser/[a:name]/[i:id]', function($x) {
  $name = $x['name'];
  $id = $x['id'];
  require("finduser.php");
});

// POST routines

// If a <form> post or an AJAX post. Pass name and extra to my helper1.php

$router->map('POST', '/test', function() {
  $name = $_POST['name'];
  $extra = $_POST['extra'];
  //$title = "<h1>Hi There</h1>";
  require("helper1.php");
});

// If a <form> or an AJAX post.
// Pass name and extra, or name and php://input extra to my helper1.php
// This works with either 'Content-Type': 'application/json' or
// 'Content-Type': 'application/x-www-form-urlencoded'
// body: JSON.stringify({name: "what is this"}) or
// body: "name=what is this"

$router->map('POST', '/test/[a:sub]', function($x) {
  $name = urldecode($x['sub']);
  $extra = $_POST['extra'];
  if(!$extra) {
    $extra = json_decode(file_get_contents("php://input"))->extra;
  }
  $title = "<h1>Hi There</h1>";
  require("helper1.php");
});

// POST finduser. If via 'test' (test.php) then we will get the values from $_POST.
// If we run this from the command line via curl:
// curl -d '{"name":"Barton", "id": 1}' -H 'Content-Type: application/json' https://bartonlp.org/finduser
// Then the information is from php://input.
// If we run this from the command line via curl:
// curl -d "name=Barton&id=1" https://bartonlp.org/findus
// Then the info is in $POST as 'Content-Type': 'application/x-www-form-urlencoded' seems to be the default.

$router->map('POST', '/finduser', function() {
  $data = json_decode(file_get_contents("php://input"));

  if($_POST) {
    // Get the data from $_POST if it is not empty.

    $name = $_POST['name'];
    $id = $_POST['id'];
  } else {
    // Get info from the $data object.
    $name = $data->name;
    $id = $data->id;
  }
  
  require('finduser.php');
});

// Match request against $router_map(...) entries.
// This returns $match which has target, param and name.


$match = $router->match();

// If we found a match with one of the above $router->map entries and if the match is callable then
// we execute the match with the params.
// If no match output error information.

if(is_array($match) && is_callable($match['target'])) {
  // Yes we found it so lets exicute it.
  
  call_user_func($match['target'], $match['params']);
} else {
  // We did not find a match so send a 404 header and then echo the information.
  
  header("HTTP/1.0 404 Not Found");
  echo <<<EOF
<!-- AltoRouter Demo -->
<!DOCTYPE html>
<html>
<body>
<h1>Sorry. That for which you were looking, we could not find.</h1>
<h3>404 Not Found.</h3>
<p>The router responds to:</p>
<ul>
<li>/
<li>/getip
<li>/contactus
<li>/contactus/{subject}
<li>/test
<li>/test/{subject}
<li>/finduser/{name}/{id}
</ul>
<p>You could also use <b>curl</b> from the command line to post data.</p>
<ul>
<li>A POST with /test. Like <b>curl -d "subject=HI&subject2=There&name=Barton" https://bartonlp.org/test</b>
<li>A POST with /test/{subject}. Like <b>curl -d "name=Jack" https://bartonlp.org/test/Something</b>
<li>A POST with /finduser. Like <b>curl -d "name=Barton&id=1" https://bartonlp.org/finduser</b>
</ul>
</body>
</html>
EOF;
}
