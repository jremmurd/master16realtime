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
use RT\Service\Endpoint\DefaultHttpEndpoint;
use RT\Service\Endpoint\IEndpoint;
use RT\Service\Provider\DefaultHttpProvider;
use RT\Service\Provider\IProvider;

class HttpService implements IService
{
    private $endpoint;
    private $errorCb;

    public function __construct(IEndpoint $endpoint = null)
    {
        if (!$endpoint) {
            $endpoint = new DefaultHttpEndpoint();
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


        try {
            // todo catch 404

            if($this->get_http_response_code($url) != "200"){
                throw new \Exception("Error occured in request {$url}.");
            }else{
                $result = file_get_contents($url);
            }

            Simple::log("_rt", "{$event->getVerb()} to {$channel->getRealtimeSignature()}");
        } catch (\Exception $e) {
            Simple::log("_rt", $e->getMessage());
        }

        if (!$result) {
            $this->error();
        }

        return $result;
    }

   private function get_http_response_code($url) {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }

}