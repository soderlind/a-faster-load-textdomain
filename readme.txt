=== Plugin Name ===
Contributors: PerS
Tags: l10n, load_textdomain, cache, transient
Requires at least: 6.3
Tested up to: 6.3
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A faster load_textdomain

== Description ==

This plugin caches the .mo file in a transient to speed up the load_textdomain function in WordPress. 
You don't have to, but you should add an an object cache.


== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/mu-plugind` directory.
2. Optional, add an object cache to your WordPress installation.

== Frequently Asked Questions ==

= How do I add an object cache? =

You can add an object cache by installing a caching plugin like 
* [W3 Total Cache](https://wordpress.org/plugins/w3-total-cache/)
* [Redis Object Cache](https://wordpress.org/plugins/redis-cache/)
* [Object Cache Pro](https://objectcache.pro/) 


== Changelog ==

= 1.0.0 =
* Initial release

== Upgrade Notice ==

= 1.0.0 =
Initial release
