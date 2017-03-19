<?php
    /**
     * Получение инстана контейрера
     * @return \Engine\container\ServiceContainer|null
     */
    function app ()
    {
        return Engine\container\ServiceContainer::getInstance();
    }

    /**
     * получение конфигов
     * @return mixed
     */
    function config ()
    {
        return app ()->set ('config', Engine\config\Repository::class)->buildClass('config');
    }

    /**
     * класс Redirect
     * @return mixed
     */
    function request ()
    {
        return app ()->set ('request', Engine\request\Request::class)->buildClass('request');
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
    function view ($path, $data = [])
    {
        return app ()->set ('view', Engine\view\View::class)
                    ->buildClass('view')
                    ->generate($path, $data);
    }

    /**
     * быстрый доступ к папке public
     * @param $param
     */
    function asset ($param)
    {
        $path = "/resource/public/";
        echo $path . $param;
    }

    /**
     * класс Redirect
     * @param null $url
     * @return mixed
     */
    function redirect ($url = null)
    {
        return app ()->set ('redirect', Engine\request\Redirect::class)->buildClass('redirect')->redirect($url);
    }

    /**
     * ьыстрое получение старого ввода из класса Flash
     * @param $key
     * @return mixed
     */
    function old ($key)
    {
        return \Engine\helpers\Flash::getInstance()->old($key);
    }
    /**
     * ьыстрое получение сообщение после редиректа
     * @param $key
     * @return mixed
     */
    function message ($key)
    {
        return \Engine\helpers\Flash::getInstance()->message($key);
    }