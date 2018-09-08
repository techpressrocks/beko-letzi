<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://1daywebsite.ch
 * @since      1.0.0
 *
 * @package    Beko_Letzi
 * @subpackage Beko_Letzi/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Beko_Letzi
 * @subpackage Beko_Letzi/includes
 * @author     Andreas Feuz <info@1daywebsite.ch>
 */
class Beko_Letzi_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'beko-letzi',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
