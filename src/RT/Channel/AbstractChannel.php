<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 09.12.2016
 * Time: 16:36
 */

namespace RT\Channel;


use RT\Channel\Traits\PubSub;
use RT\Channel\Traits\Signature;
use RT\Service\IService;

abstract class AbstractChannel implements PubSubable, IRealtimeChannel
{
    protected $service;
    protected $room;
    protected $identifier;

    use PubSub;
    use Signature;

    public function __construct(IService $service, string $identifier, string $room)
    {
        $this->room = $room;
        $this->identifier = $identifier;
        $this->service = $service;
    }

    public function getRealtimeService()
    {
        return $this->service;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getRoom()
    {
        return $this->room;
    }
}