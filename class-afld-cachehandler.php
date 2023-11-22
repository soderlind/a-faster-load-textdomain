<?php
/**
 * Cache handler class.
 *
 * @package A_Faster_Load_Textdomain
 */

namespace Soderlind\Plugin\A_Faster_Load_Textdomain;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/**
 * Class CacheHandler
 *
 * Handles caching of data.
 */
class AFLD_CacheHandler {
	/**
	 * Path to the cache directory.
	 *
	 * @var string
	 */
	private $cache_path;

	/**
	 * Prefix for cache files.
	 *
	 * @var string
	 */
	private $cache_file_prefix;

	/**
	 * CacheHandler constructor.
	 *
	 * @param string $cache_path Path to the cache directory.
	 * @param string $cache_file_prefix Prefix for cache files.
	 */
	public function __construct( $cache_path, $cache_file_prefix ) {
		$this->cache_path        = $cache_path;
		$this->cache_file_prefix = $cache_file_prefix;
	}

	/**
	 * Get cached data for a specific file.
	 *
	 * @param string $file Path to the file.
	 *
	 * @return mixed Cached data if it exists, false otherwise.
	 */
	public function get_cache_data( $file ) {
		// Ensure cache directory exists.
		if ( ! file_exists( $this->cache_path ) ) {
			if ( ! wp_mkdir_p( $this->cache_path ) ) {
				return false;
			}
		}

		// Construct cache file path.
		$cache_file = sprintf( '%s/%s-%s.php', $this->cache_path, $this->cache_file_prefix, md5( $file ) );

		// If cache file exists, include it and return the data.
		if ( file_exists( $cache_file ) ) {
			include $cache_file;
			return isset( $val ) ? $val : false;
		} else {
			return false;
		}
	}

	/**
	 * Update cached data for a specific file.
	 *
	 * @param string $file Path to the file.
	 * @param mixed  $data Data to cache.
	 * @param string $str_class String class name.
	 */
	public function update_cache_data( $file, $data, $str_class = 'Translation_Entry' ) {
		// Construct cache file path.
		$cache_file = sprintf( '%s/%s-%s.php', $this->cache_path, $this->cache_file_prefix, md5( $file ) );
		$val        = var_export( $data, true ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_var_export
		$val        = str_replace( 'Translation_Entry::', sprintf( '\%s::', $str_class ), $val );
		// Write data to cache file.
		if ( ! WP_Filesystem() ) {
			file_put_contents( $cache_file, '<?php $val = ' . $val . ';', LOCK_EX ); // phpcs:ignore
		} else {
			global $wp_filesystem;
			$wp_filesystem->put_contents( $cache_file, '<?php $val = ' . $val . ';', FS_CHMOD_FILE );
		}
	}
}
