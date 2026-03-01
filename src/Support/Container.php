<?php

namespace App\Support;

class Container {
    private array $instancies = [];
    private array $recipes = [];

    public function bind($what, \Closure $recipe){
        $this->recipes[$what] = $recipe;
    }

    public function get($what){
        if(empty($this->instancies[$what])){
            if(empty($this->recipes[$what])){
                echo "Could not build {$what}.\n";
                die();
            }
            $this->instancies[$what] = $this->recipes[$what]();
            
        }
        return $this->instancies[$what];
    }

}