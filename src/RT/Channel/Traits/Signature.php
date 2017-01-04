<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 03.01.2017
 * Time: 12:02
 */

namespace RT\Channel\Traits;


trait Signature
{
    public function getRealtimeSignature($getArray = false)
    {
        if ($getArray) {
            return [
                $this->getRoom(),
                $this->getIdentifier()
            ];
        }
        return $this->getRoom() . $this->getIdentifier();
    }
}