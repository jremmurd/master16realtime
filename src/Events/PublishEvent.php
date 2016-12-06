<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 16:15
 */

namespace RT\Event;

use Carbon\Carbon;

abstract class PublishEvent extends Event
{

    private $publishedAt;

    protected $verb = "unknown";

    public function setPublished()
    {
        $this->publishedAt = Carbon::now();
    }

}