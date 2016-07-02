<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 29-06-2016
 * Time: 19:54
 */

namespace Controller;

class Root extends BaseController{
    public function __construct(\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, \Slim\App $app, $args){
        parent::__construct($request, $response, $app, $args);
    }
    
    public function index(){
        $my_form = new \ViewHelper\Form('post');

        return $this->view->render($this->response, 'home.html');
    }
}