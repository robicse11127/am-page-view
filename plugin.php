<?php
/**
 * @link            https://wp-vue-kickstart.com
 * @since           1.0.0
 * @package         WP_Vue_KickStart
 *
 * Plugin Name: Awesome Motive Page view
 * Plugin URI: https://pluginsurl.com
 * Description: Awesome Motive Page View Plugin.
 * Version: 1.0.0
 * Author: Md. Rabiul Islam Robi
 * Author URI: https://robizstory.me
 * License: GPL v3
 * Text-Domain: am-page-view
 */

if( ! defined( 'ABSPATH' ) ) exit(); // No direct access allowed

/**
 * Require Autoloader
 */
require_once 'vendor/autoload.php';

use AMPV\Api\Api;
use AMPV\Includes\Admin;
use AMPV\Includes\Frontend;

final class Am_Page_View {

	/**
	 * Define Plugin Version
	 */
	const VERSION = '1.0.0';

	/**
	 * Construct Function
	 */
	public function __construct() {
		$this->plugin_constants();
		register_activation_hook( __FILE__, [ $this, 'activate' ] );
		register_deactivation_hook( __FILE__, [ $this, 'deactivate' ] );
		add_action( 'plugins_loaded', [ $this, 'init_plugin' ] );
	}

	/**
	 * Plugin Constants
	 * @since 1.0.0
	 */
	public function plugin_constants() {
		define( 'AMPV_VERSION', self::VERSION );
		define( 'AMPV_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
		define( 'AMPV_PLUGIN_URL', trailingslashit( plugins_url( '', __FILE__ ) ) );
		define( 'AMPV_API_DATA_URL', 'https://miusage.com/v1/challenge/2/static/' );
		define( 'AMPV_NONCE', 'b?le*;K7.T2jk_*(+3&[G[xAc8O~Fv)2T/Zk9N:GKBkn$piN0.N%N~X91VbCn@.4' );
	}

	/**
	 * Singletone Instance
	 * @since 1.0.0
	 */
	public static function init() {
		static $instance = false;

		if( !$instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * On Plugin Activation
	 * @since 1.0.0
	 */
	public function activate() {
		$is_installed    = get_option( 'ampv_is_installed' );

		if( ! $is_installed ) {
			update_option( 'ampv_is_installed', time() );
		}
		update_option( 'ampv_is_installed', AMPV_VERSION );

		// Updated with default settings values.
		$this->update_with_default_settings();
	}

	public function update_with_default_settings() {
		$count_rows      = get_option( 'ampv_settings_countRows' );
		$human_date      = get_option( 'ampv_settings_humanReadable' );
		$settings_emails = get_option( 'ampv_settings_email' );

		if ( ! $count_rows ) {
			update_option( 'ampv_settings_countRows', 5 );
		}

		if ( ! $human_date ) {
			update_option( 'ampv_settings_humanReadable', true );
		}

		if ( ! $settings_emails ) {
			$admin_email = get_bloginfo( 'admin_email' );
			$default_emails = [
				'id'    => 1,
				'value' =>  $admin_email
			];
			update_option( 'ampv_settings_email', [ $default_emails ] );
		}
	}

	/**
	 * On Plugin De-actiavtion
	 * @since 1.0.0
	 */
	public function deactivate() {
		// On plugin deactivation
	}

	/**
	 * Init Plugin
	 * @since 1.0.0
	 */
	public function init_plugin() {
		// init
		new Admin();
		new Api();
	}

}

/**
 * Initialize Main Plugin
 * @since 1.0.0
 */
function am_page_view() {
	return Am_Page_View::init();
}

// Run the Plugin
am_page_view();