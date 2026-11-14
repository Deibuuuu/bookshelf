    @extends('layouts.app')

    @section('content')
        <section class="hero">
            <h1>Book Collection</h1>
            <p>Browse and manage <span>books</span> in our database.</p>
            <a href="#book-section"><img src="{{ asset('images/icons/down-arrow.svg') }}" alt="Down Arrow" ></a>
        </section>
        
        <section>
            <nav>
                @auth
                    <a class="button" href="{{ route('books.create') }}">Add Book</a>
                @endauth
                @session('success')
                    <p class="success">{{ session('success') }}</p>
                @endsession  
                
                {{-- todo: filter and search box --}}
            </nav>

            <div class="book-grid" id="book-section">
                @foreach ($books as $book)
                    <article class="card">
                        <span class="tag">{{ $book->genre }}</span>
                        <a href="{{ route('books.show', $book) }}" class="card-image-link">
                            @if ($book->cover)
                                <img src="{{ str_starts_with($book->cover, 'http') 
                                    ? $book->cover
                                    : Storage::url($book->cover) }}" alt="{{ $book->title }}" class="card-image">
                            @else
                                <div class="card-image-placeholder">No Cover Available</div>
                            @endif
                        </a>
                        <h2 class="card-title">
                            <a href="{{ route('books.show', $book) }}">{{ $book->title }}</a>
                        </h2>
                        <p class="card-author">
                        <p>by {{ $book->author }}</p>
                        <p>Published by: {{ $book->publisher->name ?? 'Unknown' }}</p>
                        @auth
                        <div class="card-actions">
                            <a class="button button-secondary" href="{{ route('books.edit', $book) }}">Edit Book</a>
                        </div>
                        <form action="{{ route('books.destroy',  $book) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="button button-danger">Delete</button>
                        </form>
                        @endauth
                    </article>
                @endforeach
                </div>
        </section>
        @if ($books->total() > 0)
            <p>
                Showing {{ $books->firstItem() }} - {{ $books->lastItem() }}
                of {{ $books->total() }} books
            </p>
        @endif
        @if ($books->hasPages())
            <nav class="pagination">
                @if ($books->onFirstPage())
                    <span class="pagination-disabled">
                        Previous
                    </span>
                @else
                    <a class="button" href="{{ $books->previousPageUrl() }}">
                        Previous
                    </a>
                @endif
            </nav>
            
        @endif

        @if ($books->hasMorePages())
            <a class="button" href="{{ $books->nextPageUrl() }}">
                Next
            </a>
        @else
            <span class="pagination-disabled">
                Next
            </span>
        @endif
    @endsection


