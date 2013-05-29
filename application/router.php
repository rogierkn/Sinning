<?php
$route = new Routing;


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
 *
 * Instead of giving a controller you can also use an anonymous function.
 * Any parameters in the URL that are needed in the function are passed through as an array with [0] being the first and [1] the second and so on
 */

$route->make('get', '/', 'home#index');

$route->make('get', 'home', function()
{
   return 'This page is brought through an anonymous function.';
});