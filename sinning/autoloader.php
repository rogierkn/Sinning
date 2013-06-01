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
}