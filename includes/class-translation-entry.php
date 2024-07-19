<?php
/**
 * Translation_Entry class.
 *
 * @package a-faster-load-textdomain
 */

namespace Soderlind\Plugin\A_Faster_Load_Textdomain;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
/**
 * Translation_Entry class.
 *
 * @package a-faster-load-textdomain
 */
class Translation_Entry extends \Translation_Entry {


		/**
		 * Constructor for the Translation_Entry class.
		 *
		 * @param array<string, mixed> $args Arguments array.
		 *
		 * @return \Translation_Entry
		 */
	public static function __set_state( $args ) {
		return new \Translation_Entry( $args );
	}
}
