<?php

namespace App\Controllers;

use App\Core\Controller\BaseController;
use App\Core\Http\Request;
use App\Core\Http\Response;
use PDO;


class AuthController extends BaseController
{
    public function login(Request $request, Response $response)
    {
        $db = $this->app->get('database');
        $sql = 'SELECT * FROM users where enable = 1 AND email = :email LIMIT 1';
        $sth = $db->prepare($sql);
        $sth->execute(['email' => $_POST['email']]);
        $user = $sth->fetch(PDO::FETCH_ASSOC);
        if ($user === false || !password_verify($_POST['password'], $user['password'])){
            // $this->app->get('session')->error_message = "Wrong credentials provided";
            $_SESSION['error_message'] = "Wrong credentials provided";
            $query = \http_build_query(['error' => true, 'message' => 'Wrong credentials provided']);
            return $response->redirect('/?'.$query);
        } 
        // $this->app->get('session')->user_id = $user['id'];       
        $_SESSION['user_id' ]= $user['id'];       
        return $response->redirect('/dashboard');
    }
    public function register(Request $request, Response $response)
    {
        // get required fields
        $db = app()->get('database');
        $email = $request->get('email');
        $password = $request->get('password');
        $firstname = $request->get('firstname');
        $lastname = $request->get('lastname');
        $query = '';
        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $query = http_build_query(['error' => true, 'message' => 'Email provided is invalid']);
            return $response->redirect('/register?'.$query);
        }
        if ($ferror = empty($firstname) || $lerror= empty($lastname)){
            $query = http_build_query(['error' => true, 'message' => sprintf('%s provided is invalid', $ferror? 'First name': 'Last name')]);
            return $response->redirect('/register?'.$query);
        }
        if (empty($password)){
            $query = http_build_query(['error' => true, 'message' => 'password must not be empty']);
            return $response->redirect('/register?'.$query);
        }
        // check that email is not taken
        $stmt = $db->prepare("SELECT 1 FROM users WHERE email=?");
        $stmt->execute([$email]); 
        $user = $stmt->fetchColumn();;
        if($user){
            $query = http_build_query(['error' => true, 'message' => 'Email is already taken']);
            return $response->redirect('/?'.$query);
        }
        // insert into database
        $hash_password = password_hash($password, PASSWORD_DEFAULT);
        $insertStmt = $db->prepare('INSERT into users (firstname,lastname,email, password, role_id) values (:firstname, :lastname, :email, :hash_password, 2)');
        $status = $insertStmt->execute(['firstname' => $firstname, 'lastname' => $lastname, 'email' => $email, 'hash_password' =>  $hash_password]);
        if ($status  === false){
            $query = http_build_query(['error'=>true, 'message' => 'Unable to create an account, please try again later']);
            return $response->redirect(sprintf('/register?%s', $query));
        };
        $_SESSION['user_id' ]= $user['id'];
        // redirect to dashboard
        return $response->redirect('/dashboard');
    }
    public function requestPasswordReset(Request $request, Response $response)
    {
        $email = $request->get('email');
        if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
            $query = http_build_query(['error' => true, 'message' => 'Email provided is invalid']);
            return $response->redirect('/forgot-password?'.$query);
        }
        $db = $this->app->get('database');
        $stmt = $db->prepare("SELECT 1 FROM users WHERE email=?");
        $stmt->execute([$email]); 
        $user = $stmt->fetchColumn();;
        if(!$user){
            $query = http_build_query(['error' => true, 'message' => "Email provided doesn't exist on this platform"]);
            return $response->redirect('/forgot-password?'.$query);
        }
        $stm = $db->prepare("SELECT 1 from password_reset where email = :email");
        $stm->execute(['email'=> $email]);
        $reset = $stm->fetchColumn();
        $updated_at = date('Y-m-d H:i:s');
        if ($reset){
            $sql = "UPDATE password_reset SET token = :token, updated_at = :updated_at WHERE email = :email";
        }else{
            $sql = "INSERT INTO password_reset (email, token, updated_at) values(:email, :token, :updated_at)";
        }
        $stmt = $db->prepare($sql);
        $token = sha1(time());
        if($stmt->execute(['email'=> $email, 'token'=> $token, 'updated_at' => $updated_at])){

            $message = "An email has been sent to your inbox, please follow the link to continue";
            $error= false;
            //send reset link to email
        }else {
            $message = "Unable to reset your password now please try again later";
            $error = true;
        }
        $query =\http_build_query(['error' => $error, 'message' => $message]);
        return $response->redirect('/forgot-password?'. $query);
    }
    public function logout(Request $request, Response $response)
    {
        // $this->app->get('session')->flush();
        session_destroy();

        return $response->redirect('/');
    }

    public function resetPassword(Request $request, Response $response)
    {
        //look for token in reset table
        $db = $this->app->get('database');
        $token  =  $request->get('token');
        $password = $request->get('password');
        $passwordConfirmation = $request->get('password_confirmation');
        $error = false;
        if(empty($token)) {
            $error = true;
            $message = 'The link followed is invalid';
        }else if (empty($password) || $same = ($password !== $passwordConfirmation)){
            $error = true;
            $message = $same ? 'Password must be this same' :'Password must not be empty';
        }
        if($error){

            $query = \http_build_query(['error'=> true, 'message' => $message, 'token' => $token]);
            return $response->redirect('/reset-password?'. $query);
        }
        // if found use email to find user
        $sth = $db->prepare("SELECT id, email FROM password_reset WHERE token = :token");
        $sth->execute(['token'=> $token]);
        $resetData = $sth->fetch(PDO::FETCH_ASSOC);
        if($resetData === false || empty($resetData)){
            $query = \http_build_query(['error'=> true, 'message' => 'Link is invalid or has expired', 'token' => $token]);
            return $response->redirect('/reset-password?'. $query);
        }
        $st = $db->prepare("UPDATE users set password = :password where email = :email");
        $st->execute(['email'=> $resetData['email'], 'password' => password_hash($password, PASSWORD_DEFAULT)]);
        $db->exec(sprintf("DELETE FROM password_reset where id = %d", $resetData['id']));
        return $response->redirect('/dashboard');
    }
}
