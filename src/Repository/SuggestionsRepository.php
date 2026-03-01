<?php

namespace App\Repository;

use PDO;
use PDOException;
use App\Models\Suggestion;
use App\Models\Comment;
use App\Models\User;

class SuggestionsRepository{
    public function __construct(private PDO $pdo){}

    public function count($filter=''){
        $sql = 'SELECT COUNT(`id`) AS `count` FROM `suggestions`';
        if($filter!== ''){
            $sql= $sql . 'WHERE `status` = :status';
        }

        $stmt = $this->pdo->prepare($sql);
        if($filter!=='') $stmt->bindValue(':status', $filter);
        $stmt->execute();
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        return $count;
    }

    public function fromDbToObjComment(array $entry){
        return new Comment($entry['id'], $entry['author'], $entry['suggestion_id'], $entry['comment'], $entry['created_at']);
    }

    public function getComments(int $s_id){
        $admin_id = (int) ($_SESSION['user'] ?? 1);

        $stmt = $this->pdo->prepare('
        SELECT c.*, u.username AS `author`
        FROM `comments` AS c
        JOIN users AS u ON u.id = c.admin_id
        WHERE `admin_id`= :admin_id AND `suggestion_id`= :s_id;');        
        $stmt->bindValue(':admin_id', $admin_id, PDO::PARAM_INT);
        $stmt->bindValue(':s_id', $s_id, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if($results === false){
            return false;
        }
        $entries=[];
        foreach($results as $result){
            $entries[] = $this->fromDbToObjComment($result);
        }
        return $entries;
    }

    public function fromDBtoObjSuggestion(array $entry){
        return new Suggestion($entry['id'], $entry['title'], 
        $entry['description'], $entry['created_at'], $entry['updated_at'], $entry['status'], ($entry['vote_count'] ?? 0), ($entry['author'] ?? 'anonymous'));
    }

    public function getSuggestion(int $id){
        $stmt = $this->pdo->prepare(
            'SELECT 
                COUNT(v.id) AS vote_count,
                s.*,
                COALESCE(u.username, "anonymous") AS author
            FROM suggestions AS s
            LEFT JOIN votes AS v 
                ON s.id = v.suggestion_id
            LEFT JOIN users_suggestions AS us
                ON s.id = us.suggestion_id
            LEFT JOIN users AS u
                ON u.id = us.user_id
            WHERE s.id = :id
            GROUP BY s.id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $entrie = $stmt->fetch();
        if($entrie === false) {
            var_dump('Error. No suggestions with this id.');
            die;
        }
        return $this->fromDBtoObjSuggestion($entrie);
    }
    public function getAllSuggestions(){
        $stmt = $this->pdo->prepare(
            'SELECT 
                COUNT(v.id) AS vote_count,
                s.*,
                COALESCE(u.username, "anonymous") AS author
            FROM suggestions AS s
            LEFT JOIN votes AS v 
                ON s.id = v.suggestion_id
            LEFT JOIN users_suggestions AS us
                ON s.id = us.suggestion_id
            LEFT JOIN users AS u
                ON u.id = us.user_id
            GROUP BY s.id
            ORDER BY `updated_at` DESC');
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = [];
        foreach($entries as $entrie){
            $results[] = $this->fromDBtoObjSuggestion($entrie);
        }
        return $results;
    }

    public function getSuggestionsBySearch(string $search){
        $keywords=explode(' ', $search);
        $pattern = '%'. implode('%', $keywords) . '%';
        $stmt = $this->pdo->prepare(
            'SELECT 
                COUNT(v.id) AS vote_count,
                s.*,
                COALESCE(u.username, "anonymous") AS author
            FROM suggestions AS s
            LEFT JOIN votes AS v 
                ON s.id = v.suggestion_id
            LEFT JOIN users_suggestions AS us
                ON s.id = us.suggestion_id
            LEFT JOIN users AS u
                ON u.id = us.user_id
            WHERE `title` LIKE :pattern
            GROUP BY s.id ');
        $stmt->bindValue(':pattern', $pattern);
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = [];
        foreach($entries as $entrie){
            $results[] = $this->fromDBtoObjSuggestion($entrie);
        }
        if(empty($results)) return false;
        return $results;
    }

    public function getRecent(int $limit){
        $stmt = $this->pdo->prepare(
            'SELECT 
                COUNT(v.id) AS vote_count,
                s.*,
                COALESCE(u.username, "anonymous") AS author
            FROM suggestions AS s
            LEFT JOIN votes AS v 
                ON s.id = v.suggestion_id
            LEFT JOIN users_suggestions AS us
                ON s.id = us.suggestion_id
            LEFT JOIN users AS u
                ON u.id = us.user_id
            GROUP BY s.id
            ORDER BY `updated_at` DESC
            LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = [];
        foreach($entries as $entrie){
            $results[] = $this->fromDBtoObjSuggestion($entrie);
        }
        return $results;
    }

    public function getPopular(int $limit){
        $stmt = $this->pdo->prepare(
            'SELECT 
                COUNT(v.id) AS vote_count,
                s.*,
                COALESCE(u.username, "anonymous") AS author
            FROM suggestions AS s
            LEFT JOIN votes AS v 
                ON s.id = v.suggestion_id
            LEFT JOIN users_suggestions AS us
                ON s.id = us.suggestion_id
            LEFT JOIN users AS u
                ON u.id = us.user_id
            GROUP BY s.id
            ORDER BY vote_count DESC
            LIMIT :limit');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = [];
        foreach($entries as $entrie){
            $results[] = $this->fromDBtoObjSuggestion($entrie);
        }
        return $results;
    }

    public function getSortedByVote(int $page, int $perPage=3){
        $stmt = $this->pdo->prepare(
            'SELECT 
                COUNT(v.id) AS vote_count,
                s.*,
                COALESCE(u.username, "anonymous") AS author
            FROM suggestions AS s
            LEFT JOIN votes AS v 
                ON s.id = v.suggestion_id
            LEFT JOIN users_suggestions AS us
                ON s.id = us.suggestion_id
            LEFT JOIN users AS u
                ON u.id = us.user_id
            GROUP BY s.id
            ORDER BY vote_count DESC
            LIMIT :limit
            OFFSET :offset');
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', ($page-1) * $perPage, PDO::PARAM_INT);
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = [];
        foreach($entries as $entrie){
            $results[] = $this->fromDBtoObjSuggestion($entrie);
        }
        return $results;
    }

    public function getSortedByDate(int $page, int $perPage=3){
        $stmt = $this->pdo->prepare(
            'SELECT 
                COUNT(v.id) AS vote_count,
                s.*,
                COALESCE(u.username, "anonymous") AS author
            FROM suggestions AS s
            LEFT JOIN votes AS v 
                ON s.id = v.suggestion_id
            LEFT JOIN users_suggestions AS us
                ON s.id = us.suggestion_id
            LEFT JOIN users AS u
                ON u.id = us.user_id
            GROUP BY s.id
            ORDER BY `updated_at` DESC
            LIMIT :limit
            OFFSET :offset');
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', ($page-1) * $perPage, PDO::PARAM_INT);
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = [];
        foreach($entries as $entrie){
            $results[] = $this->fromDBtoObjSuggestion($entrie);
        }
        return $results;
    }

    public function getFilteredByStatus(string $filter, int $page, int $perPage=3){
        $stmt = $this->pdo->prepare(
            'SELECT 
                COUNT(v.id) AS vote_count,
                s.*,
                COALESCE(u.username, "anonymous") AS author
            FROM suggestions AS s
            LEFT JOIN votes AS v 
                ON s.id = v.suggestion_id
            LEFT JOIN users_suggestions AS us
                ON s.id = us.suggestion_id
            LEFT JOIN users AS u
                ON u.id = us.user_id
            WHERE `status` = :status
            GROUP BY s.id
            ORDER BY `updated_at` DESC
            LIMIT :limit
            OFFSET :offset');
        $stmt->bindValue(':status', $filter);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', ($page-1) * $perPage, PDO::PARAM_INT);
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = [];
        foreach($entries as $entrie){
            $results[] = $this->fromDBtoObjSuggestion($entrie);
        }
        return $results;
    }

    public function increaseVote(int $userId, int $suggestionId){
        try{
        $stmt = $this->pdo->prepare(
            'INSERT INTO votes (suggestion_id, user_id)
            VALUES (:suggestion_id, :user_id);');
        $stmt->bindValue(':suggestion_id', $suggestionId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        }
        catch (PDOException $e){
            var_dump("Error with increasing votes.");
            die;
        } 
    }

    public function decreaseVote(int $userId, int $suggestionId){
        try{
        $stmt = $this->pdo->prepare(
            'DELETE FROM votes
            WHERE suggestion_id = :suggestion_id
            AND user_id = :user_id;');
        $stmt->bindValue(':suggestion_id', $suggestionId, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        }
        catch(PDOException $e){
            var_dump("Error with decreasing votes.");
            var_dump($e);
            die;
        }
    }

    public function getVotedFor(int $userId) : array{
        $stmt = $this->pdo->prepare(
        'SELECT `suggestion_id` FROM `votes` 
        WHERE `user_id` = :id');
        $stmt->bindValue(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $votedFor = [];
        if(!empty($results)){
            foreach($results as $result){
                $votedFor[] = $result['suggestion_id'];
            }
        }
        return $votedFor;
    }

    public function createSuggestion(string $title, string $description, int $userId){
        $stmt = $this->pdo->prepare(
        'INSERT INTO `suggestions` (`title`, `description`, `status`)
        VALUES (:title, :description, "new")
        ');
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->execute();

        $suggestionId = $this->pdo->lastInsertId();

        $stmt2 = $this->pdo->prepare('
        INSERT INTO `users_suggestions`(`user_id`, `suggestion_id`)
        VALUES (:uId, :sId)');
        $stmt2->bindValue(':uId', $userId, PDO::PARAM_INT);
        $stmt2->bindValue(':sId', $suggestionId, PDO::PARAM_INT);
        $stmt2->execute();

    }
    public function editSuggestion(int $id, string $title, string $description){
        $stmt = $this->pdo->prepare(
        'UPDATE `suggestions` 
         SET `title` = :title,
         `description` = :description
         WHERE `id` = :id
        ');
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function editAdminSuggestion(int $id, string $title, string $description, string $status){
        $stmt = $this->pdo->prepare(
        'UPDATE `suggestions` 
         SET `title` = :title,
         `description` = :description,
         `status` = :status
         WHERE `id` = :id
        ');
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':status', $status);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteSuggestion(int $id){
        $stmt = $this->pdo->prepare(
        'DELETE FROM `suggestions` 
         WHERE `id` = :id
        ');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getSuggestionsFromUser($uId){
        $stmt = $this->pdo->prepare(
        'SELECT 
            COUNT(v.id) AS vote_count, 
            s.*, 
            COALESCE(u.username, "anonymous") AS author 
        FROM suggestions AS s 
        LEFT JOIN votes AS v ON s.id = v.suggestion_id 
        LEFT JOIN users_suggestions AS us ON s.id = us.suggestion_id 
        LEFT JOIN users AS u ON u.id = us.user_id 
        WHERE us.user_id = :uId
        GROUP BY s.id 
        ORDER BY `updated_at` DESC;');
        $stmt->bindValue(':uId', $uId, PDO::PARAM_INT);
        $stmt->execute();
        $entries = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $results = [];
        foreach($entries as $entrie){
            $results[] = $this->fromDBtoObjSuggestion($entrie);
        }
        return $results;
    }

    public function fromDbToObjectUser($entry){
        return new User($entry['id'], $entry['username'], $entry['first_name'], $entry['last_name'], ($entry['email'] ?? 'none'), $entry['role'], $entry['password']);
    }

    public function getUserById($id) : ?User{
        $stmt = $this->pdo->prepare('
        SELECT * FROM `users`
        WHERE `id` = :id');
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $entry = $stmt->fetch((PDO::FETCH_ASSOC));
        if($entry === false){
            return null;
        }
        return $this->fromDbToObjectUser($entry);
    }
    public function addComment(int $sId){
        $comment = @(string) $_POST['comment'];
        $uId = @(int) $_SESSION['userId'];

        $stmt = $this->pdo->prepare(
            'INSERT INTO `comments`(`comment`, `suggestion_id`, `admin_id`)
            VALUES (:comment, :sId, :uId)');
        $stmt->bindValue(':comment', $comment);
        $stmt->bindValue(':uId', $uId, PDO::PARAM_INT);
        $stmt->bindValue(':sId', $sId, PDO::PARAM_INT);
        $stmt->execute();
    }
}
