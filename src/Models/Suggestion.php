<?php

namespace App\Models;

class Suggestion{
    public function __construct(public int $id,
    public string $title,
    public string $description,
    public string $created_at,
    public string $updated_at,
    public string $status,
    public int $vote_count,
    public string $author){}
}