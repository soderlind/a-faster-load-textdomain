<?php
/**
 * Plugin Name: A faster load_textdomain
 * Version: 1.0.3
 * Description: Cache the .mo file in a transient
 * Author: Per Soderlind
 * Author URI: https://soderlind.no
 * Plugin URI: https://github.com/soderlind/wp-cache-textdomain
 * License: GPLv2 or later
 * Credit: nicofuma , I just created the plugin based on his patch (https://core.trac.wordpress.org/ticket/32052)
 * Save the plugin in mu-plugins. You don't have to, but you should add an an object cache.
 *
 * @package wp-cache-textdomain
 */

declare( strict_types = 1 );
namespace Soderlind\Plugin\WP_Cache_Textdomain;

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

	// Check if the .mo file is readable.
	$hash = md5_file( $mofile );
	if ( false === $hash ) {
		// If the file is not readable, return false.
		return false;
	}

	// Check if the data for the file is already in the transient cache.
	$data  = ( ( \is_multisite() ) ) ? \get_site_transient( $hash ) : \get_transient( $hash );
	$mtime = filemtime( $mofile );

	// Create a new MO object.
	$mo = new \MO();

	// Check if the data is already in the cache and if it is up-to-date.
	if ( ! $data || ! isset( $data['mtime'] ) || $mtime > $data['mtime'] ) {
		// If the data is not in the cache or is outdated, import the .mo file into the MO object.
		if ( ! $mo->import_from_file( $mofile ) ) {
			// If the import fails, return false.
			return false;
		}

		// Store the entries and headers from the MO object in an array with the modification time.
		$data = [
			'mtime'   => $mtime,
			'entries' => $mo->entries,
			'headers' => $mo->headers,
		];

		// Store the data in a transient with the MD5 hash of the .mo file path as the key.
		if ( \is_multisite() ) {
			\set_site_transient( $hash, $data );
		} else {
			\set_transient( $hash, $data );
		}
	} else {
		// If the data is already in the cache and the file has not been modified, retrieve the data from the cache.
		$mo->entries = $data['entries'];
		$mo->headers = $data['headers'];
	}

	// If the text domain already exists in the $l10n global variable, merge the new MO object with the existing object.
	if ( isset( $l10n[ $domain ] ) ) {
		$mo->merge_with( $l10n[ $domain ] );
	}

	// Set the $l10n global variable to the new MO object and return true.
	$l10n[ $domain ] = &$mo; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited

	return true;
}
\add_filter( 'pre_load_textdomain', __NAMESPACE__ . '\a_faster_load_textdomain', 1, 4 );
