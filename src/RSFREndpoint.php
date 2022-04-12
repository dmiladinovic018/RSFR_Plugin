<?php

namespace RSFREndpoint;

if (!defined('ABSPATH')) {
    die;
}

use RSFREndpoint\Traits\SingletonTrait;
use RSFREndpoint\Controllers\RestController;
use RSFREndpoint\Admin\RSFREndpointSettings;

class RSFREndpoint
{
    use SingletonTrait;

    public function __construct()
    {
        $this->setLoaders();
        $this->loadAdminSettings();
    }

    public function setLoaders()
    {
        RestController::getInstance();
    }

    public function loadAdminSettings(){
        // TODO uncomment when set transient f-on moved to helper class
//        if(is_admin()){
            new RSFREndpointSettings();
//        }
    }

}
