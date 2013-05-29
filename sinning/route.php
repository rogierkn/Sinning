<?php

class Route
{
    private $method;

    private $route;

    private $action;

    private $parameters = array();


    // Set all data to class variables
    public function __construct($method, $route, $action, $parameters = array())
    {
        $this->method = $method;
        $this->route = $route;
        $this->action = $action;
        $this->parameters = $parameters;
        // Get the action from this route
    }

    public function getRouteReponse()
    {
        return $this->getAction();
    }

    private function getAction()
    {
        if(is_string($this->action['action']))
        {
            return $this->callController($this->action['action']);
        }
        elseif( $this->action['action'] instanceof Closure)
        {
            return $this->action['action']($this->parameters);
        }
    }

    // Call the corresponding controller by splitting the controller and action
    private function callController($action)
    {
        // Get controller part
        $controller = 'Controller_'.explode('#', $action)[0];
        $action = explode('#', $action)[1];
        $controller = new $controller;
        return $controller->$action();

    }

}