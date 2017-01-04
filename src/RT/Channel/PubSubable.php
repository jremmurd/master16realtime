<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 17:37
 */
namespace RT\Channel;

use RT\Event\Event;

interface PubSubable
{

    public function subscribe();

    public function publish(Event $event);

}