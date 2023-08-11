# A Faster load_textdomain

This is a WordPress plugin that caches the .mo file as an PHP array, and [include](https://www.php.net/manual/en/function.include.php) the array instead of the .mo file. In theory, nothing is faster in PHP than loading and executing another PHP file.

## Installation

1. Download the plugin files and extract `a-faster-load-textdomain.php` to the `wp-content/mu-plugins` directory.

## How It Works

If you have a plugin or theme that loads a textdomain, e.g. `load_textdomain( 'textdomain', $path_to_mo_file )`, then this plugin will:

1. Look for a PHP version of the .mo file in `WP_CONTENT_DIR . '/cache/a-faster-load-textdomain'` directory.
2. If the PHP version exists, [include](https://www.php.net/manual/en/function.include.php) the file.
3. If the PHP version doesn't exist, load the .mo file, and save the file as an PHP array in `wp-content/cache/a-faster-load-textdomain/` directory.

The localized PHP array can be cached via [PHP OPcache](http://blog.jpauli.tech/2015-03-05-opcache-html/). If you have PHP OPcache enabled, then the localized PHP array will be cached in memory, and the PHP file will not be parsed again.

## Changelog

### 2.1.0

- Rename namespace to `Soderlind\Plugin\A_Faster_Load_Textdomain`
- Rename cache directory to `WP_CONTENT_DIR . '/cache/a-faster-load-textdomain'`

### 2.0.1

- Rename file to `a-faster-load-textdomain.php` to follow WordPress plugin standards.

### 2.0.0

- Refactor code, instead of using a transient, save .mo file as an PHP array, and [include](https://www.php.net/manual/en/function.include.php) the array instead of the .mo file.

### 1.0.3

- Housekeeping.

### 1.0.2

- DRY (Don't Repeat Yourself) code. Add namespace.

### 1.0.1

- Add multisite support

### 1.0.0

- Initial release

## Credits

Orignal file: https://github.com/lynt-smitka/WP-nginx-config/blob/master/extras/mu-plugins/lynt-mo-cache.php

## Copyright and License

This plugin is copyright © 2023 [Per Soderlind](http://soderlind.no).

This plugin is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See [LICENSE](LICENSE) for more information.
