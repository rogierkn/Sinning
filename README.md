Latest project, a simple lightweight MVC framework, Sinning.
Inspired by Laravel
By Rogier Knoester



## Notes ##
If you're already familiar with Laravel's syntax you'll find a lot of this looking the same, this is because Sinning is inspired by Laravel.


# How to install #
First off download the files to the folder you want to host it from.
Make sure each request goes to the public folder, you can do this with your virtualhost setup or .htaccess

Now all should already be running.


# Start routing #

You can make a simple route by specifying a few things:
* The HTTP method
* The route
* The action
* Optional: wildcards

Example:

    $route->make('get', 'home', function()
    {
        return 'The homepage, through an anonymous function.';
    });

#### HTTP methods ####
If you want to make the route respond to any HTTP method, use an asterix (*).
Example:

    $route->make('*', 'home', function()
    {
            return 'The homepage, through an anonymous function.';
    });

#### Routes ####
You can register more than one route at a time to a specific action, just by making an array of the route parameter.
Example:

    $route->make('get', array('home', 'homepage'), function()
    {
            return 'The homepage, through an anonymous function.';
    });

This will respond to either 'Home' or 'Homepage' with this action.

#### Actions ####
There are two ways to specify an action:

    $route->make('get', 'home', function() {} );

and

    $route->make('get', 'home', 'home#index');

The second one involves controllers. It will create a new Home controller and go to the function Index. Controllers will be explained more a bit later.

#### Wildcards ####
If you want to have a wildcard in a URL, you can by simply putting a ':*:' on the spot of the wilcard.
The wildcard parameter will be passed on to the called function later on.
Example:

    $route->make('get', 'photo/:*:', function($id)
    {
        return "You are viewing photo: {$id}";
    }
    );

When you visit 'GET photo/12' the response will be: 'You are viewing photo: 12'.
If you use a controller ('controller#action'), the wildcard parameter will too be passed on and is accessible like in the anonymous function above.

#### Register a whole controller ####
Instead of registering each controller route you can register one controller and every request having that controller will be forwarded to that controller class.
You can do this by making a route:

    $route->controller('home');

If you now have the function index_get(); in the Home_Controller class, it will called whenever the route 'GET home/index' is requested.


# Controllers #
Controllers are easier to maintain when your application gets many routes.
You can set up a controller really easy, make a new file with the name of the controller class,  ending with _Controller extending the Controller class and add in a function ending with _(HTTP-method).
So a home controller would look like this:

    class Home_Controller extends Controller
    {
        public function index_get()
        {
            return 'Home controller, index action';
        }
    }

This class with the index_get() will get called on a 'GET home/index' request and will return 'Home controller, index action'.

#### Controller wilcards ####
Just like with an anonymous function you can put in wildcards, just give the function constructor the variables in order of them appearing in the URL.
Example:

    class Photo_Controller extends Controller
        {
            public function view_get($id)
            {
                return "View photo {$id}";
            }
        }

This would respond to a request like 'GET photo/view/12' and return 'View photo 12'.


#### Nesting controllers ####
It is possible to nest controllers in another folder within the controller folder.
Example:
  Folder
   application/controllers/admin/special/actions.php

  Controller
   Calling it:

    $route->make('get', 'admin', 'admin/special#actions');

   or

    $route->controller('admin/special');

   Controller structure

    class Admin_Special_Controller extends Controller
    {
        public function index_get()
            {
                return 'Admin/Special controller, actions action';
            }
    }





# Views #
Views come in when returning plain text isn't enough anymore.
Views are the way to split the logic of your application from the logic of your presentation.
Views are stored in application/views/ and the extension of them has to be '.sin.php'
You can return Views from an anonymous route function or a controller function.
Example:
  Controller

    class Home_Controller extends Controller
    {
        public function index_get()
        {
            return View::create('home')->show();;
        }
    }

  View

    <html>
        <body>
            <p>The Home_Controller's view</p>
        </body>
    </html>

You can also bind variables to the view by chaining them aftre the View::create();
Example:
  Controller

    class Home_Controller extends Controller
    {
        public function index_get()
        {
            return View::create('home')->set('name', 'Roger')->show();
        }
    }

  View

    <html>
        <body>
            <p>Welcome to the Home_Controller, <?php echo $name ?>.</p>
        </body>
    </html>

This will render out: 'Welcome to the Home_Controller, Roger.'
There's no limit to amount of chains.

#### SinEngine ####
SinEngine is the rendering engine of Sinning.
SinEngine comes in handy when you want a certain layout for your website and on each view have that layout present.
You can have that by making another file, extension being '.sin.php', and in here have your HTML layout.
Where you want your content to appear you must add in

    @yield('content')

NOTE: you can replace content with anything else, as long as you use the same names for the same sections.
It will look something like

    <html>
        <body>
            @yield('content')
        </body>
    </html>

Now when you make your view file, you'll have to include, at the top of the file, "@layout('name_of_layout')".
Your view can look like this, we named our layout file 'main.sin.php'

    @layout('main')

    @section('content')
     The content section
    @endsection

Now when this view gets rendered, it will output 'The content section'.

You can have as many sections and layouts as you want. You can use a different layout for users and staff members and so on.



