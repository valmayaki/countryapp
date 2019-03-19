<?php

namespace App\Core\Http;

class Request
{
    protected $method;
    protected $body;
    protected $headers = [];
    protected $path;
    protected $query;
    protected $url;

    function __construct($body= '', $method = 'GET', $path = '/',$headers = [])
    {
        $this->method = $method;
        $this->body = $body;
        $this->headers = $headers;
        $this->path = $path;
    }
    static function capture()
    {

    }
}