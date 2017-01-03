<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 03.01.2017
 * Time: 09:59
 */
namespace RT\Channel\Traits;

use RT\Client\Genratable\Subscription;
use RT\ServiceLocator;

trait Sub
{
    public function subscribe()
    {
        if (method_exists($this, "beforeSubscribe") && !$this->beforeSubscribe()) {
            return false;
        }

        $signature = $this->getRealtimeSignature(true);
        ServiceLocator::instance()->getCodebase()->add(new Subscription($signature[0], $signature[1], "console.log(res);"));

    }


    public function beforeSubscribe()
    {
        return true;
    }
}