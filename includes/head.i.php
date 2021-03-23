<?php
// $arg is available from SiteClass::getPageHead() as the $args passed in.
// $this is available from SiteClass

//error_log("arg: " . print_r($arg, true));
//error_log("this: " . print_r($this, true));

if(empty($arg['keywords'])) {
  $arg['keywords'] = $this->keywords;
}
if(empty($arg['title'])) {
  $arg['title'] = $this->title;
}
if(empty($arg['desc'])) {
  $arg['desc'] = $this->desc;
}
// Renter Head section

return <<<EOF
<head>
  <title>{$arg['title']}</title>
  <!-- METAs -->
  <meta charset='utf-8'/>
  <meta name="copyright" content="$this->copyright">
  <meta name="Author" content="$this->author"/>
  <meta name="description" content="{$arg['desc']}"/>
  <meta name="keywords" content="{$arg['keywords']}"/>
  <meta name=viewport content="width=device-width, initial-scale=1">
  <!-- More meta tags -->
{$arg['meta']}
  <!-- CSS -->
  <link rel="stylesheet" href="https://bartonphillips.net/css/blp.css">
  <link rel="stylesheet" href="fonts.css">
  <!-- css is not css but a link to tracker via .htaccess RewriteRule. -->
  <link rel="stylesheet" href="/csstest-{$this->LAST_ID}.css" title="blp test">
  {$arg['link']}
  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script>
var lastId = $this->LAST_ID;
  </script>
  <script src="https://bartonphillips.net/js/tracker.js"></script>
  <!-- Custom Scripts and CSS -->
{$arg['extra']}
{$arg['script']}
{$arg['css']}
</head>
EOF;
