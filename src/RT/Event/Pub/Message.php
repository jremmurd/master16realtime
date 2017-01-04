<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 16:16
 */

namespace RT\Event\Pub;

use RT\Event\PublishEvent;
use RT\Util\Jsonify;

class Message extends PublishEvent
{
    use Jsonify;

    public function __construct($data = "")

    {
        parent::__construct("messaged", $data);

    }

}