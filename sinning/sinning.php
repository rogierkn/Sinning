<?php

ob_start();

// Get the autoloader running
require 'autoloader.php';
$autoloader = new Autoloader();




// Run routes
$url = new Url;
include '../application/router.php';

// Run controller
$router->getController($url->url);



ob_end_flush();







