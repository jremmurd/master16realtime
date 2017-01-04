<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 09.12.2016
 * Time: 16:36
 */

namespace RT\Channel;


use RT\Channel\Traits\Pub;
use RT\Channel\Traits\Signature;
use RT\Service\IService;

abstract class AbstractPubChannel implements Pubable, IRealtimeChannel
{
    protected $service;
    protected $room;
    protected $identifier;

    protected $beforePublishFn;
    protected $beforeSubscribeFn;

    use Pub;
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