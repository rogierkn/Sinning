<?php
class Url
{
    private $data = array();

    public function __construct()
    {
        $this->data['url'] = $_SERVER['REQUEST_URI'];
        if($this->data['url'] == '')
            $this->data['url'] == '/';

    }

    public function __get($var)
    {
        return $this->data[$var];
    }
}