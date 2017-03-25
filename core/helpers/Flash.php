<?php
namespace Engine\helpers;

use Engine\traits\Singleton;

class Flash
{
    use Singleton;

    protected $_flash = [];
    protected $_messages = [];

    public function __construct()
    {
        $this->_flash = isset($_SESSION['old']) ? $_SESSION['old'] : null;
        $this->_messages = isset($_SESSION['message']) ? $_SESSION['message'] : null;
    }

    /**
     * Получение старой переменной
     * @param $key
     * @return flash
     */
    public function old ($key)
    {
        return $this->getFlash($key);
    }

    /**
     * получение сообщений по ключу
     * @param $key
     * @return mixed
     */
    public function message ($key)
    {
       if (isset($this->_messages[$key])) {
           return $this->_messages[$key];
       }
        return [];
    }

    /**
     * Проверка на ключь
     * @param $key
     * @return bool
     */
    public function has ($key)
    {
        if (isset($this->_messages[$key])) {
            return true;
        }
        return false;
    }

    /**
     * Возврат старой переменной
     * @param $key
     * @return mixed
     */
    public  function getFlash($key)
    {
        return $this->_flash[$key];
    }

    /**
     * Уничтожение сессии
     */
    public function __destruct()
    {
        if (isset($_SESSION['old'])) {
            unset($_SESSION['old']);
        }
        if (isset($_SESSION['message'])) {
            unset($_SESSION['message']);
        }
    }
}