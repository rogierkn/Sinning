<?php
class Server
{
    public function __get($var)
    {
        return $_SERVER[$var];
    }
}