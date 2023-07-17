# A Faster load_textdomain

This is a WordPress plugin that caches the `.mo` file in a transient to speed up the loading of text domains.

## Installation

1. Download the plugin files and extract them to the `wp-content/mu-plugins` directory.
2. Activate the plugin through the 'Plugins' screen in WordPress.

## Usage

The plugin automatically caches the `.mo` file in a transient when it is loaded, and retrieves the cached data when the same file is loaded again. This speeds up the loading of text domains in WordPress.

## Contributing

Contributions are welcome! Please submit a pull request or open an issue on the [GitHub repository](https://github.com/soderlind/wp-cache-textdomain).

## License

This plugin is licensed under the GPLv2 or later.

## Credits

This plugin is based on a patch by [nicofuma](https://core.trac.wordpress.org/ticket/32052).
