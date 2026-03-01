<?php

namespace App\Support;

use PDO;
use PDOException;

class AuthService{
    public function __construct(private PDO $pdo){}

    public function ensureSession(){
        if(session_id() === ''){
            session_start();
        }
    }

    public function ensureLoggedIn(){
        $isLoggedIn = $this->isLoggedIn();
        if(empty($isLoggedIn)){
            header('Location: index.php?' . http_build_query(['route' => 'login']));
            die();
        }
    }

    public function logout(){
        $this->ensureSession();
        unset($_SESSION['userId']);
        unset($_SESSION['isAdmin']);
        session_regenerate_id();
    }

    public function isLoggedIn(){
        $this->ensureSession();
        return (!empty($_SESSION['userId']));
    }

    public function isAdmin(){
        $this->ensureSession();
        return (!empty($_SESSION['isAdmin']));
    }

    public function handleLogin(string $username, string $password){
        if(empty($username)) return false;
        if(empty($password)) return false;

        $stmt = $this->pdo->prepare('SELECT `id`, `role`, `password` FROM `users` WHERE `username` = :username');
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $entry = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($entry)) return false;

        $hash = $entry['password'];

        if(empty(password_verify($password, $hash))) return false;

        $this->ensureSession();
        $_SESSION['userId'] = $entry['id'];
        if($entry['role'] === 'admin'){
            $_SESSION['isAdmin'] = true;
        }else{
            $_SESSION['isAdmin'] = false;
        }
        session_regenerate_id();
        return true;
    }

    public function handleRegister(string $firstName, string $lastName, string $email, string $username, string $password){
        if(empty($username)) return 'All fields are required.';
        if(empty($password) || strlen($password) <= 5) return 'The password must be at least 5 characters long.';
        if(empty($firstName)) return 'All fields are required.';
        if(empty($lastName)) return 'All fields are required.';
        if(empty($email)) return 'All fields are required.';

        try{
            $stmt = $this->pdo->prepare('
            INSERT INTO `users` (`username`, `password`, `email`, `first_name`, `last_name`, `role`)
            VALUES (:username, :password, :email, :first_name, :last_name, "regular")');
            $stmt->bindValue(':username', $username);
            $stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':first_name', $firstName);
            $stmt->bindValue(':last_name', $lastName);
            $stmt->execute();
            return '';
        }
        catch(PDOException $e){
            return 'This username is already taken. Please choose another one.';
        }
    }
}