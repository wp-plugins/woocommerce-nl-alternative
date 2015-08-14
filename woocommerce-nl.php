<?php
/*
Plugin Name: WooCommerce (nl) (alternative)
Plugin URI: http://zenoweb.nl/
Description: Extends the WooCommerce plugin and add-ons with the Dutch language. Uses the informal "je" form instead of the formal "u" form.
Version: 1.4.0
Requires at least: 3.0

Author: Marcel Pol
Author URI: http://zenoweb.nl

Text Domain: woocommerce_nl
Domain Path: /languages/

License: GPL
*/


// This Woo action gets called before Woo loads its translation files.
function woo_nl_alt_load() {

		/* WooCommerce Translation */
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce' );

		if ( is_admin() ) {
			load_plugin_textdomain( 'woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/woocommerce/admin' );
		}
		load_plugin_textdomain( 'woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/woocommerce' );

		/* Storefront Translation */
		$template   = get_option( 'template' );
		$stylesheet = get_option( 'stylesheet' );

		if ( is_int(strpos( $template, 'storefront' )) || is_int(strpos( $stylesheet, 'storefront' )) ) {
			load_textdomain( 'storefront', $dir . 'languages/storefront/' . $locale . '.mo' );
		}

}
add_action( 'before_woocommerce_init', 'woo_nl_alt_load' );

