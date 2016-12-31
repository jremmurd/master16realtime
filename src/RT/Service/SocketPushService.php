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
use RT\Service\Provider\DefaultServiceProvider;
use RT\Service\Provider\IProvider;

class SocketPushService implements IService
{
    /* @var SocketWrapper $socket */
    private $socket;

    public function __construct(IProvider $server = null)
    {
        if (!$server) {
            $server = new DefaultServiceProvider();
        }

        $context = new \ZMQContext(50, 1);
        $this->socket = $context->getSocket(\ZMQ::SOCKET_PUSH);

        $this->socket->bind("tcp://{$server->getHost()}:{$server->getPort()}");

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