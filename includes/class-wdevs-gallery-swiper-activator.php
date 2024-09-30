<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wijnberg.dev
 * @since      1.0.0
 *
 * @package    Wdevs_Gallery_Swiper
 * @subpackage Wdevs_Gallery_Swiper/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wdevs_Gallery_Swiper
 * @subpackage Wdevs_Gallery_Swiper/includes
 * @author     Wijnberg Developments
 */
class Wdevs_Gallery_Swiper_Activator {

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

			wp_die( esc_html__( 'This plugin requires WooCommerce. Please install and activate WooCommerce before activating this plugin.', 'product-gallery-swiper-for-woocommerce' ) );
		}

		self::migrate_settings();
	}

	/**
	 * Migrates settings from 'Woo Swiper' to 'Wdevs Gallery Swiper'.
	 *
	 * This plugin was renamed from 'Woo Swiper' to 'Wdevs Gallery Swiper' in version 1.1.
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
			'woo_swiper_scrollbar'            => 'wdevs_gallery_swiper_scrollbar',
			'woo_swiper_pagination'           => 'wdevs_gallery_swiper_pagination',
			'woo_swiper_navigation'           => 'wdevs_gallery_swiper_navigation',
			'woo_swiper_breakpoint'           => 'wdevs_gallery_swiper_breakpoint',
			'wdevs_gallery_slider_scrollbar'  => 'wdevs_gallery_swiper_scrollbar',
			'wdevs_gallery_slider_pagination' => 'wdevs_gallery_swiper_pagination',
			'wdevs_gallery_slider_navigation' => 'wdevs_gallery_swiper_navigation',
			'wdevs_gallery_slider_breakpoint' => 'wdevs_gallery_swiper_breakpoint',
		];

		// Update each setting individually
		foreach ( $settings_mapping as $old_key => $new_key ) {
			if ( isset( $old_settings[ $old_key ] ) ) {
				if ( $old_key !== 'woo_swiper_breakpoint' ) {
					// Convert checkbox values to WooCommerce format, which is 'yes'/'no'
					$new_value = $old_settings[ $old_key ] == '1' ? 'yes' : 'no';
				} else {
					// For non-checkbox settings, just use the old value
					$new_value = $old_settings[ $old_key ];
				}
				update_option( $new_key, $new_value );
			}
		}

		// Remove old settings
		delete_option( 'woo_swiper_settings' );
	}

}
