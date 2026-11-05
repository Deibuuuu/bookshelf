<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    // use SoftDeletes;
    // add this if you want to enable soft deletes

    // telling the actual name of our table
    // if hindi natin sinunod yung convention
    // protected $table = 'library_books';

    public $timestamps = false;

    // // mass assignment using create() or update()
    protected $fillable = [
        'title',
        'author',
        'genre',
        'cover',
        'publisher_id',
    ];

    public function publisher(): BelongsTo 
    {
        return $this->belongsTo(Publisher::class);
    }
}
