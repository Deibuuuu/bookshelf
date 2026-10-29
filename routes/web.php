<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;

// Route::get('/', function () {
//     // return view('index');
//     return "Hello World!";
// });

// // Route::get('/books', function(){
// //     return "Books Page";
// // });

Route::redirect('/', '/books');

Route::get('/books', [BookController::class, 'index'])
    ->name('books.index'); //optional name for the route