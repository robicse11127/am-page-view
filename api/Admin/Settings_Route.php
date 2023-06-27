<?php
namespace AMPV\Api\Admin;

use WP_REST_Controller;

class Settings_Route extends WP_REST_Controller  {

    protected $namespace;
    protected $rest_base;

    public function __construct() {
        $this->namespace = 'ampv/v1';
        $this->rest_base = 'settings';
    }

    /**
     * Register Routes
     */
    public function register_routes() {
        register_rest_route(
            $this->namespace,
            '/' . $this->rest_base,
            [
                [
                    'methods'             => \WP_REST_Server::READABLE,
                    'callback'            => [ $this, 'get_items' ],
                    'permission_callback' => [ $this, 'get_items_permission_check' ],
                    'args'                => $this->get_collection_params()
                ],
                [
                    'methods'             => \WP_REST_Server::CREATABLE,
                    'callback'            => [ $this, 'create_items' ],
                    'permission_callback' => [ $this, 'create_items_permission_check' ],
                    'args'                => $this->get_endpoint_args_for_item_schema(true )
                ]
            ]
        );
    }

    /**
     * Get items response
     */
    public function get_items( $request ) {
        $response = [
            'countRows'     => get_option( 'ampv_settings_countRows', 5 ),
            'humanReadable' => get_option( 'ampv_settings_humanReadable', true ),
            'email'          => get_option( 'ampv_settings_email', [] ),
        ];

        return rest_ensure_response( $response );
    }

    /**
     * Get items permission check
     */
    public function get_items_permission_check( $request ) {
        if ( current_user_can( 'manage_options' ) ) {
            return true;
        }
        return false;
    }

    /**
     * Create item response
     */
    public function create_items( $request ) {

        // Data validation
        $countRows     = isset( $request['countRows'] ) ? intval( $request['countRows'] ) : 5;
        $humanReadable = isset( $request['humanReadable'] ) ? boolval( $request['humanReadable'] ) : true ;
        $email          = isset( $request['email'] ) && is_array( $request['email'] ) ? ( $request['email'] ) : [];

        // Save option data into WordPress
        update_option( 'ampv_settings_countRows', $countRows );
        update_option( 'ampv_settings_humanReadable', $humanReadable );
        update_option( 'ampv_settings_email', $email );

        $response = [
            'countRows'     => $countRows,
            'humanReadable' => $humanReadable,
            'email'          => $email
        ];

        return rest_ensure_response( $response );
        
    }

    /**
     * Create item permission check
     */
    public function create_items_permission_check( $request ) {
        if ( current_user_can( 'manage_options' ) ) {
            return true;
        }
        return false;
    }

}