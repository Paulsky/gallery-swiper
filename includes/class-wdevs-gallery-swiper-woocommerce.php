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
	 * The current settings section.
	 *
	 * @since    1.5.3
	 * @access   private
	 * @var      string $current_section The current settings section.
	 */
	private $current_section;


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

		$this->current_section = isset( $_GET['section'] ) ? sanitize_text_field( $_GET['section'] ) : '';

		if ( is_admin() && isset( $_GET['page'] ) && $_GET['page'] === 'wc-settings' && isset( $_GET['tab'] ) && $_GET['tab'] === 'wdevs_gallery_swiper' ) {
			$this->handle_sections();
		}
	}

	/**
	 * Declare WooCommerce compatibility
	 *
	 * @since 1.2.0
	 */
	public function declare_compatibility() {
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
				'name'    => __( 'Enable variation images', 'product-gallery-swiper-for-woocommerce' ),
				'type'    => 'checkbox',
				'desc'    => __( 'Display variation images in the slider', 'product-gallery-swiper-for-woocommerce' ),
				'id'      => 'wdevs_gallery_swiper_variation_images',
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
				'name'    => __( 'Theme color', 'product-gallery-swiper-for-woocommerce' ),
				'type'    => 'color',
				'desc'    => __( 'Choose the Swiper theme color', 'product-gallery-swiper-for-woocommerce' ),
				'id'      => 'wdevs_gallery_swiper_theme_color',
				'default' => '#007aff'
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

	/**
	 * Output footer info
	 *
	 * @since    1.5.3
	 */
	public function render_footer_info() {
		$text = sprintf(
		/* translators: %s: Link to author site. */
			__( 'Product Gallery Swiper for WooCommerce is developed by %s. Your trusted WordPress & WooCommerce plugin partner from the Netherlands.', 'product-gallery-swiper-for-woocommerce' ),
			'<a href="https://products.wijnberg.dev" target="_blank" rel="noopener">Wijnberg Developments</a>'
		);

		echo '<span style="padding: 0 30px; background: #f0f0f1; display: block;">' . wp_kses_post( $text ) . '</span>';
	}

	/**
	 * Handle sections for the settings tab.
	 *
	 * @since    1.5.3
	 */
	private function handle_sections() {
		add_action( 'woocommerce_sections_wdevs_gallery_swiper', array( $this, 'output_sections' ) );

		if ( ! empty( $this->current_section ) ) {
			add_action( 'woocommerce_update_options_wdevs_gallery_swiper_' . $this->current_section, array(
				$this,
				'update_settings'
			) );
		} else {
			add_action( 'woocommerce_update_options_wdevs_gallery_swiper', array( $this, 'update_settings' ) );
		}
	}

	/**
	 * Output sections navigation.
	 *
	 * @since    1.5.3
	 */
	public function output_sections() {
		$sections = $this->get_sections();

		$documentationURL = 'https://products.wijnberg.dev/product/wordpress/plugins/product-gallery-swiper-for-woocommerce/';

		echo '<ul class="subsubsub">';

		foreach ( $sections as $id => $label ) {
			$url       = admin_url( 'admin.php?page=wc-settings&tab=wdevs_gallery_swiper&section=' . sanitize_title( $id ) );
			$class     = ( $this->current_section === $id ? 'current' : '' );
			$separator = '|';
			$text      = esc_html( $label );
			echo "<li><a href='$url' class='$class'>$text</a> $separator </li>";
		}

		?>

        <li>
            <a href="<?php echo esc_attr( $documentationURL ); ?>" target="_blank">
				<?php esc_html_e( 'Documentation', 'product-gallery-swiper-for-woocommerce' ); ?>
                <svg style="width: 0.8rem; height: 0.8rem; stroke: currentColor; fill: none;"
                     xmlns="http://www.w3.org/2000/svg"
                     stroke-width="10" stroke-dashoffset="0"
                     stroke-dasharray="0" stroke-linecap="round"
                     stroke-linejoin="round" viewBox="0 0 100 100">
                    <polyline fill="none" points="40 20 20 20 20 90 80 90 80 60"/>
                    <polyline fill="none" points="60 10 90 10 90 40"/>
                    <line fill="none" x1="89" y1="11" x2="50" y2="50"/>
                </svg>
            </a>
        </li>

		<?php

		echo '</ul><br class="clear" />';
	}

	/**
	 * Get available sections for the settings tab.
	 *
	 * @return array Array of sections.
	 * @since    1.5.3
	 */
	private function get_sections() {
		return array(
			'' => __( 'Settings', 'product-gallery-swiper-for-woocommerce' ),
		);
	}

}
