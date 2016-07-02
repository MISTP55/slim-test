<?php

/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 29-06-2016
 * Time: 18:36
 */

namespace Parser;

/**
 * Class RouteParser
 * @package Parser
 * Permet de construire des patterns de route compréhensibles par Slim à partir d'un arborescence de dossier et de fichiers JSON.
 *
 */
class RouteParser{
    /**
     * @var string Chemin vers le dossier contenant les routes de l'application. Par exemple : app/routes.
     */
    private $routes_root_path;

    /**
     * @var array Routes parsées qui seront retournées.
     */
    private $routes = array();

    /**
     * @var string Chemin de l'élément actuellement traité.
     */
    private $current_route_path = '';

    /**
     * RouteParser constructor.
     * @param $routes_root_path Dossier contenant les routes.
     */
    public function __construct($routes_root_path){
        $this->routes_root_path = $routes_root_path;
    }

    /**
     * Génère les routes dans l'objet d'application.
     * @param \Slim\App $app
     */
    public function generateRoutes(\Slim\App $app){
        foreach($this->getRoutes() as $route_name => $route){
            $app->map([$route['method']], $route['url'], function (\Psr\Http\Message\ServerRequestInterface $request, \Psr\Http\Message\ResponseInterface $response, $args) use ($route_name, $route, $app) {
                $controller = '\\Controller\\'.$route['controller'];
                $controller = new $controller($request, $response, $app, $args);

                return $controller->$route['action']();
            })->setName($route_name);
        }
    }

    /**
     * Exécute le parser et retourne les routes construites.
     * @return array
     */
    public function getRoutes(){
        return $this->parseDirectory();
    }

    /**
     * Parse l'arborescence contenue dans $this->routes_root_path et construit les routes à partir des fichiers JSON.
     * @param string $path
     * @return array
     */
    private function parseDirectory($path = null){
        if(is_null($path)){
            $directory = $this->routes_root_path;
        }
        else{
            $directory = $path;
        }

        $directory_content = scandir($directory);

        // Suppression de . et ..
        array_splice($directory_content, 0, 2);

        foreach($directory_content as $item){
            $item_path = $directory.DIRECTORY_SEPARATOR.$item;
            $this->current_route_path = $item_path;

            // Si c'est un dossier, on traverse récursivement les éléments enfants et on récupère
            // tous les .json tout en construisant les patterns des routes à partir du nom des éléments.
            if(is_dir($item_path)){
                array_merge($this->routes, $this->parseDirectory($item_path));
            }
            elseif(is_file($item_path) and preg_match('/.json$/', $item_path)){
                foreach(json_decode(file_get_contents($item_path), true) as $route_name => $route){
                    // Traitement spéciale pour la route "root".
                    if(basename($item_path, '.json') == 'root'){
                        $route['url'] = '[/]';
                    }
                    else{
                        // Nettoyage de la route pour obtenir un pattern utilisable par Slim.
                        $route['url'] = str_replace('/'.$this->routes_root_path, '', '/'.str_replace('.json', '', str_replace(DIRECTORY_SEPARATOR, '/', $this->current_route_path.$route['url'])));
                    }

                    $this->routes[$route_name] = $route;
                }
            }
        }

        return $this->routes;
    }
}