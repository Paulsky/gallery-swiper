<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wijnberg.dev
 * @since      1.0.0
 *
 * @package    Woo_Swiper
 * @subpackage Woo_Swiper/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woo_Swiper
 * @subpackage Woo_Swiper/public
 * @author     Wijnberg Developments
 */
class Woo_Swiper_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		//if ( is_woocommerce() || is_shop() || is_product_category() || is_product() ) {
			wp_register_style( 'swiper-css', plugin_dir_url( __FILE__ ) . 'vendor/swiper/swiper-bundle.min.css', [], '11.0.6' );
			wp_enqueue_style( 'swiper-css' );
		//}
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		//if ( is_woocommerce() || is_shop() || is_product_category() || is_product() ) {
			wp_register_script( 'swiper-js', plugin_dir_url( __FILE__ ) . 'vendor/swiper/swiper-bundle.min.js', [], '11.0.6', true );
			wp_enqueue_script( 'swiper-js' );

			wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-swiper-public.js', [ 'swiper-js' ], $this->version, true );


			$swiper_settings = get_option( 'woo_swiper_settings', [] );

			$localized_settings = [
				'swiper' => [
					'scrollbar'  => ! empty( $swiper_settings['woo_swiper_scrollbar'] ) ? true : false,
					'pagination' => ! empty( $swiper_settings['woo_swiper_pagination'] ) ? true : false,
					'navigation' => ! empty( $swiper_settings['woo_swiper_navigation'] ) ? true : false,
					'breakpoint' => ! empty( $swiper_settings['woo_swiper_breakpoint'] ) ? intval( $swiper_settings['woo_swiper_breakpoint'] ) : null,
				]
			];

			wp_localize_script( $this->plugin_name, 'wooSwiperSettings', $localized_settings );

			wp_enqueue_script( $this->plugin_name );
		//}
	}

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
			//This is the default for woocommerce_before_shop_loop_item_title!
			echo woocommerce_get_product_thumbnail();
		}
	}

	public function add_themes_compatibility() {
		//GeneratePress Theme compatibility
		remove_action( 'woocommerce_before_shop_loop_item_title', 'generatepress_wc_secondary_product_image' );
	}

	public function add_plugins_compatibility() {
		add_action( 'wp_enqueue_scripts', function () {

			//Yith infinite scrolling compatibility
			if ( is_plugin_active( 'yith-infinite-scrolling/init.php' ) ) {
				wp_register_script( 'woo-swiper-yith-infinite-scrolling', plugin_dir_url( __FILE__ ) . 'js/yith-infinite-scrolling.js', [
					'jquery',
					'yith-infinitescroll',
					$this->plugin_name
				], $this->version, true );
				wp_enqueue_script( 'woo-swiper-yith-infinite-scrolling' );
			}

		} );
	}

	public function on_woocommerce_init() {
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'mutate_product_thumbnail_structure' ], 10 );

		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

		$this->add_themes_compatibility();
		$this->add_plugins_compatibility();
	}

}
