<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 30.12.2016
 * Time: 18:04
 */

namespace RT\Channel\Model;


interface Subable
{
    public function beforeSubscribe();
    public function subscribe();
}