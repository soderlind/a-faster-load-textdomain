<?php
/**
 * Plugin Name: A faster load_textdomain
 * Version: 2.0.0
 * Description: Cache the .mo file as PHP array, and load the array instead of the .mo file.
 * Author: Per Soderlind
 * Author URI: https://soderlind.no
 * Plugin URI: https://github.com/soderlind/wp-cache-textdomain
 * License: GPLv2 or later
 *
 * @package wp-cache-textdomain
 */

declare( strict_types = 1 );
namespace Soderlind\Plugin\WP_Cache_Textdomain;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Filesystem' ) ) {
	require_once ABSPATH . 'wp-admin/includes/file.php';
}

/**
 * Translation_Entry class.
 *
 * @package wp-cache-textdomain
 */
class Translation_Entry extends \Translation_Entry {

	/**
	 * Constructor.
	 *
	 * @param array $args {
	 *     Optional. Array of arguments for the translation entry.
	 *
	 *     @type string $singular Singular form of the string.
	 *     @type string $plural   Plural form of the string.
	 *     @type string $context  Context information for the translators.
	 *     @type string $domain   Text domain. Unique identifier for retrieving translated strings.
	 *     @type string $context  Context information for the translators.
	 *     @type string $translations {
	 *         Optional. Array of translations for different plural forms.
	 *
	 *         @type string $singular Singular form of the string.
	 *         @type string $plural   Plural form of the string.
	 *     }
	 * }
	 */
	public static function __set_state( $args ) {
		return new \Translation_Entry( $args );
	}
}


/**
 * Load a text domain faster by caching the parsed .mo file data.
 *
 * @param bool   $loaded Whether the text domain was loaded.
 * @param string $domain Text domain. Unique identifier for retrieving translated strings.
 * @param string $mofile Path to the .mo file.
 * @param string $locale Optional. The locale to use. Default is null.
 *
 * @return bool Whether the text domain was loaded successfully.
 */
function a_faster_load_textdomain( $loaded, $domain, $mofile, $locale = null ) {
	global $l10n;
	if ( ! is_readable( $mofile ) ) {
		return false;
	}

	$cache_path = WP_CONTENT_DIR . '/cache/wp-cache-textdomain';
	if ( ! file_exists( $cache_path ) ) {
		mkdir( $cache_path, 0770, true );
	}
	$cache_file = sprintf( '%s/mo-%s.php', $cache_path, md5( $mofile ) );

	if ( file_exists( $cache_file ) ) {
		include $cache_file;
		$data = isset( $val ) ? $val : false;
	} else {
		$data = false;
	}

	$mtime = filemtime( $mofile );

	$mo = new \MO();

	// Check if $data is empty or if the mtime of the file is greater than the mtime in $data.
	if ( ! $data || ! isset( $data['mtime'] ) || $mtime > $data['mtime'] ) {
		// Import the translations from the MO file.
		if ( ! $mo->import_from_file( $mofile ) ) {
			return false;
		}

		// Create an array with the mtime, file, entries, and headers.
		$data = [
			'mtime'   => $mtime,
			'file'    => $mofile,
			'entries' => $mo->entries,
			'headers' => $mo->headers,
		];

		// Export the data to a PHP file.
		$val = var_export( $data, true ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_var_export

		// Replace Translation_Entry with \Soderlind\Plugin\WP_Cache_Textdomain\Translation_Entry.
		$val = str_replace( 'Translation_Entry::', '\Soderlind\Plugin\WP_Cache_Textdomain\Translation_Entry::', $val );

		// Write the data to the cache file using WP_Filesystem if available, otherwise use file_put_contents.
		if ( ! WP_Filesystem() ) {
			file_put_contents( $cache_file, '<?php $val = ' . $val . ';', LOCK_EX ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_read_file_put_contents
		} else {
			global $wp_filesystem;
			$wp_filesystem->put_contents( $cache_file, '<?php $val = ' . $val . ';', FS_CHMOD_FILE );
		}
	} else {
		// If the data is already cached, use it.
		$mo->entries = $data['entries'];
		$mo->headers = $data['headers'];
	}

	// Merge the translations with the existing translations for the domain.
	if ( isset( $l10n[ $domain ] ) ) {
		$mo->merge_with( $l10n[ $domain ] );
	}

	// Set the translations for the domain.
	$l10n[ $domain ] = &$mo; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

	// Return true to indicate success.
	return true;
}


if ( version_compare( $GLOBALS['wp_version'], '6.3' ) >= 0 ) {
	\add_filter( 'pre_load_textdomain', __NAMESPACE__ . '\a_faster_load_textdomain', 1, 4 );
} else {
	\add_filter( 'override_load_textdomain', __NAMESPACE__ . '\a_faster_load_textdomain', 0, 3 );
}
