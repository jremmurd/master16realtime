<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 13:36
 */

namespace RT;

use RT\Client\Codebase;
use RT\Service\HttpService;
use RT\Service\Endpoint\IEndpoint;
use RT\Service\IService;
use RT\Service\SocketBrokerService;
use RT\Service\SocketService;

class ServiceLocator
{

    private static $instance;

    /* @var $services IService[] */
    protected $services;

    /**
     * @var $endpoints Service\Endpoint\IEndpoint[]
     */
    protected $endpoints;

    /**
     * @var $codebase Codebase
     */
    protected $codebase;

    protected static $codebaseConfig = [
        "endpoint" => "http://localhost",
        "socketName" => "pimcoreSocket"
    ];

    private function __construct()
    {
        $this->codebase = new Codebase(self::$codebaseConfig);
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

    public function setEndpoint(string $serviceType, IEndpoint $endpoint)
    {
        if (class_exists($serviceType)) {
            $this->endpoints[$serviceType] = $endpoint;
        }
    }

    public function getCodebase()
    {
        return $this->codebase;
    }

    public static function setCodebaseConfig(array $config)
    {
        self::$codebaseConfig = $config;
    }

    protected function getService(string $serviceType)
    {
        $class = new \ReflectionClass($serviceType);
        if (class_exists($serviceType) && $class->implementsInterface(IService::class)) {
            if (!$this->services[$serviceType]) {
                $this->services[$serviceType] = new $serviceType($this->endpoints[$serviceType]);
            }

            return $this->services[$serviceType];

        }
    }

    public function getSocketBrokerService()
    {
        return $this->getService(SocketBrokerService::class);
    }

    public function getHttpService()
    {
        return $this->getService(HttpService::class);
    }

    public function getSocketService()
    {
        return $this->getService(SocketService::class);
    }


}