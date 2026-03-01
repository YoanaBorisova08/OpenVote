<?php

namespace App\Controllers;
use App\Repository\SuggestionsRepository;
use App\Support\AuthService;

class SuggestionsController extends AbstractController{
    public function __construct(AuthService $authService, public SuggestionsRepository $suggestionsRepository){
        parent::__construct($authService);
    }

    public function updateVote(int $sId, array $votedFor){
            $uId = @(int) ($_SESSION['userId'] ?? 0);
            
            if(in_array($sId, $votedFor)){
                $this->suggestionsRepository->decreaseVote($uId, $sId);
            }
            else 
            {
                $this->suggestionsRepository->increaseVote($uId, $sId);
            }

            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        
    }
    
    public function showSuggestion(){
        $uId = @(int) ($_SESSION['userId'] ?? 0);
        $votedFor = $this->suggestionsRepository->getVotedFor($uId);
        if(isset($_POST['vote'])){
            $id = @(int) $_POST['vote'];
            $this->updateVote($id, $votedFor);

            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }

        $id = @(int) ($_GET['id']?? 1);
        $this->render('suggestion', [
            's' => $this->suggestionsRepository->getSuggestion($id),
            'comments' =>  $this->suggestionsRepository->getComments($id),
            'isLoggedIn' => $this->authService->isLoggedIn(),
            'votedFor' => $votedFor,
            'isAdmin' => $this->authService->isAdmin()
            ]);
    }

    public function showForum(){
        $uId = @(int) ($_SESSION['userId'] ?? 0);
        $votedFor = $this->suggestionsRepository->getVotedFor($uId);
        if(isset($_POST['vote'])){
            $id = @(int) $_POST['vote'];
            $this->updateVote($id, $votedFor);

            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }

        $page = (int) ($_GET['page'] ?? 1);
        $perPage = 3;

        $sortMethod = (string) ($_GET['sort'] ?? 'date');
        if($sortMethod === 'vote'){
            $suggestions = $this->suggestionsRepository->getSortedByVote($page, $perPage);
        }else{
            $suggestions = $this->suggestionsRepository->getSortedByDate($page, $perPage);
        }

        $statusOptions = ['new', 'approved', 'in_progress', 'completed', 'rejected'];
        $filterMethod = '';
        if(!empty($_GET['filter']) && in_array($_GET['filter'], $statusOptions)){
            $filterMethod = $_GET['filter'];
            $suggestions = $this->suggestionsRepository->getFilteredByStatus($filterMethod, $page, $perPage);
        }

        $this->render('forum', [
            'suggestions' => $suggestions,
            'sortMethod' => $sortMethod,
            'statusOP' => $statusOptions,
            'filterMethod' => $filterMethod,
            'pagesCount' => ceil($this->suggestionsRepository->count($filterMethod)/$perPage),
            'page' => $page,
            'isLoggedIn' => $this->authService->isLoggedIn(),
            'votedFor' => $votedFor
        ]);
    }

    public function showDashboard(){
        $uId = @(int) ($_SESSION['userId'] ?? 0);
        $votedFor = $this->suggestionsRepository->getVotedFor($uId);
        if(isset($_POST['vote'])){
            $id = $_POST['vote'];
            $this->updateVote($id, $votedFor);

            header('Location: ' . $_SERVER['REQUEST_URI']);
            exit;
        }

        $searchSuggestions = [];
        if(!empty($_GET['search'])){
            $searchSuggestions = $this->suggestionsRepository->getSuggestionsBySearch($_GET['search']);
        }

        $this->render('dashboard', [
            'popular_suggestions' => $this->suggestionsRepository->getPopular(3),
            'recent_suggestions' => $this->suggestionsRepository->getRecent(3),
            'searchSuggestions' => $searchSuggestions,
            'isLoggedIn' => $this->authService->isLoggedIn(),
            'votedFor' => $votedFor
        ]);
    }
}