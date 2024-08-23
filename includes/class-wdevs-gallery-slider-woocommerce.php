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
 * @package    Wdevs_Gallery_Slider
 * @subpackage Wdevs_Gallery_Slider/includes
 * @author     Wijnberg Developments <contact@wijnberg.dev>
 */
class Wdevs_Gallery_Slider_Woocommerce {

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
			\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', 'wdevs-gallery-slider/wdevs-gallery-slider.php', true );
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
		$settings_tabs['wdevs_gallery_slider'] = __( 'Gallery Slider', 'wdevs-gallery-slider' );
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
				'name' => __( 'Gallery Slider settings', 'wdevs-gallery-slider' ),
				'type' => 'title',
				'desc' => __( 'Customize the Gallery slider settings.', 'wdevs-gallery-slider' ),
				'id'   => 'wdevs_gallery_slider_section_title'
			),
			array(
				'name'    => __( 'Enable scrollbar', 'wdevs-gallery-slider' ),
				'type'    => 'checkbox',
				'desc'    => __( 'Enable scrollbar for the slider', 'wdevs-gallery-slider' ),
				'id'      => 'wdevs_gallery_slider_scrollbar',
				'default' => 'yes'
			),
			array(
				'name'    => __( 'Enable pagination', 'wdevs-gallery-slider' ),
				'type'    => 'checkbox',
				'desc'    => __( 'Enable pagination for the slider', 'wdevs-gallery-slider' ),
				'id'      => 'wdevs_gallery_slider_pagination',
				'default' => 'no'
			),
			array(
				'name'    => __( 'Enable navigation', 'wdevs-gallery-slider' ),
				'type'    => 'checkbox',
				'desc'    => __( 'Enable navigation for the slider', 'wdevs-gallery-slider' ),
				'id'      => 'wdevs_gallery_slider_navigation',
				'default' => 'no'
			),
			array(
				'name'    => __( 'Disable slider from', 'wdevs-gallery-slider' ),
				'type'    => 'select',
				'desc'    => __( 'When set, the slider will be disabled from the specified breakpoint upwards, and the second product image will be displayed on mouse hover.', 'wdevs-gallery-slider' ),
				'id'      => 'wdevs_gallery_slider_breakpoint',
				'options' => array(
					''     => __( 'Always enabled', 'wdevs-gallery-slider' ),
					'480'  => __( 'Disabled from 480px and up', 'wdevs-gallery-slider' ),
					'768'  => __( 'Disabled from 768px and up', 'wdevs-gallery-slider' ),
					'992'  => __( 'Disabled from 992px and up', 'wdevs-gallery-slider' ),
					'1200' => __( 'Disabled from 1200px and up', 'wdevs-gallery-slider' )
				),
				'default' => ''
			),
			array(
				'type' => 'sectionend',
				'id'   => 'wdevs_gallery_slider_section_end'
			)
		);

		return apply_filters( 'wdevs_gallery_slider_settings', $settings );
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