<?php
namespace App\Middleware;

use Engine\request\Request;

class Auth
{
    public function handle ()
    {
        $request = new Request();
        if ($request->user() === false) {
            dd('dfdf');
        }
    }
}