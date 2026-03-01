<?php

namespace App\Controllers;
use App\Support\AuthService;

class AbstractController{
    public function __construct(public AuthService $authService){}

    public function render($view, $params){
        extract($params);
        ob_start();
        require __DIR__ . '/../../views/frontend/pages/' . $view . '.view.php';
        $content = ob_get_clean();
        $isLoggedIn = $this->authService->isLoggedIn();
        $isAdmin = $this->authService->isAdmin();
        require __DIR__ . '/../../views/frontend/layouts/main.view.php';
    }
}