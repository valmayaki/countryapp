<?php

namespace App\Controller;

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
        $db = $this->app->get('database')->getConnection();
        $sql = 'SELECT name, color, calories FROM fruit ORDER BY name';
        var_dump($db->query($sql));
        foreach ($db->query($sql) as $row) {
            print $row['name'] . "\t";
            print $row['color'] . "\t";
            print $row['calories'] . "\n";
        }
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
