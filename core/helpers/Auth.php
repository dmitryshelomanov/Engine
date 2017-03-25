<?php
namespace Engine\helpers;

use App\Models\Users;

class Auth
{
    /**
     * Получение инфи о юзере
     * @return bool
     */
    public static function user ()
    {
        if (isset ($_SESSION['user'])) {
            return (new Users())->find(1);
        }
        return false;
    }

    /**
     * выход
     */
    public static function logout ()
    {
        unset($_SESSION['user']);
        return redirect('/');
    }

    /**
     * вход
     * @param $data
     * @return bool|\Engine\exception\ExceptionDB
     */
    public static function attempt ($data)
    {
        $user = new Users();
        $rs = $user->where('login', '=', $data['login'])
                   ->andWhere('password', '=', $data['password'])
                   ->get();
        if (count($rs) > 0) {
            $_SESSION['user'] = $rs;
            return redirect('/');
        }
        return redirect()->with('message', 'Не верный логин или пароль')->back();
    }

    /**
     * Проверка авторизован ли
     * @return bool
     */
    public static function check ()
    {
        if (isset ($_SESSION['user'])) {
            return true;
        }
        return false;
    }
}