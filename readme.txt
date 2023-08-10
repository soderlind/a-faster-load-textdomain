=== Plugin Name ===
Contributors: PerS
Tags: l10n, load_textdomain, cache, transient
Requires at least: 5.9
Tested up to: 6.3
Stable tag: 2.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A faster load_textdomain

== Description ==

This is a WordPress plugin that caches the .mo file as PHP array, and [include](https://www.php.net/manual/en/function.include.php) the array instead of the .mo file.
In theory, nothing is faster in PHP than loading and executing another PHP file.


== Installation ==

1. Download the plugin files and extract `wp-cache-textdomain.php` to the `wp-content/mu-plugins` directory.


== Changelog ==

= 2.0.0 =
* Refactor code, instead of using a transient, save .mo file as PHP array, and [include](https://www.php.net/manual/en/function.include.php) the array instead of the .mo file.

= 1.0.3 =
* Housekeeping.

= 1.0.2 =
* DRY (Don't Repeat Yourself) code. Add namespace.

= 1.0.1 =
* Add multisite support

= 1.0.0 =
* Initial release

