<?php
// Possible replacement of the $_SERVER global, needs further work
class Server
{
    public function __get($var)
    {
        return $_SERVER[$var];
    }
}