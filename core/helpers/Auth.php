<?php
namespace Engine\helpers;

use App\Models\Users;

class Auth
{
    /**
     * Получение инфи о юзере
     * @return bool
     */
    public function user ()
    {
        if (isset ($_SESSION['user'])) {
            return (new Users())->find(1);
        }
        return false;
    }

    /**
     * выход
     */
    public function logout ()
    {
        unset($_SESSION['user']);
    }

    /**
     * регистрация
     * @param $data
     * @return bool|\Engine\exception\ExceptionDB
     */
    public function attempt ($data)
    {
        return (new Users())->insert($data);
    }

    /**
     * Проверка авторизован ли
     * @return bool
     */
    public function check ()
    {
        if (isset ($_SESSION['user'])) {
            return true;
        }
        return false;
    }
}