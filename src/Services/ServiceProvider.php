<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 17:29
 */

namespace RT\Service;

abstract class ServiceProvider implements IProvider
{

    public function __construct()
    {
        $this->onInit();
    }

    abstract function onInit();

    protected $host = "127.0.0.1";
    protected $port = "5555";

}