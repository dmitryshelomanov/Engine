<?php
    /**
     * Получение инстана контейрера
     * @return \Engine\container\ServiceContainer|null
     */
    function app()
    {
        return Engine\Container\ServiceContainer::getInstance();
    }

    /**
     * получение конфигов
     * @return mixed
     */
    function config()
    {
            return app()->register('Config', Engine\Config\Repository::class)
                     ->make('Config');
    }

    /**
     * класс Redirect
     * @return mixed
     */
    function request()
    {
        return app()->make('Request');
    }

    /**
     * симфони дампер
     */
    function dd()
    {
        $args = func_get_args();
        call_user_func_array('dump', $args);
        die();
    }

    /**
     * класс View
     * @param $path
     * @param array $data
     * @return mixed
     */
    function view($path, $data = [])
    {
        return app()->make('View')
                     ->generate($path, $data);
    }

    /**
     * быстрый доступ к папке public
     * @param $param
     */
    function asset($param)
    {
        $path = "/resource/public/";
        echo $path . $param;
    }

    /**
     * класс Redirect
     * @param null $url
     * @return mixed
     */
    function redirect($url = null)
    {
        return app()->make('Redirect')
                     ->redirect($url);
    }

    /**
     * ьыстрое получение старого ввода из класса Flash
     * @param $key
     * @return mixed
     */
    function old($key)
    {
        return app()->register('Flash', \Engine\helpers\Flash::class)
                    ->make('Flash')
                    ->old($key);
    }
    /**
     * ьыстрое получение сообщение после редиректа
     * @param $key
     * @return mixed
     */
    function message($key)
    {
        return app()->register('Flash', \Engine\helpers\Flash::class)
                    ->make('Flash')
                    ->old($key);
    }

    /**
     * @param $key
     * @return bool
     */
    function has($key)
    {
        return app()->register('Flash', \Engine\helpers\Flash::class)
                    ->make('Flash')
                    ->has($key);
    }

    /**
     * @return mixed
     */
    function response()
    {
        return app()->make('Response');
    }