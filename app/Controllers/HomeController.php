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
        $response->render('dashboard/index.php');
    }
    /**
     * Display User Dashboard
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function forgotPassword(Request $request, Response $response)
    {
        $response->render('forgot-password.php');
    }
    /**
     * Display User Dashboard
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function register(Request $request, Response $response)
    {
        $response->render('register.php');
    }

    /**
     * Display User Dashboard
     *
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function resetPassword(Request $request, Response $response)
    {
        $token = $request->get('token');
        $response->render('reset-password.php',compact('token'));
    }
}
