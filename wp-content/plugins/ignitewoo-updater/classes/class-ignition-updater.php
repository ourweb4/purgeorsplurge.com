<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Ignition Updater Class
 *
 * Base class for the Ignition Updater.
 *
 * @package WordPress
 * @subpackage Ignition Updater
 * @category Core
 * @author Ignition
 * @since 1.0.0
 *
 * TABLE OF CONTENTS
 *
 * public $updater
 * public $admin
 * private $token
 * public $plugin_url
 * public $plugin_path
 * public $version
 * private $file
 *
 * - __construct()
 * - load_localisation()
 * - load_plugin_textdomain()
 * - activation()
 * - register_plugin_version()
 * - add_product()
 * - remove_product()
 * - get_product()
 */
 
// When changing this class name all plugins' IgniteWoo Updater code must also be changed because it looks for this class name
class IgniteWoo_Updater {
	public $updater;
	public $admin;
	private $token = 'ignitewoo-updater';
	private $plugin_url;
	private $plugin_path;
	public $version;
	public $file;
	private $products;

	/**
	 * Constructor.
	 * @param string $file The base file of the plugin.
	 * @since  1.0.0
	 * @return  void
	 */
	public function __construct ( $file, $version ) {

		// If multisite, plugin must be network activated. First make sure the is_plugin_active_for_network function exists
		if( is_multisite() && ! is_network_admin() ) {
			remove_action( 'admin_notices', 'ignition_updater_notice' ); // remove admin notices for plugins outside of network admin
			if ( !function_exists( 'is_plugin_active_for_network' ) )
				require_once( ABSPATH . '/wp-admin/includes/plugin.php' );
			if( !is_plugin_active_for_network( plugin_basename( $file ) ) )
				add_action( 'admin_notices', array( $this, 'admin_notice_require_network_activation' ) );
			return;
		}

		$this->file = $file;
		$this->version = $version;
		$this->plugin_url = trailingslashit( plugins_url( '', $plugin = $file ) );
		$this->plugin_path = trailingslashit( dirname( $file ) );

		$this->products = array();

		$this->load_plugin_textdomain();
		
		add_action( 'init', array( $this, 'load_localisation' ), 0 );

		// Run this on activation.
		register_activation_hook( $this->file, array( $this, 'activation' ) );

		if ( is_admin() ) {
			// Load the admin.
			require_once( 'class-ignition-updater-admin.php' );
			$this->admin = new Ignition_Updater_Admin( $file );

			// Don't do this yet... we don't sell themes at this time
			// Look for enabled updates across all themes (active or otherwise). If they are available, queue them.
			// add_action( 'init', array( $this, 'maybe_queue_theme_updates' ), 1 );

			// Get queued plugin updates - Run on init so themes are loaded as well as plugins.
			add_action( 'init', array( $this, 'load_queued_updates' ), 2 );
		}

		$this->add_notice_unlicensed_product();

		add_filter( 'site_transient_' . 'update_plugins', array( $this, 'change_update_information' ) );

	} // End __construct()

	/**
	 * Load the plugin's localisation file.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function load_localisation () {
		load_plugin_textdomain( 'ignition-updater', false, dirname( plugin_basename( $this->file ) ) . '/lang/' );
	} // End load_localisation()

	/**
	 * Load the plugin textdomain from the main WordPress "languages" folder.
	 * @since  1.0.0
	 * @return  void
	 */
	public function load_plugin_textdomain () {
	    $domain = 'ignition-updater';
	    // The "plugin_locale" filter is also used in load_plugin_textdomain()
	    $locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	    load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
	    load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( $this->file ) ) . '/languages/' );
	} // End load_plugin_textdomain()

	/**
	 * Run on activation.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function activation () {
		$this->register_plugin_version();
	} // End activation()

	/**
	 * Register the plugin's version.
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	private function register_plugin_version () {
		if ( $this->version != '' ) {
			update_option( 'ignition-updater' . '-version', $this->version );
		}
	} // End register_plugin_version()

	/**
	 * Queue updates for any themes that have valid update credentials.
	 * @access  public
	 * @since   1.2.0
	 * @return  void
	 */
	public function maybe_queue_theme_updates () {
		$themes = wp_get_themes();
		if ( is_array( $themes ) && 0 < count( $themes ) ) {
			foreach ( $themes as $k => $v ) {
				// Search for the text file.
				$file = $this->_maybe_find_theme_info_file( $v );
				if ( ! is_wp_error( $file ) ) {
					$parsed = $this->_parse_theme_info_file( $file );
					if ( ! is_wp_error( $parsed ) ) {
						$this->add_product( $parsed[2], $parsed[1], $parsed[0] ); // 0: file, 1: file_id, 2: product_id.
					}
				}
			}
		}
	} // End maybe_queue_theme_updates()

	/**
	 * Maybe find the theme_info.txt file.
	 * @access  private
	 * @since   1.2.0
	 * @param   object $theme WP_Theme instance.
	 * @return  object/string WP_Error object if not found, path to the file, if it exists.
	 */
	private function _maybe_find_theme_info_file ( $theme ) {
		$response = new WP_Error( 404, __( 'Theme Information File Not Found.', 'ignition-updater' ) );
		$txt_files = $theme->get_files( 'txt', 0 );
		if ( isset( $txt_files['theme_info.txt'] ) ) {
			$response = $txt_files['theme_info.txt'];
		}
		return $response;
	} // End _maybe_find_theme_info_file()

	/**
	 * Parse a given theme_info.txt file.
	 * @access  private
	 * @since   1.2.0
	 * @param   string $file The path to the file to be parsed.
	 * @return  object/array WP_Error object if the data is incorrect, array, if it is accurate.
	 */
	private function _parse_theme_info_file ( $file ) {
		$response = new WP_Error( 500, __( 'Theme Information File is Inaccurate. Please try again.', 'ignition-updater' ) );
		if ( is_string( $file ) && file_exists( $file ) ) {
			$contents = file_get_contents( $file );
			$contents = explode( "\n", $contents );
			// Sanity check on the parsed array.
			if ( ( 3 == count( $contents ) ) && stristr( $contents[2], '/style.css' ) ) {
				$response = $contents;
			}
		}
		return $response;
	} // End _parse_theme_info_file()

	/**
	 * load_queued_updates function.
	 *
	 * @access public
	 * @since 1.0.0
	 * @return void
	 */
	public function load_queued_updates() {
		global $ignitewoo_queued_updates;

		if ( ! empty( $ignitewoo_queued_updates ) && is_array( $ignitewoo_queued_updates ) )
			foreach ( $ignitewoo_queued_updates as $plugin )
				if ( is_object( $plugin ) && ! empty( $plugin->file ) && ! empty( $plugin->file_id ) && ! empty( $plugin->product_id ) )
					$this->add_product( $plugin->file, $plugin->file_id, $plugin->product_id );
	} // End load_queued_updates()

	/**
	 * Add a product to await a license key for activation.
	 *
	 * Add a product into the array, to be processed with the other products.
	 *
	 * @since  1.0.0
	 * @param string $file The base file of the product to be activated.
	 * @param string $file_id The unique file ID of the product to be activated.
	 * @return  void
	 */
	public function add_product ( $file, $file_id, $product_id ) {

		if ( $file != '' && ! isset( $this->products[$file] ) ) { $this->products[$file] = array( 'file_id' => $file_id, 'product_id' => $product_id ); }
	} // End add_product()

	/**
	 * Remove a product from the available array of products.
	 *
	 * @since     1.0.0
	 * @param     string $key The key to be removed.
	 * @return    boolean
	 */
	public function remove_product ( $file ) {
		$response = false;
		if ( $file != '' && in_array( $file, array_keys( $this->products ) ) ) { unset( $this->products[$file] ); $response = true; }
		return $response;
	} // End remove_product()

	/**
	 * Return an array of the available product keys.
	 * @since  1.0.0
	 * @return array Product keys.
	 */
	public function get_products () {
		return (array) $this->products;
	} // End get_products()

	/**
	 * Display require network activation error.
	 * @since  1.0.0
	 * @return  void
	 */
	public function admin_notice_require_network_activation () {
		echo '<div class="error"><p>' . __( 'IgniteWoo Updater must be network activated when in multisite environment.', 'ignition-updater' ) . '</p></div>';
	} // End admin_notice_require_network_activation()

	/**
	 * Add action for queued products to display message for unlicensed products.
	 * @access  public
	 * @since   1.1.0
	 * @return  void
	 */
	public function add_notice_unlicensed_product () {
		global $ignitewoo_queued_updates;

		if ( !is_array( $ignitewoo_queued_updates ) || count( $ignitewoo_queued_updates ) < 0 ) 
			return;

		foreach ( $ignitewoo_queued_updates as $key => $update ) {

			add_action( 'in_plugin_update_message-' . $update->file, array( $this, 'need_license_message' ), 10, 2 );
		}
		
	} // End add_notice_unlicensed_product()

	/**
	 * Message displayed if license not activated
	 * @param  array $plugin_data
	 * @param  object $r
	 * @return void
	 */
	public function need_license_message ( $plugin_data, $r ) {

		if ( empty( $r->package ) ) {
			echo wp_kses_post( '<div class="ignition-updater-plugin-upgrade-notice">' . __( 'To enable this update please activate your IgniteWoo license by visiting the Dashboard > IgniteWoo Licenses screen.', 'ignition-updater' ) . '</div>' );
		} else if ( !empty( $r->upgrade_notice ) ) { 
			?>
			<div class="ignition-updater-plugin-upgrade-notice"><?php echo $r->upgrade_notice ?></div>
			<?php
		}
	} // End need_license_message()

	/**
	 * Change the update information for unlicense Ignition products
	 * @param  object $transient The update-plugins transient
	 * @return object
	 */
	public function change_update_information ( $transient ) {
		
		//If we are on the update core page, change the update message for unlicensed products
		global $pagenow;
		
		if ( ( 'update-core.php' == $pagenow ) && $transient && isset( $transient->response ) && ! isset( $_GET['action'] ) ) {

			global $ignitewoo_queued_updates;

			if ( empty( $ignitewoo_queued_updates ) ) 
				return $transient;

			$notice_text = __( 'To enable this update please activate your IgniteWoo license by visiting the Dashboard > IgniteWoo Licenses screen.' , 'ignition-updater' );

			foreach ( $ignitewoo_queued_updates as $key => $value ) {
				if ( isset( $transient->response[ $value->file ] ) && isset( $transient->response[ $value->file ]->package ) && '' == $transient->response[ $value->file ]->package && ( FALSE === stristr($transient->response[ $value->file ]->upgrade_notice, $notice_text ) ) ) {
					$message = '<div class="ignition-updater-plugin-upgrade-notice">' . $notice_text . '</div>';
					$transient->response[ $value->file ]->upgrade_notice = wp_kses_post( $message );
				}
			}
		}

		return $transient;
	} // End change_update_information()

} // End Class
?>