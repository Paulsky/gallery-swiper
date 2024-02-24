<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wijnberg.dev
 * @since      1.0.0
 *
 * @package    Woo_Swiper
 * @subpackage Woo_Swiper/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woo_Swiper
 * @subpackage Woo_Swiper/includes
 * @author     Wijnberg Developments
 */
class Woo_Swiper_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			
			wp_die( __( 'This plugin requires Woocommerce. Please install and activate WooCommerce before activating this plugin.', 'woo-swiper' ) );
		}
	}

}
