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

abstract class Event implements IEvent
{
    protected $createdAt;

    protected $data;

    public function __construct()
    {
        $this->createdAt = Carbon::now()->timestamp;
    }

    public function __toString()
    {
        return \Zend_Json::encode($this->getJsonData());
    }

}