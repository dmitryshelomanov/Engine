<?php
namespace Engine\request;

class Request
{
    /**
     * маг метод для получения переменных пост и гет
     * @param $name
     * @return string
     */
    public function __get($name)
    {
        return $this->input($name);
    }

    /**
     * какой метод пришел из поля _method
     * @return mixed
     */
    public function getRequestMethod ()
    {
        return $_POST['_method'];
    }

    /**
     * @return array
     */
    public function info ()
    {
       return [
           'path' =>  $_SERVER["REQUEST_URI"],
           'userAgent' =>  $_SERVER["HTTP_USER_AGENT"],
           'ip' => $_SERVER["REMOTE_ADDR"],
           'port' => $_SERVER["SERVER_PORT"],
           'signature' => $_SERVER["SERVER_SIGNATURE"],
           'accept' => $_SERVER["HTTP_ACCEPT"],
           'referer' => $_SERVER["HTTP_REFERER"],
       ];
    }

    public function method ()
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    /**
     * если аякс
     * @return bool
     */
    public function ajax ()
    {
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            return true;
        }
    }

    /**
     * получение переменно или пост или гет
     * @param $name
     * @return string
     */
    public function input ($name)
    {
        if (isset($_POST[$name])) {
            return trim($_POST[$name]);
        }
        if (isset($_GET[$name])) {
            return trim($_GET[$name]);
        }
        return false;
    }

    /**
     * проверка на существование
     * @param $name
     * @return bool
     */
    public function has ($name)
    {
        if (isset($_POST[$name])) {
            return true;
        }
        return false;
    }

    /**
     * получение всего массива пост и гет
     * @return mixed
     */
    public function all ()
    {
        foreach (array_merge($_POST, $_GET) as $k => &$v) {
            $data[$k] = trim($v);
        }
        return $data;
    }

    /**
     * получение файла
     * @param $name
     * @return mixed
     */
    public function file ($name)
    {
        return $_FILES[$name];
    }

    /**
     * проверка на существование
     * @param $name
     * @return bool
     */
    public function hasFile ($name)
    {
        if ($this->file($name)['name'] !== '' ) {
            return true;
        }
        return false;
    }

    /**
     * инфа о юзере
     * @return mixed
     */
    public function user ()
    {
        return  \Auth::user();
    }
}