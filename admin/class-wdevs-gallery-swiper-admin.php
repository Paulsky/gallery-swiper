<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wijnberg.dev
 * @since      1.0.0
 *
 * @package    Wdevs_Gallery_Swiper
 * @subpackage Wdevs_Gallery_Swiper/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wdevs_Gallery_Swiper
 * @subpackage Wdevs_Gallery_Swiper/admin
 * @author     Wijnberg Developments
 */
class Wdevs_Gallery_Swiper_Admin {

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
	 * AJAX action used to remember that the footer rating link was clicked.
	 *
	 * @since 1.7.1
	 */
	const AJAX_ACTION_FOOTER_RATED = 'wdevs_gallery_swiper_footer_rated';

	/**
	 * Nonce action for the footer rating request.
	 *
	 * @since 1.7.1
	 */
	const AJAX_NONCE_ACTION_FOOTER_RATED = 'wdevs-gallery-swiper-footer-rated-nonce';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.5.7
	 */
	public function enqueue_scripts() {
		// Only load on WooCommerce settings page with our tab
		$page = isset( $_GET['page'] ) ? sanitize_text_field( $_GET['page'] ) : '';
		$tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : '';
		
		if ( $page === 'wc-settings' && $tab === 'wdevs_gallery_swiper' ) {
			wp_enqueue_script( 
				$this->plugin_name . '-admin', 
				plugin_dir_url( __FILE__ ) . 'js/wdevs-gallery-swiper-admin.js', 
				array( 'jquery' ), 
				$this->version, 
				true 
			);
		}
	}

	/**
	 * @since 1.5.3
	 */
	public function add_action_links( $actions ) {
		$links = array(
			'<a href="' . admin_url( 'admin.php?page=wc-settings&tab=wdevs_gallery_swiper' ) . '">' . __( 'Settings' ) . '</a>', //Yes, just use WordPress text domain
		);

		$actions = array_merge( $actions, $links );

		return $actions;
	}

	/**
	 * Hide the WooCommerce rating footer on the Gallery Swiper settings tab.
	 *
	 * @since 1.7.1
	 */
	public function hide_woocommerce_footer_text( $display ) {
		return Wdevs_Gallery_Swiper_Woocommerce::is_settings_page() ? false : $display;
	}

	/**
	 * Change the admin footer text on Gallery Swiper settings pages.
	 *
	 * @see WC_Admin::admin_footer_text()
	 *
	 * @since 1.7.1
	 */
	public function admin_footer_text( $footer_text ) {
		if ( ! current_user_can( 'manage_woocommerce' ) || ! Wdevs_Gallery_Swiper_Woocommerce::is_settings_page() ) {
			return $footer_text;
		}

		if ( get_option( 'wdevs_gallery_swiper_admin_footer_text_rated' ) ) {
			return '<span id="footer-thankyou">' . esc_html__( 'Thank you for using Product Gallery Swiper for WooCommerce.', 'product-gallery-swiper-for-woocommerce' ) . '</span>';
		}

		$footer_text = sprintf(
			/* translators: 1: Product Gallery Swiper for WooCommerce 2: five stars */
			__( 'If you like %1$s please leave us a %2$s rating. A huge thanks in advance!', 'product-gallery-swiper-for-woocommerce' ),
			sprintf( '<strong>%s</strong>', esc_html__( 'Product Gallery Swiper for WooCommerce', 'product-gallery-swiper-for-woocommerce' ) ),
			'<a href="https://wordpress.org/support/plugin/product-gallery-swiper-for-woocommerce/reviews/?rate=5#new-post" target="_blank" rel="noopener" class="wdevs-gallery-swiper-rating-link" aria-label="' . esc_attr__( 'five star', 'product-gallery-swiper-for-woocommerce' ) . '" data-rated="' . esc_attr__( 'Thanks :)', 'product-gallery-swiper-for-woocommerce' ) . '">&#9733;&#9733;&#9733;&#9733;&#9733;</a>'
		);

		$script = "
			(function() {
				'use strict';
				var ratingLink = document.querySelector('a.wdevs-gallery-swiper-rating-link');
				if (!ratingLink) {
					return;
				}

				ratingLink.addEventListener('click', function(e) {
					var formData = new FormData();
					formData.append('action', '" . esc_js( self::AJAX_ACTION_FOOTER_RATED ) . "');
					formData.append('nonce', '" . esc_js( wp_create_nonce( self::AJAX_NONCE_ACTION_FOOTER_RATED ) ) . "');

					fetch('" . esc_js( admin_url( 'admin-ajax.php' ) ) . "', {
						method: 'POST',
						body: formData,
						credentials: 'same-origin'
					});

					if (e.currentTarget.parentElement) {
						e.currentTarget.parentElement.textContent = e.currentTarget.getAttribute('data-rated');
					}
				});
			})();
		";

		$handle = 'wdevs-gallery-swiper-admin-footer-rating';
		wp_register_script( $handle, '', array(), $this->version, true );
		wp_enqueue_script( $handle );
		wp_add_inline_script( $handle, $script );

		return '<span id="footer-thankyou">' . $footer_text . '</span>';
	}

	/**
	 * Remember that the current user clicked the footer rating link.
	 *
	 * @since 1.7.1
	 */
	public function wdevs_gallery_swiper_footer_rated_action() {
		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce'] ) ), self::AJAX_NONCE_ACTION_FOOTER_RATED ) ) {
			wp_die( -1 );
		}

		if ( ! current_user_can( 'manage_woocommerce' ) ) {
			wp_die( -1 );
		}

		update_option( 'wdevs_gallery_swiper_admin_footer_text_rated', 1 );
		wp_die();
	}

}
