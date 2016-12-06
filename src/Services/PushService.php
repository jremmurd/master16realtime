<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 13:20
 */

namespace RT\Service;

use React\ZMQ\SocketWrapper;
use RT\Event\Event;
use RT\ServiceFactory;

class PushService
{
    /* @var SocketWrapper $socket */
    private $socket;

    public function __construct(IProvider $server)
    {

        /* @var $context \React\ZMQ\Context */
        $context = new \React\ZMQ\Context(ServiceFactory::instance()->getLoop());

        $this->socket = $context->getSocket(\ZMQ::SOCKET_PUSH);

        $this->socket->bind("tcp://{$server->getHost()}:{$server->getPort()}");
    }

    public function onError(callable $fn)
    {
        $this->socket->on('error', $fn);
    }

    public function push(Event $event)
    {
        $this->socket->send($event);
    }

}