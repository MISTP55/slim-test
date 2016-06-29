<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Parser\RouteParser as RouteParser;

require 'vendor/autoload.php';

spl_autoload_register(function ($class) {
    include 'src'.DIRECTORY_SEPARATOR. $class . '.php';
});

$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Hello World!");

    return $response;
});

$app->run();