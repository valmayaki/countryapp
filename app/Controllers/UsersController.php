<?php

namespace App\Controllers;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\Controller\BaseController;
use PDO;

class UsersController extends BaseController
{
    public function index(Request $request, Response $response)
    {
        $users = [];
        $db = $this->app->get('database');
        $sth = $db->prepare("SELECT * from users");
        $sth->execute();
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
        if($result !== false || !empty($result)){
            $users = $result;
        }
        return $response->render('dashboard/users/index.php', compact('users'));
    }

    public function edit(Request $request, Response $response, $id)
    {
        $user = null;
        $db = $this->app->get('database');
        $roles= $db->query("SELECT id, name from roles", PDO::FETCH_OBJ);
        $sth = $db->prepare("SELECT * from users where id = :id");
        $sth->execute(['id' => $id]);
        $result = $sth->fetch(PDO::FETCH_OBJ);
        if($result !== false || !empty($result)){
            $user = $result;
            return $response->render('dashboard/users/edit.php', compact('user', 'roles'));
        }
        return $response->render('404');
    }
    public function profile(Request $request, Response $response, $id)
    {
        $user = null;
        $id = ($_SESSION['user_id']);
        $db = $this->app->get('database');
        $roles= $db->query("SELECT id, name from roles", PDO::FETCH_OBJ);
        $sth = $db->prepare("SELECT * from users where id = :id");
        $sth->execute(['id' => $id]);
        $result = $sth->fetch(PDO::FETCH_OBJ);
        if($result !== false || !empty($result)){
            $user = $result;
            return $response->render('dashboard/users/profile.php', compact('user', 'roles'));
        }
        return $response->render('404');
    }
    public function update(Request $request, Response $response, $id)
    {
        $data = [];
        if ($request->has('email')){
            $email = $request->get('email');
            if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
                $query = http_build_query(['error' => true, 'message' => 'Email provided is invalid']);
                return $response->redirect('/dashboard/users/'.$id. '?'. $query);
            }
        }
        if ($request->has('firstname') ||  $request->has('firstname')){
            $firstname = $request->get('firstname');
            $lastname = $request->get('lastname');
            if (($ferror = empty($firstname)) || ($lerror= empty($lastname))){
                $query = http_build_query(['error' => true, 'message' => sprintf('%s provided is invalid', $ferror? 'First name': 'Last name')]);
                return $response->redirect('/dashboard/users/'.$id. '?'. $query);
            }
            if(!$ferror){
                $data['firstname'] = $firstname;
            }
            if(!$lerror){
                $data['lastname'] = $lastname;
            }
        }
        if ($request->has('enable')){
            $enable = filter_var($request->get('enable'), FILTER_VALIDATE_BOOLEAN);
            $data['enable'] = $enable? 1 : 0;
        }
        $db = $this->app->get('database');
        $sth = $db->prepare("SELECT * from users where id = :id");
        $sth->execute(['id' => $id]);
        $result = $sth->fetchAll(PDO::FETCH_OBJ);
        if($result === false || empty($result)){
            return $response->render('404');
        }
        $preparedData = [];
        $message = '';
        if(!empty($data) && count($data) > 0){
            // die(var_dump(array_keys($data)));
            $preparedData = array_map(function($key){
                return sprintf("%s = :%s", $key, $key);
            }, array_keys($data));
            $sql = "UPDATE users SET ". implode(',', $preparedData). " WHERE id = {$id}";
            $stmt = $db->prepare($sql);
            $status = $stmt->execute($data);
            $message = http_build_query(['error' => false, 'message' => 'Record successfully updated']);
        }
        return $response->redirect('/dashboard/users/'. $id ."?". $message);
    }
}
