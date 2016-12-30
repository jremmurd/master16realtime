<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 13:36
 */

namespace RT;

use RT\Service\Provider\IProvider;
use RT\Service\SocketBrokerService;

class ServiceLocator
{

    private static $instance;

    /* @var $services [] IService */
    protected $services;


    private function __construct()
    {
    }

    /**
     * @return ServiceLocator
     */
    public static function instance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function getOrInstantiateService(string $serviceType, IProvider $provider = null)
    {
        if (class_exists($serviceType)) {
            if (!$this->services[$serviceType]) {
                $this->services[$serviceType] = new $serviceType($provider);
            }
            return $this->services[$serviceType];
        }
    }

    public function getSocketBrokerService(\RT\Service\Provider\IProvider $provider = null)
    {
//        return new SocketBrokerService();
        return $this->getOrInstantiateService(SocketBrokerService::class, $provider);
    }


}