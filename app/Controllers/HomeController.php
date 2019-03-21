<?php

namespace App\Controllers;

use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Application;
use App\Core\Controller\BaseController;

class HomeController extends BaseController
{
    /**
     * Render Home page
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function index(Request $request, Response $response)
    {
        $response->render('home.php');
    }
    /**
     * Display User Dashboard
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function dashboard(Request $request, Response $response)
    {
        $response->render('dashboard.php');
    }
}
