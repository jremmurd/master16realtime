<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 13:20
 */

namespace RT\Service;

use React\ZMQ\SocketWrapper;
use RT\Channel\IRealtimeChannel;
use RT\Event\Event;
use RT\Service\Endpoint\SocketEndpoint;
use RT\Service\Endpoint\IEndpoint;

class SocketService implements IService
{
    /* @var SocketWrapper $socket */
    private $socket;

    public function __construct(IEndpoint $endpoint = null)
    {
        if (!$endpoint) {
            $endpoint = new SocketEndpoint();
        }

        $context = new \ZMQContext(50, 1);
        $this->socket = $context->getSocket(\ZMQ::SOCKET_PUSH);

        $this->socket->bind("tcp://{$endpoint->getHost()}:{$endpoint->getPort()}");

    }

    public function onError(callable $fn = null)
    {
        $this->socket->on('error', $fn);
    }

    public function push(IRealtimeChannel $channel, Event $event)
    {

        $resolver = function (callable $resolve, callable $reject) use ($channel, $event) {
            $data = $event->getJsonData();
            $data["rooms"] = $channel->getRealtimeSignature();
            $this->socket->send(json_encode($data));
            $resolve(true);
        };

        $canceller = function (callable $resolve, callable $reject) {
            $this->socket->close();
            $reject(new \Exception('Promise cancelled'));
        };

        $promise = new \React\Promise\Promise($resolver, $canceller);

        $promise->done(function () {
            var_dump("push done");
        });

    }

}