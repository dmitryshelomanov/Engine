<?php
    namespace Engine\config;

    class Repository
    {
        private $file = null;

        /**
         * загрузка файла
         * @param $file
         */
        public function load ($file)
        {
            if (file_exists(getenv("DOCUMENT_ROOT") . "/config/{$file}.php")) {
                $this->file = include(getenv("DOCUMENT_ROOT") . "/config/{$file}.php");
            }
        }

        /**
         * получение файла
         * @param $key
         * @return mixed
         * @throws \Exception
         */
        public function get ($key)
        {
            $path = explode('.', $key);
            if (count ($path) > 1) {
                $this->load ($path[0]);
                return $this->file[$path[1]];
            }
            $this->load ($path[0]);
            return $this->file;
        }
    }