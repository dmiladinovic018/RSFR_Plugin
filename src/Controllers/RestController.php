<?php

namespace RSFREndpoint\Controllers;
if (!defined('ABSPATH')) exit; // Exit if accessed directly

use RSFREndpoint\Traits\SingletonTrait;

class RestController
{
    use SingletonTrait;

    public $routeNameSpace;

    private function __construct()
    {
        $this->routeNameSpace = 'rsfr-rendpoint/v1';
        $this->registerRoutes();
    }

    private function registerRoutes()
    {
        add_action('rest_api_init', function () {

            register_rest_route($this->routeNameSpace, '/css', array(
                'methods' => 'GET',
                'callback' => array($this, 'getCSS'),
                'permission_callback' => '__return_true',
            ));

            register_rest_route($this->routeNameSpace, '/js', array(
                'methods' => 'GET',
                'callback' => array($this, 'getJS'),
                'permission_callback' => '__return_true',
            ));
        });
    }

    public function getCSS()
    {

        $response = 'dummy text css';
        return new \WP_REST_Response(array('css' => $response), 200);
    }

    public function getJS()
    {

        $response = 'dummy text js';
        return new \WP_REST_Response(array('js' => $response), 200);
    }

}