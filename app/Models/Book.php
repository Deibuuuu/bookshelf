<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    // telling the actual name of our table
    // if hindi natin sinunod yung convention
    // protected $table = 'library_books';

    public $timestamps = false;
    // // mass assignment using create() or update()
    protected $fillable = [
        'title',
        'author',
        'genre',
        'cover'
    ];


}
