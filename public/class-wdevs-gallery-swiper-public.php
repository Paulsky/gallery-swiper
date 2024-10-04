<?php

/**
 * The public-facing functionality of the plugin.
 *
 * This file contains the Wdevs_Gallery_Swiper_Public class which handles all public-facing
 * aspects of the plugin, including enqueueing scripts and styles, modifying WooCommerce
 * product displays, and ensuring compatibility with themes and other plugins.
 *
 * @link       https://wijnberg.dev
 * @since      1.0.0
 *
 * @package    Wdevs_Gallery_Swiper
 * @subpackage Wdevs_Gallery_Swiper/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks for enqueueing the public-facing stylesheet
 * and JavaScript. It also handles the modification of WooCommerce product displays and
 * ensures compatibility with various themes and plugins.
 *
 * @package    Wdevs_Gallery_Swiper
 * @subpackage Wdevs_Gallery_Swiper/public
 * @author     Wijnberg Developments
 */
class Wdevs_Gallery_Swiper_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * The version of the Swiper library used by this plugin.
	 *
	 * @since    1.1.0
	 */
	private const SWIPER_VERSION = '11.1.9';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.1.0
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * This function registers and enqueues the Swiper CSS file.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_register_style( 'swiper-css', plugin_dir_url( __FILE__ ) . 'vendor/swiper/swiper-bundle.min.css', [], self::SWIPER_VERSION );
		wp_enqueue_style( 'swiper-css' );

		wp_enqueue_style( $this->plugin_name . '-public', plugin_dir_url( __FILE__ ) . 'css/wdevs-gallery-swiper-public.css', array(), $this->version );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * This function registers and enqueues the Swiper JS library and the plugin's custom JS file.
	 * It also localizes the script with the plugin settings.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_register_script( 'swiper-js', plugin_dir_url( __FILE__ ) . 'vendor/swiper/swiper-bundle.min.js', [], self::SWIPER_VERSION, true );
		wp_enqueue_script( 'swiper-js' );

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wdevs-gallery-swiper-public.js', [ 'swiper-js' ], $this->version, true );

		$localized_settings = [
			'swiper' => [
				'scrollbar'  => get_option( 'wdevs_gallery_swiper_scrollbar', 'yes' ) === 'yes',
				'pagination' => get_option( 'wdevs_gallery_swiper_pagination', 'no' ) === 'yes',
				'navigation' => get_option( 'wdevs_gallery_swiper_navigation', 'no' ) === 'yes',
				'breakpoint' => $this->parse_breakpoint( get_option( 'wdevs_gallery_swiper_breakpoint', '' ) ),
			]
		];

		wp_localize_script( $this->plugin_name, 'wgsSettings', $localized_settings );

		wp_enqueue_script( $this->plugin_name );
	}

	/**
	 * Modify the product thumbnail structure to implement the gallery slider.
	 *
	 * This function replaces the standard WooCommerce product thumbnail with a Swiper slider
	 * containing all product gallery images.
	 *
	 * @since    1.0.0
	 */
	public function mutate_product_thumbnail_structure() {
		if ( 'product' === get_post_type() && ( $product = wc_get_product() ) && ( $attachment_ids = $product->get_gallery_image_ids() ) && has_post_thumbnail() ) {
			echo '<div class="swiper">';
			echo '<div class="swiper-wrapper">';

			echo '<div class="swiper-slide"> ' . woocommerce_get_product_thumbnail() . '</div > ';

			foreach ( $attachment_ids as $attachment_id ) {
				echo '<div class="swiper-slide">' . wp_get_attachment_image( $attachment_id, 'woocommerce_thumbnail' ) . '</div>';
			}

			echo '</div>';

			echo '<div class="swiper-pagination"></div>';
			echo '<div class="swiper-button-prev"></div>';
			echo '<div class="swiper-button-next"></div>';
			echo '<div class="swiper-scrollbar"></div>';
			echo '</div>';
		} else {
			// This is the default for woocommerce_before_shop_loop_item_title
			echo woocommerce_get_product_thumbnail();
		}
	}

	/**
	 * Add compatibility fixes for various themes.
	 *
	 * Currently, this function removes the secondary product image functionality
	 * from the GeneratePress theme to avoid conflicts.
	 *
	 * @since    1.0.0
	 */
	public function add_themes_compatibility() {
		// GeneratePress Theme compatibility
		remove_action( 'woocommerce_before_shop_loop_item_title', 'generatepress_wc_secondary_product_image' );
	}

	/**
	 * Add compatibility fixes for various plugins.
	 *
	 * This function adds compatibility with the YITH Infinite Scrolling plugin.
	 *
	 * @since    1.0.0
	 */
	public function add_plugins_compatibility() {
		add_action( 'wp_enqueue_scripts', function () {
			// YITH Infinite Scrolling compatibility
			if ( is_plugin_active( 'yith-infinite-scrolling/init.php' ) ) {
				wp_register_script( 'wdevs-gallery-swiper-yith-infinite-scrolling', plugin_dir_url( __FILE__ ) . 'js/yith-infinite-scrolling.js', [
					'jquery',
					'yith-infinitescroll',
					$this->plugin_name
				], $this->version, true );
				wp_enqueue_script( 'wdevs-gallery-swiper-yith-infinite-scrolling' );
			}
		} );
	}

	/**
	 * Initialize the plugin's public-facing functionality.
	 *
	 * This function is called when WooCommerce is initialized. It sets up all necessary
	 * actions and filters for the plugin to function properly.
	 *
	 * @since    1.0.0
	 */
	public function on_woocommerce_init() {
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'mutate_product_thumbnail_structure' ], 10 );

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

		$this->add_themes_compatibility();
		$this->add_plugins_compatibility();
	}

	/**
	 * Parse the breakpoint value from the settings.
	 *
	 * This function converts the breakpoint setting to an integer and validates it.
	 *
	 * @param string $breakpoint The breakpoint value from the settings.
	 *
	 * @return   int|null                 The parsed breakpoint value or null if invalid.
	 * @since    1.1.0
	 */
	private function parse_breakpoint( $breakpoint ) {
		$value = intval( $breakpoint );

		return $value > 0 ? $value : null;
	}
}