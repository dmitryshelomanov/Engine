<?php
    namespace App\Controllers;

    use Engine\request\Request;
    use App\Models\Test;
    use Engine\validate\Validator;

    class IndexController
    {
        public function index($id)
        {
            return view('index');
        }
        public function add ()
        {
            $validator = new Validator();
            $validator->make((new Request())->all(), [
                'login' => 'required|min:6',
                'password' => 'required|min:6'
            ]);

            if ($validator->fails()) {
                redirect()->with('errors', $validator->messages())
                         ->withInput()
                         ->back();
            }
        }
    }