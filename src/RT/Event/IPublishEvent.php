<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 16:15
 */

namespace RT\Event;

use Carbon\Carbon;
use RT\Util\Jsonify;

interface IPublishEvent
{

    public function getJsonData();

}