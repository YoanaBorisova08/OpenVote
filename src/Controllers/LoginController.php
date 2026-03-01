<?php

namespace App\Controllers;

class LoginController extends AbstractController{

    public function logout(){
        $this->authService->logout();
        header('Location: index.php?' . http_build_query(['route' => 'login']));
        exit;
    }

    public function login(){
        if ($this->authService->isLoggedIn()){
            header('Location: index.php');
            exit;
        }
        $loginError = false;

        if(!empty($_POST)){
            $username = @(string) ($_POST['username'] ?? '');
            $password = @(string) ($_POST['password'] ?? '');

            if(!empty($username) && !empty($password)){
                $loginOk = $this->authService->handleLogin($username, $password);
                if($loginOk === true){
                    header("Location: index.php");
                    exit;
                }
                else{
                    $loginError = true;
                }
            }
            else
            {
                    $loginError = true;
            }
        }

        $this->render('login', [
            'loginError' => $loginError
        ]);
    }

    public function register(){
        if ($this->authService->isLoggedIn()){
            header('Location: index.php');
            exit;
        }
        $loginError ='';

        if(!empty($_POST)){
            $firstName = @(string) ($_POST['first_name'] ?? '');
            $lastName = @(string) ($_POST['last_name'] ?? '');
            $email = @(string) ($_POST['email'] ?? '');
            $username = @(string) ($_POST['username'] ?? '');
            $password = @(string) ($_POST['password'] ?? '');

            if(!empty($username) && !empty($firstName) && !empty($lastName) && !empty($email) && !empty($password)){
                $error = $this->authService->handleRegister($firstName, $lastName, $email, $username, $password);
                if(empty($error)){
                    header("Location: index.php?" . http_build_query(['route' => 'login']));
                    exit;
                }
                else{
                    $loginError = $error;
                }
            }
            else
            {
                    $loginError = 'All fields are required.';
            }
        }

        $this->render('register', [
            'loginError' => $loginError
        ]);
    }
}