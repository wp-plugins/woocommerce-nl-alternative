<?php
/*
Plugin Name: WooCommerce (nl) (alternative)
Plugin URI: http://zenoweb.nl/
Description: Extends the WooCommerce plugin with the Dutch language. Uses the informal "je" form instead of the formal "u" form.
Version: 2.4.10
Requires at least: 3.7
Author: Marcel Pol
Author URI: http://zenoweb.nl
Text Domain: woocommerce
Domain Path: /languages/
License: GPLv2
*/


define('WOO_NL_ALT_VER', '2.4.10');


/*
 * Load WooCommerce Plugin Translation
 * This Woo action gets called before Woo loads its translation files.
 */
function woo_nl_alt_load_woocommerce() {

	$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce' );

	if ( is_admin() ) {
		load_plugin_textdomain( 'woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/woocommerce/admin' );
	}
	load_plugin_textdomain( 'woocommerce', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/woocommerce' );

}
add_action( 'before_woocommerce_init', 'woo_nl_alt_load_woocommerce' );


/*
 * Load Storefront Theme Translation.
 */
function woo_nl_alt_load_storefront() {

	$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce' );

	/* Storefront Translation */
	$template   = get_option( 'template' );
	$stylesheet = get_option( 'stylesheet' );

	if ( is_int(strpos( $template, 'storefront' )) || is_int(strpos( $stylesheet, 'storefront' )) ) {
		load_theme_textdomain( 'storefront', plugin_dir_path( __FILE__ ) . 'languages/storefront/' );
	}

}
add_action( 'after_setup_theme', 'woo_nl_alt_load_storefront' );

