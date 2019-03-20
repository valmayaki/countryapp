<?php

namespace App\Core\Controller;

use App\Application;

abstract class BaseController
{
    protected $app;

    function __construct(Application $container)
    {
        $this->app = $container;
    }
}