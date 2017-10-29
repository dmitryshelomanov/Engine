<?php
namespace Engine\Container;

use Engine\Container\Helpers;
use Engine\traits\Singleton;

class ServiceContainer extends Helpers
{
    use Singleton;

    public function register($name, $class)
    {
        if (empty($this->bindings[$name])) {
            $this->bindings[$name] = $class;
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