<?php

namespace RSFREndpoint\Admin;

if (!defined('ABSPATH')) {
    die;
}

class RSFREndpointSettings
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'addRSFREndpointAdminMenu'], 9);
        add_action('wp_head', [$this, 'getAndStoreAllEnqueuedStyles'], 99);
    }

    public function addRSFREndpointAdminMenu()
    {
        add_menu_page('RSFR Endpoint',
            'RSFR Endpoint',
            'administrator', 'rsfr-endpoint',
            array($this, 'displayRSFRAdminDashboard'),
            'dashicons-chart-area',
            99);
    }

    public function displayRSFRAdminDashboard()
    {
        require_once RSFR_ENDPOINT_DIR . '/views/admin/rsfr-endpoint-settings-page.php';
    }

// TODO move to helper, this class load to admin only
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
}