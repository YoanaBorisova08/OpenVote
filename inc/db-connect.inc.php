<?php
try{
    $pdo = new PDO('mysql:host=localhost;dbname=open_vote;charset=utf8mb4',
     'open_vote', 'u2P4]uevi-9A5vCx', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
}
catch(PDOException $e){
    echo 'A problem occured with the database connection.';
    die;
}

return $pdo;