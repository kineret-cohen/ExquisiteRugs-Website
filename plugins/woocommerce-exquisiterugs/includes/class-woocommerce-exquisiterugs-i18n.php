<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://paulmiller3000.com
 * @since      1.0.0
 *
 * @package    WC_ExquisiteRugs
 * @subpackage WC_ExquisiteRugs/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    WC_ExquisiteRugs
 * @subpackage WC_ExquisiteRugs/includes
 * @author     Paul Miller <hello@paulmiller3000.com>
 */
class WC_ExquisiteRugs_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'woocommerce-exquisiterugs',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
