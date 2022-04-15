<?php

namespace RSFREndpoint;

use RSFREndpoint\Traits\SingletonTrait;
use RSFREndpoint\Controllers\RestController;
use RSFREndpoint\Controllers\TransientsController;
use RSFREndpoint\Controllers\HookController;

/**
 * RSFREndpoint class
 */
class RSFREndpoint
{
    use SingletonTrait;

    /**
     * RSFREndpoint constructor
     */
    public function __construct()
    {
        $this->setLoaders();
    }

    /**
     * @return void
     */
    public function setLoaders()
    {
        RestController::getInstance();
        TransientsController::getInstance();
        HookController::getInstance();
    }
}
