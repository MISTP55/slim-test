<?php
function p($arr = array(), $lin = 0, $f = '') {
//	print_r($arr);
    if($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='127.0.0.1'){
        if (!$arr)
            $arr = $_POST;
        echo '<pre style="background:#fff; border:1px solid red;">';
        if ($lin)
            echo "** $lin ===== $f **<br>";
        echo htmlspecialchars(print_r($arr, true));
        //	print_r($arr);
        echo '</pre>';
    }
}

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Parser\RouteParser as RouteParser;

require 'vendor/autoload.php';

spl_autoload_register(function ($class) {
    include 'src'.DIRECTORY_SEPARATOR. $class . '.php';
});

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

$route_parser = new RouteParser('routes');

//p($route_parser->getRoutes());

foreach($route_parser->getRoutes() as $route_name => $route){
    $app->map([$route['method']], $route['url'], function (Request $request, Response $response, $args) use ($route_name, $route, $app) {
        $controller = '\\Controller\\'.$route['controller'];
        $controller = new $controller($request, $response, $app, $args);

        return $controller->$route['action']();
    })->setName($route_name);
}

$app->run();