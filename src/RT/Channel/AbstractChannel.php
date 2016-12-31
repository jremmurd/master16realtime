<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 09.12.2016
 * Time: 16:36
 */

namespace RT\Channel;


use RT\Channel\Traits\PubSub;
use RT\Service\IService;

abstract class Channel implements PubSubable, IRealtimeChannel
{
    protected $signature;
    protected $realtimeService;

    use PubSub;

    public function __construct(IService $realtimeService, $signature = "")
    {
        $this->signature = $signature;
        $this->realtimeService = $realtimeService;
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