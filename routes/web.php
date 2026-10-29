<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('index');
    return "Hello World!";
});

Route::get('/books', function(){
    return "Books Page";
});