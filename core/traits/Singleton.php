<?php
    namespace Engine\traits;

    trait Singleton {
        static private $instance = null;

        private function __construct() {}
        private function __clone() {}
        private function __wakeup() {}

        static public function getInstance() {
            if (self::$instance === null) {
                return self::$instance = new static();
            }
            return self::$instance;
        }
    }