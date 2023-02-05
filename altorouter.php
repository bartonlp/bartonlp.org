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

// This file DOES NOT DO a require_onece(getenv("SITELOADNAME") or set $S.
// The $router->map() functions can do it to set up $_site.

require_once("/var/www/vendor/autoload.php");

$router = new AltoRouter();

// Do Routing

$router->map('GET', '/', function() {
  global $h, $b;
  require('index.php');
});

$router->map('GET', '/getip', function() {
  global $h, $b;
  require('getmyip.php');
});

$router->map('GET', '/contactus', function() {
  global $h, $b;  
  $subject = "NO INFO PASSED";
  require("contact.php");
});
          
$router->map('GET', '/contactus/[a:subject]', function($y) {
  global $h, $b;  
  $subject = urldecode($y['subject']);
  require("contact.php");
});

$router->map('GET', '/test', function() {
  global $h, $b;  
  require("test.php");
});

$router->map('GET', '/test/[*:xyz]', function($y) {
  global $h, $b;  
  $data = file_get_contents("php://input");
  $xyz = urldecode($y['xyz']);
  echo "<h1>This is test</h1><p>{$xyz}</p>";
});

// GET. If you enter https://bartonlp.org/{name}/{id} at the location bar

$router->map('GET', '/finduser/[a:name]/[i:id]', function($x) {
  global $h, $b;  
  $name = $x['name'];
  $id = $x['id'];
  require("finduser.php");
});

// POSTS

$router->map('POST', '/test', function() {
  global $h, $b;  
  $subject = $_POST['subject'];
  $subject2 = $_POST['subject2'];
  $name = $_POST['name'];
  echo "TEST: subject=$subject, subject2=$subject2, name=$name\n";
  //require("test2.php");
});

// POST test/{subject}
// This works with either 'Content-Type': 'application/json' or
// 'Content-Type': 'application/x-www-form-urlencoded'
// body: JSON.stringify({name: "what is this"}) or
// body: "name=what is this"

$router->map('POST', '/test/[*:sub]', function($x) {
  $subject = urldecode($x['sub']);
  $extra = json_decode(file_get_contents("php://input"));
  $name = $_POST["name"];

  if($name) $subject .= ", $name";
  elseif($extra->name) $subject .= ", $extra->name";

  echo "<h1>This is test</h1><p>$subject</p>\n";
});

// POST finduser. If via 'test' (test.php) then we will get the values from $_POST.
// If we run this from the command line via curl:
// curl -d '{"name":"Barton", "id": 1}' -H 'Content-Type: application/json'\
//   https://bartonlp.org/finduser
// Then the information is from php://input.
// If we run this from the command line via curl:
// curl -d "name=Barton&id=1" https://bartonlp.org/findus
// Then the info is in $POST as 'Content-Type': 'application/x-www-form-urlencoded' seems to be the default.

$router->map('POST', '/finduser', function() {
  global $h, $b;  
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

$match = $router->match();

if(is_array($match) && is_callable($match['target'])) {
  call_user_func($match['target'], $match['params']);
} else {
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
