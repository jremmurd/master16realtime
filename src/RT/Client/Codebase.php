<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 02.01.2017
 * Time: 11:50
 */

namespace RT\Client;


class Codebase implements Generatable
{
    /**
     * @var $generatables Generatable[]
     */
    private $generatables = [];

    public function add(Generatable $gen)
    {
        $this->generatables[] = $gen;
    }

    public function generate()
    {
        $output = "";

        foreach ($this->generatables as $generatable) {
            $output .= $generatable->generate();
        }

        return $output;
    }

    public function __toString()
    {
        return $this->generate();
    }

}