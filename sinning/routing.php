<?php

class Routing
{
    public $routes = array();

    private $methods = array(
        'GET',
        'POST',
        'PUT',
        'DELETE',
        'HEAD',
        'OPTIONS'
    );
    // Keep registering short by using another function which redirects it to the register
    public function make($method, $route, $action)
    {
        $this->registerRoute(strtoupper($method),$route,$action);
    }

    // The actual registeting of a route. Starting with the HTTP method (GET, POST, PUT, DELETE), then the URL to respond to and the action that should follow
    // Such as a controller action or an anonymous function
    private function registerRoute($method, $url, $action)
    {
        if($method == '*')
        {
            foreach($this->methods as $method)
            {
                $this->registerRoute($method, $url, $action);
            }
            return;
        }
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

    // Register a controller
    public function controller($controllers)
    {
        foreach((array) $controllers as $controller)
        {
            $wildcards = $this->repeatUrlWildcards('?:*:');
            $pattern = trim("{$controller}/{$wildcards}?)?)?)?)?)", '/');
            $action = "{$controller}#(:action:)";
            $this->registerRoute('*', $pattern, $action);
        }
    }

    // Get the action that is specified to save for the route (call comes from registerRoute())
    private function getAction($action)
    {
        return array('action' => $action);
    }

    // Get the current route that is run
    public function getRoute($method, $url)
    {
        // Get all routes from this HTTP method
        //$routes = $this->routes[strtoupper($method)];
        if(isset($this->routes[$method][$url]))
        {
            $action = $this->routes[$method][$url];
            $route = new Route($method, $url, $action);
            return $route->getRouteReponse();
        }
        if(!is_null($route = $this->findRoute($method, $url)))
        {
            return $route->getRouteReponse();
        }
        return Error::code('404', 'Route not found.');
    }

    // If the route has parameters then we'll find the corresponding route and action with some RegEx
    private function findRoute($method, $url)
    {
        foreach($this->routes[$method] as $route => $action)
        {
            $route = str_replace('/:*:', '(?:/([a-zA-Z0-9]+))', $route, $count);
            $route = str_replace('/?:*:', '(?:/([a-zA-Z0-9]+)', $route, $count);
            $route = '#'.$route. '#';
            if(preg_match($route, '#'.$url.'#', $parameters))
            {
                return new Route($method, $url, $action, array_slice($parameters,1));
            }
        }
    }

    public function repeatUrlWildcards($pattern, $count = 5)
    {
        return implode('/', array_fill(0, $count, $pattern));
    }

}