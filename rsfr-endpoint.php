<?php

/**
 * Plugin Name: RSFR Endpoint
 * Description: RSFR Endpoint for Headless CMS Endpoint.
 * Version:     1.0.0
 * Author:      Better Collective RSFR
 * Text Domain: rsfr-endpoint
 * Domain Path: /languages
 *
 */

use RSFREndpoint\RSFREndpoint;
use RSFREndpoint\Services\UpdateChecker;

if (! defined('ABSPATH')) {
    die;
}

require 'vendor/autoload.php';

define('RSFR_ENDPOINT_VERSION', '1.0.0');

define('RSFR_ENDPOINT_DIR', __DIR__);
define('RSFR_ENDPOINT_URL', \plugin_dir_url(__FILE__));
define('RSFR_ENDPOINT_FILE', __FILE__);

try {
    $dotenv = new \Dotenv\Dotenv(__DIR__);
    $dotenv->load();
    define('RSFR_ENDPOINT_IS_DEV_ENV', getenv('ENV') === 'develop');
    new UpdateChecker();
    RSFREndpoint::getInstance();
} catch (\Exception $exception) {
    $message = $exception->getMessage();
    \add_action('admin_notices', function () use ($message) {
        echo $message;
    });
}
