<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Publisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        // Genre and publisher filter
        $genres = Book::whereNotNull('genre')->distinct()->orderBy('genre')->pluck('genre');
        $publishers = Publisher::orderBy('name')->get();

        $books = Book::with('publisher')
            // Search by title or author
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->input('search');
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%");
                });
            })
            // Filter by genre
            ->when($request->filled('genre'), function ($query) use ($request) {
                $query->where('genre', $request->input('genre'));
            })
            // Filter by publishing house
            ->when($request->filled('publisher_id'), function ($query) use ($request) {
                $query->where('publisher_id', $request->input('publisher_id'));
            })
            // Sort options
            ->when($request->filled('sort'), function ($query) use ($request) {
                match ($request->input('sort')) {
                    'title_asc' => $query->orderBy('title', 'asc'),
                    'title_desc' => $query->orderBy('title', 'desc'),
                    default => $query->orderBy('id', 'desc'),
                };
            }, function ($query) {
                $query->orderBy('id', 'desc');
            })
            ->paginate(6)
            ->withQueryString();

        return view('books.index', compact('books', 'genres', 'publishers'));
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
            'cover' => ['nullable', 'image',
                'mimes:jpeg,png,webp', 'max:2048'],
            'publisher_id' => ['nullable', 'exists:publishers,id'],
        ]);

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        }

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
            'cover' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'publisher_id' => ['nullable', 'exists:publishers,id'],
        ]);
        if ($request->hasFile('cover')) {

            if ($book->cover && Storage::disk('public')->exists($book->cover)) {
                Storage::disk('public')->delete($book->cover);
            }

            $validated['cover'] = $request->file('cover')->store('covers', 'public');
        } else {

            unset($validated['cover']);
        }
        $book->update($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Book updated successfully!');
    }

    public function destroy(Book $book)
    {
        if ($book->cover && Storage::disk('public')->exists($book->cover)) {
            Storage::disk('public')->delete($book->cover);
        }
        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Book deleted successfully');
    }
}
