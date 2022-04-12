<?php

/**
 * Plugin Name: BC Plugin Boiler Plate
 * Description: BC WP Plugin Starter Kit for Developers.
 * Version:     1.0.0
 * Author:      Better Collective A/S
 */

use BetterCollective\WpPlugins\BoilerPlate\BoilerPlate;
use BetterCollective\WpPlugins\BoilerPlate\Services\UpdateChecker;

if (! defined('ABSPATH')) {
    die;
}

require 'vendor/autoload.php';

define('BC_PLUGIN_BOILER_PLATE_VERSION', '1.0.0');

define('BC_PLUGIN_BOILER_PLATE_DIR', __DIR__);
define('BC_PLUGIN_BOILER_PLATE_URL', \plugin_dir_url(__FILE__));
define('BC_PLUGIN_BOILER_PLATE_FILE', __FILE__);

try {
    $dotenv = new \Dotenv\Dotenv(__DIR__);
    $dotenv->load();
    define('BC_PLUGIN_BOILER_PLATE_IS_DEV_ENV', getenv('ENV') === 'develop');
    new UpdateChecker();
    BoilerPlate::getInstance();
} catch (\Exception $exception) {
    $message = $exception->getMessage();
    \add_action('admin_notices', function () use ($message) {
        echo $message;
    });
}
