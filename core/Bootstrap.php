<?php
    namespace Engine;

    use Engine\request\Cors;
    use Engine\routers\Router;

    class Bootstrap
    {
        public function appRun ()
        {
            foreach (config()->get ('app.aliases') as $k => $v) {
                app()->set($k, $v)->createAlias($k, $k);
            }
            Cors::getCors();
            require 'app/routes/main.php';
            (new Router())->run();
        }
    }