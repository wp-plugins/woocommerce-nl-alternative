<?php
/*
Plugin Name: WooCommerce (nl) (alternative)
Plugin URI: http://zenoweb.nl/
Description: Extends the WooCommerce plugin and add-ons with the Dutch language. Uses the informal "je" form instead of the formal "u" form.
Version: 1.3.0
Requires at least: 3.0

Author: Marcel Pol
Author URI: http://zenoweb.nl

Text Domain: woocommerce_nl
Domain Path: /languages/

License: GPL
*/

class WooCommerceNLPlugin_Alt {


	/**
	 * Bootstrap
	 */
	public function __construct( $file ) {
		$this->file = $file;

		// Filters and actions
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );

		/*
		 * WooThemes/WooCommerce don't execute the load_plugin_textdomain() in the 'init'
		 * action, therefor we have to make sure this plugin will load first
		 *
		 * @see http://stv.whtly.com/2011/09/03/forcing-a-wordpress-plugin-to-be-loaded-before-all-other-plugins/
		 */
		add_action( 'activated_plugin', array( $this, 'activated_plugin' ) );
	}


	/**
	 * Activated plugin
	 */
	public function activated_plugin() {
		$path = plugin_basename( $this->file );

		if ( $plugins = get_option( 'active_plugins' ) ) {
			if ( $key = array_search( $path, $plugins ) ) {
				array_splice( $plugins, $key, 1 );
				array_unshift( $plugins, $path );

				update_option( 'active_plugins', $plugins );
			}
		}
	}


	/**
	 * Plugins loaded
	 */
	public function plugins_loaded() {

		/* WooCommerce Translation */
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce' );
		$dir    = plugin_dir_path( __FILE__ );

		if ( is_admin() ) {
			load_textdomain( 'woocommerce', $dir . 'languages/woocommerce/admin-' . $locale . '.mo' );
		}

		load_textdomain( 'woocommerce', $dir . 'languages/woocommerce/' . $locale . '.mo' );

		/* Storefront Translation */
		$template   = get_option( 'template' );
		$stylesheet = get_option( 'stylesheet' );

		if ( is_int(strpos( $template, 'storefront' )) || is_int(strpos( $stylesheet, 'storefront' )) ) {
			load_textdomain( 'storefront', $dir . 'languages/storefront/' . $locale . '.mo' );
		}

	}

}

global $woocommerce_nl_plugin_alt;

$woocommerce_nl_plugin_alt = new WooCommerceNLPlugin_Alt( __FILE__ );


