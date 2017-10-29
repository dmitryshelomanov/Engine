<?php
Router::get('/', "App\Controllers\IndexController@show");
Router::get('/users', "App\Controllers\IndexController@users");
Router::post('/create', "App\Controllers\IndexController@create");