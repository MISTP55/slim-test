<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 29-06-2016
 * Time: 19:49
 */

namespace Controller;

class BaseController{
    protected $request;
    protected $response;
    protected $app;
    protected $view;
    protected $args;

    public function __construct( \Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, \Slim\App $app, $args){
        $this->request = $request;
        $this->response = $response;
        $this->app = $app;
        $this->view = $app->getContainer()['view'];
        $this->args = $args;
    }
}