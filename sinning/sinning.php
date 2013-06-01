<?php
chdir('../');
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);




// Get the autoloader running
require 'autoloader.php';
$autoloader = new Autoloader();
$server = new Server;





// Run routes
$url = new Url;
include 'application/router.php';

// Find corresponding route, execute it's action and return that as the response
// Final type of $response is a pure string

$response = $route->getRoute($server->REQUEST_METHOD, $url->get());

// When we've got the whole response, echo it out to the browser
echo $response;


//echo microtime(true) - START_TIME;







