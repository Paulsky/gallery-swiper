<?php

/**
 * The WooCommerce functionality of the plugin.
 *
 * @link       https://wijnberg.dev
 * @since      1.2.0
 *
 * @package    Wdevs_Tax_Switch
 * @subpackage Wdevs_Tax_Switch/includes
 */

/**
 * The WooCommerce functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks for WooCommerce functionality.
 * This class is responsible for registering and rendering the WooCommerce settings.
 *
 * @package    Wdevs_Gallery_Swiper
 * @subpackage Wdevs_Gallery_Swiper/includes
 * @author     Wijnberg Developments <contact@wijnberg.dev>
 */
class Wdevs_Gallery_Swiper_Woocommerce {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.2.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.2.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;


	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.2.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
	}

	/**
	 * Declare WooCommerce compatibility
	 *
	 * @since 1.2.0
	 */
	public function declare_compatibility(){
		if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', 'wdevs-gallery-swiper/wdevs-gallery-swiper.php', true );
		}
	}

	/**
	 * Add settings tab to WooCommerce settings.
	 *
	 * @param array $settings_tabs Array of WooCommerce setting tabs.
	 *
	 * @return   array    $settings_tabs    Array of WooCommerce setting tabs.
	 * @since    1.2.0
	 */
	public function add_settings_tab( $settings_tabs ) {
		$settings_tabs['wdevs_gallery_swiper'] = __( 'Gallery Swiper', 'product-gallery-swiper-for-woocommerce' );
		return $settings_tabs;
	}

	/**
	 * Get settings for the Wdevs Tax Switch tab.
	 *
	 * @return   array    $settings    Array of settings.
	 * @since    1.2.0
	 */
	public function get_settings() {
		$settings = array(
			array(
				'name' => __( 'Gallery Swiper settings', 'product-gallery-swiper-for-woocommerce' ),
				'type' => 'title',
				'desc' => __( 'Customize the Gallery slider settings.', 'product-gallery-swiper-for-woocommerce' ),
				'id'   => 'wdevs_gallery_swiper_section_title'
			),
			array(
				'name'    => __( 'Enable scrollbar', 'product-gallery-swiper-for-woocommerce' ),
				'type'    => 'checkbox',
				'desc'    => __( 'Enable scrollbar for the slider', 'product-gallery-swiper-for-woocommerce' ),
				'id'      => 'wdevs_gallery_swiper_scrollbar',
				'default' => 'yes'
			),
			array(
				'name'    => __( 'Enable pagination', 'product-gallery-swiper-for-woocommerce' ),
				'type'    => 'checkbox',
				'desc'    => __( 'Enable pagination for the slider', 'product-gallery-swiper-for-woocommerce' ),
				'id'      => 'wdevs_gallery_swiper_pagination',
				'default' => 'no'
			),
			array(
				'name'    => __( 'Enable navigation', 'product-gallery-swiper-for-woocommerce' ),
				'type'    => 'checkbox',
				'desc'    => __( 'Enable navigation for the slider', 'product-gallery-swiper-for-woocommerce' ),
				'id'      => 'wdevs_gallery_swiper_navigation',
				'default' => 'no'
			),
			array(
				'name'    => __( 'Disable slider from', 'product-gallery-swiper-for-woocommerce' ),
				'type'    => 'select',
				'desc'    => __( 'When set, the slider will be disabled from the specified breakpoint upwards, and the second product image will be displayed on mouse hover.', 'product-gallery-swiper-for-woocommerce' ),
				'id'      => 'wdevs_gallery_swiper_breakpoint',
				'options' => array(
					''     => __( 'Always enabled', 'product-gallery-swiper-for-woocommerce' ),
					'480'  => __( 'Disabled from 480px and up', 'product-gallery-swiper-for-woocommerce' ),
					'768'  => __( 'Disabled from 768px and up', 'product-gallery-swiper-for-woocommerce' ),
					'992'  => __( 'Disabled from 992px and up', 'product-gallery-swiper-for-woocommerce' ),
					'1200' => __( 'Disabled from 1200px and up', 'product-gallery-swiper-for-woocommerce' )
				),
				'default' => ''
			),
			array(
				'type' => 'sectionend',
				'id'   => 'wdevs_gallery_swiper_section_end'
			)
		);

		return apply_filters( 'wdevs_gallery_swiper_settings', $settings );
	}

	/**
	 * Output the settings.
	 *
	 * @since    1.2.0
	 */
	public function settings_tab() {
		woocommerce_admin_fields( $this->get_settings() );
	}

	/**
	 * Save the settings.
	 *
	 * @since    1.2.0
	 */
	public function update_settings() {
		woocommerce_update_options( $this->get_settings() );
	}

}
