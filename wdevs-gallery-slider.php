<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wijnberg.dev
 * @since             1.0.0
 * @package           Wdevs_Gallery_Slider
 *
 * @wordpress-plugin
 * Plugin Name:       Product Gallery Slider for WooCommerce
 * Plugin URI:        https://products.wijnberg.dev
 * Description:       Enhances WooCommerce product images display on product listing sections, providing a responsive and touch-friendly slider.
 * Version:           1.1.0
 * Author:            Wijnberg Developments
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wdevs-gallery-slider
 * Domain Path:       /languages
 * Requires at least: 6.0
 * Tested up to:      6.6
 * Requires PHP:      7.2
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOO_SWIPER_VERSION', '1.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wdevs-gallery-slider-activator.php
 */
function activate_wdevs_gallery_slider() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wdevs-gallery-slider-activator.php';
	Wdevs_Gallery_Slider_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wdevs-gallery-slider-deactivator.php
 */
function deactivate_wdevs_gallery_slider() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wdevs-gallery-slider-deactivator.php';
	Wdevs_Gallery_Slider_Deactivator::deactivate();
}

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

register_activation_hook( __FILE__, 'activate_wdevs_gallery_slider' );
register_deactivation_hook( __FILE__, 'deactivate_wdevs_gallery_slider' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wdevs-gallery-slider.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wdevs_gallery_slider() {

	$plugin = new Wdevs_Gallery_Slider();
	$plugin->run();

}

run_wdevs_gallery_slider();
