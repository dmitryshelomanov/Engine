<?php
namespace Engine\Container;

use Engine\Contracts\Container\IServiceContainer;

class ServiceContainer extends Helper implements IServiceContainer
{
    protected static $instance = null;

    protected function __construct(){}

    public static function getInstance ()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return  self::$instance;
    }

    public function register ($name, $class = '')
    {
        if ($this->bindings[$name]) {
            return $this;
        }
        if (!$class) {
            $this->setClassWithoutName($name, false);
        } else {
            $this->setClassWithName($name, $class, false);
        }
        return $this;
    }

    public function registerSingleton ($name, $class = '')
    {
        if ($this->bindings[$name]) {
            return $this;
        }
        if (!$class) {
            $this->setClassWithoutName($name, true);
        } else {
            $this->setClassWithName($name, $class, true);
        }
        return $this;
    }

    public function make($name)
    {
        if ($this->has($name)) {
            return $this->get($name);
        }
        return false;
    }

    public function has($name)
    {
        return $this->hasBind($name);
    }

    public function createAliases($alias, $class)
    {
        return class_alias($class, $alias);
    }
}