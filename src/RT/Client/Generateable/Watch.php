<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 02.01.2017
 * Time: 13:28
 */
namespace RT\Client\Genratable;
use RT\ServiceLocator;

class Watch implements \RT\Client\Generatable
{

    protected $room;
    protected $condition;
    protected $cb;

    public function __construct($room, $condition, $cb = "console.log(res);")
    {
        $this->room = $room;
        $this->condition = $condition;
        $this->cb = $cb;
    }

    public function generate()
    {
        $condition = base64_decode($this->condition);
        $room = $this->room;
        $socketName = ServiceLocator::instance()->getCodebase()->getSocketName();

        return <<<JS
        
    {$socketName}.get("/$room/watch/$condition", function (res) {
        $this->cb
    });

JS;
    }


}