=== A faster load_textdomain ===
Contributors: PerS
Tags: l10n, load_textdomain, cache, performance
Requires at least: 5.9
Requires PHP: 7.4
Tested up to: 6.4
Stable tag: 2.2.4
Donate link: https://paypal.me/PerSoderlind
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A faster load_textdomain

== Description ==

This is a WordPress plugin that caches the .mo file as an PHP array, and [include](https://www.php.net/manual/en/function.include.php) the array instead of the .mo file.
In theory, nothing is faster in PHP than loading and executing another PHP file.

= How it works =

If you have a plugin or theme that loads a textdomain, e.g. `load_textdomain( 'textdomain', $path_to_mo_file )`, then this plugin will:

1. Look for a PHP version of the .mo file in `WP_CONTENT_DIR . '/cache/a-faster-load-textdomain'` directory.
2. If the PHP version exists, [include](https://www.php.net/manual/en/function.include.php) the file.
3. If the PHP version doesn't exist, load the .mo file, and save the file as an PHP array in `wp-content/cache/a-faster-load-textdomain/` directory.

The localized PHP array can be cached via [PHP OPcache](http://blog.jpauli.tech/2015-03-05-opcache-html/). If you have PHP OPcache enabled, then the localized PHP array will be cached in memory, and the PHP file will not be parsed again.

= Filters =

`a_faster_load_textdomain_cache_path`

Change the cache path, default is `WP_CONTENT_DIR . '/cache/a-faster-load-textdomain'`.

`
add_filter( 'a_faster_load_textdomain_cache_path', function( $path ) {
	return WP_CONTENT_DIR . '/cache/my-cache';
} );
`

= GitHub =

The plugin source is available at [GitHub](https://github.com/soderlind/a-faster-load-textdomain/blob/main/a-faster-load-textdomain.php)


== Installation ==

Either (recommended):
- Download the plugin files and extract `a-faster-load-textdomain.php` and `class-afld-cachehandler.php` to the `wp-content/mu-plugins` directory.

Or:
- Search for "A faster load_textdomain" and install with the WordPress plugin installer. 
- (Network) Activate the plugin through the 'Plugins' menu in WordPress.

It's also possible to install the plugin via Composer:

`composer require soderlind/a-faster-load-textdomain` 

== Changelog ==

= 2.2.4 =

* Fail gracefully if  cache directory can't be created.

= 2.2.3 =

* Housekeeping.

= 2.2.2 =

* Add uninstall handler. Will remove the cache directory when the plugin is uninstalled.

= 2.2.1 =

* Fix bug in cache handler.

= 2.2.0 =

* Refactor cache handler.

= 2.1.5 =

- Bump version to force deploy to WordPress.org

= 2.1.4 =

- Deploy with GitHub Actions to WordPress.org

= 2.1.3 =

- Remove `mkdir()`

= 2.1.2 =

* Fail gracefully if `$cache_path` can't be created.

= 2.1.1 =
* Add `aflt_load_textdomain` filter.

= 2.1.0 =
* Rename namespace to `Soderlind\Plugin\A_Faster_Load_Textdomain`
* Rename cache directory to `WP_CONTENT_DIR . '/cache/a-faster-load-textdomain'`

= 2.0.1 =
* Rename file to `a-faster-load-textdomain.php` to follow WordPress plugin standards.

= 2.0.0 =
* Refactor code, instead of using a transient, save .mo file as an PHP array, and [include](https://www.php.net/manual/en/function.include.php) the array instead of the .mo file.

= 1.0.3 =
* Housekeeping.

= 1.0.2 =
* DRY (Don't Repeat Yourself) code. Add namespace.

= 1.0.1 =
* Add multisite support

= 1.0.0 =
* Initial release

