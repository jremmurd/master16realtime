<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 09.12.2016
 * Time: 12:47
 */

namespace RT\Channel\Traits;

trait Pub
{

    public function publish(\RT\Event\Event $event)
    {
        if (method_exists($this, "beforePublish") && !$this->beforePublish()) {
            return false;
        }

        if (!method_exists($this, "getRealtimeService")) {
            throw new \Exception("Required method getRealtimeService missing. PubSub Trait has to be used in RealtimeChannel context. ");
        }
        return $this->getRealtimeService()->push($this, $event);
    }

}