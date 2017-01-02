<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 31.12.2016
 * Time: 14:55
 */

namespace RT\Event\Pub;

use RT\Event\PublishEvent;
use RT\Util\Jsonify;

class Update extends PublishEvent {

    use Jsonify;

    public function __construct($data)
    {
        parent::__construct("updated");

        $this->data = $data;
    }

}