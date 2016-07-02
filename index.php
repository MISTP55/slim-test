<?php
function p($arr = array(), $lin = 0, $f = '') {
    if($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='127.0.0.1'){
        if (!$arr)
            $arr = $_POST;
        echo '<pre style="background:#fff; border:1px solid red;">';
        if ($lin)
            echo "** $lin ===== $f **<br>";
        echo htmlspecialchars(print_r($arr, true));
        echo '</pre>';
    }
}

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Parser\RouteParser as RouteParser;

$_SERVER['DOCUMENT_ROOT'] = __DIR__.DIRECTORY_SEPARATOR;

require $_SERVER['DOCUMENT_ROOT'].'vendor'.DIRECTORY_SEPARATOR.'autoload.php';

spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    include $_SERVER['DOCUMENT_ROOT'].'src'.DIRECTORY_SEPARATOR.$class.'.php';
});

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

$container = $app->getContainer();

$container['view'] = function ($container) {
    $view = new \Slim\Views\Twig('views', [
        'cache' => 'views/cache'
    ]);
    $view->addExtension(new \Slim\Views\TwigExtension(
        $container['router'],
        $container['request']->getUri()
    ));

    return $view;
};

$route_parser = new RouteParser('routes');
$route_parser->generateRoutes($app);

$app->run();