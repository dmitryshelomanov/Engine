<?php
    Router::get('/test/{id}', 'App\Controllers\IndexController@index');
    Router::post('/post', 'App\Controllers\IndexController@add');