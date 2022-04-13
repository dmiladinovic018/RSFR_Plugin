<?php

namespace RSFREndpoint;

if (!defined('ABSPATH')) {
    die;
}

use RSFREndpoint\Traits\SingletonTrait;
use RSFREndpoint\Controllers\RestController;
use RSFREndpoint\Controllers\TransientsController;

class RSFREndpoint
{
    use SingletonTrait;

    public function __construct()
    {
        $this->setLoaders();
    }

    public function setLoaders()
    {
        RestController::getInstance();
        TransientsController::getInstance();
    }
}
