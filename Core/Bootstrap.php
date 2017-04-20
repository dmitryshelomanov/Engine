<?php
    namespace Engine;

    use Engine\request\Cors;
    use Engine\routers\Router;

    class Bootstrap
    {
        public function appRun ()
        {
            $aliases = config()->get ('app.aliases');
            $required = config()->get ('app.required');

            foreach ($aliases as $alias => $class) {
                 app()->createAliases($alias, $class);
            }
            foreach ($required as $alias => $class) {
                app()->register($alias, $class);
            }
            require 'app/routes/main.php';
            (new Router())->run();
        }
    }