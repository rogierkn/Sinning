<?php

class View
{

    // The array to hold the variables of a view
    protected $variables = array();

    // Path of the view
    protected $path;

    public function __construct($path)
    {
        $path = 'application/views/'.$path.'.sin.php';
        if(file_exists($path))
        {
            $this->path = $path;
            return $this;
        }
        else
        {
            return Error::code('500', 'Could not find view');
        }
    }

    // Use a static function to create Views so the DEV can call Views easier
    public static function create($path)
    {
        return new static($path);
    }

    // Set a variable of the view which will be extracted later in SinEngine
    public function set($var_name, $value)
    {
        $this->variables[$var_name] = $value;
        return $this;
    }

    // Get the View's output by rendering it
    public function show()
    {
        // Start SinEngine, the render engine of Sinning
        return SinEngine::start($this->path, $this->variables);
    }
}