<?php

namespace App\Models;

class User{
    public function __construct(
        public int $id,
        public string $username,
        public string $firstName, 
        public string $lastName, 
        public string $email, 
        public string $role,
        public string $password 
    ){}
}