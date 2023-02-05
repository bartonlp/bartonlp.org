# This is the *www.bartonlp.org* domain which lives in /var/www/html.

This site uses AltoRouter to route the pages. AltoRouter is at https://github.com/dannyvankooten/AltoRouter. The __.htaccess__ file
must be modified for the router:
```
  RewriteEngin on
  RewriteRule ^$ altorouter.php [L]
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule . altorouter.php [L]
```
These are the pages in this directory:
```
  index.php
  test.php
  contact.php
  getmyip.php
  finduser.php
```
These can all be displayed by just entering the page name. For example to display the index just enter __index.x.php__.
These pages can also be displayed by just entering these names: __test__, __getip__, __contactus/*{name}*__, __finduser/*{name}*/*{id}*__,
(replace {name} with a single name, {id} with a number). This goes through __altorouter.php__ which uses the *AltoRouter* Class.

Enter __https://bartonlp.org/test__. From __test__ you can exersise the demo.

Contact me at [bartonphillips@gmail.com](mailto:bartonphillips@gmail.com)  
My home page is https://www.bartonphillips.com




