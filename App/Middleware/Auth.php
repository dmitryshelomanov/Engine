<?php
namespace App\Middleware;

use Engine\Request\Request;

class Auth
{
    public function handle ()
    {
        $request = new Request();
        if ($request->user() === false) {

        }
    }
}