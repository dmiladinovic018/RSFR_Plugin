<?php

namespace RSFREndpoint;

use RSFREndpoint\Traits\SingletonTrait;
use RSFREndpoint\Controllers\RestController;

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
    }

}
