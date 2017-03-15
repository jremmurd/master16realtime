<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 17:29
 */

namespace RT\Service\Endpoint;

class HttpEndpoint implements IEndpoint
{

    protected $host;
    protected $port;

    function __construct($host = "127.0.0.1", $port = "1337")
    {
        $this->host = $host;
        $this->port = $port;
    }

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