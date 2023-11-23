<?php
/**
 * Plugin Name: A faster load_textdomain
 * Version: 2.2.1
 * Description: Cache the .mo file as an PHP array, and load the array instead of the .mo file.
 * Author: Per Soderlind
 * Author URI: https://soderlind.no
 * Plugin URI: https://github.com/soderlind/a-faster-load-textdomain
 * License: GPLv2 or later
 *
 * @package a-faster-load-textdomain
 */

declare( strict_types = 1 );
namespace Soderlind\Plugin\A_Faster_Load_Textdomain;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_Filesystem' ) ) {
	require_once ABSPATH . 'wp-admin/includes/file.php';
}

if ( ! \class_exists( 'AFLD_CacheHandler' ) ) {
	require_once __DIR__ . '/includes/class-afld-cachehandler.php';
}

require_once __DIR__ . '/includes/class-translation-entry.php';

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
	// Get the global $l10n variable.
	global $l10n;

	// Check if the .mo file is readable.
	if ( ! is_readable( $mofile ) ) {
		// If the file is not readable, return false.
		return false;
	}

	// Apply filter to get cache path, default is 'WP_CONTENT_DIR/cache/a-faster-load-textdomain'.
	$cache_path = apply_filters( 'a_faster_load_textdomain_cache_path', WP_CONTENT_DIR . '/cache/a-faster-load-textdomain' );

	// Create a new instance of the CacheHandler class.
	$cache_handler = new \AFLD_CacheHandler( $cache_path, 'mo' );

	// Get the cached data for the MO file.
	$data = $cache_handler->get_cache_data( $mofile );

	// Get the last modification time of the MO file.
	$mtime = filemtime( $mofile );

	// Create a new instance of the MO class.
	$mo = new \MO();

	// If there's no cached data or the MO file has been modified since the last cache update...
	if ( ! $data || ! isset( $data['mtime'] ) || $mtime > $data['mtime'] ) {
		// ...try to import the MO file.
		if ( ! $mo->import_from_file( $mofile ) ) {
			return false;
		}

		// Prepare the data to be cached.
		$data = [
			'mtime'   => $mtime, // The last modification time of the MO file.
			'file'    => $mofile, // The path to the MO file.
			'entries' => $mo->entries, // The entries from the MO file.
			'headers' => $mo->headers, // The headers from the MO file.
		];

		// Update the cached data.
		$cache_handler->update_cache_data( $mofile, $data, __NAMESPACE__ . '\Translation_Entry' );
	} else {
		// If the cached data is up-to-date, use it to set the entries and headers of the MO object.
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
