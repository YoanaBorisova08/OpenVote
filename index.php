<?php

require __DIR__ . '/inc/all.inc.php';
$container = new App\Support\Container();
$container->bind('pdo', function(){
    $pdo = require __DIR__ . '/inc/db-connect.inc.php';
    return $pdo;
});
$container->bind('authService', function() use($container){
    $pdo = $container->get('pdo');
    $authService = new App\Support\AuthService($pdo);
    return $authService;
});
$container->bind('suggestionsRepository', function() use($container){
    $pdo = $container->get('pdo');
    $suggestionsRepository = new App\Repository\SuggestionsRepository($pdo);
    return $suggestionsRepository;
});
$container->bind('suggestionsController', function() use($container){
    $suggestionsRepository = $container->get('suggestionsRepository');
    $authService = $container->get('authService');
    $suggestionsController = new App\Controllers\SuggestionsController($authService, $suggestionsRepository);
    return $suggestionsController;
});
$container->bind('suggestionsUserController', function() use($container){
    $suggestionsRepository = $container->get('suggestionsRepository');
    $authService = $container->get('authService');
    $suggestionsUserController = new App\Controllers\SuggestionsUserController($authService, $suggestionsRepository);
    return $suggestionsUserController;
});
$container->bind('suggestionsAdminController', function() use($container){
    $suggestionsRepository = $container->get('suggestionsRepository');
    $authService = $container->get('authService');
    $suggestionsAdminController = new App\Controllers\SuggestionsAdminController($authService, $suggestionsRepository);
    return $suggestionsAdminController;
});
$container->bind('loginController', function() use($container){
    $authService = $container->get('authService');
    $loginController = new App\Controllers\LoginController($authService);
    return $loginController;
});
$container->bind('csrfHelper', function() {
    return new App\Support\CsrfHelper();
});

$csrfHelper = $container->get('csrfHelper');
$csrfHelper->handle();

function csrf_token(){
    global $container;
    $csrfHelper = $container->get('csrfHelper');
    return $csrfHelper->generateToken();
}

$route = (string) ($_GET['route'] ?? 'dashboard');

if($route === 'dashboard'){
    $suggestionsController = $container->get('suggestionsController');
    $suggestionsController->showDashboard();
}
elseif ($route === "forum"){
    $suggestionsController = $container->get('suggestionsController');
    $suggestionsController->showForum();
}
elseif($route === 'suggestion'){
    $suggestionsController = $container->get('suggestionsController');
    $suggestionsController->showSuggestion();
}
elseif ($route === 'login'){
    $loginController = $container->get('loginController');
    $loginController->login();
}
elseif ($route === 'logout'){
    $loginController = $container->get('loginController');
    $loginController->logout();
}
elseif ($route === 'register'){
    $loginController = $container->get('loginController');
    $loginController->register();
}
elseif ($route === 'create'){
    $suggestionsUserController = $container->get('suggestionsUserController');
    $suggestionsUserController->authService->ensureLoggedIn();
    $suggestionsUserController->create();
}
elseif ($route === 'edit'){
    $suggestionsUserController = $container->get('suggestionsUserController');
    $suggestionsUserController->authService->ensureLoggedIn();
    $suggestionsUserController->edit();
}
elseif ($route === 'delete'){
    $suggestionsUserController = $container->get('suggestionsUserController');
    $suggestionsUserController->authService->ensureLoggedIn();
    $suggestionsUserController->delete();
}
elseif ($route === 'profile'){
    $suggestionsUserController = $container->get('suggestionsUserController');
    $suggestionsUserController->authService->ensureLoggedIn();
    $suggestionsUserController->showProfile();
}
elseif ($route === 'adminPanel'){
    $suggestionsAdminController = $container->get('suggestionsAdminController');
    $suggestionsAdminController->authService->ensureLoggedIn();
    $suggestionsAdminController->showAdminPanel();
}
elseif ($route === 'adminEdit'){
    $suggestionsAdminController = $container->get('suggestionsAdminController');
    $suggestionsAdminController->authService->ensureLoggedIn();
    $suggestionsAdminController->edit();
}
elseif ($route === 'adminDelete'){
    $suggestionsAdminController = $container->get('suggestionsAdminController');
    $suggestionsAdminController->authService->ensureLoggedIn();
    $suggestionsAdminController->delete();
}
else if($route === 'addComment'){
    $suggestionsAdminController = $container->get('suggestionsAdminController');
    $suggestionsAdminController->authService->ensureLoggedIn();
    $suggestionsAdminController->comment();
}
else{
    var_dump("Error");
    die();
}
