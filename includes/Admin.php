<?php
namespace AMPV\Includes;

class Admin {

	/**
	 * Construct Function
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'admin_menu' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'register_scripts_styles' ] );
	}

	public function register_scripts_styles() {
		$this->load_scripts();
		$this->load_styles();
	}

	/**
	 * Load Scripts
	 *
	 * @return void
	 */
	public function load_scripts() {
		wp_register_script( 'ampv-admin', AMPV_PLUGIN_URL . 'assets/build/js/admin.js', [], wp_rand(), true );
		wp_enqueue_script( 'ampv-admin' );

		wp_localize_script( 'ampv-admin', 'ampvAdminLocalizer', [
			'adminUrl'   => admin_url( '/' ),
			'ajaxUrl'    => admin_url( 'admin-ajax.php' ),
			'apiUrl'     => home_url( '/wp-json' ),
			'adminEmail' => get_bloginfo( 'admin_email' ),
			'nonce'      => wp_create_nonce( 'wp_rest' ),
		] );
	}

	public function load_styles() {
		wp_register_style( 'ampv-admin', AMPV_PLUGIN_URL . 'assets/build/css/admin.css' );

		wp_enqueue_style( 'ampv-admin' );
	}

	/**
	 * Register Menu Page
	 * @since 1.0.0
	 */
	public function admin_menu() {
		global $submenu;

		$capability = 'manage_options';
		$slug       = 'am-page-view';

		$hook = add_menu_page(
			__( 'AM Page View', 'am-page-view' ),
			__( 'AM Page View', 'am-page-view' ),
			$capability,
			$slug,
			[ $this, 'menu_page_template' ],
			'dashicons-buddicons-replies'
		);

		if( current_user_can( $capability )  ) {
			$submenu[ $slug ][] = [ __( 'Dashboard', 'am-page-view' ), $capability, 'admin.php?page=' . $slug . '#/' ];
		}
	}

	/**
	 * Init Hooks for Admin Pages
	 * @since 1.0.0
	 */
	public function init_hooks() {
		add_action( 'admin_enqueu_scripts', [ $this, 'enqueue_scripts' ] );
	}

	/**
	 * Load Necessary Scripts & Styles
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_style( 'ampv-admin' );
		wp_enqueue_script( 'ampv-admin' );
	}

	/**
	 * Render Admin Page
	 * @since 1.0.0
	 */
	public function menu_page_template() {
		printf(
			'<noscript>Please enable JavaScript from you browser settings.</noscript>
			<div class="wrap"><div id="ampv-admin-app"></div></div>'
		);
	}

}