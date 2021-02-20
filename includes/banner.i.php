<?php
return <<<EOF
<header id="header">
  <a href="http://www.bartonlp.org">
    <img id='logo' src="https://bartonphillips.net/images/blp-image.png" alt="barton"></a>
  <!-- the 'a' tag must be at the end of the image src otherwise we get an '-'-->
  <a href="http://linuxcounter.net/">
    <img id='linuxcounter' src="/tracker.php?page=normal&id=$this->LAST_ID" alt="linux counter image.">
  </a>
  <h1>$this->mainTitle</h1>
  <h2>$mainTitle</h2>
<noscript id="noscript">
<style>
html {
  display:block;
}
</style>
<p>
Your browser either does not support <b>JavaScripts</b> or you have JavaScripts disabled, in either case your browsing
experience will be significantly impaired. If your browser supports JavaScripts but you have it disabled consider enabaling
JavaScripts conditionally if your browser supports that. Sorry for the inconvienence.</p>
</noscript>
</header>
EOF;
