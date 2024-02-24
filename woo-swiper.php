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
 * @package           Woo_Swiper
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommerce Swiper
 * Plugin URI:        https://wijnberg.dev
 * Description:       Enhances WooCommerce product image display with Swiper, providing a responsive and touch-friendly slider.
 * Version:           1.0.0
 * Author:            Wijnberg Developments
 * License:           MIT
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-swiper
 * Domain Path:       /languages
 * Requires at least:   6.0
 * Tested up to:        6.4
 * Requires PHP:        7.2
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
define( 'WOO_SWIPER_VERSION', '1.0.0' );//

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-swiper-activator.php
 */
function activate_woo_swiper() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-swiper-activator.php';
	Woo_Swiper_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-swiper-deactivator.php
 */
function deactivate_woo_swiper() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-swiper-deactivator.php';
	Woo_Swiper_Deactivator::deactivate();
}

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

register_activation_hook( __FILE__, 'activate_woo_swiper' );
register_deactivation_hook( __FILE__, 'deactivate_woo_swiper' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-swiper.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_swiper() {

	$plugin = new Woo_Swiper();
	$plugin->run();

}

run_woo_swiper();
