<?php
    return [
        "name" => "engine",
        "debug" => false,
        "db" => [
        	"host" => "localhost",
        	"dbname" => "test",
        	"user" => "root",
        	"password" => ""
        ],
        /**
         * middleware /app/Middleware
         */
        "middleware" => [
            "auth" => \App\Middleware\Auth::class,
        ],
        /**
         * Алиасы для автозагрузки кдлассов
         */
        'aliases'  => [
            'Router' => \Engine\Routers\Router::class,
            'Auth' => \Engine\Helpers\Auth::class,
        ],
        /**
         * Классы которые при стрте попадут в контейнер и их останется только вызвать
         * Ниже не синглтон. Для классов синглтон нужно вызывать метод registerSingleton()
         */
        "required" => [
            "Request" => \Engine\Request\Request::class,
            "View" => \Engine\View\View::class,
            "Redirect" => \Engine\Request\Redirect::class,
            "Response" => \Engine\Response\Response::class
        ]
    ];