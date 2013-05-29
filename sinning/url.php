<?php
class Url
{
    private $url;

    public function __construct()
    {
        $this->url = ltrim($_SERVER['REQUEST_URI'], '/');
        $this->url = rtrim($this->url, '/');
        if($this->url == '') $this->url = '/';

    }

    public function get()
    {
        return $this->url;
    }

}