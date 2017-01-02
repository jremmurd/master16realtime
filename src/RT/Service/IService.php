<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 09.12.2016
 * Time: 14:09
 */

namespace RT\Service;


use RT\Channel\IRealtimeChannel;
use RT\Event\Event;

interface IService
{
    public function push(IRealtimeChannel $channel, Event $event);
}