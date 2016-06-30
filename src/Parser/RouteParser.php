<?php

/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 29-06-2016
 * Time: 18:36
 */

namespace Parser;

class RouteParser{
    private $routes = array();
    private $route_path = '';
    private $directory;

    public function __construct($directory){
        $this->directory = $directory;
    }

    public function getRoutes($path = null){
        if(is_null($path)){
            $directory = $this->directory;
        }
        else{
            $directory = $path;
        }

        $directory_content = scandir($directory);

        // Suppression de . et ..
        array_splice($directory_content, 0, 2);

        foreach($directory_content as $item){
            $item_path = $directory.DIRECTORY_SEPARATOR.$item;
            $this->route_path = $item_path;

            if(is_dir($item_path)){
                array_merge($this->routes, $this->getRoutes($item_path));
            }
            elseif(is_file($item_path) and preg_match("/.json$/", $item_path)){
                foreach(json_decode(file_get_contents($item_path), true) as $route_name => $route){
                    if(basename($item_path, ".json") == 'root'){
                        $route['url'] = '/';
                    }
                    else{
                        $route['url'] = '/'.str_replace('.json', '', implode('/', array_slice(explode('/', str_replace(DIRECTORY_SEPARATOR, '/', $this->route_path.$route['url'])), 1)));
                    }

                    $this->routes[$route_name] = $route;
                }
            }

            $this->route_path = '';
        }

        return $this->routes;
    }
}