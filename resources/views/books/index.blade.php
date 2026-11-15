    @extends('layouts.app')

    @section('content')
        <section class="hero">
            <h1>Book Collection</h1>
            <p>Browse and manage <span>books</span> in our database.</p>
            <a href="#book-section"><img src="{{ asset('images/icons/down-arrow.svg') }}" alt="Down Arrow" ></a>
        </section>
        
        <section id="book-section">
            <div class="catalog-toolbar">
                @session('success')
                    <p class="success">{{ session('success') }}</p>
                @endsession

                <div class="catalog-header">
                    <div>
                        <h2 class="catalog-title">Explore Books</h2>
                        <p class="catalog-subtitle">Search by keyword or filter by genre, publisher, and title order</p>
                    </div>
                    @auth
                        <a class="button button-accent add-book-button" href="{{ route('books.create') }}">+ Add Book</a>
                    @endauth
                </div>

              
                <form method="GET" action="{{ route('books.index') }}#book-section" class="filter-container" role="search">
                    <div class="search-box">
                        <img src="{{ asset('images/icons/search.svg') }}" alt="Search" class="search-icon" width="18" height="18">
                        <input
                            type="search"
                            id="search-input"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search book or author..."
                            class="filter-control search-input"
                            autocomplete="off"
                        >
                        @if(request('search'))
                            <a href="{{ route('books.index', request()->except('search')) }}#book-section" class="search-clear" title="Clear search" aria-label="Clear search">
                                &times;
                            </a>
                        @endif
                    </div>

                    <div class="filter-grid">
                        <div class="filter-field">
                            <label for="sort-select">Sort By</label>
                            <div class="select-wrapper">
                                <select id="sort-select" name="sort" class="filter-control">
                                    <option value="">Default (Newest)</option>
                                    <option value="title_asc" @selected(request('sort') == 'title_asc')>Title: A to Z</option>
                                    <option value="title_desc" @selected(request('sort') == 'title_desc')>Title: Z to A</option>
                                </select>
                            </div>
                        </div>

                        <div class="filter-field">
                            <label for="genre-select">Genre</label>
                            <div class="select-wrapper">
                                <select id="genre-select" name="genre" class="filter-control">
                                    <option value="">All Genres</option>
                                    @foreach ($genres as $genre)
                                        <option value="{{ $genre }}" @selected(request('genre') == $genre)>
                                            {{ $genre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="filter-field">
                            <label for="publisher-select">Publishing House</label>
                            <div class="select-wrapper">
                                <select id="publisher-select" name="publisher_id" class="filter-control">
                                    <option value="">All Publishers</option>
                                    @foreach ($publishers as $publisher)
                                        <option value="{{ $publisher->id }}" @selected(request('publisher_id') == $publisher->id)>
                                            {{ $publisher->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="filter-actions">
                            <button type="submit" class="button button-accent">
                                <img src="{{ asset('images/icons/funnel.svg') }}" alt="" class="button-icon" width="16" height="16">
                                <span>Apply</span>
                            </button>
                            @if (request()->hasAny(['search', 'sort', 'genre', 'publisher_id']))
                                <a href="{{ route('books.index') }}#book-section" class="button button-secondary">Reset</a>
                            @endif
                        </div>
                    </div>

                    @if (request()->hasAny(['search', 'sort', 'genre', 'publisher_id']))
                        <div class="active-filters">
                            <span class="active-filters-label">Active filters:</span>
                            @if (request('search'))
                                <a href="{{ route('books.index', request()->except('search')) }}#book-section" class="filter-chip" title="Remove search filter">
                                    Search: "{{ request('search') }}"
                                    <span class="chip-remove">&times;</span>
                                </a>
                            @endif
                            @if (request('sort'))
                                <a href="{{ route('books.index', request()->except('sort')) }}#book-section" class="filter-chip" title="Remove sort filter">
                                    Sort: {{ request('sort') === 'title_asc' ? 'A to Z' : 'Z to A' }}
                                    <span class="chip-remove">&times;</span>
                                </a>
                            @endif
                            @if (request('genre'))
                                <a href="{{ route('books.index', request()->except('genre')) }}#book-section" class="filter-chip" title="Remove genre filter">
                                    Genre: {{ request('genre') }}
                                    <span class="chip-remove">&times;</span>
                                </a>
                            @endif
                            @if (request('publisher_id'))
                                @php
                                    $activePub = $publishers->firstWhere('id', request('publisher_id'));
                                @endphp
                                @if ($activePub)
                                    <a href="{{ route('books.index', request()->except('publisher_id')) }}#book-section" class="filter-chip" title="Remove publisher filter">
                                        Publisher: {{ $activePub->name }}
                                        <span class="chip-remove">&times;</span>
                                    </a>
                                @endif
                            @endif
                            <a href="{{ route('books.index') }}#book-section" class="filter-chip-clear">Clear all</a>
                        </div>
                    @endif
                </form>
            </div>

            <div class="book-grid" >
                @forelse ($books as $book)
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
                        <p class="card-author">by {{ $book->author }}</p>
                        <p>Published by: {{ $book->publisher->name ?? 'Unknown' }}</p>
                        @auth
                            <div class="card-actions-container">
                                <a class="button button-secondary" href="{{ route('books.edit', $book) }}">Edit Book</a>
                                <form action="{{ route('books.destroy',  $book) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button button-danger">Delete</button>
                                </form>
                            </div>
                        @endauth
                    </article>
                @empty
                    <p id="no-record">No records found.</p>
                @endforelse
                </div>
        </section>

        @if ($books->hasPages() || $books->total() > 0)
            <div class="pagination-container" role="navigation" aria-label="Pagination">
                <div class="pagination-col pagination-col-prev">
                    @if ($books->hasPages())
                        @if ($books->onFirstPage())
                            <span class="pagination-btn pagination-disabled" aria-disabled="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M15 18l-6-6 6-6"/>
                                </svg>
                                <span>Previous</span>
                            </span>
                        @else
                            <a class="pagination-btn pagination-btn-active" href="{{ $books->previousPageUrl() }}" rel="prev">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M15 18l-6-6 6-6"/>
                                </svg>
                                <span>Previous</span>
                            </a>
                        @endif
                    @endif
                </div>

                <div class="pagination-col pagination-col-info">
                    @if ($books->total() > 0)
                        <div class="pagination-info-wrapper">
    
                            <span class="pagination-counter">
                                Showing <strong>{{ $books->firstItem() }}&ndash;{{ $books->lastItem() }}</strong> of <strong>{{ $books->total() }}</strong> books
                            </span>
                        </div>
                    @endif
                </div>

                <div class="pagination-col pagination-col-next">
                    @if ($books->hasPages())
                        @if ($books->hasMorePages())
                            <a class="pagination-btn pagination-btn-active" href="{{ $books->nextPageUrl() }}" rel="next">
                                <span>Next</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M9 18l6-6-6-6"/>
                                </svg>
                            </a>
                        @else
                            <span class="pagination-btn pagination-disabled" aria-disabled="true">
                                <span>Next</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                    <path d="M9 18l6-6-6-6"/>
                                </svg>
                            </span>
                        @endif
                    @endif
                </div>
            </div>
        @endif

        <script src="{{ asset('js/app.js') }}"></script>
    @endsection


