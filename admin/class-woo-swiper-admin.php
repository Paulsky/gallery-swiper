<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wijnberg.dev
 * @since      1.0.0
 *
 * @package    Woo_Swiper
 * @subpackage Woo_Swiper/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Swiper
 * @subpackage Woo_Swiper/admin
 * @author     Wijnberg Developments
 */
class Woo_Swiper_Admin {

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

	public function settings_section_callback() {
		echo __( 'Customize the swiper settings for your WooCommerce store.', 'woo-swiper' );
	}

	public function checkbox_field_render( $args ) {
		$defaults = [
			'woo_swiper_scrollbar' => '1', // Scrollbar is enabled by default
		];

		$options = get_option( 'woo_swiper_settings', $defaults );

		$value = isset($options[$args['label_for']]) ? $options[$args['label_for']] : (isset($defaults[$args['label_for']]) ? $defaults[$args['label_for']] : '0');
		?>
        <input type='checkbox'
               name='woo_swiper_settings[<?php echo esc_attr( $args['label_for'] ); ?>]' <?php checked( $value, 1 ); ?>
               value='1'>
		<?php
	}

	public function select_field_render( $args ) {
		$options = get_option( 'woo_swiper_settings' );
		?>
        <select name='woo_swiper_settings[<?php echo esc_attr( $args['label_for'] ); ?>]'>
			<?php foreach ( $args['options'] as $value => $label ) : ?>
                <option value='<?php echo esc_attr( $value ); ?>' <?php selected( isset( $options[ $args['label_for'] ] ) ? $options[ $args['label_for'] ] : '', $value ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>
        </select>
		<?php
	}

	public function options_page() {
		?>
        <div class="wrap">
            <h1>WooCommerce Swiper</h1>

            <form action='options.php' method='post'>
				<?php
				settings_fields( 'woo_swiper' );
				do_settings_sections( 'woo_swiper' );
				submit_button();
				?>
            </form>
        </div>
		<?php
	}

	public function add_admin_menu() {
		add_menu_page(
			__( 'WooCommerce Swiper settings', 'woo-swiper' ),
			__( 'WooCommerce Swiper', 'woo-swiper' ),
			'manage_options',
			'woocommerce_swiper',
			[ $this, 'options_page' ],
			'dashicons-images-alt'
		);
	}

	public function init_settings() {
		register_setting( 'woo_swiper', 'woo_swiper_settings' );

		add_settings_section(
			'woo_swiper_section',
			__( 'Swiper settings', 'woo-swiper' ),
			[ $this, 'settings_section_callback' ],
			'woo_swiper'
		);

		// Scrollbar
		add_settings_field(
			'woo_swiper_scrollbar',
			__( 'Enable scrollbar', 'woo - swiper' ),
			[ $this, 'checkbox_field_render' ],
			'woo_swiper',
			'woo_swiper_section',
			[
				'label_for' => 'woo_swiper_scrollbar'
			]
		);

		// Pagination
		add_settings_field(
			'woo_swiper_pagination',
			__( 'Enable pagination', 'woo - swiper' ),
			[ $this, 'checkbox_field_render' ],
			'woo_swiper',
			'woo_swiper_section',
			[
				'label_for' => 'woo_swiper_pagination'
			]
		);

		// Navigation
		add_settings_field(
			'woo_swiper_navigation',
			__( 'Enable navigation', 'woo - swiper' ),
			[ $this, 'checkbox_field_render' ],
			'woo_swiper',
			'woo_swiper_section',
			[
				'label_for' => 'woo_swiper_navigation'
			]
		);

		// Breakpoint
		add_settings_field(
			'woo_swiper_breakpoint',
			__( 'Disable swiper from', 'woo - swiper' ),
			[ $this, 'select_field_render' ],
			'woo_swiper',
			'woo_swiper_section',
			[
				'label_for' => 'woo_swiper_breakpoint',
				'options'   => [
					''     => 'Always enabled',
					'480'  => 'Disabled from 480px and up',
					'768'  => 'Disabled from 768px and up',
					'992'  => 'Disabled from 992px and up',
					'1200' => 'Disabled from 1200px and up',
				]
			]
		);
	}
}
