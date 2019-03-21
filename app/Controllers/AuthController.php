<?php

namespace App\Controllers;

use App\Core\Controller\BaseController;
use App\Core\Http\Request;
use App\Core\Http\Response;


class AuthController extends BaseController
{
    public function login(Request $request, Response $response)
    {
        $db = $this->app->get('connector');
        $sql = 'SELECT * FROM users where enable=1 AND email = :email and password = :password LIMIT 1';
        $sth = $db->prepare($sql);
        $sth->execute([':email' => $_POST['email'], ':password' => $_POST['password']]);
        $user = $sth->fetch(PDO::FETCH_OBJ);
        if ($user === false){
            $response->setSession('error_message', "Wrong credentials provided");
            $response->redirect('/');
        }
        $response->redirect('dashboard');
    }
}
