<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     // return view('index');
//     return "Hello World!";
// });

// // Route::get('/books', function(){
// //     return "Books Page";
// // });


// for unauthenticated users (guest)
Route::middleware('guest')->group(function(){
    Route::get('/Login', [AuthController::class, 'loginForm'])
        ->name('login');
    Route::post('/Login', [AuthController::class, 'login'])
        ->name('login.store');
});

// for authenticated (logged in) users
Route::middleware('auth')->group(function(){
    Route::post('logout', [AuthController::class, 'logout'])
        ->name('logout');
    // new/add book form
    Route::get('/books/create', [BookController::class, 'create'])
        ->name('books.create');
    // edit
    Route::get('/books/{book}/edit/', [BookController::class, 'edit'])
        ->name('books.edit');
    
    // update book
    Route::put('/books/{book}', [BookController::class, 'update'])
        ->name('books.update');
    
    // page for displaying a single book
    Route::get('/books/{book}', [BookController::class, 'show'])
        ->name('books.show');
    
    // store new book
    Route::post('/books', [BookController::class, 'store'])
        ->name('books.store');
    
    // delete book 
    Route::delete('/books/{book}', [BookController::class, 'destroy'])
        ->name('books.destroy');
});

// public routes
Route::redirect('/', '/books');
// page for displaying individual books
Route::get('/books', [BookController::class, 'index'])
    ->name('books.index'); // optional name for the route
