<?php

namespace App\Controllers;
use App\Support\AuthService;
use App\Repository\SuggestionsRepository;

class SuggestionsAdminController extends AbstractController{
    public function __construct(AuthService $authService, public SuggestionsRepository $suggestionsRepository){
        parent::__construct($authService);
    }

    function showAdminPanel(){
        if(!$this->authService->isAdmin()){
            header('Location: index.php');
            die();
        }

        $suggestions = $this->suggestionsRepository->getAllSuggestions();

        $this->render('adminPanel', [
            'suggestions' => $suggestions
        ]);
    }

    public function edit(){
        if(!$this->authService->isAdmin()){
            header('Location: index.php');
            die();
        }
        if(empty($_GET['id'])) return;
        $id = @(int) ($_GET['id']);
        $suggestion = $this->suggestionsRepository->getSuggestion($id);

        if(!empty($_POST)){
                $title = $_POST['title'];
                $description = $_POST['description'];
                $status = $_POST['status'];
                if(!empty($title) && !empty($description) && !empty($status)){
                    $this->suggestionsRepository->editAdminSuggestion($id, $title, $description, $status);
                    header("Location: index.php?" . http_build_query(['route' => 'adminPanel']));
                    die();
                }
            }
            $this->render('adminEdit', [
                'suggestion' => $suggestion,
                'statusOptions' =>  ['new', 'approved', 'in_progress', 'completed', 'rejected']
            ]);
    }

    public function delete(){
        if(empty($_GET['id'])) return;
        $id = @(int) ($_GET['id']);
        $suggestion = $this->suggestionsRepository->getSuggestion($id);

        if(!empty($_POST)){
            if(isset($_POST['confirm']) && $_POST['confirm'] === 'yes'){
                $this->suggestionsRepository->deleteSuggestion($id);
            }
            header('Location: index.php?' . http_build_query(['route' => 'adminPanel']));
            die();
        }

        $this->render('delete', [
            "suggestion" => $suggestion
        ]);
    }

    public function comment(){
        $id = @(int) ($_GET['id']?? 1);
        if(!empty($_POST['comment'])){
            $this->suggestionsRepository->addComment($id);
            $commentInput = '';
        }else{
            ob_start();
            require __DIR__ . '/../../views/frontend/pages/comment.view.php';
            $commentInput = ob_get_clean();
        }
        $uId = @(int) ($_SESSION['userId'] ?? 0);
            $votedFor = $this->suggestionsRepository->getVotedFor($uId);
            $this->render('suggestion', [
                'commentInput' => $commentInput,
                's' => $this->suggestionsRepository->getSuggestion($id),
                'comments' =>  $this->suggestionsRepository->getComments($id),
                'isLoggedIn' => $this->authService->isLoggedIn(),
                'votedFor' => $votedFor,
                'isAdmin' => $this->authService->isAdmin()
            ]);
    }

}