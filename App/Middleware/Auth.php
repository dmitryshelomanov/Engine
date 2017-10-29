<?php
namespace App\Middleware;

use Engine\Request\Request;
use App\Models\Users;

class Auth
{
    public function handle ()
    {
        $request = new Request();
        if ($request->user() === false) {

        }
    }
}