<?php

ob_start();

// Get the autoloader running
require 'autoloader.php';
$autoloader = new Autoloader();
$server = new Server;




// Run routes
$url = new Url;
include '../application/router.php';

// Run controller and give a Route object to $route, which will then execute the action of the route
$route = $router->getRoute($server->REQUEST_METHOD, $url->get());




ob_end_flush();







