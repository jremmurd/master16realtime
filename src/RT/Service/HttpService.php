<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 13:20
 */

namespace RT\Service;

use RT\Channel\IRealtimeChannel;
use RT\Event\Event;
use RT\Event\PublishEvent;
use RT\Service\Endpoint\HttpEndpoint;
use RT\Service\Endpoint\IEndpoint;

class HttpService implements IService
{
    private $endpoint;
    private $errorCb;

    public function __construct(IEndpoint $endpoint = null)
    {
        if (!$endpoint) {
            $endpoint = new HttpEndpoint();
        }
        $this->endpoint = $endpoint;

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
            throw new \Exception("PubSub Channel required for HTTP Service.");
        }

        /* @var $channel PublishEvent */

        $url = "http://" . $this->endpoint->getHost() . ":" . $this->endpoint->getPort() .
            "/" . $channel->getRoom() .
            "/" . $event->getVerb() .
            "/" . $channel->getIdentifier() .
            "?event=" . urlencode($event);


        $result = @file_get_contents($url);

//        \Pimcore\Log\Simple::log("_rt", "{$event->getVerb()} to {$channel->getRealtimeSignature()}");

//        if ($result) {
//            \Pimcore\Log\Simple::log("_rt", "Error response from {$url}.");
//        }

        if (!$result) {
            $this->error();
        }

        return $result;
    }

}