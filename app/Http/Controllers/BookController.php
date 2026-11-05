<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('publisher')->get();

        return view('books.index', compact('books'));
    }

    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    public function create()
    {
        $publishers = Publisher::all();

        return view('books.create', compact('publishers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'author' => ['required', 'string', 'max:100'],
            'genre' => ['required', 'string', 'max:50'],
            'cover' => ['nullable', 'url', 'max:2048'],
            'publisher_id' => ['nullable', 'exists:publishers,id'],
        ]);

        Book::create($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Book created successfully!');
    }

    public function edit(Book $book)
    {
        $publishers = Publisher::all();

        return view('books.edit', compact('book', 'publishers'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'author' => ['required', 'string', 'max:100'],
            'genre' => ['required', 'string', 'max:50'],
            'cover' => ['nullable', 'url', 'max:2048'],
            'publisher_id' => ['nullable', 'exists:publishers,id'],
        ]);

        $book->update($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Book deleted successfully');
    }
}
