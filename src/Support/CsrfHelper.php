<?php

namespace App\Support;

class CsrfHelper{
    public function handle(){
        $this->ensureSession();

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!empty($_POST['csrf_token'])
                && !empty($_SESSION['csrf_token'])
                && hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])){
                    return;
                }

            echo "Error: CSRF token mismatch";
            die();
        }
        
    }

    private function ensureSession(){
        if(session_id() === ''){
            session_start();
        }
    }

    public function generateToken(): string{
        if(empty($_SESSION['csrf_token'])){
            $token = bin2hex(random_bytes(32));
            $_SESSION['csrf_token'] = $token;
        }
        return $_SESSION['csrf_token'];
    }
}