<?php

class Route
{
    private $method;

    private $route;

    private $action;

    private $parameters = array();


    // Set all data to class variables
    public function __construct($method, $route, $action, $parameters = array())
    {
        $this->method = $method;
        $this->route = $route;
        $this->action = $action;
        $this->parameters = $parameters;
        // Get the action from this route
    }

    public function getRouteReponse()
    {
        return $this->getAction();
    }


    private function getAction()
    {
        if(is_string($this->action['action']))
        {
            // If a controller has been registered, give the action the variable after the controller in the URL
            if(strpos($this->action['action'], '(:action:)') !== false)
            {
                $this->action['action'] = str_replace('(:action:)', (!is_null($this->parameters[0])) ? $this->parameters[0]: 'index', $this->action['action']);
                unset($this->parameters[0]);
            }
            /*
             * Get path of controller file
             * strstr -> removing the #action part so we get a path to the controller
             */
            $path = 'application/controllers/'.strtolower( strstr( $this->action['action'], '#', true ) .'.php');
            if(file_exists($path))
            {
                require_once $path;
                $controller_path = strstr($this->action['action'], '#', true); // Remove the #action from the string
                $controller = str_replace('/', '_',$controller_path).'_controller'; // Create the controller class name
                $controller = new $controller($this->method, $this->route, str_replace('#', '', strstr($this->action['action'], '#')), $this->parameters); // Create the new controller
                return $controller->getActionResponse(); // Get the response of the controller at the needed action
            }
            else
            {
                return Error::code('500', 'Controller not found for this route');
            }
        }
        elseif( $this->action['action'] instanceof Closure)
        {
            return call_user_func_array($this->action['action'], $this->parameters);
        }

        return Error::code('500', 'No return function found for this route.');
    }
}