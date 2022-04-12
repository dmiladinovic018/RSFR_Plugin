<?php

namespace BetterCollective\WpPlugins\BoilerPlate\Services;

use Puc_v4_Factory;

/**
 * Class UpdateChecker
 */
class UpdateChecker
{
    /**
     * UpdateChecker constructor.
     */
    public function __construct()
    {
        Puc_v4_Factory::buildUpdateChecker(
            getenv('PLUGIN_JSON_URL'),
            BC_PLUGIN_BOILER_PLATE_DIR . "/plugin-boiler-plate.php",
            BC_PLUGIN_BOILER_PLATE_SLUG
        );
    }
}
