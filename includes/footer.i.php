<?php
// BLP 2018-06-21 -- NOTE we are using PUG and this is ONLY used if the xxx.php is the url!
//  See the pug/layout.pug!

// Footer file
// Render the Footer

$lastmod = date("M j, Y H:i", getlastmod());

return <<<EOF
<style>
.social {
        text-align: center;
        margin-bottom: 1em;
}
</style>
<!--
  This div has the 'twitter', 'facebook' icons and links.
  It uses "FontAwesome" from the "https://bartonphillips.net/css/allnatural/social/font/"
  directory. FontAwesome has gliphs for the social media companies. XXX
-->
<div class="social">
  <a href="http://twitter.com" class="icon-button twitter">
    <i class="icon-twitter"></i>
    <span></span>
  </a>
  <a href="https://www.facebook.com/tysongroup/"
    class="icon-button facebook">
    <i class="icon-facebook"></i>
    <span></span>
  </a>
</div>
<!--
  Normal footer
-->
<footer>
<address>
<div id="address">
<address>
  Copyright &copy; $this->copyright
</address>
<address>
$this->author at $this->address<br>
<a href='mailto:$this->EMAILADDRESS'>$this->EMAILADDRESS</a>
</address>
</div>
{$arg['msg']}
{$arg['msg1']} 
$counterWigget
{$arg['msg2']}
<p>Last Modified: $lastmod</p>
</footer>
{$arg['script']}
</body>
</html>
EOF;
