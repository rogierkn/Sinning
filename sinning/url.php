<?php
class Url
{
    private $url;

    public function __construct()
    {
        $this->data['url'] = ltrim($_SERVER['REQUEST_URI'], '/');
        if($this->url == '') $this->url = '/';

    }

    public function get()
    {
        return $this->url;
    }

}