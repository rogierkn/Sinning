<?php

class Home_Controller extends Controller
{

    // The home controller
    // Responds to path.com/home/index on a GET request
    public function index_get()
    {
        return View::create('home')->show();
    }

}