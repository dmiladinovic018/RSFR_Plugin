<?php

namespace RSFREndpoint\Controllers;

use RSFREndpoint\Config\Config;
use RSFREndpoint\Traits\SingletonTrait;

/**
 * TransientsController class
 */
class TransientsController
{
    use SingletonTrait;

    /**
     * TransientsController constructor
     */
    private function __construct()
    {
        add_action('wp_head', [$this, 'getAndStoreAllEnqueuedStyles'], 99);
        add_action('wp_head', [$this, 'getAndStoreAllEnqueuedScripts'], 99);
        add_action('wp_head', [$this, 'getAndStoreMenu'], 99);
        add_action('after_switch_theme ', [$this, 'deleteRSFRTransients']);
        add_action('update_option_active_plugins', [$this, 'deleteRSFRTransients']);
    }

    /**
     * @return void
     */
    public function getAndStoreAllEnqueuedStyles()
    {
        if (empty(get_transient(Config::RSFR_TRANSIENT_STYLES))) {
            global $wp_styles;
            $keys = $wp_styles->queue;
            $values = [];
            foreach ($keys as $key) {
                array_push($values, $wp_styles->registered[$key]->src);
            }
            $registeredStyles = array_combine($keys, $values);
            set_transient(Config::RSFR_TRANSIENT_STYLES, $registeredStyles, Config::RSFR_TRANSIENT_DEFAULT_EXPIRE);
        }
    }

    /**
     * @return void
     */
    public function getAndStoreAllEnqueuedScripts()
    {
        if (empty(get_transient(Config::RSFR_TRANSIENT_SCRIPTS))) {
            global $wp_scripts;
            $keys = $wp_scripts->queue;
            $values = [];
            foreach ($keys as $key) {
                array_push($values, $wp_scripts->registered[$key]->src);
            }
            $registeredScripts = array_combine($keys, $values);
            set_transient(Config::RSFR_TRANSIENT_SCRIPTS, $registeredScripts, Config::RSFR_TRANSIENT_DEFAULT_EXPIRE);
        }
    }

    /**
     * @return void
     */
    public function getAndStoreMenu()
    {
        if (empty(get_transient(Config::RSFR_TRANSIENT_MENU))) {
            ob_start();
            wp_nav_menu();
            $primaryMenu = ob_get_contents();
            ob_end_clean();
            set_transient(Config::RSFR_TRANSIENT_MENU, $primaryMenu, Config::RSFR_TRANSIENT_DEFAULT_EXPIRE);
        }
    }

    /**
     * @return void
     */
    public function deleteRSFRTransients()
    {
        delete_transient(Config::RSFR_TRANSIENT_STYLES);
        delete_transient(Config::RSFR_TRANSIENT_SCRIPTS);
        delete_transient(Config::RSFR_TRANSIENT_MENU);
    }
}
