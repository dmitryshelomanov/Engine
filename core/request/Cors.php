<?php
namespace Engine\request;

class Cors
{
    public static function getCors ()
    {
        header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Headers: Origin, Content-Type, X-Requested-With, XMLHttpRequest");
    }
}