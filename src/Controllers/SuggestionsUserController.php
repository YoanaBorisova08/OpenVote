<?php

namespace App\Controllers;
use App\Support\AuthService;
use App\Repository\SuggestionsRepository;

class SuggestionsUserController extends AbstractController{
    public function __construct(AuthService $authService, public SuggestionsRepository $suggestionsRepository){
        parent::__construct($authService);
    }
    public function create(){
        if(!empty($_POST)){
            $title = @(string) ($_POST['title'] ?? '');
            $description = @(string) ($_POST['description'] ?? '');
            $userId = $_SESSION['userId'];

            if(!empty($title) && !empty($description)){
                $this->suggestionsRepository->createSuggestion($title, $description, $userId);
                header("Location: index.php");
                exit;
            }
        }

        $this->render('create', []);
    }

    public function edit(){
            if(empty($_GET['id'])) return;
            $id = @(int) ($_GET['id']);
            $suggestion = $this->suggestionsRepository->getSuggestion($id);
            $userId = $_SESSION['userId'];
            $user = $this->suggestionsRepository->getUserById($userId);
            if(empty($user) || ($user->username !== $suggestion->author)){
                header('Location: index.php');
                exit;
            }

            if(!empty($_POST)){
                $title = $_POST['title'];
                $description = $_POST['description'];
                if(!empty($title) && !empty($description)){
                    $this->suggestionsRepository->editSuggestion($id, $title, $description);
                    header("Location: index.php?" . http_build_query(['route' => 'profile']));
                    die();
                }
            }
            $this->render('edit', [
                'suggestion' => $suggestion
            ]);
    }

    public function delete(){
        if(empty($_GET['id'])) return;
        $id = @(int) ($_GET['id']);
        $suggestion = $this->suggestionsRepository->getSuggestion($id);

        $userId = $_SESSION['userId'];
        $user = $this->suggestionsRepository->getUserById($userId);
        if(empty($user) || ($user->username !== $suggestion->author)){
            header('Location: index.php');
            exit;
        }

        if(!empty($_POST)){
            if(isset($_POST['confirm']) && $_POST['confirm'] === 'yes'){
                $this->suggestionsRepository->deleteSuggestion($id);
            }
            header('Location: index.php?' . http_build_query(['route' => 'profile']));
            die();
        }

        $this->render('delete', [
            "suggestion" => $suggestion
        ]);
    }

    public function showProfile(){
        $userId = $_SESSION['userId'];
        $user = $this->suggestionsRepository->getUserById($userId);
        $suggestions = $this->suggestionsRepository->getSuggestionsFromUser($userId);

        $this->render('profile', [
            'user' => $user,
            'suggestions' => $suggestions
        ]);
    }
}