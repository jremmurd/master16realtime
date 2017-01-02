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

abstract class PublishEvent extends Event
{
    use Jsonify;

    protected $verb;

    public function __construct($verb = "unknown")
    {
        parent::__construct();

        $this->verb = $verb;
    }


    public function setPublished()
    {
        $this->publishedAt = Carbon::now();
    }

    public function getVerb()
    {
        return $this->verb;
    }


}