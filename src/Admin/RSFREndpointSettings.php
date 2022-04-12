<?php

namespace RSFREndpoint\Admin;

if (!defined('ABSPATH')) {
    die;
}

class RSFREndpointSettings
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'addRSFREndpointAdminMenu'), 9);
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

    public function displayRSFRAdminDashboard() {
        require_once RSFR_ENDPOINT_DIR . '/views/admin/rsfr-endpoint-settings-page.php';
    }
}