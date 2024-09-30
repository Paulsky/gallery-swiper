# Product Gallery Swiper for WooCommerce

Enhances the product image gallery in WooCommerce by integrating the Swiper library. This enables a responsive and touch-friendly slider for product thumbnails displayed on **product listing sections** (e.g., shop page, product categories pages, related products) rather than the single product gallery.

<img src="https://github.com/Paulsky/woo-swiper/assets/9481318/1d9765af-70e9-4459-a084-af36cea3aff8" width="250" alt="Product Gallery Swiper demo" style="max-width: 250px !important; height: auto !important;" />

For more WordPress plugins, check out our products at [Wijnberg Developments](https://products.wijnberg.dev).

## Built with

- [Swiper](https://github.com/nolimits4web/swiper)
- [WooCommerce](https://github.com/woocommerce/woocommerce)
- [WordPress](https://github.com/WordPress/WordPress)

## Requirements

- WooCommerce plugin installed and activated

## Installation

To install the plugin, follow these steps:

1. Download the `.zip` file from the [releases page](https://github.com/Paulsky/gallery-swiper/releases).
2. In your WordPress admin dashboard, go to `Plugins` > `Add New`.
3. Click `Upload Plugin` at the top of the page.
4. Click `Choose File`, select the `.zip` file you downloaded, then click `Install Now`.
5. After installation, click `Activate Plugin`.

The plugin is now ready for use.

## Getting started

These instructions will guide you through the installation and basic setup of the Gallery Swiper plugin, ensuring a smooth integration with your WooCommerce product listing sections.

### Configuration

Once activated, Product Gallery Swiper for WooCommerce requires no mandatory configuration to start working. By default, it will automatically apply the Swiper slider to your WooCommerce product galleries on listing pages.

To customize the Swiper slider settings:
1. Go to the Gallery Swiper settings page located under the 'WooCommerce' menu in the WordPress admin area.
2. Adjust the settings according to your preferences, such as enabling or disabling the scrollbar, pagination, and navigation arrows.
3. Save your changes.

### Usage

After installation and configuration, navigate to any product listing page on your website. You should see the product images displayed within a Swiper slider, allowing for a touch-friendly and responsive browsing experience.

## Compatibility

This plugin is tested and compatible with the following:

### Themes

- [**GeneratePress**](https://generatepress.com): The secondary thumbnail image is disabled.

### Plugins

- [**YITH Infinite Scrolling**](https://yithemes.com/themes/plugins/yith-infinite-scrolling/): Swiper is initialized for AJAX loaded products.

If you encounter any conflicts with other themes or plugins, please report them to us by opening an issue or through our website. We welcome community contributions, so feel free to submit a pull request if you have a fix or improvement.

Some WooCommerce Blocks are not fully compatible with this plugin as they do not use standard WooCommerce filters for generating thumbnails. This is a known limitation of WooCommerce Blocks and not specific to this plugin. You can fix this by using WooCommerce shortcodes instead of the WooCommerce Blocks.

## Language support

Currently supported languages:
- English
- Dutch (Nederlands)

If you would like to add support for a new language or improve existing translations, please let us know by opening an issue or contacting us through our website. You are also welcome to submit a pull request of course!

## Contributing

Your contributions are welcome! If you'd like to contribute to the project, feel free to fork the repository, make your changes, and submit a pull request.

## Development and deployment

To prepare your development work for submission, ensure you have `npm` installed and run `npm run deploy`. This command packages your changes into a `.zip` file, ready for deployment.

### Steps:

1. Ensure `npm` is installed.
2. Navigate to the project root.
3. Run `npm run deploy`.

The `.zip` file created is ready for use. Please ensure your changes adhere to the project's coding standards.

## Security

If you discover any security related issues, please email us instead of using the issue tracker.

## License

This plugin is licensed under the GNU General Public License v2 or later.

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License, version 2, as published by the Free Software Foundation.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.