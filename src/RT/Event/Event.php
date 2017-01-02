<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 15:51
 */

namespace RT\Event;


use Carbon\Carbon;
use Realtime\Channel\PubSubable;
use RT\Util\Jsonify;

abstract class Event
{
    protected $id;
    protected $createdAt;

    protected $data;

    use Jsonify;

    public function __construct()
    {
        $this->id = uniqid("rt-");
        $this->createdAt = Carbon::now()->timestamp;
    }


    public function __toString()
    {
        return \Zend_Json::encode($this->getJsonData());
    }

    public function addRoom($room)
    {
        $this->rooms[] = $room;
    }
}