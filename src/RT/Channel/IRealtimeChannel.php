<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 30.12.2016
 * Time: 18:39
 */

namespace RT\Channel;


interface IRealtimeChannel
{
    public function getRealtimeService();
    public function getRealtimeSignature($getArray = false);
    public function getRoom();
    public function getIdentifier();

}