<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        return view('books.index', compact('books'));
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],  // <-- Removed spaces after colons
            'author' => ['required', 'string', 'max:100'],
            'genre' => ['required', 'string', 'max:50'],
            'cover' => ['nullable', 'url', 'max:2048'],
        ]);

        Book::create($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Book created successfully!');
    }
}
