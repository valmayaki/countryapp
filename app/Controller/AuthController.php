<?php

namespace App\Controller;

use App\Core\Controller\BaseController;
use App\Core\Http\Request;
use App\Core\Http\Response;


class AuthController extends BaseController
{
    public function login(Request $request, Response $response)
    {
        $response->redirect('dashboard');
    }
}
