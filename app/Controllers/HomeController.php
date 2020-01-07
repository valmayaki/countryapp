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
        $db = $this->app->get('database');
        $sth = $db->prepare("SELECT 1 FROM password_reset WHERE token = :token");
        $sth->execute(['token'=> $token]);
        $resetData = $sth->fetch(PDO::FETCH_ASSOC);
        if($resetData === false || empty($resetData)){
            $query = \http_build_query(['error'=> true, 'message' => 'Link is invalid or has expired', 'token' => $token]);
            return $response->redirect('/reset-password?'. $query);
        }
        $response->render('reset-password.php',compact('token'));
    }
}
