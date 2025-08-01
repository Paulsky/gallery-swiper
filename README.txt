=== Product Gallery Swiper for WooCommerce ===
Contributors: wijnbergdevelopments
Tags: woocommerce, product gallery, slider, swiper
Requires at least: 6.0
Tested up to: 6.8
Stable tag: 1.5.10
Requires PHP: 7.2
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

Enhance WooCommerce product images display on product listing sections with a responsive and touch-friendly slider for product thumbnails.

== Description ==

Product Gallery Swiper for WooCommerce integrates the Swiper library to enhance the product images display on product listing sections. This plugin provides a responsive and touch-friendly slider for product thumbnails, improving the user experience on shop pages, product category pages, and related products sections.

This slider is designed for product listing sections where multiple products are displayed, not for single product itself.

=== Key features ===

* Responsive and touch-friendly product image slider
* Customizable settings for scrollbar, pagination, and navigation
* Breakpoint options to disable swiper on larger screens
* Seamless integration with WooCommerce
* Option to use variation images in the slider

For more information about this plugin, please visit the [plugin page](https://products.wijnberg.dev/product/wordpress/plugins/product-gallery-swiper-for-woocommerce/).

=== Requirements ===

* WooCommerce plugin installed and activated

=== Usage ===

After installation and activation, Product Gallery Swiper for WooCommerce will automatically apply to your product galleries on listing pages. You can customize the settings in the WooCommerce -> Gallery Slider menu.

=== Known compatibility ===

Themes:

* GeneratePress (secondary thumbnail image disabled)
* Blocksy
* XStore

Plugins:

* YITH Infinite Scrolling (Swiper initializes for AJAX loaded products)
* WooCommerce HPOS
* Product Filter by WBW (Swiper initializes for AJAX loaded products)
* GeneratePress Premium

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/product-gallery-swiper-for-woocommerce` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the WooCommerce -> Gallery Swiper screen to configure the plugin.

== Frequently Asked Questions ==

= Are there any known compatibility issues? =

The plugin includes support for WooCommerce ProductImage Block. Some other WooCommerce Blocks are not fully compatible with this plugin as they do not use standard WooCommerce filters for generating thumbnails. This is a known limitation of WooCommerce Blocks and not specific to this plugin. You can fix this by using WooCommerce shortcodes instead of the WooCommerce Blocks.

If you encounter any conflicts with other themes or plugins, please report them to us. We are trying to use all standard WooCommerce filters and hooks, and we want to use the active theme settings and change as little as possible. This approach ensures maximum compatibility with themes and other plugins. However, some themes and plugins might not follow standard WordPress/WooCommerce practices, which can result in compatibility issues out of the box.

== Changelog ==
= 1.5.10 =
* Improved compatibility for XStore theme

= 1.5.9 =
* Added WooCommerce ProductImage block integration

= 1.5.8 =
* Added new rendering filters/actions for third party compatibility adjustments
* Added helper functions for cleaner code organization and better maintainability
* Updated code structure with better method organization and documentation
* Updated theme compatibility handling with more modular approach

= 1.5.7 =
* Added option to enable/disable hover functionality when slider is disabled above breakpoint
* Updated breakpoint functionality to work properly with mobile-first approach

= 1.5.6 =
* Added compatibility for GeneratePress Premium

= 1.5.5 =
* Removed load_plugin_textdomain() because it has been discouraged since WordPress version 4.6.
* Tested WooCommerce 10.0.2

= 1.5.4 =
* Added compatibility for XStore theme

= 1.5.3 =
* Tested WooCommerce 9.9.4
* Added settings link

= 1.5.2 =
* Added option to display variation images

= 1.5.1 =
* Tested WordPress 6.8.0
* Tested WooCommerce 9.8.1

= 1.5.0 =
* Small improvement for YITH Infinite Scrolling
* Tested WordPress 6.7.2
* Tested WooCommerce 9.7.1
* Added compatibility for Product Filter by WBW

= 1.4.1 =
* Tested WooCommerce 9.6.0

= 1.4.0 =
* Possible breaking change: only render the Swiper HTML if the slider can be displayed
* Possible breaking change: render the default theme featured image HTML in the first slide
* Updated Swiper from 11.1.9 to 11.2.0
* Added color setting for Swiper buttons and pagination
* Added compatibility for Blocksy theme

= 1.3.0 =
* Renamed 'Product Gallery Slider for WooCommerce' to 'Product Gallery Swiper for WooCommerce'

= 1.2.0 =
* Declared WooCommerce HPOS compatibility

= 1.1.0 =
* Renamed 'Woo Swiper' to 'Product Gallery Slider for WooCommerce'
* Updated Swiper from 11.0.6 to 11.1.9
* Changed License from MIT to GPL-2.0+
* Added CHANGELOG.md file

= 1.0.0 =
* Initial release of Woo Swiper.

== Additional Information ==

For more information and other WordPress plugins, visit [Wijnberg Developments](https://products.wijnberg.dev/product-category/wordpress/plugins/).

== Screenshots ==

1. This GIF demonstrates the main functionality of the plugin.
