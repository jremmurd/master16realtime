<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 02.01.2017
 * Time: 13:28
 */
namespace RT\Client\Generatable;

use RT\ServiceLocator;

class Subscription implements \RT\Client\Generatable
{

    protected $room;
    protected $ids;
    protected $cb;

    public function __construct($room, $ids)
    {
        $this->room = $room;
        $this->ids = $ids;
    }

    public function generate()
    {
        $ids = $this->ids;
        $room = $this->room;

        $socketName = ServiceLocator::instance()->getCodebase()->getSocketName();

        return <<<JS
reconnectUrls.push("/$room/sub/$ids");

JS;
    }


}