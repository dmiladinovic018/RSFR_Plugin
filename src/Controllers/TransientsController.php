<?php

namespace RSFREndpoint\Controllers;

if (!defined('ABSPATH')) {
    die;
}

use RSFREndpoint\Traits\SingletonTrait;

class TransientsController
{
    use SingletonTrait;

    private function __construct()
    {
        add_action('wp_head', [$this, 'getAndStoreAllEnqueuedStyles'], 99);
        add_action('wp_head', [$this, 'getAndStoreAllEnqueuedScripts'], 99);
        add_action('after_switch_theme ', [$this, 'deleteRSFRTransients']);
        add_action('update_option_active_plugins',[$this, 'deleteRSFRTransients']);
    }

    public function getAndStoreAllEnqueuedStyles()
    {
        if (empty(get_transient('rsfr_endpoint_enqueued_styles'))) {
            global $wp_styles;
            $keys = $wp_styles->queue;
            $values = [];
            foreach ($keys as $key) {
                array_push($values, $wp_styles->registered[$key]->src);
            }
            $registeredStyles = array_combine($keys, $values);
            set_transient('rsfr_endpoint_enqueued_styles', $registeredStyles, 6 * HOUR_IN_SECONDS);
        }
    }

    public function getAndStoreAllEnqueuedScripts()
    {
        if (empty(get_transient('rsfr_endpoint_enqueued_scripts'))) {
            global $wp_scripts;
            $keys = $wp_scripts->queue;
            $values = [];
            foreach ($keys as $key) {
                array_push($values, $wp_scripts->registered[$key]->src);
            }
            $registeredScripts = array_combine($keys, $values);
            set_transient('rsfr_endpoint_enqueued_scripts', $registeredScripts, 6 * HOUR_IN_SECONDS);
        }
    }

    public function deleteRSFRTransients()
    {
        delete_transient('rsfr_endpoint_enqueued_styles');
        delete_transient('rsfr_endpoint_enqueued_scripts');
    }
}