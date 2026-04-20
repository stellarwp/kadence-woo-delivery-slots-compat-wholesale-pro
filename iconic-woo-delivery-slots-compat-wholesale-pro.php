<?php
/**
 * Plugin Name:     WooCommerce Delivery Slots by Kadence [WooCommerce Wholesale Pro]
 * Plugin URI:      https://iconicwp.com/products/woocommerce-delivery-slots/
 * Description:     Compatibility between WooCommerce Delivery Slots by Kadence and WooCommerce Wholesale Pro Plugin by Barn2.
 * Author:          Kadence
 * Author URI:      https://www.kadencewp.com/
 * Text Domain:     iconic-compat-41192
 * Domain Path:     /languages
 * Version:         0.1.0
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Iconic_Compat_41192 {
	public static function init() {
		add_action( 'plugins_loaded', array( __CLASS__, 'hooks' ) );
	}

	
	public static function hooks() {
		if ( ! function_exists( 'Barn2\Plugin\WC_Wholesale_Pro\woocommerce_wholesale_pro' ) ) {
			return;
		}

		remove_action( 'init', array( 'Iconic_WDS_Core_Settings', 'init' ) );
		add_action( 'init', array( 'Iconic_WDS_Core_Settings', 'init' ), 20 );

		add_filter( 'iconic_wds_shipping_method_options', array( __CLASS__, 'replace_shipping_method_id' ) );
	}

	
	public static function replace_shipping_method_id( $shipping_method_options ) {
		// print_r($shipping_method_options);exit;

		foreach ( $shipping_method_options as $key => $shipping_method_option ) {
			if ( strpos( $key, 'barn2\plugin\wc_wholesale_pro\shipping' ) !== false ) {
				$new_key                             = str_replace( 'barn2\plugin\wc_wholesale_pro\shipping\\', 'wcwp_', $key );
				$shipping_method_options[ $new_key ] = $shipping_method_option;
				unset( $shipping_method_options[ $key ] );
			}

		}

		// print_r($shipping_method_options);exit;
		return $shipping_method_options;
	}
}

Iconic_Compat_41192::init();
