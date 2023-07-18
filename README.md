# A Faster load_textdomain

This is a WordPress plugin that caches the `.mo` file in a transient to speed up the loading of text domains.

## Prerequisites

WordPress 6.3, I'm using the `pre_load_textdomain` filter, or later.

## Installation

1. Download the plugin files and extract `wp-cache-textdomain.php` to the `wp-content/mu-plugins` directory.
2. Optional, add an object cache to your WordPress installation.

## Usage

The plugin automatically caches the `.mo` file in a transient when it is loaded, and retrieves the cached data when the same file is loaded again. This speeds up the loading of text domains in WordPress.

## Frequently Asked Questions

### How do I add an object cache?

You can add an object cache by installing a caching plugin like

- [W3 Total Cache](https://wordpress.org/plugins/w3-total-cache/)
- [Redis Object Cache](https://wordpress.org/plugins/redis-cache/)
- [Object Cache Pro](https://objectcache.pro/)

I use Object Cache Pro, it's a premium plugin, but it's worth every penny.

## Credits

This plugin is based on a patch by [nicofuma](https://core.trac.wordpress.org/ticket/32052).

## Copyright and License

This plugin is copyright © 2023 [Per Soderlind](http://soderlind.no).

This plugin is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See [LICENSE](LICENSE) for more information.
