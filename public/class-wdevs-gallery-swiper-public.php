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
	private const SWIPER_VERSION = '11.2.0';

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

		$theme_color = get_option( 'wdevs_gallery_swiper_theme_color', '' );
		if ( ! empty( $theme_color ) ) {
			$inline_css = sprintf(
				'.woocommerce ul.products li.product .swiper { --swiper-theme-color: %s; }',
				esc_attr($theme_color)
			);
			wp_add_inline_style( $this->plugin_name . '-public', $inline_css );
		}
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
	 * Add compatibility fixes for various themes.
	 *
	 * Currently, this function removes the secondary product image functionality
	 * from the GeneratePress theme to avoid conflicts.
	 *
	 * @since    1.0.0
	 */
	public function add_themes_compatibility() {
		// Default WooCommerce
		//remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

		// GeneratePress Theme compatibility
		remove_action( 'woocommerce_before_shop_loop_item_title', 'generatepress_wc_secondary_product_image' );

		// Blocksy Theme compatibility: disable product (card) image
		if ( function_exists( 'blocksy_template_loop_product_thumbnail' ) ) {
			add_filter( "theme_mod_woo_card_layout", function ( $value ) {
				if ( $this->should_display_gallery() ) {
					if ( is_array( $value ) ) {
						foreach ( $value as &$layout ) {
							if ( $layout['id'] === 'product_image' ) {

								$layout['enabled'] = false;
							}
						}
					}
				}

				return $value;
			} );

			add_action( 'woocommerce_before_shop_loop_item_title', function () {
				if ( $this->should_display_gallery() ) {
					blocksy_template_loop_product_thumbnail( [
						'id'      => 'product_image',
						'enabled' => true
					] );
				}
			}, 5 );
		}

		// XStore theme compatibility: init swiper after AJAX filter
		if(function_exists('etheme_theme_setup')){
			wp_register_script( 'wdevs-gallery-swiper-xstore-theme', plugin_dir_url( __FILE__ ) . 'js/xstore-theme.js', [
				'jquery',
				'ajaxFilters',
				$this->plugin_name
			], $this->version, true );
			wp_enqueue_script( 'wdevs-gallery-swiper-xstore-theme' );
		}
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

			// Woo Product Filter by WBW compatibility
			if ( is_plugin_active( 'woo-product-filter/woo-product-filter.php' ) ) {
				wp_register_script( 'wdevs-gallery-swiper-woo-product-filter-by-wbw', plugin_dir_url( __FILE__ ) . 'js/woo-product-filter-by-wbw.js', [
					'jquery',
					'commonWpf',
					$this->plugin_name
				], $this->version, true );
				wp_enqueue_script( 'wdevs-gallery-swiper-woo-product-filter-by-wbw' );
			}
		} );

		// GeneratePress Premium compatibility. Adjust gallery rendering timing for image wrapper conflict
		if ( function_exists( 'generatepress_wc_image_wrapper_close' ) ) {
			remove_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'finish_gallery_rendering' ], PHP_INT_MAX );
			add_action( 'woocommerce_shop_loop_item_title', [ $this, 'finish_gallery_rendering' ], 9 );
		}
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

		add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'start_gallery_rendering' ], PHP_INT_MIN );
		add_action( 'woocommerce_before_shop_loop_item_title', [ $this, 'finish_gallery_rendering' ], PHP_INT_MAX );

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

	/**
	 * Begins the HTML structure for the Swiper gallery container.
	 *
	 * Creates the opening HTML elements for the Swiper gallery, including
	 * the main container, wrapper, and first slide which will contain
	 * the product's featured image. Only runs if the gallery should be
	 * displayed for the current product.
	 *
	 * @since    1.4.0
	 */
	public function start_gallery_rendering() {
		if ( $this->should_display_gallery() ) {
			echo '<div class="swiper">';
			echo '<div class="swiper-wrapper">';
			echo '<div class="swiper-slide">';
		}
	}

	/**
	 * Completes the Swiper gallery structure and adds gallery images.
	 *
	 * Closes the initial slide div, then adds additional slides for each gallery
	 * image from the product's gallery. Finally adds the Swiper navigation elements and closes all container elements.
	 * This method works in conjunction with start_gallery_rendering() to create
	 * the complete gallery structure.
	 *
	 * @since    1.4.0
	 */
	public function finish_gallery_rendering() {
		if ( $this->should_display_gallery() ) {
			echo '</div>';

			$product = wc_get_product();
			foreach ( $product->get_gallery_image_ids() as $attachment_id ) {
				echo '<div class="swiper-slide">' . $this->get_product_image( $product, $attachment_id ) . '</div>';
			}

			if ($product->is_type('variable')){
				$consider_variation_images = ( get_option( 'wdevs_gallery_swiper_variation_images', 'no' ) === 'yes' );
				if ( $consider_variation_images ) {
					$variation_images = [];
					$variations       = $product->get_available_variations();

					foreach ( $variations as $variation ) {
						if ( ! empty( $variation['image_id'] ) && ! in_array( $variation['image_id'], $variation_images, true ) ) {
							echo '<div class="swiper-slide">' . $this->get_product_image( $product, $variation['image_id'] ) . '</div>';
							$variation_images[] = $variation['image_id'];
						}
					}
				}
			}

			echo '</div>';
			echo '<div class="swiper-pagination"></div>';
			echo '<div class="swiper-button-prev"></div>';
			echo '<div class="swiper-button-next"></div>';
			echo '<div class="swiper-scrollbar"></div>';
			echo '</div>';
		}
	}

	/**
	 * Determines if the gallery should be displayed.
	 *
	 * Checks if the current post is a product, has a product object,
	 * contains gallery images, and has a featured thumbnail.
	 *
	 * @return bool True if gallery should be displayed, false otherwise.
	 * @since    1.4.0
	 */
	private function should_display_gallery(): bool {
		if ('product' !== get_post_type()) {
			return false;
		}

		$has_featured_image = has_post_thumbnail();

		if(!$has_featured_image){
			return false;
		}

		$product = wc_get_product();
		if (!$product) {
			return false;
		}

		$gallery_images = $product->get_gallery_image_ids();
		if(count($gallery_images) > 0){
			return true;
		}

		$consider_variation_images = (get_option('wdevs_gallery_swiper_variation_images', 'no') === 'yes');
		if($consider_variation_images){
			return $this->product_has_variation_images($product);
		}

		return false;
	}

	/**
	 * Get the product image HTML for the gallery.
	 *
	 * Retrieves the product image HTML based on the attachment ID and theme compatibility.
	 *
	 * @param WC_Product $product The product object.
	 * @param int $attachment_id The attachment ID of the image.
	 * @return string The HTML for the product image.
	 *
	 * @since    1.4.0
	 */
	private function get_product_image( $product, $attachment_id ) {
		if ( ! isset( $product ) ) {
			return '';
		}

		if ( function_exists( 'blocksy_media' ) ) {

			return $this->get_blocksy_image( $product, $attachment_id );
		}

		return wp_get_attachment_image( $attachment_id, 'woocommerce_thumbnail' );
	}

	/**
	 * Get the product image HTML using Blocksy theme compatibility.
	 *
	 * Generates the product image HTML using Blocksy theme's media function
	 * with proper attributes and filters.
	 *
	 * @param WC_Product $product The product object.
	 * @param int $attachment_id The attachment ID of the image.
	 * @return mixed The HTML for the product image with Blocksy compatibility.
	 *
	 * @since    1.4.0
	 */
	private function get_blocksy_image( $product, $attachment_id ): mixed {
		$html_atts = [
			'href'       => apply_filters(
				'woocommerce_loop_product_link',
				get_permalink( $product->get_id() ),
				$product
			),
			'aria-label' => strip_tags( $product->get_name() ),
		];

		$image = blocksy_media( [
			'no_image_type'               => 'woo',
			'attachment_id'               => $attachment_id,
			'post_id'                     => $product->get_id(),
			'size'                        => 'woocommerce_archive_thumbnail',
			'include_original_image_size' => is_customize_preview(),
			'ratio'                       => apply_filters(
				'blocksy:woocommerce:product-card:thumbnail:ratio',
				blocksy_get_woocommerce_ratio( [
					'key'      => 'archive_thumbnail',
					'cropping' => blocksy_akg(
						'blocksy_woocommerce_archive_thumbnail_cropping',
						[],
						'predefined'
					)
				] ),
				$product->get_id()
			),
			'tag_name'                    => 'a',
			'html_atts'                   => $html_atts,
		] );

		return apply_filters(
			'woocommerce_product_get_image',
			$image,
			$product,
			'woocommerce_archive_thumbnail',
			[],
			'',
			$image
		);
	}

	/**
	 * Checks if the product has a variation with an image
	 *
	 * @param $product
	 *
	 * @return bool
	 *
	 * @since    1.5.2
	 */
	private function product_has_variation_images($product): bool {
		if (!$product->is_type('variable')) {
			return false;
		}

		foreach ($product->get_available_variations() as $variation) {
			if (!empty($variation['image_id'])) {
				return true;
			}
		}

		return false;
	}
}
