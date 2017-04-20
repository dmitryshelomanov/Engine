<?php
namespace Engine\Request;

class Redirect
{
    /**
     * редирект на урл
     * @param $url
     * @return $this
     */
    public function redirect ($url)
    {
        if ($url) {
            header("location: {$url}");
        }
       return $this;
    }

    /**
     * заполнить сессию старыми переменными
     * @return $this
     */
    public function withInput ()
    {
        $_SESSION['old'] =  request()->all();
        return $this;
    }

    public function with($key, $message)
    {
        $_SESSION['message'][$key] = $message;
        return $this;
    }

    /**
     * редирект назад
     */
    public function back ()
    {
        header("location: " . request()->info()['referer']);
    }
}