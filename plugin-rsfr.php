<?php

/**
 * Plugin Name: BC Plugin Rsfr Plate
 * Description: BC WP Plugin for showing WP content on non WP sites.
 * Version:     1.0.0
 * Author:      BC RSFR Team
 */

use BetterCollective\WpPlugins\RsfrPlate\RsfrPlate;
use BetterCollective\WpPlugins\RsfrPlate\Services\UpdateChecker;

if (! defined('ABSPATH')) {
    die;
}

require 'vendor/autoload.php';

define('BC_RSFR_VERSION', '1.0.0');

define('BC_RSFR_DIR', __DIR__);
define('BC_RSFR_URL', \plugin_dir_url(__FILE__));
define('BC_RSFR_FILE', __FILE__);

try {
    $dotenv = new \Dotenv\Dotenv(__DIR__);
    $dotenv->load();
    define('BC_RSFR_IS_DEV_ENV', getenv('ENV') === 'develop');
    new UpdateChecker();
    RsfrPlate::getInstance();
} catch (\Exception $exception) {
    $message = $exception->getMessage();
    \add_action('admin_notices', function () use ($message) {
        echo $message;
    });
}
