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

class SocketBrokerService implements IService
{
    /* @var SocketWrapper $socket */
    private $socket;

    public function __construct(IEndpoint $endpoint = null)
    {
        // TODO: consider starting the broker automatically, or output errors etc

        if (!$endpoint) {
            $endpoint = new SocketEndpoint();
        }

        $context = new \ZMQContext();

        $dns = "tcp://{$endpoint->getHost()}:{$endpoint->getPort()}";
//
        $requester = new \ZMQSocket($context, \ZMQ::SOCKET_REQ);
//        $socket = $context->getSocket(\ZMQ::SOCKET_PUSH);

        // see http://php.net/manual/en/class.zmq.php#zmq.constants
        $requester->setSockOpt(\ZMQ::SOCKOPT_RCVTIMEO, 2000);
        $requester->setSockOpt(\ZMQ::SOCKOPT_SNDTIMEO, 2000);
        $requester->setSockOpt(\ZMQ::SOCKOPT_RECONNECT_IVL_MAX, 2);

        $requester->setSockOpt(\ZMQ::SOCKOPT_LINGER, 0);

        $requester->connect($dns);


        $this->socket = $requester;


    }

    public function onError(callable $fn = null)
    {
        $this->socket->on('error', $fn);
    }

    public function push(IRealtimeChannel $channel, Event $event)
    {

//        $resolver = function (callable $resolve, callable $reject) use ($channel, $event) {
//        $resolve(true);
//    };
//        $promise = new \React\Promise\Promise($resolver, $canceller);

        $data = $event->getJsonData();
        $data["room"] = $channel->getRealtimeSignature(true)[1];

        $this->socket->send(json_encode($data));
        $result = $this->socket->recv();

        return (bool)$result;

    }

}