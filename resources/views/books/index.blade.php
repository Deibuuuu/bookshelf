    @extends('layouts.app')

    @section('content')
        <section class="hero">
            <h1>Book Collection</h1>
            <p>Browse and manage <span>books</span> in our database.</p>
            <a href="#book-section"><img src="{{ asset('images/icons/down-arrow.svg') }}" alt="Down Arrow" ></a>
        </section>
        
        <section id="book-section">
            <nav>
                @auth
                    <a class="button" href="{{ route('books.create') }}">Add Book</a>
                @endauth

                @session('success')
                    <p class="success">{{ session('success') }}</p>
                @endsession  
                {{-- filter and search box --}}
                    <form method="GET" action="{{ route('books.index') }}" class="filter-bar">
                         @csrf 
                         <div class="search-filter-group">
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search book or author..."
                                class="filter-control"
                            >

                            <label for="">Book Title:</label>
                            <select name="sort" class="filter-control">
                                <option value="">Sort by</option>
                                <option value="title_asc" @selected(request('sort') == 'title_asc')>A-Z</option>
                                <option value="title_desc" @selected(request('sort') == 'title_desc')>Z-A</option>
                            </select>

                            <label>Genre:</label>
                            <select name="genre" class="filter-control">
                                <option value="">All Genres</option>
                                @foreach ($genres as $genre)
                                    <option value="{{ $genre }}" @selected(request('genre') == $genre )>
                                        {{ $genre }}
                                    </option>
                                @endforeach
                            </select>

                            <label>Publishing House:</label>
                            <select name="publisher_id" class="filter-control">
                                <option value="">All Publishers</option>
                                @foreach ($publishers as $publisher)
                                    <option value="{{ $publisher->id }}" @selected(request('publisher_id') == 
                                    $publisher->id )>
                                        {{ $publisher->name }}
                                    </option>
                                @endforeach
                            </select>

                            <div>
                                <button type="submit" class="button">Apply</button>
                                @if (request()->hasAny(['search','sort', 'genre', 'publisher_id']))
                                    <a href="{{ route('books.index') }}" class="button button-secondary">Reset</a>
                                @endif
                            </div>
                        </div>
                    </form>
            </nav>

            <div class="book-grid" >
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


