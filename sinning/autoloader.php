<?php

/*
 * Autoloading of class
 *
 */
class Autoloader
{
    public function __construct()
    {
        spl_autoload_register('Autoloader::loadLocal');
        spl_autoload_register('Autoloader::loadController');
    }

    public static function loadLocal($class)
    {
        $file = __DIR__.'/'.$class.'.php';

        $file = strtolower($file);
        if(file_exists($file))
        {
            require $file;
        }
    }

    public static function loadController($class)
    {
        $file = '../application/controllers/'.$class.'.php';

        $file = strtolower($file);
        if(file_exists($file))
        {
            require $file;
        }
    }
}