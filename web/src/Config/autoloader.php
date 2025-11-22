<?php

//Implémentations de l'autoloader

spl_autoload_register(function ($class_name) {
    // Gérer PHPMailer depuis le répertoire Utils
    if (strpos($class_name, 'PHPMailer\\PHPMailer') === 0) {
        $file = __DIR__ . '/../Utils/' . str_replace('\\', '/', $class_name) . '.php';
    } else {
        $file = __DIR__ . '/../' . str_replace('\\', '/', $class_name) . '.php';
    }
    
    if (file_exists($file)) {
        require_once $file;
    }
});

