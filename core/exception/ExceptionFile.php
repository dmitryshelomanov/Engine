<?php
    namespace Engine\exception;


    class ExceptionFile
    {
        protected $alert = "Нету файла в каталоге путь resource/view/";
        public function __construct($path)
        {
            $this->alert .= isset($path[1]) ? $path[0] . '/' . $path[1] . '.php' : $path[0] . '.php';
            dd($this->alert);
        }
    }