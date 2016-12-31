<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 16:16
 */

namespace RT\Event\Pub;

use RT\Event\PublishEvent;

class Message extends PublishEvent {

    public function __construct($data)
    {
        parent::__construct();
        $this->verb = "msg";

        $this->data = $data;
    }

}