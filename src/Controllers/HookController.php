<?php

namespace RSFREndpoint\Controllers;
if (!defined('ABSPATH')) exit; // Exit if accessed directly

use RSFREndpoint\Traits\SingletonTrait;

class HookController
{
    use SingletonTrait;

    private function __construct()
    {
        add_action('transition_post_status', [$this, 'addRouteOnPublish'], 10, 3);
    }

    public function addRouteOnPublish($newStatus, $oldStatus, $post)
    {
        $filePath = wp_upload_dir()['basedir'] . '/rsfrRoutes.json';
        if($oldStatus != 'publish' && $newStatus === 'publish' && file_exists($filePath)) {
            $contents = json_decode(file_get_contents($filePath));
            $contents->routes[] = [
                'route' => wp_make_link_relative(get_permalink($post->ID)),
                'id' => $post->ID,
                'type' => get_post_type($post->ID)
            ];
            $contents = json_encode($contents);
    
            $rsfrRoutes = fopen($filePath, 'w');
            fwrite($rsfrRoutes, $contents);
            fclose($rsfrRoutes);
        }
    }
}
