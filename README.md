Rescue Case Management
===

Provide a way for volunteers to create and update rescue cases.

Hipchat: https://www.hipchat.com/gBniKYEB9


## To get started
1. There's an sql dump in the root. Use it. 
1. There's a wp-config-sample file. Use it. Make sure you read the comments.
1. There is *not* an .htaccess file. You'll need to create one. See below for an example.
1. Once you get everything set up the __first__ thing you need to do is login via /wp-login.php __then__ go comment out the line in wp-config.php that's sets RELOCATE to true.
1. Username/password for this sql dump is master/changeme. Don't worry. It's changed on the live site.
1. Live site is on http://sagip.me/

## Htaccess example
```
# BEGIN WordPress
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteBase /
  RewriteRule ^index\.php$ - [L]
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule . /index.php [L]
</IfModule>
# END WordPress
```

## Data Import
Save a copy of [this Google Doc](https://docs.google.com/spreadsheet/ccc?key=0At2Cl1rhLtA_dFF0TjYyeGlNU1JIeHhmLU9VcUVldHc&usp=sharing) and follow the instructions on the first sheet.

Basic steps are:

1. Fill in form
2. Save as CSV
3. Go to Tools -> Import -> CSV (in WP Admin section)
4. Follow instructions
5. Verify imported cases

Spreadsheets templates can also be found in the __"data-import"__ folder in Excel and Open Document Format.


## Need help?
Need a user account on the live site? 
Need files pushed up to live from the repo?
Want to be a contributor on this project?

__Anything. Contact me.__

https://www.hipchat.com/gBniKYEB9 or @mikengarrett or mgarrett@webdevelopmentgroup.com 


## Other resources
Project tracker
https://docs.google.com/document/d/1bxo6nyPDKtj1suauQeaCMt3BBBqEoNAf6ngQsGGm7zE/edit#heading=h.6rboxxuan26f

General chat
https://www.hipchat.com/g9bBgsIwG

What's all this crazy wp-config stuff you're having me do?
http://codex.wordpress.org/Editing_wp-config.php


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/MikeNGarrett/rcm/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

