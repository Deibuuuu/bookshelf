<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     // return view('index');
//     return "Hello World!";
// });

// // Route::get('/books', function(){
// //     return "Books Page";
// // });

Route::redirect('/', '/books');

Route::get('/books', [BookController::class, 'index'])
    ->name('books.index'); // optional name for the route

// new/add book form
Route::get('/books/create', [BookController::class, 'create'])
    ->name('books.create');

Route::get('/books/{book}', [BookController::class, 'show'])
    ->name('books.show');

// store new book
Route::post('/books', [BookController::class, 'store'])
    ->name('books.store');
