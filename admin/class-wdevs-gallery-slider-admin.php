<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wijnberg.dev
 * @since      1.0.0
 *
 * @package    Wdevs_Gallery_Slider
 * @subpackage Wdevs_Gallery_Slider/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wdevs_Gallery_Slider
 * @subpackage Wdevs_Gallery_Slider/admin
 * @author     Wijnberg Developments
 */
class Wdevs_Gallery_Slider_Admin {

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
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	public function add_settings_tab( $settings_tabs ) {
		$settings_tabs['wdevs_gallery_slider'] = __( 'Gallery Slider', 'wdevs-gallery-slider' );
		return $settings_tabs;
	}

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

	public function settings_tab() {
		woocommerce_admin_fields( $this->get_settings() );
	}

	public function update_settings() {
		woocommerce_update_options( $this->get_settings() );
	}
}
