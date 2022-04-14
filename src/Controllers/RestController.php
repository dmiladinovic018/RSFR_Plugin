<?php

namespace RSFREndpoint\Controllers;
if (!defined('ABSPATH')) exit; // Exit if accessed directly

use RSFREndpoint\Traits\SingletonTrait;
use WP_Query;

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

            register_rest_route($this->routeNameSpace, '/routes', array(
                'methods' => 'GET',
                'callback' => array($this, 'RSFRGetRoutes'),
                'permission_callback' => '__return_true',
            ));
        });
    }

    public function getCSS()
    {

        $response = json_encode(get_transient('rsfr_endpoint_enqueued_styles'));
        return new \WP_REST_Response(array('css' => $response), 200);
    }

    public function getJS()
    {

        $response = json_encode(get_transient('rsfr_endpoint_enqueued_scripts'));
        return new \WP_REST_Response(array('js' => $response), 200);
    }

    public function RSFRGetRoutes()
    {
        $filePath = wp_upload_dir()['basedir'] . '/rsfrRoutes.json';
        if (file_exists($filePath) && (time() - json_decode(file_get_contents($filePath))->createdAt) < 6*60*60) {
            return file_get_contents($filePath);
        }

        $contents = [
            'routes' => []
        ];

        $query = new WP_Query([
        'post_type' => 'any',
        'posts_per_page' => -1
        ]);

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $contents['routes'][] = [
                    'route' => wp_make_link_relative(get_permalink()),
                    'id' => get_the_ID(),
                    'type' => get_post_type()
                ];
            }
        }

    	$contents['createdAt'] = time();
    	$contents = json_encode($contents);

        $rsfrRoutes = fopen($filePath, 'w');
        fwrite($rsfrRoutes, $contents);
        fclose($rsfrRoutes);

        return $contents;
    }
}
