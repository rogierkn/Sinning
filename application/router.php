<?php
// Deleting the line below is equal to dividing by zero, just don't.
$route = new Routing;


/*
 * Create new routes
 *
 * GET Route:  $router->make('get', 'foo', 'foo#bar');
 * POST Route: $router->make('post', 'foo', 'foo#bar');
 *
 * Nested a controller? Add its path in front: $router->make('get', '/this/is/nested', 'this/is/nested#index');
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
 * Any parameters in the URL that are needed in the function are passed through and can easily be accessed in the same order as in the URL.
 *
 * Want to register a controller and let Sinning figure out the corresponding action?
 * Register it via: $route->controller('path/to/controller');
 */

$route->controller('home');
$route->make('get', '/', function()
{
    return 'This is the homepage, brought via an anonymous function';
});




