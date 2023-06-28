<?php
namespace AMPV\Api\Admin;

use WP_REST_Controller;

class Am_Data_Route extends WP_REST_Controller  {

	protected $namespace;
	protected $rest_base;

	public function __construct() {
		$this->namespace = 'ampv/v1';
		$this->rest_base = '/am_data';
	}

	/**
	 * Register Routes
	 *
	 * @return void
	 */
	public function register_routes() {
		register_rest_route(
			$this->namespace,
			$this->rest_base,
			[
				[
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => [ $this, 'get_items' ],
					'permission_callback' => [ $this, 'get_items_permission_check' ],
				],
			]
		);
	}

	/**
	 * Get Requested Data.
	 *
	 * @param array $request
	 * @return array
	 */
	public function get_items( $request ) {
		$data = [];

		$cache_key = 'ampv_data_cache';

		$data = get_transient( $cache_key );

		if ( false === $data ) {
			$response = wp_remote_get( esc_url_raw( AMPV_API_DATA_URL ) );

			if ( is_array( $response ) && ! is_wp_error( $response ) )  {
				$data = json_decode( $response[ 'body' ] );
			};

			set_transient( $cache_key, $data, 3600 );
		}

		return rest_ensure_response( $data );
	}

	/**
	 * Get items permission check.
	 *
	 * @param array $request
	 * @return boolean
	 */
	public function get_items_permission_check( $request ) {
		if ( current_user_can( 'manage_options' ) ) {
			return true;
		}
		return false;
	}

}