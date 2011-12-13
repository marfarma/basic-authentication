=== Plugin Name ===
Contributors: Klaas Cuvelier
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=LKYLGQJPSRY9Q
Tags: authentication, login
Requires at least: 3.0
Tested up to: 3.3
Stable tag: 1.9

With this plugin, you can ask users to authenticate before they can see your Wordpress site.


== Description ==

With this plugin, you can ask users to authenticate before they can see your Wordpress site.
You can either use the WordPress logins to authenticate, or a given password.
This plugin can be useful when your website is still under construction or in beta fase.
No HTTP Authentication is used.


== Installation ==

1. Upload all files to a folder in  the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Activate/deactive authentication and edit preferences in the Option page

== Frequently Asked Questions ==

= Any Questions? =
No, not yet

== Upgrade Notice ==
No special remarks

== Screenshots ==

1. Overview of the options for this plugin


== Changelog ==

= 1.0 =
* first version of this plugin

= 1.3 =
* fix for people with older PHP

= 1.4 = 
* fix use site_url for redirection

= 1.5 =
* typo fix

= 1.6 =
* description
* flood message
* better flood protection 
* defined blocked time
* if using predefined pwd, you are not loggedin when the pwd changes (even though you're sessions can still be active)

= 1.6.1 =
* debug fix

= 1.7 =
* fix for xmlrpc

= 1.8 =
* fix redirect_url when WP isn't installed in root directory. Thx @ Rob Record

= 1.8.1 =
* bugfix

= 1.9 =
* make compatible with WordPress 3.3