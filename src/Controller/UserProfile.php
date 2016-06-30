<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 29-06-2016
 * Time: 19:54
 */

namespace Controller;

class UserProfile extends BaseController{
    public function __construct(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, \Slim\App $app, $args){
        parent::__construct($request, $response, $app, $args);
    }
    
    public function index(){
        return $this->response->write("Bonjour {$this->args['username']} !");
    }
}