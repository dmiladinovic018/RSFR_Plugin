<?php

namespace RSFREndpoint\Services;

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
            RSFR_ENDPOINT_DIR . "/plugin-boiler-plate.php",
            RSFR_ENDPOINT_SLUG
        );
    }
}
