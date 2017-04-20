<?php
namespace App\Controllers;

use Engine\Request\Redirect;
use Engine\Request\Request;

class IndexController
{
    public function __construct(Request $request, Redirect $redirect)
    {
        $this->request = $request;
        $this->redirect = $redirect;
    }

    public function show ()
    {

    }
}