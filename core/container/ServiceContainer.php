<?php
    namespace Engine\container;

    class ServiceContainer
    {
        private $bindings = [];
        private static $instance = null;

        private function __construct () {}

        public static function getInstance ()
        {
            if (is_null (self::$instance)) {
                return self::$instance = new self ();
            }
            return self::$instance;
        }

        /**
         * биндинг класса
         * @param $key
         * @param $object
         * @return $this
         */
        public function set ($key, $object)
        {
            if (! array_key_exists($key, $this->bindings)) {
                $this->bindings[$key] = compact('object');
            }
            return $this;
        }

        /**
         * вызов полученного класса
         * @param $key
         * @return mixed
         * @throws \Exception
         */
        public function buildClass ($key)
        {
            $object = null;
            if (array_key_exists($key, $this->bindings)) {
                return $this->create ($this->bindings[$key]['object']);
            }
            throw new \Exception("Ключa '{$key}' не существует");
        }

        /**
         * @param $object
         * @return mixed
         */
        public function create ($object)
        {
            return new $object;
        }

        /**
         * Подгрузка классов в автозагрузку
         * @param $key
         * @param $alias
         * @return bool
         * @throws \Exception
         */
        public function createAlias ($key, $alias)
        {
            if (array_key_exists($key, $this->bindings)) {
                return class_alias($this->bindings[$key]['object'], $alias);
            }
            throw new \Exception("Ключa '{$key}' не существует");
        }
    }