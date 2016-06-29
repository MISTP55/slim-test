<?php

/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 29-06-2016
 * Time: 18:36
 */

namespace Parser;

class RouteParser{
    private $var;

    public function __construct($var = 2){
        $this->var = $var;
    }

    public function getVar(){
        return $this->var;
    }
}