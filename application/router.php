<?php
$router = new Routing;


/*
 * Create new routes
 * Need a GET route, use ->get();, same for POST, PUT, DELETE
 *
 * Nested a controller? Add its path in front: $router->get('/this/is/nested/', 'this/is/nested#index');
 *
 * Wildcards :num, :str, :any
 */
$router->get('/rawr', 'home#rawr');
$router->get('/', 'home#index');
