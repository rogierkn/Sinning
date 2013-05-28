<?php

class Routing
{
    private $routes = array();

    public function __construct()
    {

    }


    // Keep registering short by using another function which redirects it to the register
    public function make($method, $route, $action)
    {
        $this->registerRoute(strtoupper($method),$route,$action);
    }


    // The actual registeting of a route. Starting with the HTTP method (GET, POST, PUT, DELETE), then the URL to respond to and the action that should follow
    // Such as a controller action or an anonymous function
    public function registerRoute($method, $url, $action)
    {
        // If the URL has several routes, split them with the | symbol
        if(is_string($url)) $url = explode('|', $url);

        foreach( (array) $url as $route )
        {

            $route = ltrim($route, '/');
            if($route == '') $route = '/';
            if(is_array($action))
            {
                $this->routes[$method][$route] = $action;
            }
            else
            {

                $this->routes[$method][$route] = $this->getAction($action);

            }
        }
    }

    // Get the action that is specified to save for the route (call comes from registerRoute())
    public function getAction($action)
    {
        // If the action is as string, just make it an array with key ACTION, then return it
        if(is_string($action))
        {
            $action = array('action' => $action);
        }
        // If the action is an anonymous function, put it inside an array to avoid a bug in PHP 5.3.2 (Thanks Laravel)
        elseif($action instanceof Closure)
        {
            $action = array($action);
        }
        return (array) $action;
    }


    // Get the current route that is run
    public function getRoute($method, $url)
    {
        // Get all routes from this HTTP method
        //$routes = $this->routes[strtoupper($method)];

        if(isset($this->routes[$method][$url]))
        {
            $action = $this->routes[$method][$url];
            return new Route($method, $url, $action);
        }

        if(!is_null($route = $this->findRoute($method, $url)))
            return $route;
    }

    public function findRoute($method, $url)
    {
        foreach($this->routes[$method] as $route => $action)
        {
            $route = '#^'.str_replace(':*:', '([a-zA-Z0-9\.\-_%=]+)', $route, $count).'$#u';
            if(preg_match($route, $url, $parameters))
            {
                return new Route($method, $url, $action, $parameters);
            }

        }
    }

    public function routeWildcard($route)
    {

    }


    public function getController($url)
    {
        $controlleraction = explode('#', $this->data[$url]);
        $controller = new $controlleraction[0];
        $controller->$controlleraction[1]();
    }


}