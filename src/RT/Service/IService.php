<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 09.12.2016
 * Time: 14:09
 */

namespace RT\Service;


use Realtime\Channel\IChannel;
use RT\Event\Event;

interface IService
{
    public function onError(callable $fn = null);
    public function push(IChannel $channel, Event $event);
}