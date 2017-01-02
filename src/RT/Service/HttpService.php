<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 13:20
 */

namespace RT\Service;

use Pimcore\Log\Simple;
use RT\Channel\IRealtimeChannel;
use RT\Channel\PubSubable;
use RT\Event\Event;
use RT\Event\PublishEvent;
use RT\Service\Provider\DefaultHttpProvider;
use RT\Service\Provider\IProvider;

class HttpService implements IService
{
    private $server;
    private $errorCb;

    public function __construct(IProvider $server = null)
    {
        if (!$server) {
            $server = new DefaultHttpProvider();
        }
        $this->server = $server;

    }

    public function onError(callable $fn = null)
    {
        $this->errorCb = $fn;
    }

    public function error()
    {
        if ($cb = $this->errorCb) {
            $cb();
        }
    }

    public function push(IRealtimeChannel $channel, Event $event)
    {

        if (!$event instanceof PublishEvent) {
            throw new \Exception("PubSub Channel required.");
        }

        /* @var $channel PublishEvent */

        $url = "http://" . $this->server->getHost() . ":" . $this->server->getPort() .
            "/" . $channel->getRealtimeSignature(true)[0] .
            "/" . $event->getVerb() .
            "/" . $channel->getRealtimeSignature(true)[1] .
            "?changes=" . urlencode($event);

        $result = file_get_contents($url);

        if (!$result) {
            $this->error();
        }

        return $result;
    }
}