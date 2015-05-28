<?php
/*
Plugin Name: WooCommerce (nl) (alternative)
Plugin URI: http://zenoweb.nl/
Description: Extends the WooCommerce plugin and add-ons with the Dutch language. Uses the informal "je" form instead of the formal "u" form.
Version: 1.1.7
Requires at least: 3.0

Author: Marcel Pol
Author URI: http://zenoweb.nl

Text Domain: woocommerce_nl
Domain Path: /languages/

License: GPL
*/

class WooCommerceNLPlugin_Alt {
	/**
	 * The current langauge
	 *
	 * @var string
	 */
	private $language;

	/**
	 * Flag for the dutch langauge, true if current langauge is dutch, false otherwise
	 *
	 * @var boolean
	 */
	private $is_dutch;

	////////////////////////////////////////////////////////////

	/**
	 * Bootstrap
	 */
	public function __construct( $file ) {
		$this->file = $file;

		// Filters and actions
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );

		add_filter( 'load_textdomain_mofile', array( $this, 'load_mo_file' ), 10, 2 );

		/*
		 * WooThemes/WooCommerce don't execute the load_plugin_textdomain() in the 'init'
		 * action, therefor we have to make sure this plugin will load first
		 *
		 * @see http://stv.whtly.com/2011/09/03/forcing-a-wordpress-plugin-to-be-loaded-before-all-other-plugins/
		 */
		add_action( 'activated_plugin',       array( $this, 'activated_plugin' ) );
	}

	////////////////////////////////////////////////////////////

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

	////////////////////////////////////////////////////////////

	/**
	 * Plugins loaded
	 */
	public function plugins_loaded() {
		$rel_path = dirname( plugin_basename( $this->file ) ) . '/languages/';

		// Load plugin text domain - WooCommerce Gravity Forms
		// WooCommerce mixed use of 'wc_gf_addons' and 'wc_gravityforms'
		load_plugin_textdomain( 'wc_gravityforms', false, $rel_path );

		// Other
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce' );
		$dir    = plugin_dir_path( __FILE__ );

		if ( is_admin() ) {
			load_textdomain( 'woocommerce', $dir . 'languages/woocommerce/admin-' . $locale . '.mo' );
		}

		load_textdomain( 'woocommerce', $dir . 'languages/woocommerce/' . $locale . '.mo' );
	}

	////////////////////////////////////////////////////////////

	/**
	 * Load text domain MO file
	 *
	 * @param string $moFile
	 * @param string $domain
	 */
	public function load_mo_file( $mo_file, $domain ) {
		if ( $this->language == null ) {
			$this->language = get_locale();
			$this->is_dutch = ( $this->language == 'nl' || $this->language == 'nl_NL' );
		}

		// The ICL_LANGUAGE_CODE constant is defined from an plugin, so this constant
		// is not always defined in the first 'load_textdomain_mofile' filter call
		if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
			$this->is_dutch = ( ICL_LANGUAGE_CODE == 'nl' );
		}

		if ( $this->is_dutch ) {
			$domains = array(
				'wc_eu_vat_number'           => array(
					'wc_eu_vat_number-nl_NL.mo'                 => 'woocommerce-eu-vat-number/nl_NL.mo',
				),
				'wc_gf_addons'               => array(
					'languages/wc_gf_addons-nl_NL.mo'           => 'woocommerce-gravityforms-product-addons/nl_NL.mo',
				),
				'wc_gravityforms'            => array(
					'languages/wc_gravityforms-nl_NL.mo'        => 'woocommerce-gravityforms-product-addons/nl_NL.mo',
				),
				'wc_subscribe_to_newsletter' => array(
					'wc_subscribe_to_newsletter-nl_NL.mo'       => 'woocommerce-subscribe-to-newsletter/nl_NL.mo',
				),
				'x3m_gf'                     => array(
					'languages/x3m_gf-nl_NL.mo'                 => 'woocommerce-gateway-fees/nl_NL.mo',
				),
				'woocommerce-delivery-notes' => array(
					'languages/woocommerce-delivery-notes-nl_NL.mo' => 'woocommerce-delivery-notes/nl_NL.mo',
				),
			);

			if ( isset( $domains[ $domain ] ) ) {
				$paths = $domains[ $domain ];

				foreach ( $paths as $path => $file ) {
					if ( substr( $mo_file, -strlen( $path ) ) == $path ) {
						$new_file = dirname( $this->file ) . '/languages/' . $file;

						if ( is_readable( $new_file ) ) {
							$mo_file = $new_file;
						}
					}
				}
			}
		}

		return $mo_file;
	}
}

global $woocommerce_nl_plugin_alt;

$woocommerce_nl_plugin_alt = new WooCommerceNLPlugin_Alt( __FILE__ );
