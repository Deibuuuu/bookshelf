@extends('layouts.app')

@section('content')
    <h1>Book Collection</h1>
    <p>Browse and manage books in our database</p>

    <a class="button" href="{{ route('books.create') }}">Add Book</a>
    @session('success')
        <p class="success">{{ session('success') }}</p>
    @endsession
    <div class="book-grid">
        @foreach ($books as $book)
            <article class="card">
                <span class="tag">{{ $book->genre }}</span>
                <a href="{{ route('books.show', $book) }}" class="card-image-link">
                    @if ($book->cover)
                        <img src="{{ $book->cover }}" alt="{{ $book->title }}" class="card-image">
                    @else
                        <div class="card-image-placeholder">No Cover Available</div>
                    @endif
                </a>
                <h2 class="card-title">
                    <a href="{{ route('books.show', $book) }}">{{ $book->title }}</a>
                </h2>
                <p class="card-author">by {{ $book->author }}</p>
                <div class="card-actions">
                    <a class="button button-secondary" href="{{ route('books.edit', $book) }}">Edit Book</a>
                </div>
            </article>
        @endforeach
    </div>
@endsection


