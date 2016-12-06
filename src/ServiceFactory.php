<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 13:36
 */

namespace RT;

use RT\Service\IProvider;
use RT\Service\PushService;
use RT\Service\ServiceProvider;

class ServiceFactory
{

    private static $instance;

    private $loop;

    private function __construct()
    {
        $this->loop = \React\EventLoop\Factory::create();
        $this->loop->run();
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

    public function createPushService(IProvider $server)
    {
        return new PushService($server);
    }

    /**
     * @return \React\EventLoop\ExtEventLoop|\React\EventLoop\LibEventLoop|\React\EventLoop\LibEvLoop|\React\EventLoop\StreamSelectLoop
     */
    public function getLoop(){
        return $this->loop;
    }



}