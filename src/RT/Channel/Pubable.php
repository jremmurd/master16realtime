<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 30.12.2016
 * Time: 18:04
 */

namespace RT\Channel;

use RT\Event\Event;

interface Pubable
{
    public function publish(Event $e);

}