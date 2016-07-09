<?php

/**
 * The WC Vendors Pro shipping controller. 
 *
 * Defines shipping controller functions that are external to the shipping calculator
 *
 * @package    WCVendors_Pro
 * @subpackage WCVendors_Pro/admin
 * @author     Jamie Madden <support@wcvendors.com>
 */

class WCVendors_Pro_Shipping_Controller {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.1.0
	 * @access   private
	 * @var      string    $wcvendors_pro    The ID of this plugin.
	 */
	private $wcvendors_pro;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Is the plugin in debug mode 
	 *
	 * @since    1.1.0
	 * @access   private
	 * @var      bool    $debug    plugin is in debug mode 
	 */
	private $debug;

	/**
	 * Is the plugin base directory 
	 *
	 * @since    1.1.0
	 * @access   private
	 * @var      string    $base_dir  string path for the plugin directory 
	 */
	private $base_dir;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.1.0
	 * @param      string    $wcvendors_pro       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wcvendors_pro, $version, $debug ) {

		$this->wcvendors_pro 		= $wcvendors_pro;
		$this->version 				= $version;
		$this->debug 				= $debug; 
		$this->base_dir				= plugin_dir_path( dirname(__FILE__) ); 
		 
	}

	/**
	 *  Add the shipping tab on the front end
	 * 
	 * @since    1.1.0
	 * @deprecated 1.2.0
	 */
	public function shipping_panel_tab( $tabs ) {

		global $product, $woocommerce;

		$shipping_methods 	= $woocommerce->shipping->load_shipping_methods();
		$shipping_disabled	= WCVendors_Pro::get_option( 'shipping_management_cap' );

		if ( ( array_key_exists('wcv_pro_vendor_shipping', $shipping_methods ) && $shipping_methods['wcv_pro_vendor_shipping']->enabled == 'yes' ) && $product->needs_shipping() && ! $shipping_disabled && WCV_Vendors::is_vendor( $product->post->post_author ) && $product->product_type != 'external' ) { 

			$tabs[ 'wcv_shipping_tab' ] = apply_filters( 'wcv_shipping_tab', array(
				'title' 	=> __( 'Shipping', 'wcvendors-pro' ),
				'priority' 	=> 60,
				'callback' 	=> array( $this, 'shipping_panel' ) 
			) );
		} 

		return $tabs;

	} // shipping_panel_tab()

	/**
	 * 
	 */

	/**
	 *  Add the shipping panel information for this product to the front end
	 * 
	 * @since    1.1.0
	 * @deprecated 1.2.0
	 */
	public function shipping_panel() {

		global $product;

		$product_id 			= $product->id; 
		$settings 				= get_option( 'woocommerce_wcv_pro_vendor_shipping_settings' ); 
		$vendor_id 				= WCV_Vendors::get_vendor_from_product( $product_id ); 
		$store_rates			= get_user_meta( $vendor_id, '_wcv_shipping', true ); 
		$store_country 			= ( $store_rates && $store_rates['shipping_from'] == 'other' ) ? strtolower( $store_rates['shipping_address']['country'] ) : strtolower( get_user_meta( $vendor_id, '_wcv_store_country', true ) ); 
		$store_state 			= ( $store_rates && $store_rates['shipping_from'] == 'other' ) ? strtolower( $store_rates['shipping_address']['state'] ) : strtolower( get_user_meta( $vendor_id, '_wcv_store_state', true ) ); 
		$product_rates 			= get_post_meta( $product_id, '_wcv_shipping_details', true );  
		$countries 				= WCVendors_Pro_Form_Helper::countries();

		$shipping_flat_rates 	= array(); 
		$shipping_table_rates 	= array(); 
		$store_shipping_type	= get_user_meta( $vendor_id, '_wcv_shipping_type', true );
		$shipping_system		= ( !empty( $store_shipping_type ) ) ? $store_shipping_type : $settings[ 'shipping_system' ]; 
		$store_check			= true; 

		if ( ! $store_country ) $store_country = WC()->countries->get_base_country(); 

		// Product rates is empty so set to null 
		if ( is_array( $product_rates ) && !array_filter( $product_rates ) ) $product_rates = null; 

		// Store rates is empty so set to null 
		if ( is_array( $store_rates ) && ( array_key_exists( 'national', $store_rates ) && strlen( trim( $store_rates[ 'national' ] ) ) === 0 ) && ( array_key_exists( 'international', $store_rates ) && strlen( trim( $store_rates[ 'international' ] ) ) === 0 ) && ( array_key_exists( 'national_free', $store_rates ) && strlen( trim( $store_rates[ 'national_free' ] ) ) === 0 ) && ( array_key_exists( 'national_free', $store_rates ) && strlen( trim( $store_rates[ 'international_free' ] ) ) === 0 ) ) $store_check = false; 

		// Get default country for admin.  
		if ( ! WCV_Vendors::is_vendor( $vendor_id ) ) $store_country = WC()->countries->get_base_country(); 

		if ( $shipping_system == 'flat' ){

			if ( is_array( $product_rates) ) {
					
				$shipping_flat_rates = $product_rates; 

			} elseif ( is_array( $store_rates ) ) { 

				$shipping_flat_rates = $store_rates; 

			} elseif ( $settings[ 'national_cost' ] >= 0 && $settings[ 'international_cost' ]  >= 0 )  { 

				$shipping_flat_rates[ 'national' ] 	 			= $settings[ 'national_cost' ]; 
				$shipping_flat_rates[ 'international' ] 		= $settings[ 'international_cost']; 
				$shipping_flat_rates[ 'product_fee' ] 			= $settings[ 'product_fee']; 
				$shipping_flat_rates[ 'national_disable' ] 		= $settings[ 'national_disable'];
				$shipping_flat_rates[ 'national_free' ] 		= $settings[ 'national_free']; 
				$shipping_flat_rates[ 'international_disable' ] = $settings[ 'international_disable'];
				$shipping_flat_rates[ 'international_free' ] 	= $settings[ 'international_free'];
				
			} 

		} else { 

			$product_shipping_table = get_post_meta( $product_id, '_wcv_shipping_rates',  true );
			$store_shipping_table = get_user_meta( $vendor_id, '_wcv_shipping_rates',  true ); 

			// Check to see if the product has any rates set.
			if ( is_array( $product_shipping_table ) && ! empty( $product_shipping_table ) ) {  
				$shipping_table_rates = $product_shipping_table; 
			} elseif ( is_array( $store_shipping_table ) && ! empty( $store_shipping_table ) ){ 
				$shipping_table_rates = $store_shipping_table; 
			} else { 
				
				$shipping_flat_rates[ 'national' ] 			= $settings[ 'national_cost' ]; 
				$shipping_flat_rates[ 'international' ] 	= $settings[ 'international_cost']; 
				$shipping_flat_rates[ 'product_fee' ] 		= $settings[ 'product_fee']; 
				$shipping_flat_rates[ 'national_disable' ] 		= $settings[ 'national_disable'];
				$shipping_flat_rates[ 'international_disable' ] = $settings[ 'international_disable'];
			}
		}

		$shipping_policy 	= ( empty( $store_rates[ 'shipping_policy' ] ) ) ? $settings[ 'shipping_policy'] : $store_rates[ 'shipping_policy' ]; 
		$return_policy		= ( empty( $store_rates[ 'return_policy' ] ) ) ? $settings[ 'return_policy'] : $store_rates[ 'return_policy' ]; 

		wc_get_template( 'shipping-panel.php', array(
			'shipping_system'		=> $shipping_system, 
			'shipping_flat_rates'	=> $shipping_flat_rates, 
			'shipping_table_rates'	=> $shipping_table_rates, 
			'store_country'			=> $store_country,
			'countries'				=> $countries, 
			'product'				=> $product, 
			'store_rates'			=> $store_rates, 
			'shipping_policy'		=> $shipping_policy, 
			'return_policy'			=> $return_policy, 

		), 'wc-vendors/front/shipping/', $this->base_dir . 'templates/front/shipping/' );
		

	} // shipping_panel()

	/**
	 *  Add shipping override to user edit screen
	 *
	 * @since    1.2.0
	 */
	public function store_shipping_override( $user ) { 

		if ( !current_user_can( 'manage_woocommerce' ) ) return;

		if ( ! WCV_Vendors::is_vendor( $user->ID ) ) { return; } 

		include('partials/vendor/wcvendors-pro-store-meta-shipping-panel.php'); 

	} // store_shipping_override()

	/**
	 *  Save shipping override from user edit screen
	 *
	 * @param    int    $post_id       post_id being saved 
	 * @since    1.1.0
	 * @deprecated 1.2.0
	 */
	public function store_shipping_meta_save( $vendor_id ) { 

		if ( isset( $_POST[ '_wcv_shipping_type' ] ) && '' !== $_POST[ '_wcv_shipping_type' ] ) {
			update_user_meta( $vendor_id, '_wcv_shipping_type', $_POST[ '_wcv_shipping_type' ] );
		} else { 
			delete_user_meta( $vendor_id, '_wcv_shipping_type' );
		}

	} //store_shipping_meta_save()


	/**
	 *  Shipping types
	 *
	 * @since    1.1.0
	 */
	public static function shipping_types( ) {

		return apply_filters( 'wcv_shipping_types', array( 
				'flat' 		=> __( 'Flat Rate', 'wcvendors-pro' ),
				'country' 	=> __( 'Country Table Rate',  'wcvendors-pro' ), 
				) 
		); 

	} // shipping_types()


}