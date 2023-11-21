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
