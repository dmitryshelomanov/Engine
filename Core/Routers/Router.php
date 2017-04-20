<?php
namespace Engine\Routers;

class Router
{
    private $_currentUrl;
    private $_requestMethod;
    private static $_routes = [];
    private $_next = true;

    public function __construct ()
    {
        $this->_currentUrl = explode('?', $_SERVER["REQUEST_URI"])[0];
        $this->_requestMethod = $_SERVER['REQUEST_METHOD'];
    }
    public function requestMethod ()
    {
        return $this->_requestMethod;
    }

    public static function get(...$arguments)
    {
        self::addRoute('GET', $arguments);
    }

    public static function post(...$arguments)
    {
        self::addRoute('POST', $arguments);
    }

    public static function delete(...$arguments)
    {
        self::addRoute('DELETE', $arguments);
    }

    public static function put(...$arguments)
    {
        self::addRoute('PUT', $arguments);
    }

    public static function addRoute ($method, $arguments)
    {
        self::$_routes[] = [
            'method'     => $method,
            'url'        => $arguments[0],
            'call'       => $arguments[1],
            'middleware' => isset($arguments[2]) ? $arguments[2]['middleware'] : null
        ];
    }

    public function middleware ($name)
    {
        if (isset ($name)) {
            $middleware = config()->get('app.middleware')[$name];
            $this->_next = (new $middleware)->handle ();
        }
    }

    public function convert_url($pattern)
    {
        $pattern = preg_replace_callback('#\{[A-z0-9]+\}#', function ($match){
            if ($match[0] === '{id}') {
                return '([0-9]+)';
            } else if ($match[0] === '{string}') {
                return '([A-Za-z]+)';
            }

        }, $pattern);
        return "#^{$pattern}$#";
    }

    public function run ()
    {
        foreach (self::$_routes as $k => $v) {
            $pattern = $this->convert_url($v['url']);
            if (preg_match_all($pattern, $this->_currentUrl, $match, PREG_SET_ORDER)) {
                if ($this->requestMethod () === $v['method'] ||
                    request()->getRequestMethod () === $v['method']) {
                        $this->middleware($v['middleware']);
                        if ($this->_next === true) {
                            return $this->initRouter($match[0], $v['call']);
                        }
                }
                echo 'нету такого метода реквеста';
                break;
            }
        }
    }

    public function initRouter ($matches, $call)
    {
        array_shift($matches);
        if (is_callable($call)) {
            return call_user_func_array($call, $matches);
        }

        $string = explode('@',$call);
        $class = $string[0];
        $method = $string[1];

        if ( ! class_exists($class)) {
            throw new \Exception("Класс {$class} не найден");
        }
       if (!  method_exists($class, $method)) {
           throw new \Exception("Метод {$method} класса {$class} не найден");
       }

       $class = app()->register('Controller', $class)->make('Controller');
        call_user_func_array(array($class, $method), $matches);
    }

    public function notFount ()
    {

    }

    public function notRequestMethods ()
    {

    }
}
