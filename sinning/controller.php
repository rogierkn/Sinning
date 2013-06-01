<?php

class Controller
{
    protected $route;

    protected $action;

    protected $parameters;

    protected $method;

    // Create the controller and set is variables
    public function __construct($method, $route, $action, $parameters)
    {
        $this->method = strtolower($method);
        $this->route = $route;
        $this->parameters = $parameters;
        $this->action = $action;
    }

    // Retrieve the controllers response by going to it's corresponding action function
    public function getActionResponse()
    {
        // Might add filters like before and after

        $user_function = "{$this->action}_{$this->method}";
        if(is_null($response = call_user_func_array(array($this, $user_function), $this->parameters)))
        {
            return Error::code('500', 'Could not execute function at route '.$this->route);
        }
        else
        {
            return $response;
        }

    }

    // If the called function does not exist, throw an error
    public function __call($method, $args)
    {
        return Error::code('404', 'Function: '.$method.' in '.get_class($this).' does not exist.');
    }
}