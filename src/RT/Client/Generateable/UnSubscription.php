<?php

/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 02.01.2017
 * Time: 13:28
 */
namespace RT\Client\Generatable;

use RT\ServiceLocator;

class UnSubscription implements \RT\Client\Generatable
{

    protected $room;
    protected $ids;
    protected $cb;

    public function __construct($room, $ids, $cb = "console.log(res);")
    {
        $this->room = $room;
        $this->ids = $ids;
        $this->cb = $cb;
    }

    public function generate()
    {
        $ids = $this->ids;
        $room = $this->room;

        $socketName = ServiceLocator::instance()->getCodebase()->getSocketName();

        return <<<JS

var url = "/$room/unsub/$ids";
        
{$socketName}.get(url, function (res) {
    $this->cb
});

var index = $.inArray(item, reconnectUrls);
if (index != -1) {
    reconnectUrls.splice(index, 1);
}

JS;
    }


}