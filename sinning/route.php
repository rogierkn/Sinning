<?php

class Route
{
    private $method;

    private $route;

    public $action;

    // Set all data to class variables
    public function __construct($method, $route, $action, $parameters = array())
    {
        $this->method = $method;
        $this->route = $route;
        $this->action = $action;
        $this->parameters = $parameters;
    }


}