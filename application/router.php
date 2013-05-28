<?php
$router = new Routing;


/*
 * Create new routes
 *
 * GET Route:  $router->make('get', 'foo', 'foo#bar');
 * POST Route: $router->make('post', 'foo', 'foo#bar');
 *
 * Nested a controller? Add its path in front: $router->make('GET', '/this/is/nested', 'this/is/nested#index');
 *
 * Wildcards :*:
 * $router->make('get', 'photo/:*:/view', 'foo#bar');
 *
 * Register multiple routes by splittin them with a | sign or with an array
 * e.g.
 *      $router->make('get', 'home|admin|user', 'home#index');
 *      $router->make('get', array('home', 'admin', 'user'), 'home#index');
 * This will register the three routes home, admin, and user
 */

