<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 06.12.2016
 * Time: 17:26
 */

namespace RT\Service\Provider;


interface IProvider
{

    public function getPort():string;
    public function getHost():string;

}