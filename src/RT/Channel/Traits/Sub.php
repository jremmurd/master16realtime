<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 03.01.2017
 * Time: 09:59
 */
namespace RT\Channel\Traits;

use RT\Client\Genratable\Subscription;
use RT\Client\Placement;
use RT\ServiceLocator;

trait Sub
{
    public function subscribe()
    {
        if (method_exists($this, "beforeSubscribe") && $this->beforeSubscribe() === false) {
            return false;
        }

        $signature = $this->getRealtimeSignature(true);

        if (method_exists($this, "getSubscription")) {
            $sub = $this->getSubscription();
        } else {
            $sub = new Subscription($signature[0], $signature[1]);
        }

        ServiceLocator::instance()->getCodebase()->add($sub, Placement::RE_CONNECT_CALLBACK());

    }

    public function unsubscribe()
    {
        if (method_exists($this, "beforeUnsubscribe") && $this->beforeUnsubscribe() === false) {
            return false;
        }

        $signature = $this->getRealtimeSignature(true);

        if (method_exists($this, "getUnSubscription")) {
            $sub = $this->getUnSubscription();
        } else {
            $sub = new UnSubscription($signature[0], $signature[1]);
        }

        ServiceLocator::instance()->getCodebase()->add($sub);

    }
}