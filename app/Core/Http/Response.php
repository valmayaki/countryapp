<?php

namespace App\Core\Http;

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

    /**
     * Send header to client
     *
     * @return void
     */
    protected function sendHeaders()
    {
        foreach($this->headers as $header => $value){
            if (strpos($header, '-') !== false){
                $headerParts = explode('-', $header);
                $headerParts =  array_map('\ucfirst', $headerParts);
                $header = \implode('-', $headerParts);
            }
            
            header(sprintf('%s: %s', ucfirst($header), $value));
        }
    }

    /**
     * Displays the body of the request
     *
     * @return void
     */
    public function sendBody()
    {
        echo $this->body;
    }

    public function render($viewFile, $data = [])
    {
        extract($data);
        if ($viewFile[0] !== '/'){
            $viewFile = '/'.$viewFile;
        }
        ob_start();
        require VIEW_PATH. $viewFile;
        $this->body = \ob_get_clean();
        return $this;
    }
    
    public function withHeader($name, $value)
    {
        $this->setHeader($name, $value);
        return $this;
    }

    public function withHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);
        return $this;
    }

    public function withBody($content)
    {
        $this->body = $content;
        return $this;
    }
}