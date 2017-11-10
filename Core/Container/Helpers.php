<?php
namespace Engine\Container;

class Helpers
{
    protected $bindings = [];

    public function get($name) {
        return new $this->bindings[$name];
    }

    public function hasBind($name) {
        if (isset($this->bindings[$name]))
            return true;
        return false;
    }
}