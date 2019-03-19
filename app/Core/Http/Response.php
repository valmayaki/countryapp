<?php

namespace App\Core\Controller;

class Response
{
    protected $body;
    protected $status;
    protected $headers;
    function __construct($content='', $status = 200, $headers = [])
    {
        $this->body = $content;
        $this->status = $status;
        $this->headers = $headers;
    }

    public function setHeader($header, $value)
    {
        $this->headers[$header] = $value;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function send()
    {
        $this->sendHeaders();
        $this->sendBody();
    }

    protected function sendHeaders()
    {
        foreach($this->header as $header => $value){
            if (strpos($header, '-') !== false){
                $headerParts = explode('-', $header);
                $headerParts =  array_map('\ucfirst', $headerParts);
                $header = \implode('-', $headerParts);
            }
            
            header(sprintf('%s: %s', ucfirst($header), $value));
        }
    }
    public function sendBody()
    {
        echo $this->body;
    }
}