<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 17:29
 */

namespace RT\Service\Provider;

class DefaultHttpProvider implements IProvider
{

    protected $host = "127.0.0.1";
    protected $port = "1337";

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getPort(): string
    {
        return $this->port;
    }

}