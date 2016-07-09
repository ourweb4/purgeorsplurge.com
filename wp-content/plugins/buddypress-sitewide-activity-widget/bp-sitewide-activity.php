<?php

/**
 * Plugin Name: BuddyPress Sitewide Activity Widget
 * Plugin URI: http://buddydev.com/plugins/buddypress-sitewide-activity-widget/
 * Version: 1.3.2
 * Author: Brajesh Singh(BuddyDev.com)
 * Author URI: http://buddydev.com
 * 
 * Description: Power packed, customizable Sitewide activity widget for BuddyPress. 
 * 
 * 
 */

if( ! defined( 'ABSPATH' ) ) {
	exit( 0 );
}
/**
 * Sitewide Activity Helper Class
 * 
 * Loads the assets and does basic duties
 * 
 * @since v1.14
 * 
 */

class SWA_Helper {
	
	/**
	 * Singleton instance of SWA Helper
	 * 
	 * @var SWA_Helper 
	 */
	private static $instance = null;
	
	/**
	 * Absolute path to the swa plugin directory
	 * 
	 * @var type 
	 */
	private $path;
	
	/**
	 * Absolute url to the swa plugin directory
	 * 
	 * @var type 
	 */
	private $url;
	
	
	private function __construct() {
		
		$this->setup();
	}

	/**
	 * Get singleton instance
	 * 
	 * @return SWA_Helper 
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	
	/**
	 * Setup initialize and setup various hooks
	 */
	private function setup() {
		
		//set plugin path &url
		$this->path = plugin_dir_path( __FILE__ );
		$this->url = plugin_dir_url( __FILE__ );
		
		//load core files
		add_action( 'bp_include', array( $this, 'load' ) );
		
		//for enqueuing javascript
		add_action( 'bp_enqueue_scripts', array( $this, 'load_js' ) );
		//load css
		add_action( 'bp_enqueue_scripts', array( $this, 'load_css' ) );
		//load admin css on widgets.php
		add_action( 'admin_print_styles-widgets.php', array( $this, 'load_admin_css' ) );
		
		
		$this->load_textdomain();
		
	}
	
	/**
	 * Load SWA core files
	 * 
	 */
	public function load() {
		
		$files = array(
			'core/functions.php',
			'core/template.php',
			'core/ajax.php',
			'core/widget.php',
		);
		
		foreach( $files as $file ) {
			require_once $this->path . $file ;
		}

	}


	public function load_js() {
		
		if ( ! is_admin() ) {
			wp_enqueue_script( 'swa-js', $this->url . 'assets/swa.js', array( 'jquery' ) );
		}
		
	}

	public function load_css() {
		
		if ( apply_filters( 'swa_load_css', true ) ) {
			wp_register_style( 'swa-css', $this->url . 'assets/swa.css' );
			wp_enqueue_style( 'swa-css' );
		}
			
	}
	
	/**
	 * Load admin style on widgets page
	 * 
	 */
	public function load_admin_css() {
		
		wp_register_style( 'swa-admin-css', $this->url . 'assets/swa-admin.css' );
		wp_enqueue_style( 'swa-admin-css' );
	}

	/**
	 * Load text domain
	 * 
	 */
	public function load_textdomain() {
		
		load_plugin_textdomain( 'buddypress-sitewide-activity-widget', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}
	
	/**
	 * Get all admin users of the given blog
	 * 
	 * @param int $blog_id
	 * @return array of user IDs
	 */
	public function get_admin_users_for_blog( $blog_id ) {
		
		$users = get_users( array( 'role' => 'administrator', 'blog_id' => $blog_id, 'fields'=> 'ID' ) );
		
		return $users;
		
	}
	
	/**
	 * Get absolute url of the plugin
	 * 
	 * @return string
	 */
	public function get_url() {
		
		return $this->url;
	}
	
	/**
	 * Get absolute path of the plugin
	 *  
	 * @return string
	 */
	public function get_path() {
		
		return $this->path;
	}
	
}

SWA_Helper::get_instance();

/**
 * 
 * @return SWA_Helper
 */
function swa_helper() {
	
	return SWA_Helper::get_instance();
}