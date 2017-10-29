<?php
namespace App\Controllers;
use App\Models\Users;
use Engine\Validate\Validator;
use Engine\ORM\Model;

class IndexController
{
    private $users;

    public function __construct()
    {
        $this->users = new Users();
    }

    public function show() {
        return view("index");
    }

    public function users() {
        $user = $this->users->paginate(2)->get();
        dd([
            "user" => $user,
            "prev" => $this->users->_prevPage,
            "next" => $this->users->_nextPage,
        ]);
    }

    public function create() {
        $this->users->insert([
            "name" => request()->name
        ]);
        return redirect()->back();
    }

}