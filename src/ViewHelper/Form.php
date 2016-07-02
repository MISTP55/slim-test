<?php
/**
 * Created by PhpStorm.
 * User: goeld
 * Date: 02/07/16
 * Time: 14:59
 */

namespace ViewHelper;


class Form{
    const ALLOWED_METHODS = array('GET', 'POST', 'PUT', 'PATCH', 'DELETE');

    private $method;
    private $inputs;

    public function __construct($method = 'GET'){
        if(!in_array(strtoupper($method), $this::ALLOWED_METHODS)){
            throw new \Exception("Invalid method $method supplied. Must be one of ".implode(', ', $this::ALLOWED_METHODS).'.');
        }

        $this->method = $method;
    }
}