<?php
namespace Engine\validate;


class Validator
{
    private
        $_errors = [],
        $_validate = [],
        $_rules;
    public function __construct()
    {
        $this->_validate = config()->get('validate');
    }

    public function fails ()
    {
        if (isset($this->_errors)) {
            return true;
        }
        return false;
    }
    public function make ($request, $rules)
    {
        foreach ($rules as $key => $value) {
            $keys = explode('.', $key);
            if (array_key_exists($keys[0], $request)) {
                $allRules = explode('|', $value);
                foreach ($allRules as $k) {
                    $moreParams = stristr($k, ':') ? explode(':', $k) : $k;
                    $this->callMethod($request[$keys[0]], $moreParams, $keys);
                }
            }
        }
    }

    public function callMethod ($data, $params, $key)
    {
        if (1 == count($params)) {
            call_user_func_array(
                [$this, $params], [$data, $key]
            );
        } else {
            call_user_func_array(
                [$this, $params[0]], [$data, $params[1], $key]
            );
        }
    }

    public function required ($data, $key)
    {
        if ($data === '') {
            $this->errorsSet($this->attribute($key), $this->_validate['required']);
        }
    }

    public function max ($data, $param, $key)
    {
        if (strlen($data) > $param) {
            $this->errorsSet($this->attribute($key), $this->_validate['min'] , $param);
        }
    }

    public function min ($data, $param, $key)
    {
        if (strlen($data) < $param) {
            $this->errorsSet($this->attribute($key), $this->_validate['min'] , $param);
        }
    }

    public function attribute ($key)
    {
        return count($key) > 1 ? $key[1] : $key[0];
    }

    public function errorsSet ($key, $value, $count = null)
    {
        $value = preg_replace('#(:attribute)#', $key, $value);
        $value = preg_replace('#(:min)|(:max)#', $count, $value);
        $this->_errors[] = $value;
    }

    public function messages ()
    {
        return $this->_errors;
    }
}