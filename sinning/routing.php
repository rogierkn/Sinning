<?php

class Routing
{


    private $data = array();



    public function __construct()
    {

    }


    public function get($route, $controller)
    {
        $this->data[$route] = $controller;
    }


    public function getController($url)
    {
        $controlleraction = explode('#', $this->data[$url]);
        $controller = new $controlleraction[0];
        $controller->$controlleraction[1]();
    }


}