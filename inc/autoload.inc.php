<?php

spl_autoload_register(function($class){
    $prefix = 'App\\';
    $prefixLen = strlen($prefix);
    if(strncmp($prefix, $class, $prefixLen) !== 0){
        return;
    }

    $relativeName = substr($class, $prefixLen);
    $fileName = __DIR__ . '/../src/' . $relativeName . '.php';
    $file = str_replace('\\', '/', $fileName);
    if(file_exists($file)){
        require $file;
    }
    else {
        echo "Autoloader failed for: $file\n";
    }

});