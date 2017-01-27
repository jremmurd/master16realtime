<?php
/**
 * Created by PhpStorm.
 * User: Julian Raab
 * Date: 02.01.2017
 * Time: 13:28
 */
namespace RT\Client\Genratable;

class Script implements \RT\Client\Generatable
{

 protected $script;

 public function __construct($script)
 {
     $this->script = $script;
 }

 public function generate()
 {

  return <<<JS
        
   $this->script;

JS;
 }

}