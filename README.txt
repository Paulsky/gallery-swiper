=== Product Gallery Slider for WooCommerce ===
Contributors: wijnbergdevelopments
Tags: woocommerce, product gallery, slider, swiper
Requires at least: 6.0
Tested up to: 6.6
Stable tag: 1.1.0
Requires PHP: 7.2
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

Enhance WooCommerce product images display on product listing sections with a responsive and touch-friendly slider for product thumbnails.

== Description ==

Product Gallery Slider for WooCommerce integrates the Swiper library to enhance the product images display on product listing sections. This plugin provides a responsive and touch-friendly slider for product thumbnails, improving the user experience on shop pages, product category pages, and related products sections.

This slider is designed for product listing sections where multiple products are displayed, not for single product itself.

Key features:
* Responsive and touch-friendly product image slider
* Customizable settings for scrollbar, pagination, and navigation
* Breakpoint options to disable swiper on larger screens
* Seamless integration with WooCommerce

= Requirements =

* WooCommerce plugin installed and activated

= Usage =

After installation and activation, Product Gallery Slider for WooCommerce will automatically apply to your product galleries on listing pages. You can customize the settings in the WooCommerce -> Gallery Slider menu.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/wdevs-gallery-slider` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the WooCommerce -> Gallery Slider screen to configure the plugin.

== Frequently Asked Questions ==

= Are there any known compatibility issues? =

Product Gallery Slider for WooCommerce has been tested with GeneratePress theme, where the secondary thumbnail image is disabled. It's also compatible with YITH Infinite Scrolling plugin, with Swiper being initialized for AJAX loaded products.

Some WooCommerce Blocks are not fully compatible with this plugin as they do not use standard WooCommerce filters for generating thumbnails. This is a known limitation of WooCommerce Blocks and not specific to this plugin. You can fix this by using WooCommerce shortcodes instead of the WooCommerce Blocks.

If you encounter any conflicts with other themes or plugins, please report them to us.

== Changelog ==

= 1.1.0 =
* Renamed 'Woo Swiper' to 'Product Gallery Slider for WooCommerce'
* Updated Swiper from 11.0.6 to 11.1.9
* Changed License from MIT to GPL-2.0+
* Added CHANGELOG.md file

= 1.0.0 =
* Initial release of Product Gallery Slider for WooCommerce.

== Additional Information ==

For more information and other WordPress plugins, visit [Wijnberg Developments](https://products.wijnberg.dev).