<?php
// When you run https://bartonlp.org it is routed through autorouter.php. See autorouter.php.
// This Demo goes with the altorouter.php and the AltoRouter class.
// To make altorouter work you need to add the following to the .htaccess
//  RewriteRule ^$ altorouter.php [L]
//  RewriteRule ^$ altorouter.php [L]
//  RewriteCond %{REQUEST_FILENAME} !-f
//  RewriteRule . altorouter.php [L]
// Get AltoRouter from github or composer.
// composer require altorouter/altorouter
// https://github.com/dannyvankooten/AltoRouter
//

$_site = require_once(getenv("SITELOADNAME"));
ErrorClass::setDevelopment(true);
$S = new SiteClass($_site);

$S->title = "Part of AltoRouter Demo";
$S->banner = "<h1>$S->title</h1>";
$S->preheadcomment = "<!-- Using AltoRouter. Using SiteClass -->";

// The JavaScript does a lot of the work.

$S->b_inlineScript = <<<EOF
// Show source button

$("#but1").on("click", function() {
  if(!this.flag) {
    $("#fileinfo").css("display", "block");
    $(this).html("Don't Display This File");
  } else {
    $("#fileinfo").css("display", "none");
    $(this).html("Display This File");
  }
  this.flag = !this.flag;
});

$("#but2").on("click", function() {
  if(!this.flag) {
    $("#altoinfo").css("display", "block");
    $(this).html("Don't Display altorouter.php");
  } else {
    $("#altoinfo").css("display", "none");
    $("this").html("Display altorouter.php");
  }
  this.flag = !this.flag;
});

// Get keydown on doit, post and fetch.

$("body").on("keydown", "#get,#post,#fetch", function(e) {
  if(e.keyCode == '13') {
    let x = $("#"+this.id).nextUntil("div", "input"); // the id is followed by a br an input and a div.
    $(x).trigger("click");
  }
});

// Ajax Get

$("#getit").on("click", function() {
  let stuff = $("#get").val();
  console.log(`stuff: \${stuff}`);
  
  $.ajax({
    url: `test/\${stuff}`,
    //data: {other: "This is other Stuff"}, // I could pass data up in addition to stuff.
    type: "get",
    success: function(data) {
      console.log(`Data: \${data}`);
      $("#getithere").html(data);
    },
    error: function(err) {
      console.log(`ERR: \${err}`);
    }
  });
});

// Ajax Post

$("#postit").on("click", function() {
  let stuff = $("#post").val();

  $.ajax({
    url: `test/\${stuff}`,
    data: {extra: "JavaScript added 'WhatTheHell'"}, // I can pass data up in addition to stuff
    type: "post",
    success: function(data) {
      //$("#postithere").html(data);
      $("#postithere").html("<iframe width='100%'></ifram>");
      let iframe = document.querySelector("#postithere iframe");
      iframe.srcdoc = data;
    },
    error: function(err) {
      console.log(`POST ERR: \${err}`);
    }
  });
});

// Use fetch

$("#fetchit").on("click", function() {
  let name = $("#fetch").val();

  fetch(`test/\${name}`, {
    method: "POST",
    headers: {
      'Content-Type': 'application/json'
      //'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: JSON.stringify({extra: "JavaScript added this little bit 'what is this'"})
    //body: "name=what is this"
  })
  .then(data => data.text())
  .then(data => {
    $("#fetchithere").html("<iframe width='100%'></iframe>");
    //let iframe = $("#fetchithere iframe");
    let iframe = document.querySelector("#fetchithere iframe");
    iframe.srcdoc = data;
  })
  .catch(err => console.log(`ERR: ${err}`));
});
EOF;

$S->css = <<<EOF
input { font-size: 25px; }
input[type="submit"] { border-radius: 5px; }
#fileinfo, #altoinfo { display: none; }
#but1, #but2 { color: white; background: green; border-radius: 5px; font-size: 20px; }
.border { padding: 10px; width: 600px; border: 1px solid black; border-radius: 5px; margin-bottom: 10px; }
EOF;

$S->h_script =<<<EOF
<!-- Get the syntaxhightlighter code and the theme.css -->
<script src="https://bartonphillips.net/js/syntaxhighlighter.js"></script>
<link rel='stylesheet' href="https://bartonphillips.net/css/theme.css">
EOF;

$file = escapeltgt(file_get_contents("helper2.php"));
$altofile = escapeltgt(file_get_contents("altorouter.php"));

[$top, $footer] = $S->getPageTopBottom();

// Display Page

echo <<<EOF
<!-- Head and start of body -->
$top
<!--<style>.border { padding: 10px; width: 300px; border: 1px solid black; border-radius: 5px; }</style>-->
<hr>
<!-- Start of Page -->
<p>Full Source Code. Just click the two buttons below.</p>

<div>
<button id="but1">Display this File</button>
<div id="fileinfo">
<p><b>helper2.php</b></p>
<pre class='brush: php'>
$file
</pre>
</div>
</div>

<div>  
<button id="but2">Display altorouter.php</button>
<div id="altoinfo">
<p><b>altorouter.php</b></p>
<pre class='brush: php'>
$altofile
</pre>
</div>
</div>

<!-- Link to 'helper1.php?subject=Barton' -->
<p><a href="/test/Barton">This is a TEST link (/test/Barton. This is like helper1.php?subject=Barton)</a></p>
<!-- First Form -->
<div class="border">
<p>FORM 1</p>
<form action="test" method="post">
Enter Something: <input type="text" name="name"><br>
<input type="submit" value="Submit">
</form>
<div id="form1">$name</div>
</div>

<!-- Second Form -->
<div class="border">
<p>FORM 2</p>
<form action="test" method="post">
<table border="1">
<tr><td>Name</td><td><input type="text" name="name"></td></tr>
<tr><td>Message</td><td><input type="text" name="extra"></td></tr>
</table>
<input type="submit" value="Submit">
</form>
<div id="form2">$name $extra</div>
</div>

<!-- Third Form -->
<!--
<div class="border">
<p>FORM 3. This goes to finduser.php</p>
<form action="finduser/one" method="post">
<table border="1">
<tr><td>Name</td><td><input type="text" name="name"></td></tr>
<tr><td>ID</td><td><input type="text" name="id"></td></tr>
</table>
<input type="submit" value="Submit">
</div>
-->
<!-- Ajax GET -->
<div class="border">
<p>Ajax GET</p>
<input id="get"><br>
<input id="getit" type='submit' value="Submit">
<div id="getithere"></div>
</div>
<!-- Ajax POST -->
<div class="border">
<p>Ajax POST</p>
<input id="post"><br>
<input id="postit" type='submit' value="Submit">
<div id="postithere"></div>
</div>
<!-- Use Fetch -->
<div class="border">
<p>Fetch Post</p>
<input id="fetch"><br>
<input id="fetchit" type='submit' value="Submit">
<div id="fetchithere"></div>
</div>
<hr>
<!-- All done footer goes here -->
$footer
EOF;
