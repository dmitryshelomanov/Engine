<?php
namespace Engine\view;

use Engine\exception\ExceptionFile;

class View
{
    protected $path = "/resource/view/";

    public function generate($path, $data = [])
    {
        $path = explode('.', $path);
        if (count($path) === 1) {
            if (file_exists("{$_SERVER['DOCUMENT_ROOT']}{$this->path}{$path[0]}.php")) {
                return require_once "{$_SERVER['DOCUMENT_ROOT']}{$this->path}{$path[0]}.php";
            }
        }
        if (file_exists("{$_SERVER['DOCUMENT_ROOT']}{$this->path}{$path[0]}/{$path[1]}.php")) {
            return require_once "{$_SERVER['DOCUMENT_ROOT']}{$this->path}{$path[0]}/{$path[1]}.php";
        }
        return new ExceptionFile ("Нету файла или каталога {$path[0]}/{$path[1]}");
    }
}