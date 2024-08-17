<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wijnberg.dev
 * @since      1.0.0
 *
 * @package    Wdevs_Gallery_Slider
 * @subpackage Wdevs_Gallery_Slider/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wdevs_Gallery_Slider
 * @subpackage Wdevs_Gallery_Slider/includes
 * @author     Wijnberg Developments
 */
class Wdevs_Gallery_Slider_Activator {

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
			
			wp_die( __( 'This plugin requires WooCommerce. Please install and activate WooCommerce before activating this plugin.', 'wdevs-gallery-slider' ) );
		}

		self::migrate_settings();
	}

	/**
	 * Migrates settings from 'Woo Swiper' to 'Wdevs Gallery Slider'.
	 *
	 * This plugin was renamed from 'Woo Swiper' to 'Wdevs Gallery Slider' in version 1.1.
	 * This method ensures that existing settings are transferred to the new format.
	 *
	 * @since    1.1.0
	 */
	private static function migrate_settings() {
		$old_settings = get_option( 'woo_swiper_settings', [] );

		if ( empty( $old_settings ) ) {
			return;
		}

		// Mapping of old setting keys to new ones
		$settings_mapping = [
			'woo_swiper_scrollbar'  => 'wdevs_gallery_slider_scrollbar',
			'woo_swiper_pagination' => 'wdevs_gallery_slider_pagination',
			'woo_swiper_navigation' => 'wdevs_gallery_slider_navigation',
			'woo_swiper_breakpoint' => 'wdevs_gallery_slider_breakpoint'
		];

		// Update each setting individually
		foreach ( $settings_mapping as $old_key => $new_key ) {
			if ( isset( $old_settings[ $old_key ] ) ) {
				update_option( $new_key, $old_settings[ $old_key ] );
			}
		}

		// Remove old settings
		delete_option( 'woo_swiper_settings' );
	}

}
