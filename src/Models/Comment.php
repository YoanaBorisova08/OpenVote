<?php

namespace App\Models;

class Comment{
    public function __construct(public int $id,
                                public string $author,
                                public int $suggestion_id,
                                public string $comment,
                                public string $created_at){}

}