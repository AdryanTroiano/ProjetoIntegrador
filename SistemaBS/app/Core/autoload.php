<?php

spl_autoload_register(function ($class) {

    $pastas = [
        __DIR__ . '/../Controllers/',
        __DIR__ . '/../Models/',
        __DIR__ . '/../Middleware/',
        __DIR__ . '/'
    ];

    foreach ($pastas as $pasta) {
        $arquivo = $pasta . $class . '.php';

        if (file_exists($arquivo)) {
            require_once $arquivo;
            return;
        }
    }
});