<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 13:36
 */

namespace RT;

use RT\Service\IProvider;
use RT\Service\IService;
use RT\Service\PushService;
use RT\Service\ServiceProvider;

class ServiceFactory
{

    private static $instance;

    /* @var $pushService IService */
    protected $pushService;


    private function __construct()
    {
    }

    /**
     * @return ServiceFactory
     */
    public static function instance()
    {
        if (!self::$instance) {
            new self();
        }
        return self::$instance;
    }

    public function getPushService(\RT\Service\Provider\IProvider $server = null)
    {
        if(!$this->pushService){
            $this->pushService = new PushService($server);
        }
        return $this->pushService;
    }


}