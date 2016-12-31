<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 09.12.2016
 * Time: 12:47
 */

namespace RT\Channel\Traits;

use Pimcore\API\Plugin\Exception;

trait PubSub
{

    public function publish(\RT\Event\Event $event)
    {
        if (method_exists($this, "beforePublish") && !$this->beforePublish()) {
            return false;
        }

        if (!method_exists($this, "getRealtimeService")) {
            throw new Exception("PubSub Trait has to be used in RealtimeChannel context. ");
        }

        return $this->getRealtimeService()->push($this, $event);
    }

    public function subscribe()
    {
        if (method_exists($this, "beforeSubscribe") && !$this->beforeSubscribe()) {
            return false;
        }

    }

    public function beforePublish()
    {
        return true;
    }

    public function beforeSubscribe()
    {
        return true;
    }

}