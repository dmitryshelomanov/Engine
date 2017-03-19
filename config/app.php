<?php
    return [
        "name" => "engine",
        "db" => [
        	"host" => "localhost",
        	"dbname" => "lessonPHP",
        	"user" => "root",
        	"password" => ""
        ],
        /**
         * middleware /app/Middleware
         */
        "middleware" => [
            "auth" => App\Middleware\Auth::class
        ],
        /**
         * Алиасы для автозагрузки кдлассов
         */
        'aliases'  => [
            'Router' => \Engine\routers\Router::class,
            'Auth' => \Engine\helpers\Auth::class,
        ]
    ];