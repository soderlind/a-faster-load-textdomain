=== A faster load_textdomain ===
Contributors: PerS
Tags: l10n, load_textdomain, cache, performance
Requires at least: 5.9
Requires PHP: 7.4
Tested up to: 6.3
Stable tag: 2.0.1
Donate link: https://paypal.me/PerSoderlind
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A faster load_textdomain

== Description ==

This is a WordPress plugin that caches the .mo file as PHP array, and [include](https://www.php.net/manual/en/function.include.php) the array instead of the .mo file.
In theory, nothing is faster in PHP than loading and executing another PHP file.

If you have a plugin or theme that loads a textdomain, e.g. `load_textdomain( 'textdomain', $path_to_mo_file )`, then this plugin will:

1. Look for a cached version of the .mo file in `wp-content/cache/wp-cache-textdomain/` directory.
2. If the cached version exists, [include](https://www.php.net/manual/en/function.include.php) the cached version.
3. If the cached version doesn't exist, load the .mo file, and save the file as PHP array in `wp-content/cache/wp-cache-textdomain/` directory.

The localized PHP array can be cached via PHP OPcache. If you have PHP OPcache enabled, then the localized PHP array will be cached in memory, and the PHP file will not be parsed again.

== Installation ==

1. Download the plugin files and extract `wp-cache-textdomain.php` to the `wp-content/mu-plugins` directory.


== Changelog ==

= 2.0.1 =
* Rename file to `a-faster-load-textdomain.php` to follow WordPress plugin standards.

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

