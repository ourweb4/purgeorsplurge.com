<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WCVendors_Pro
 * @subpackage WCVendors_Pro/public
 * @author     Jamie Madden <support@wcvendors.com>
 */
class WCVendors_Pro_Public {

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
	 * Script suffix for debugging 
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $suffix    script suffix for including minified file versions 
	 */
	private $suffix;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $wcvendors_pro       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 * @param      bool      $debug    Plugin is in debug mode 
	 */
	public function __construct( $wcvendors_pro, $version, $debug ) {

		$this->wcvendors_pro 	= $wcvendors_pro;
		$this->version 			= $version;
		$this->debug 			= $debug; 
		$this->base_dir			= plugin_dir_url( __FILE__ ); 
		$this->suffix		 	= $this->debug ? '' : '.min';
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 * @todo 	 check if any of the styles are already loaded before enqueing them 
	 */
	public function enqueue_styles() {
		
		// wp_enqueue_style( $this->wcvendors_pro, $this->base_dir . 'assets/css/wcvendors-pro-public'.$this->suffix.'.css', array(), $this->version, 'all' );

		$current_page_id = get_the_ID(); 

		$dashboard_page_id 	= WCVendors_Pro::get_option( 'dashboard_page_id' ); 
		$feedback_page_id 	= WCVendors_Pro::get_option( 'feedback_page_id' );  
		$view_dashboard		= apply_filters( 'wcv_view_dashboard', 	$current_page_id == $dashboard_page_id ? true : false );
 		$view_feedback		= apply_filters( 'wcv_view_feedback', 	$current_page_id == $feedback_page_id ? true : false );

		if ( $view_dashboard ) { 
	
			if ( is_user_logged_in() ) {

				// Dashboard Style
				wp_enqueue_style( 'wcv-pro-dashboard', apply_filters( 'wcv_pro_dashboard_style' , $this->base_dir . 'assets/css/dashboard' . $this->suffix . '.css' ), false, $this->version );

			} 

		} 

		// Store Style 
		if ( is_shop() || is_product() ) { 
			wp_enqueue_style( 'wcv-pro-store-style', apply_filters( 'wcv_pro_store_style', $this->base_dir . 'assets/css/store' . $this->suffix . '.css' ), false, $this->version );			
		} 
		
		if ( ( $view_dashboard ) || ( $view_feedback ) )  { 

			// Ink system 
			wp_enqueue_style( 'wcv-ink', 	apply_filters( 'wcv_pro_ink_style', $this->base_dir . 'assets/lib/ink-3.1.10/dist/css/ink.min.css' ), array(), '3.1.10', 'all' );

			//Select2 3.5.4
			wp_enqueue_style( 'select2-css', 	$this->base_dir . '../includes/assets/css/select2' . $this->suffix . '.css', array(), '4.3.0', 'all' );

		} 

		//font awesome 
		wp_enqueue_style( 'font-awesome', 	$this->base_dir . '../includes/assets/lib/font-awesome-4.3.0/css/font-awesome.min.css', array(), '4.3.0', 'all' );


	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->wcvendors_pro, $this->base_dir . 'assets/js/wcvendors-pro-public'.$this->suffix.'.js', array( 'jquery' ), $this->version, true );

		$current_page_id = get_the_ID(); 

		$dashboard_page_id 	= WCVendors_Pro::get_option( 'dashboard_page_id' );

		$file_display 		= WC_Vendors::$pv_options->get_option( 'file_display' );

		$view_dashboard		= apply_filters( 'wcv_view_dashboard', 	$current_page_id == $dashboard_page_id ? true : false ); 

		if ( $view_dashboard ) { 
	
			if ( is_user_logged_in() ) {
	
				wp_enqueue_media();

				$localize_search_args = array(
					'i18n_matches_1'            => __( 'One result is available, press enter to select it.', 'wcvendors-pro' ),
					'i18n_matches_n'            => __( '%qty% results are available, use up and down arrow keys to navigate.', 'wcvendors-pro' ),
					'i18n_no_matches'           => __( 'No matches found', 'wcvendors-pro' ),
					'i18n_ajax_error'           => __( 'Loading failed', 'wcvendors-pro' ),
					'i18n_input_too_short_1'    => __( 'Please enter 1 or more characters', 'wcvendors-pro' ),
					'i18n_input_too_short_n'    => __( 'Please enter %qty% or more characters', 'wcvendors-pro' ),
					'i18n_input_too_long_1'     => __( 'Please delete 1 character', 'wcvendors-pro' ),
					'i18n_input_too_long_n'     => __( 'Please delete %qty% characters', 'wcvendors-pro' ),
					'i18n_selection_too_long_1' => __( 'You can only select 1 item', 'wcvendors-pro' ),
					'i18n_selection_too_long_n' => __( 'You can only select %qty% items', 'wcvendors-pro' ),
					'i18n_load_more'            => __( 'Loading more results&hellip;', 'wcvendors-pro' ),
					'i18n_searching'            => sprintf( __( 'Searching %s', 'wcvendors-pro' ), '&hellip;'),
					'ajax_url'                  => admin_url( 'admin-ajax.php' ),
					'nonce'						=> wp_create_nonce('wcv-search'), 
				); 

				// ChartJS 1.0.2
				wp_register_script( 'chartjs', 				$this->base_dir . 'assets/lib/chartjs/Chart' . $this->suffix	 . '.js', array( 'jquery' ), '1.0.2', true );
				wp_enqueue_script( 'chartjs'); 

				// WCV chart init 
				wp_register_script( 'wcvendors-pro-charts', $this->base_dir . 'assets/js/wcvendors-pro-charts'.$this->suffix.'.js', array( 'chartjs' ), $this->version, true );
				wp_enqueue_script( 'wcvendors-pro-charts'); 
				
				// Select 2 (3.5.2 branch)
				wp_register_script( 'select2', 				$this->base_dir . '../includes/assets/js/select2' . $this->suffix	 . '.js', array( 'jquery' ), '3.5.2', true );
				wp_enqueue_script( 'select2'); 

				// Ink js 
				wp_register_script( 'ink-js', 				$this->base_dir . 'assets/lib/ink-3.1.10/dist/js/ink-all' . $this->suffix	 . '.js', array(), '1.11.4', true );
				wp_enqueue_script( 'ink-js'); 
				
				// Ink autoloader 
				wp_register_script( 'ink-autoloader-js', 	$this->base_dir . 'assets/lib/ink-3.1.10/dist/js/autoload' . $this->suffix	 . '.js', array( 'jquery' ), '1.11.4', true );
				wp_enqueue_script( 'ink-autoloader-js'); 

				// Accounting 
				wp_register_script( 'accounting', 			$this->base_dir . 'assets/lib/accounting/accounting' . $this->suffix	 . '.js', array( 'jquery' ), '0.4.2', true );
				wp_localize_script( 'accounting', 			'accounting_params', array( 'mon_decimal_point' => wc_get_price_decimal_separator() ) );

				// Product search
				wp_register_script( 'wcv-product-search', 	$this->base_dir . 'assets/js/select' . $this->suffix . '.js', array( 'jquery', 'select2' ), '3.5.2', true );
				$localize_search_args['nonce'] = wp_create_nonce( 'wcv-search-products' ); 
				wp_localize_script( 'wcv-product-search', 'wcv_product_select_params', $localize_search_args );
				wp_enqueue_script( 'wcv-product-search' );

				// Tag search 
				wp_register_script( 'wcv-tag-search', 	$this->base_dir . 'assets/js/tags' . $this->suffix . '.js', array( 'jquery', 'select2' ), WCV_PRO_VERSION, true );
				$localize_search_args['nonce'] = wp_create_nonce( 'wcv-search-product-tags' ); 
				wp_localize_script( 'wcv-tag-search', 'wcv_tag_search_params', $localize_search_args ); 
				wp_enqueue_script( 'wcv-tag-search' );

				// Product Edit 
				$product_params = array( 
					'ajax_url'                      		=> admin_url( 'admin-ajax.php' ),
					'product_types' 						=> array_map( 'sanitize_title', get_terms( 'product_type', array( 'hide_empty' => false, 'fields' => 'names' ) ) ),
					'wcv_add_attribute_nonce'       		=> wp_create_nonce( 'wcv-add-attribute' ),
					'wcv_add_new_attribute_nonce'   		=> wp_create_nonce( 'wcv-add-new-attribute' ),
					'remove_attribute'              		=> __( 'Remove this attribute?', 'wcvendors-pro' ),
					'name_label'                    		=> __( 'Name', 'wcvendors-pro' ),
					'remove_label'                  		=> __( 'Remove', 'wcvendors-pro' ),
					'click_to_toggle'               		=> __( 'Click to toggle', 'wcvendors-pro' ),
					'values_label'                  		=> __( 'Value(s)', 'wcvendors-pro' ),
					'text_attribute_tip'            		=> __( 'Enter some text, or some attributes by pipe (|) separating values.', 'wcvendors-pro' ),
					'visible_label'                 		=> __( 'Visible on the product page', 'wcvendors-pro' ),
					'used_for_variations_label'     		=> __( 'Used for variations', 'wcvendors-pro' ),
					'new_attribute_prompt'          		=> __( 'Enter a name for the new attribute term:', 'wcvendors-pro' ),
					'wc_deliminator'						=> WC_DELIMITER, 
					'wcv_file_display'						=> $file_display, 
				); 

				wp_register_script( 'wcv-frontend-product', $this->base_dir . 'assets/js/product' . $this->suffix	 . '.js', array('jquery-ui-core' ), WCV_PRO_VERSION, true ); 				
				wp_localize_script( 'wcv-frontend-product', 'wcv_frontend_product',  $product_params );
				wp_enqueue_script( 'wcv-frontend-product' ); 

				// Product Variation 
				$product_variation_params = array(
					'ajax_url'                      		=> admin_url( 'admin-ajax.php' ),
					'wcv_add_variation_nonce'               => wp_create_nonce( 'wcv-add-variation' ),
					'wcv_link_variation_nonce'              => wp_create_nonce( 'wcv-link-variations' ),
					'wcv_delete_variations_nonce'           => wp_create_nonce( 'wcv-delete-variations' ),
					'wcv_json_link_all_variations_nonce'	=> wp_create_nonce( 'wcv-link-all-variations'), 
					'wcv_load_variations_nonce'             => wp_create_nonce( 'wcv-load-variations' ),
					'wcv_bulk_edit_variations_nonce'        => wp_create_nonce( 'wcv-bulk-edit-variations' ),
					'wcv_woocommerce_placeholder_img_src'   => wc_placeholder_img_src(),
					'wc_deliminator'						=> WC_DELIMITER, 
					'i18n_link_all_variations'            	=> esc_js( __( 'Are you sure you want to link all variations? This will create a new variation for each and every possible combination of variation attributes (max 50 per run).', 'wcvendors-pro' ) ),	
					'i18n_enter_a_value'                  	=> esc_js( __( 'Enter a value', 'wcvendors-pro' ) ),
					'i18n_enter_menu_order'               	=> esc_js( __( 'Variation menu order (determines position in the list of variations)', 'wcvendors-pro' ) ),
					'i18n_enter_a_value_fixed_or_percent' 	=> esc_js( __( 'Enter a value (fixed or %)', 'wcvendors-pro' ) ),
					'i18n_delete_all_variations'          	=> esc_js( __( 'Are you sure you want to delete all variations? This cannot be undone.', 'wcvendors-pro' ) ),
					'i18n_last_warning'                   	=> esc_js( __( 'Last warning, are you sure?', 'wcvendors-pro' ) ),
					'i18n_choose_image'                   	=> esc_js( __( 'Choose an image', 'wcvendors-pro' ) ),
					'i18n_set_image'                      	=> esc_js( __( 'Set variation image', 'wcvendors-pro' ) ),
					'i18n_variation_added'                	=> esc_js( __( "variation added", 'wcvendors-pro' ) ),
					'i18n_variations_added'               	=> esc_js( __( "variations added", 'wcvendors-pro' ) ),
					'i18n_no_variations_added'            	=> esc_js( __( "No variations added", 'wcvendors-pro' ) ),
					'i18n_remove_variation'               	=> esc_js( __( 'Are you sure you want to remove this variation?', 'wcvendors-pro' ) ),
					'i18n_scheduled_sale_start'           	=> esc_js( __( 'Sale start date (YYYY-MM-DD format or leave blank)', 'wcvendors-pro' ) ),
					'i18n_scheduled_sale_end'             	=> esc_js( __( 'Sale end date (YYYY-MM-DD format or leave blank)', 'wcvendors-pro' ) ),
					'i18n_edited_variations'              	=> esc_js( __( 'Save changes before changing page?', 'wcvendors-pro' ) ),
					'i18n_variation_count_single'         	=> esc_js( __( '%qty% variation', 'wcvendors-pro' ) ),
					'i18n_variation_count_plural'         	=> esc_js( __( '%qty% variations', 'wcvendors-pro' ) ),
					'i18n_any_label' 						=> esc_js( __( 'Any', 'wcvendors-pro' ) ),
					'variations_per_page'                 	=> absint( apply_filters( 'woocommerce_admin_meta_boxes_variations_per_page', 15 ) )
				); 

				wp_register_script( 'wcv-frontend-product-variation', $this->base_dir . 'assets/js/product-variation' . $this->suffix	 . '.js', array( 'jquery', 'jquery-ui-core', 'accounting' ), WCV_PRO_VERSION, true ); 		
				wp_localize_script( 'wcv-frontend-product-variation', 'wcv_frontend_product_variation',  $product_variation_params );
				wp_enqueue_script( 'wcv-frontend-product-variation' ); 

				// Order 
				wp_register_script( 'wcv-frontend-order', $this->base_dir . 'assets/js/order' . $this->suffix	 . '.js', array( 'jquery' ), WCV_PRO_VERSION, true ); 				
				wp_enqueue_script( 'wcv-frontend-order' );
		
				// General settings 
				wp_register_script( 'wcv-frontend-general', $this->base_dir . 'assets/js/general' . $this->suffix	 . '.js', array( 'jquery', 'select2' ), WCV_PRO_VERSION, true ); 				
				wp_enqueue_script( 'wcv-frontend-general' );

			}  // user logged in check 
		
		} // on dashboard page 

	}

}
