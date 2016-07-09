<?php
/**
 * The WCVendors Pro Store Controller class
 *
 * This is the store controller class for all pro features
 *
 * @package    WCVendors_Pro
 * @subpackage WCVendors_Pro/public
 * @author     Jamie Madden <support@wcvendors.com>
 * @deprecated 1.2.0 
 */
class WCVendors_Pro_Store_Controller {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wcvendors_pro    The ID of this plugin.
	 */
	private $wcvendors_pro;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Is the plugin in debug mode 
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      bool    $debug    plugin is in debug mode 
	 */
	private $debug;

	/**
	 * Is the plugin base directory 
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $base_dir  string path for the plugin directory 
	 */
	private $base_dir;

	/**
	 * This is the store slug 
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $store_slug  string slug for the vendor stores 
	 */
	public static $store_slug = 'vendor_store';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $wcvendors_pro       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $wcvendors_pro, $version, $debug ) {

		$this->wcvendors_pro 	= $wcvendors_pro;
		$this->version 			= $version;
		$this->debug 			= $debug; 
		$this->base_dir			= plugin_dir_path( dirname(__FILE__) );  
	}

	/**
	 *  Register the new Pro Post Type
	 *
	 * @since    1.0.0
	 */
	public function register_post_type() { 

			$vendor_store_slug =  untrailingslashit( WCVendors_Pro::get_option( 'vendor_store_slug' ) ); 

			register_post_type( self::$store_slug, 	
				apply_filters( 'wcv_register_post_type_vendor_store',
					array(
						'labels'            => array(
							'name'                	=> __( 'Vendor Stores', 'wcvendors-pro' ),
							'singular_name'       	=> __( 'Vendor Store', 'wcvendors-pro' ),
							'all_items'           	=> __( 'Vendor Stores', 'wcvendors-pro' ),
							'new_item'            	=> __( 'New Vendor Store', 'wcvendors-pro' ),
							'add_new'             	=> __( 'Add New', 'wcvendors-pro' ),
							'add_new_item'        	=> __( 'Add New Vendor Store', 'wcvendors-pro' ),
							'edit_item'           	=> __( 'Edit Vendor Store', 'wcvendors-pro' ),
							'view_item'           	=> __( 'View Vendor Store', 'wcvendors-pro' ),
							'search_items'        	=> __( 'Search Vendor Stores', 'wcvendors-pro' ),
							'not_found'           	=> __( 'No Vendor Stores found', 'wcvendors-pro' ),
							'not_found_in_trash'  	=> __( 'No Vendor Stores found in trash', 'wcvendors-pro' ),
							'parent_item_colon'   	=> __( 'Parent Vendor Store', 'wcvendors-pro' ),
							'menu_name'           	=> __( 'Vendor Stores', 'wcvendors-pro' ),
							'featured_image'        => __( 'Store Banner', 'wcvendors-pro' ),
							'set_featured_image'    => __( 'Set store banner', 'wcvendors-pro' ),
							'remove_featured_image' => __( 'Remove store banner', 'wcvendors-pro' ),
							'use_featured_image'    => __( 'Use as store banner', 'wcvendors-pro' ),
						),
						'public'            	=> true,
						'hierarchical'      	=> false,
						'show_ui'           	=> true,
						'show_in_nav_menus' 	=> false,
						// 'capability_type'  		=> 'wcv_pro_vendor_store',
						'supports'          	=> array( 'title', 'editor', 'thumbnail', 'comments', 'custom-fields', 'wpcom-markdown', 'author' ),
						'has_archive'       	=> true,
						'rewrite' 				=> array( 'slug' => $vendor_store_slug, 'with_front' => true  ),
						'query_var'         	=> true,	
						'menu_icon'         	=> 'dashicons-admin-post',
					)
				) 
			);


	} // register_post_type() 

	/**
	 *  Register the new Pro Post type messages 
	 *
	 * @since    1.0.0
	 */
	public function vendorstore_updated_messages( $messages ) {

		global $post;

		$permalink = get_permalink( $post );

		$messages[ self::$store_slug ] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => sprintf( __('updated. <a target="_blank" href="%s">View Vendor Store</a>', 'wcvendors-pro'), esc_url( $permalink ) ),
			2 => __('Custom field updated.', 'wcvendors-pro'),
			3 => __('Custom field deleted.', 'wcvendors-pro'),
			4 => __('updated.', 'wcvendors-pro'),
			/* translators: %s: date and time of the revision */
			5 => isset($_GET['revision']) ? sprintf( __('restored to revision from %s', 'wcvendors-pro'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
			6 => sprintf( __('published. <a href="%s">View Vendor Store</a>', 'wcvendors-pro'), esc_url( $permalink ) ),
			7 => __('saved.', 'wcvendors-pro'),
			8 => sprintf( __('submitted. <a target="_blank" href="%s">Preview Vendor Store</a>', 'wcvendors-pro'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
			9 => sprintf( __('scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview Vendor Store</a>', 'wcvendors-pro'),
			// translators: Publish box date format, see http://php.net/date
			date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( $permalink ) ),
			10 => sprintf( __('draft updated. <a target="_blank" href="%s">Preview Vendor Store</a>', 'wcvendors-pro'), esc_url( add_query_arg( 'preview', 'true', $permalink ) ) ),
		);

			return $messages;
			
	} // vendorstore_updated_messages()

	/**
	 *  Register the new Pro taxonomies 
	 *
	 * @since    1.0.0
	 */
	public function register_taxonomies() { 

		// Add woocommerce product category and tag to vendor_store 
		// register_taxonomy_for_object_type( 'product_cat', self::$store_slug ); 
		// register_taxonomy_for_object_type( 'product_tag', self::$store_slug ); 

	} // register_taxonomies()

	/**
	 * Add the query vars for the rewrirte rules add_query_vars function.
	 *
	 * @access 		public
	 * @since    	1.0.0
	 * @param 		array $vars query vars array 
	 * @return 		array $vars new query vars 
	 */
	public function add_query_vars( $vars ) {

		$vars[] = "product_paged"; 
		$vars[] = "ratings"; 

		return $vars;

	} // add_query_vars() 


	/**
	 *  Load the new stores template 
	 *
	 * @since    1.0.0
	 */
	public function load_template( $template ) {

		$file = ''; 
	
		if ( is_single() && get_post_type() == self::$store_slug ) {

			$file 	= 'single-' . self::$store_slug . '.php';
		
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
   			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

		} elseif ( is_post_type_archive( self::$store_slug ) ) {

			$file 	= 'archive-' . self::$store_slug  . '.php';
		}

		if ( $file ) {

			// Check in the theme to ensure file is there. 
			$template       = locate_template( 'wc-vendors/store/' . $file );

			if ( ! $template ) {
				$template = $this->base_dir . '/templates/store/' . $file;
			}
		}

		return $template; 

	} 	

	/**
	 * Hook into pre_get_posts to do the main store products query
	 *
	 * @since    1.0.0
	 * @param mixed $q query object
	 */
	public function pre_get_posts( $q ) {
		// We only want to affect the main query
		if ( ! $q->is_main_query() ) {
			return;
		}
	} 

	/**
	 *  Save the store details 
	 *
	 * @since    1.0.0
	 */
	public static function update_store( $args ) {
		return wp_update_post( $args, true );
	} 	


	/**
	 *  Create a store for newly created vendors 
	 * 
	 * @since    1.0.0
	 * @param 	 int 		$vendor_id  vendor id for store id
	 */
	public static function create_vendor_store( $vendor_id ) {

		if ( WCVendors_Pro_Utils::count_user_posts( $vendor_id ) == 0 ) { 

			$user_data = get_userdata( $vendor_id ); 

			$vendor_role = is_array( $user_data->roles ) ? in_array( 'vendor', $user_data->roles ) : false;

			// Only create the store if the newly created user is a vendor
			if ( $vendor_role ) { 

				$default_store_name = apply_filters( 'wcv_default_vendor_store_name', ucfirst( $user_data->display_name ) . __( ' Store', 'wcvendors-pro' ), $user_data ); 

				$store_details = array(
				    'post_author'   => $vendor_id, 
				    'post_type'		=> 'vendor_store', 
				    'post_status'	=> 'publish', 
				    'post_title'	=> $default_store_name
		    	);

		    	$store_id = wp_insert_post( $store_details, true ); 
		    	return $store_id; 
		   	}

	 	} 

	} 

	/**
	 *  Create a store for newly created vendors 
	 * 
	 * @since    1.0.0
	 * @param 	 int 		$vendor_id  vendor id for store id
	 */
	public static function update_vendor_store( $vendor_details ) {

		$store_details = array(
		    'post_author'   => $vendor_details['vendor_id'], 
		    'post_content'  => $vendor_details['store_description'], 
		    'post_type'		=> 'vendor_store', 
		    'post_status'	=> 'publish', 
		    'post_title'	=> $vendor_details['store_name']
    	);

    	$store_id = wp_update_post( $store_details, true ); 

    	if ( $store_id ){ 

	    	// Paypal address
			update_post_meta( $store_id, '_wcv_paypal_address', $vendor_details[ 'paypal_address' ] ); 

			// Seller Info 
			update_post_meta( $store_id, '_wcv_seller_info',   $vendor_details[ 'seller_info' ] ); 

    	}
    			
	} 



	/**
	 *  Save the store categories 
	 *
	 * @since    1.0.0
	 * @param 	 int 	$object_id to update 
	 * @param 	 array  categories to set
	 */
	public static function update_categories( $post_id, $categories ) {

		if ( $categories ) { 
			$store_categories = self::merge_categories( $categories ); 
			wp_set_object_terms( $post_id, $store_categories, 'wcv_vendorstore_cat', true ); 
		} else { 	
			wp_set_object_terms( $post_id, null, 'wcv_vendorstore_cat' ); 
		}
	} 	

	/**
	 *  Save the store taxonomies
	 *
	 * @since    1.0.0
	 */
	public static function update_tags( $post_id, $tags ) {

		if ( $tags ) { 
			$store_tags = self::merge_tags( $tags, array( 'product_tag', 'wcv_vendorstore_tag' ) ); 
			wp_set_object_terms( $post_id, $store_tags, 'wcv_vendorstore_tag', true ); 
		} else { 
			wp_set_object_terms( $post_id, null, 'wcv_vendorstore_tag' ); 
		}
	} 

	/**
	 *  Take the product categories and merge into the store categories then return the store term ids
	 *
	 * @since    1.0.0
	 * @param 	 array  terms to merge
	 * @param 	 array  term types
	 * @todo  	 change to product categories 
	 */
	public static function merge_categories( $terms ) {

		$new_terms = array(); 

		foreach ( $terms as $term ) {
			
			$product_term 	= get_term( $term, 'product_cat' );
			$term_exists 	= term_exists( $product_term->name, 'wcv_vendorstore_cat' ); 

			if ( $term_exists == null || !is_array( $term_exists ) ) { 
				 $new_term_id = wp_insert_term( $product_term->name, 'wcv_vendorstore_cat' ); 
				 $new_terms[] = $new_term_id['term_id']; 
			} else { 
				$new_terms[] = $term_exists['term_id']; 
			}

		}

		$new_terms = array_map( 'intval', $new_terms ); 

		return apply_filters( 'wcv_store_merge_categories', $new_terms ); 

	} // merge_categories() 

	/**
	 *  Take the product tags and merge into the store tags and return the tag ids
	 *
	 * @since    1.0.0
	 * @param 	 array  terms to merge
	 * @param 	 array  term types
	 * @todo  	 support heirachy 
	 */
	public static function merge_tags( $terms ) {

		$new_terms 	= array(); 
		$terms 		= explode( ',', $terms ); 

		foreach ( $terms as $term ) {
			
			$product_term 	= get_term( $term, 'product_cat' );
			$term_exists 	= term_exists( $term, 'wcv_vendorstore_tag' ); 

			if ( $term_exists == null || !is_array( $term_exists ) ) { 
				 $new_term_id = wp_insert_term( $term, 'wcv_vendorstore_tag' ); 
				 $new_terms[] = $new_term_id['term_id']; 
			} else { 
				$new_terms[] = $term; 
			}

		}

		$new_terms = array_map( 'intval', $new_terms ); 

		return apply_filters('wcv_store_merge_tags', $new_terms); 

	} // merge_categories() 

	/**
	 *  Register the new pro taxonomies 
	 *
	 * @since    1.0.0
	 */
	public function add_cap() {
    	
    	// gets the admin role
	    $role = get_role( 'administrator' );
	    $role->add_cap( 'wcv_pro_vendor_store' ); 

	} // add_caps()

	/**
	 *  Process the form submission from the front end. 
	 *
	 * @since    1.0.0
	 */
	public function process_submit() { 

		if ( ! isset( $_POST[ '_wcv-save_store_settings' ] ) || !wp_verify_nonce( $_POST[ '_wcv-save_store_settings' ], 'wcv-save_store_settings' ) || !is_user_logged_in() || ! isset( $_POST[ '_wcv-store_id' ] )) { 
			return; 
		}

		$vendor_status 	= ''; 
		$notice_text 	= ''; 
		$vendor_id 		= get_current_user_id(); 

		if ( isset( $_POST[ '_wcv_vendor_application_id' ] ) ) { 
			$vendor_status 	= 'draft'; 
		} else { 	

			// Check if the Shop name is unique 
			$users = get_users( array( 'meta_key' => 'pv_shop_slug', 'meta_value' => sanitize_title( $_POST[ '_wcv_store_name' ] ) ) );

			if ( !empty( $users ) && $users[ 0 ]->ID != $vendor_id ) {		
				wc_add_notice( __( 'That store name is already taken. Your store name must be unique. <br /> Settings have not been saved.', 'wcvendors-pro' ), 'error' ); 
				return; 
			} 

			$vendor_status = 'publish'; 
			wc_add_notice( __( 'Store Settings Saved', 'wcvendors-pro' ), 'success' ); 
		}

		// Maybe server side validation 
		$store_id			= ( isset( $_POST[ '_wcv-store_id' ] ) )			? $_POST[ '_wcv-store_id' ] 					: 0; 
		$paypal_address		= ( isset( $_POST[ 'pv_paypal_address' ] ) )		? trim( $_POST[ 'pv_paypal_address' ] ) 		: ''; 
		$store_name 		= ( isset( $_POST[ '_wcv_store_name' ] ) )			? trim( $_POST[ '_wcv_store_name' ] )			: ''; 
		$store_phone		= ( isset( $_POST[ '_wcv_store_phone' ] ) )			? trim( $_POST[ '_wcv_store_phone' ] )			: '';
		$seller_info 		= ( isset( $_POST[ '_wcv_seller_info' ] ) )			? trim( $_POST[ '_wcv_seller_info' ] )			: ''; 
		$store_description 	= ( isset( $_POST[ '_wcv_store_description' ]) )	? trim( $_POST[ '_wcv_store_description' ] )	: ''; 
		$store_banner_id 	= ( isset( $_POST[ '_wcv_store_banner_id' ] ) ) 	? trim( $_POST[ '_wcv_store_banner_id' ] )		: ''; 
		$store_icon_id 		= ( isset( $_POST[ '_wcv_store_icon_id' ] ) ) 		? trim( $_POST[ '_wcv_store_icon_id' ] )		: ''; 
		$twitter_username 	= ( isset( $_POST[ '_wcv_twitter_username' ] ) ) 	? trim( $_POST[ '_wcv_twitter_username' ] )		: ''; 
		$instagram_username = ( isset( $_POST[ '_wcv_instagram_username' ] ) ) 	? trim( $_POST[ '_wcv_instagram_username' ] )	: ''; 
		$facebook_url 		= ( isset( $_POST[ '_wcv_facebook_url' ] ) ) 		? trim( $_POST[ '_wcv_facebook_url' ] )			: ''; 
		$linkedin_url 		= ( isset( $_POST[ '_wcv_linkedin_url' ] ) ) 		? trim( $_POST[ '_wcv_linkedin_url' ] )			: ''; 
		$youtube_url 		= ( isset( $_POST[ '_wcv_youtube_url' ] ) ) 		? trim( $_POST[ '_wcv_youtube_url' ] )			: ''; 
		$googleplus_url 	= ( isset( $_POST[ '_wcv_googleplus_url' ] ) ) 		? trim( $_POST[ '_wcv_googleplus_url' ] )		: ''; 
		$address1 			= ( isset( $_POST[ '_wcv_store_address1' ] ) ) 		? trim( $_POST[ '_wcv_store_address1' ] ) 		: '';
		$address2 			= ( isset( $_POST[ '_wcv_store_address2' ] ) ) 		? trim( $_POST[ '_wcv_store_address2' ] ) 		: '';
		$city	 			= ( isset( $_POST[ '_wcv_store_city' ] ) ) 			? trim( $_POST[ '_wcv_store_city' ] ) 			: '';
		$state	 			= ( isset( $_POST[ '_wcv_store_state' ]	 ) ) 		? trim( $_POST[ '_wcv_store_state' ] )	  		: '';
		$country			= ( isset( $_POST[ '_wcv_store_country' ] ) )  		? trim( $_POST[ '_wcv_store_country' ] )  		: '';
		$postcode			= ( isset( $_POST[ '_wcv_store_postcode' ] ) ) 	 	? trim( $_POST[ '_wcv_store_postcode' ] ) 		: '';

		$shipping_fee_national				= ( isset( $_POST[ '_wcv_shipping_fee_national' ] ) ) 				? trim( $_POST[ '_wcv_shipping_fee_national' ] ) 				: '';
		$shipping_fee_international			= ( isset( $_POST[ '_wcv_shipping_fee_international' ] ) ) 			? trim( $_POST[ '_wcv_shipping_fee_international' ] ) 			: '';
		$shipping_fee_national_qty			= ( isset( $_POST[ '_wcv_shipping_fee_national_qty' ] ) ) 			? trim( $_POST[ '_wcv_shipping_fee_national_qty' ] ) 			: '';
		$shipping_fee_international_qty		= ( isset( $_POST[ '_wcv_shipping_fee_international_qty' ] ) ) 		? trim( $_POST[ '_wcv_shipping_fee_international_qty' ] ) 		: '';
		$shipping_fee_national_free			= ( isset( $_POST[ '_wcv_shipping_fee_national_free' ] ) ) 			? trim( $_POST[ '_wcv_shipping_fee_national_free' ] ) 			: '';
		$shipping_fee_international_free	= ( isset( $_POST[ '_wcv_shipping_fee_international_free' ] ) ) 	? trim( $_POST[ '_wcv_shipping_fee_international_free' ] ) 		: '';
		$shipping_fee_national_disable		= ( isset( $_POST[ '_wcv_shipping_fee_national_disable' ] ) ) 		? trim( $_POST[ '_wcv_shipping_fee_national_disable' ] ) 		: '';
		$shipping_fee_international_disable	= ( isset( $_POST[ '_wcv_shipping_fee_international_disable' ] ) ) 	? trim( $_POST[ '_wcv_shipping_fee_international_disable' ] ) 	: '';
		$product_handling_fee   			= ( isset( $_POST[ '_wcv_shipping_product_handling_fee' ] ) ) 		? trim( $_POST[ '_wcv_shipping_product_handling_fee' ] ) 		: '';
		$order_handling_fee					= ( isset( $_POST[ '_wcv_shipping_order_handling_fee' ] ) ) 		? trim( $_POST[ '_wcv_shipping_order_handling_fee' ] ) 			: '';
		$shipping_policy					= ( isset( $_POST[ '_wcv_shipping_policy' ] ) ) 					? trim( $_POST[ '_wcv_shipping_policy' ] ) 						: '';
		$return_policy						= ( isset( $_POST[ '_wcv_shipping_return_policy' ] ) ) 				? trim( $_POST[ '_wcv_shipping_return_policy' ] ) 				: '';
		$shipping_from						= ( isset( $_POST[ '_wcv_shipping_from' ] ) ) 						? trim( $_POST[ '_wcv_shipping_from' ] ) 						: '';
		
		$shipping_address1 					= ( isset( $_POST[ '_wcv_shipping_address1' ] ) ) 		? trim( $_POST[ '_wcv_shipping_address1' ] ) 		: '';
		$shipping_address2 					= ( isset( $_POST[ '_wcv_shipping_address2' ] ) ) 		? trim( $_POST[ '_wcv_shipping_address2' ] ) 		: '';
		$shipping_city	 					= ( isset( $_POST[ '_wcv_shipping_city' ] ) ) 			? trim( $_POST[ '_wcv_shipping_city' ] ) 			: '';
		$shipping_state	 					= ( isset( $_POST[ '_wcv_shipping_state' ]	 ) ) 		? trim( $_POST[ '_wcv_shipping_state' ]	)  			: '';
		$shipping_country					= ( isset( $_POST[ '_wcv_shipping_country' ] ) )  		? trim( $_POST[ '_wcv_shipping_country' ] ) 		: '';
		$shipping_postcode					= ( isset( $_POST[ '_wcv_shipping_postcode' ] ) ) 	 	? trim( $_POST[ '_wcv_shipping_postcode' ] ) 		: '';

		// Core store settings 
		$store_settings = array(
				'post_content'   => $store_description, 
				'post_title'     => $store_name,
				'post_status'    => $vendor_status, 
				'post_type'      => 'vendor_store',
				'post_author'    => $vendor_id, 
		);  

		if ( 0 !== $store_id ) $store_settings[ 'ID' ] = $store_id; 

		$store_id = wp_update_post( $store_settings, true ); 

		if ( is_wp_error( $store_id ) ) { 
			wc_clear_notices(); 
			wc_add_notice( __( 'There was a problem saving your settings. Settings have not been saved.', 'wcvendors-pro' ), 'error' ); 
			return; 
		} 

		// Store Banner
		if ( isset( $store_banner_id ) && '' !== $store_banner_id ) { 
			set_post_thumbnail( $store_id, (int) $store_banner_id ); 
		} else { 
			delete_post_thumbnail( $store_id ); 
		}

		// Store Icon 
		update_post_meta( $store_id, '_wcv_store_icon_id', 		$store_icon_id );  	

		// $wcvendors_usermeta = array(
		// 	'vendor_id'					=> $vendor_id, 
		// 	'_wcv_store_name' 			=> $store_name, 
		// 	'_wcv_store_slug' 			=> sanitize_title( $store_name ), 
		// 	'_wcv_store_description' 	=> $store_description,  
		// 	'pv_paypal_address'			=> $paypal_address, 
		// 	'_wcv_seller_info' 			=> $seller_info,  
		// ); 

		// // Update base plugin store settings  
		// $this->merge_wcvendors_shop_setting( $wcvendors_usermeta ); 	
		
		// Store Address 
		update_post_meta( $store_id, '_wcv_store_address1', 	$address1 ); 
		update_post_meta( $store_id, '_wcv_store_address2', 	$address2 ); 
		update_post_meta( $store_id, '_wcv_store_city', 		$city ); 
		update_post_meta( $store_id, '_wcv_store_state',		$state ); 
		update_post_meta( $store_id, '_wcv_store_country', 		$country ); 
		update_post_meta( $store_id, '_wcv_store_postcode', 	$postcode ); 

		// Paypal address
		update_post_meta( $store_id, 'pv_paypal_address', 	$paypal_address ); 

		// Store Phone
		update_post_meta( $store_id, '_wcv_store_phone', 		$store_phone ); 

		// Seller Info 
		update_post_meta( $store_id, 'pv_seller_info', 		$seller_info ); 
		
		// Twitter Username
		update_post_meta( $store_id, '_wcv_twitter_username', 	$twitter_username );  
		
		//Instagram Username 
		update_post_meta( $store_id, '_wcv_instagram_username', $instagram_username );
		
		// Facebook URL
		update_post_meta( $store_id, '_wcv_facebook_url', 		$facebook_url ); 
		
		// LinkedIn URL
		update_post_meta( $store_id, '_wcv_linkedin_url', 		$linkedin_url ); 

		// YouTube URL
		update_post_meta( $store_id, '_wcv_youtube_url', 		$youtube_url ); 	

		// Google+ URL
		update_post_meta( $store_id, '_wcv_googleplus_url', 	$googleplus_url ); 	

		$wcvendors_shipping = array( 
			'national' 						=> $shipping_fee_national, 
			'national_qty_override'			=> $shipping_fee_national_qty,
			'national_free'					=> $shipping_fee_national_free,
			'national_disable'				=> $shipping_fee_national_disable, 
			'international' 				=> $shipping_fee_international,
			'international_qty_override' 	=> $shipping_fee_international_qty, 
			'international_free' 			=> $shipping_fee_international_free, 
			'international_disable' 		=> $shipping_fee_international_disable, 
			'product_handling_fee' 			=> $product_handling_fee, 
			'order_handling_fee' 			=> $order_handling_fee, 
			'shipping_policy'				=> $shipping_policy, 
			'return_policy' 				=> $return_policy, 
			'shipping_from' 				=> $shipping_from, 
			'shipping_address'				=> '', 
		); 

		if ( $shipping_from && $shipping_from == 'other' ) { 

			$shipping_address = array(
				'address1' => 	$shipping_address1,
				'address2' => 	$shipping_address2,
				'city'	   =>	$shipping_city,
				'state'    =>	$shipping_state,
				'country'  => 	$shipping_country,
				'postcode' => 	$shipping_postcode,
			); 

			$wcvendors_shipping['shipping_address'] = $shipping_address; 
		} 

		update_post_meta( $store_id, '_wcv_shipping', 	$wcvendors_shipping ); 	

		// shipping rates 
		$shipping_rates = array();

		if ( isset( $_POST['_wcv_shipping_fees'] ) ) {
			$shipping_countries    	= isset( $_POST['_wcv_shipping_countries'] ) 	? $_POST['_wcv_shipping_countries'] : array(); 
			$shipping_states    	= isset( $_POST['_wcv_shipping_states'] ) 		? $_POST['_wcv_shipping_states'] : array();
			$shipping_fees     		= isset( $_POST['_wcv_shipping_fees'] )  		? $_POST['_wcv_shipping_fees'] : array();
			$shipping_fee_count 	= sizeof( $shipping_fees );

			for ( $i = 0; $i < $shipping_fee_count; $i ++ ) {

				if ( $shipping_fees[ $i ] != '' ) {
					$country       = wc_clean( $shipping_countries[ $i ] ); 
					$state         = wc_clean( $shipping_states[ $i ] );
					$fee           = wc_format_decimal( $shipping_fees[ $i ] );
					$shipping_rates[ $i ] = array(
						'country'	=> $country,
						'state' 	=> $state, 
						'fee' 		=> $fee,
					);
				}
			}
			update_post_meta( $store_id, '_wcv_shipping_rates',  $shipping_rates  );
		} else { 
			delete_post_meta( $store_id, '_wcv_shipping_rates' );
		}

		


		// To be used to allow custom meta keys 
		$wcv_custom_metas = array_intersect_key( $_POST, array_flip(preg_grep('/^_wcv_custom_settings_/', array_keys( $_POST ) ) ) );

		if ( !empty( $wcv_custom_metas ) ) { 

			foreach ( $wcv_custom_metas as $key => $value ) {
				update_post_meta( $store_id, $key, 	$value ); 	
			}

		}		
		

		// save the pending vendor 
		if ( isset( $_POST[ '_wcv_vendor_application_id' ] ) ) {  
			WCVendors_Pro_Vendor_Controller::save_pending_vendor( $vendor_id ); 
			wc_clear_notices(); 
			wc_add_notice( __( 'Your application has been received. You will be notified by email the results of your application', 'wcvendors-pro' ), 'success' );
			wp_safe_redirect( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); 
			exit; 
		} 

		do_action( 'wcv_pro_store_settings_saved', $store_id, $vendor_id );


	} // process_submit() 


	/**
	 *  Merge settings with free meta keys
	 * 
	 * @since    1.0.0
	 * @param 	 array 	$wcvendors_usermeta  wcvendors pro store settings 
	 */
	public function merge_wcvendors_shop_setting( $wcvendors_usermeta ) {

		$vendor_id = $wcvendors_usermeta[ 'vendor_id' ]; 
		update_user_meta( $vendor_id, 'pv_paypal', 				$wcvendors_usermeta[ '_wcv_paypal_address' ] );
		update_user_meta( $vendor_id, 'pv_shop_name', 			$wcvendors_usermeta[ '_wcv_store_name' ] );
		update_user_meta( $vendor_id, 'pv_shop_slug', 			$wcvendors_usermeta[ '_wcv_store_slug' ] );
		update_user_meta( $vendor_id, 'pv_shop_description', 	$wcvendors_usermeta[ '_wcv_store_description' ] );
		update_user_meta( $vendor_id, 'pv_seller_info', 		$wcvendors_usermeta[ '_wcv_seller_info' ] );
		
	} 

	/**
	 *  Hook into the loop sold by on the product screen. Add sold by to product loop before add to cart
	 * 
	 * @since    1.0.0
	 * @param 	 int 		$product_id  the product to hook into 
	 */
	public function loop_sold_by( $product_id ) { 

		remove_action( 'woocommerce_after_shop_loop_item', array( 'WCV_Vendor_Shop', 'template_loop_sold_by' ), 9, 2 );	

		if ( !is_single() && get_post_type() != WCVendors_Pro_Store_Controller::$store_slug ) { 

			$shop_url 		=  ''; 
			$vendor_id 		= WCV_Vendors::get_vendor_from_product( $product_id ); 
			$is_vendor 		= WCV_Vendors::is_vendor( $vendor_id ); 
			$store_id 		= $is_vendor ? WCVendors_Pro_Vendor_Controller::get_vendor_store_id( $vendor_id ) : 0; 
			$sold_by_label 	= WC_Vendors::$pv_options->get_option( 'sold_by_label' ); 

			$sold_by 		= apply_filters( 'wcv_loop_sold_by', 
				array( 
					'product_id'		=> $product_id, 
					'vendor_id'			=> $vendor_id, 
					'shop_url' 			=> ( $store_id 	!= 0 ) ? get_the_permalink( $store_id ) : '', 
					'shop_name'			=> $is_vendor ? WCV_Vendors::get_vendor_sold_by( $vendor_id ) : get_bloginfo( 'name' ), 
					'wrapper_start'		=> '<small class="wcv_sold_by_in_loop">', 
					'wrapper_end'		=> '</small><br />', 
					'title'				=> $sold_by_label, 
				) ); 

			include('partials/product/wcvendors-pro-sold-by.php');
			
		} 

	} // loop_sold_by()

	/**
	 *  Hook into the single product page to display the sold by vendor store link
	 * 
	 * @since    1.0.0
	 * @param 	 int 		$product_id  the product to hook into 
	 */
	public function product_sold_by( $product_id ) { 

		remove_action( 'woocommerce_product_meta_start', array( 'WCV_Vendor_Cart', 'sold_by_meta' ), 10, 2 );

		$shop_url 		=  ''; 
		$vendor_id 		= WCV_Vendors::get_vendor_from_product( $product_id ); 
		$is_vendor 		= WCV_Vendors::is_vendor( $vendor_id ); 
		$store_id 		= $is_vendor ? WCVendors_Pro_Vendor_Controller::get_vendor_store_id( $vendor_id ) : 0; 
		$sold_by_label 	= WC_Vendors::$pv_options->get_option( 'sold_by_label' ); 

		$sold_by 		= apply_filters( 'wcv_product_sold_by', 
			array( 
				'product_id'		=> $product_id, 
				'vendor_id'			=> $vendor_id, 
				'shop_url' 			=> ( $store_id 	!= 0 ) ? get_the_permalink( $store_id ) : '', 
				'shop_name'			=> $is_vendor ? WCV_Vendors::get_vendor_sold_by( $vendor_id ) : get_bloginfo( 'name' ), 
				'title'				=> $sold_by_label, 
			) ); 

		include('partials/product/wcvendors-pro-sold-by.php'); 

	} // product_sold_by() 


	/**
	 *  Hook into the single product page to display the ships from link
	 * 
	 * @since    1.0.0
	 * @param 	 int 		$product_id  the product to hook into 
	 */
	public function product_ships_from( $product_id ) { 

		global $post, $product;


		$shipping_disabled		= WCVendors_Pro::get_option( 'shipping_management_cap' );

		if ( $product->needs_shipping() && ! $shipping_disabled && WCV_Vendors::is_vendor( $product->post->post_author ) ) { 

			$vendor_id 	= WCV_Vendors::get_vendor_from_product( $product_id ); 
			$is_vendor 	= WCV_Vendors::is_vendor( $vendor_id ); 
			$store_id 	= $is_vendor ? WCVendors_Pro_Vendor_Controller::get_vendor_store_id( $vendor_id ) : 0; 

			$store_rates		= get_post_meta( $store_id, '_wcv_shipping', true ); 
			$store_country 		= ( $store_rates && $store_rates['shipping_from'] == 'other' ) ? strtolower( $store_rates['shipping_address']['country'] ) : strtolower( get_post_meta( $store_id, '_wcv_store_country', true ) ); 
			$countries 			= WCVendors_Pro_Form_Helper::countries();

			if ( ! $store_country ) $store_country = WC()->countries->get_base_country(); 

			$ships_from 	= apply_filters( 'wcv_product_ships_from', 
				array( 
					'store_country'		=> $countries[ strtoupper( $store_country ) ], 
					'wrapper_start'	=> '<span class="wcvendors_ships_from"><br />', 
					'wrapper_end'	=> '</span><br />',  	
					'title'				=> __( 'Ships From: ', 'wcvendors-pro' )
				) ); 

			include('partials/product/wcvendors-pro-ships-from.php'); 
		} 

	} // product_sold_by() 


	/**
	 *  Hook into the cart to display the sold by vendor store link
	 * 
	 * @since    1.1.0
	 * @param 	 array 		$cart_items the cart items
	 * @param 	 array 		$cart_item  the cart item
	 */
	public function cart_sold_by( $values, $cart_item ) { 

		remove_filter( 'woocommerce_get_item_data', array( 'WCV_Vendor_Cart', 'sold_by' ), 10, 2 );

		$vendor_id 		= $cart_item[ 'data' ]->post->post_author;
		$is_vendor 		= WCV_Vendors::is_vendor( $vendor_id ); 
		$store_id 		= $is_vendor ? WCVendors_Pro_Vendor_Controller::get_vendor_store_id( $vendor_id ) : 0; 
		$shop_url 		= ( $store_id 	!= 0 ) ? get_the_permalink( $store_id ) : ''; 
		$sold_by 		= ''; 
		$sold_by_label 	= WC_Vendors::$pv_options->get_option( 'sold_by_label' ); 

		if ( $is_vendor ) { 
			$sold_by = sprintf( '<a href="%s" target="_TOP">%s</a>', $shop_url, WCV_Vendors::get_vendor_sold_by( $vendor_id ) ); 
		} else { 
			$sold_by =  get_bloginfo( 'name' ); 
		}
		
		$values[] = array(
			'name' => apply_filters( 'wcv_cart_sold_by_label', $sold_by_label .' ' ),
			'display' => $sold_by,
		);

		return $values; 

	} //cart_sold_by() 

	/**
	 *  Hook into the cart to display the sold by vendor store link
	 * 
	 * @since    1.1.0
	 * @param 	 string 		$name  the product to hook into 
	 * @todo Need to check if this still works or not in woo. 
	 */
	public function email_sold_by( $name, $_product ){ 

		$product 		= get_post( $_product->id );	
		$vendor_id 		= $product->post_author; 
		$is_vendor 		= WCV_Vendors::is_vendor( $vendor_id ); 
		$store_id 		= $is_vendor ? WCVendors_Pro_Vendor_Controller::get_vendor_store_id( $vendor_id ) : 0; 
		$shop_url 		= ( $store_id 	!= 0 ) ? get_the_permalink( $store_id ) : ''; 
		$sold_by 		= '';
		$sold_by_label 	= WC_Vendors::$pv_options->get_option( 'sold_by_label' ); 

		if ( $is_vendor ) { 
			$sold_by = sprintf( '<a href="%s" target="_TOP">%s</a>', $shop_url, WCV_Vendors::get_vendor_sold_by( $vendor_id ) ); 
		} else { 
			$sold_by =  get_bloginfo( 'name' ); 
		}

		$name_args 	= apply_filters( 'wcv_email_sold_by_name_args', 
			array( 
				'sold_by'		=> $sold_by,  
				'wrapper_start'	=> '<small class="wcvendors_sold_by_in_email"><br />', 
				'wrapper_end'	=> '</small><br />', 
				'title'			=> $sold_by_label, 
				'product_id'	=>  $_product->id, 
				'vendor_id'		=> $vendor_id, 
			) 
		); 

		$name .= $name_args['wrapper_start'] . $name_args['title'] . $name_args['sold_by'] . ' ' . $name_args['wrapper_end'];

		return $name; 

	} // email_sold_by() 


	/**
	 *  Override the authors selectbox with +vendor roles
	 * 
	 * @since    1.0.0
	 * @param 	 output 	html for select box
	 * @return   html 	    html to output 
	 */
	public function author_add_vendor_roles( $output ) {
		global $post;

		if ( empty( $post ) ) return $output;

		// Return if this isn't a WooCommerce product post type
		if ( $post->post_type != self::$store_slug ) return $output;

		// Return if this isn't the vendor author override dropdown
		if ( !strpos( $output, 'post_author_override' ) ) return $output;

		$args = array(
			'selected' => $post->post_author,
			'id'       => 'post_author_override',
		);

		$output = $this->vendor_dropdown( $args );

		return $output;
	}


	/**
	 * Create a selectbox to display vendor & administrator roles
	 *
	 * @param array $args
	 * @since    1.0.0
	 * @return html
	 */
	public function vendor_dropdown( $args ) {

		$default_args = array(
			'placeholder',
			'id',
			'class',
		);

		foreach ( $default_args as $key ) {
			if ( !is_array( $key ) && empty( $args[ $key ] ) ) $args[ $key ] = '';
			else if ( is_array( $key ) ) foreach ( $key as $val ) $args[ $key ][ $val ] = esc_attr( $args[ $key ][ $val ] );
		}
		extract( $args );

		$roles     = array( 'vendor', 'administrator' );
		$user_args = array( 'fields' => array( 'ID', 'user_login' ) );

		include('partials/vendor/wcvendors-pro-vendor-metabox.php'); 
		
		return $output;
	}

	/**
	 * Change the "Author" metabox to "Vendor" on Vendor Stores 
	 *
	 * @since    1.0.0
	 * @return html
	 */
	public function change_author_meta_box_title() {
		global $wp_meta_boxes;
		$wp_meta_boxes[ self::$store_slug ][ 'normal' ][ 'core' ][ 'authordiv' ][ 'title' ] = __( 'Vendor', 'wcvendors' );;
	}

	/**
	 * Return if the current page is related to vendor store pages 
	 *
	 * @since    1.0.0
	 * @return   bool   - if is vendor store pages
	 */
	public static function is_vendor_store() {

		return ( ( is_shop() || is_product_taxonomy() || is_product() ) || is_post_type_archive( self::$store_slug ) || ( is_single() && get_post_type() == self::$store_slug ) ); 
	}


	/**
	 * Output the Pro header on single and archive pages 
	 *
	 * @since    1.0.0
	 * @return html
	 */
	public function store_single_header( ) { 

		global $product; 

		// remove_action( 'woocommerce_before_single_product', array('WCV_Vendor_Shop', 'vendor_mini_header') ); 

		if ( WCV_Vendors::is_vendor_product_page( $product->post->post_author ) )  { 

		} 

	}

	public function store_main_content_header() { 

		// Remove the basic shop description from the loop 
		// remove_action( 'woocommerce_before_main_content', array( 'WCV_Vendor_Shop', 'shop_description' ), 30 );
		// Remove free info from the loop 
		// remove_action( 'woocommerce_before_main_content', array( 'WCV_Vendor_Shop', 'vendor_main_header'), 20 ); 

		if ( WCV_Vendors::is_vendor_page() ) { 

			$vendor_shop 		= urldecode( get_query_var( 'vendor_shop' ) );
			$vendor_id   		= WCV_Vendors::get_vendor_id( $vendor_shop ); 
			$store_id 			= WCVendors_Pro_Vendor_Controller::get_vendor_store_id( $vendor_id );
		
			do_action('wcv_before_main_header', $vendor_id); 

			wc_get_template( 'store-header.php', array( 
						'store_id' 	=> $store_id, 
						'vendor_id' => $vendor_id
			), 'wc-vendors/store/', $this->base_dir . 'templates/store/' ); 


			do_action('wcv_after_main_header', $vendor_id); 

		}

	}

	/**
	 * Sync the user meta with the store meta 
	 *
	 * @since    1.1.0
	 * @return html
	 */
	public function vendor_store_sync( $vendor_id  ){ 

		if ( ! WCV_Vendors::is_vendor( $vendor_id ) ) return; 

		$store_id = WCVendors_Pro_Vendor_Controller::get_vendor_store_id( $vendor_id ); 

		// Core store settings 
		$store_settings = array(
			'ID'			 => $store_id, 
			'post_content'   => $_POST[ 'pv_shop_description' ], 
			'post_title'     => $_POST[ 'pv_shop_name' ],
			'post_author'    => $vendor_id, 
		);  
		
		$post_id = wp_update_post( $store_settings, true );	

		if ( is_wp_error( $post_id ) ) {
			$errors = $post_id->get_error_messages();
			foreach ( $errors as $error ) {
				echo $error;
			}
		}

		update_post_meta( $store_id, '_wcv_paypal_address', $_POST[ 'pv_paypal' ] );
		update_post_meta( $store_id, '_wcv_seller_info', $_POST[ 'pv_seller_info' ] );

	}

}	