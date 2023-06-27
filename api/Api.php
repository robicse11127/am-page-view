<?php
namespace AMPV\Api;
use AMPV\Api\Admin\Settings_Route;
use AMPV\Api\Admin\Graph_Route;

/**
 * Rest API Handler
 */
class Api {

    /**
     * Construct Function
     */
    public function __construct() {
        add_action( 'rest_api_init', [ $this, 'register_routes' ] );
    }

    /**
     * Register API routes
     */
    public function register_routes() {
        ( new Settings_Route() )->register_routes();
        ( new Graph_Route() )->register_routes();
    }

}