<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 13:20
 */

namespace RT\Service;

use Realtime\Channel\PubSubable;
use RT\Event\Event;
use RT\Service\Provider\DefaultServiceProvider;
use RT\Service\Provider\IProvider;

class HttpPushService implements IService
{
    private $server;
    private $errorCb;

    public function __construct(IProvider $server = null)
    {
        if (!$server) {
            $server = new DefaultServiceProvider();
        }
        $this->server = $server;

    }

    public function onError(callable $fn = null)
    {
        $this->errorCb = $fn;
    }

    public function error()
    {
        call_user_func($this->errorCb);
    }

    public function push(PubSubable $channel, Event $event)
    {

        $url = $this->server->getHost() . ":" . $this->server->getPort() . "/" . $channel->getSignature();

        // use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
//                'content' => http_build_query($data)
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        if (!$result) {
            $this->error();
        }

        return $result;
    }
}