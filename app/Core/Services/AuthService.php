<?php
namespace App\Core\Services;

use App\Application as Container;

class AuthService 
{
    protected $container;

    function __construct(Container $app)
    {
        $this->container = $app;
    }

    public function check($credentials)
    {
        
    }
}
