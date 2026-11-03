@extends('layouts.app')

@section('content')
    <h1>Book Collection</h1>
    <p>Browse and manage books in our database</p>

    <a class="button" href="{{ route('books.create') }}">Add Book</a>
    @session('success')
        <p class='success'>{{ session('success') }}</p>
    @endsession
    <div class="book-grid">
        @foreach ($books as $book)
            {{-- <a href="{{ route('books.show', $book) }}"> --}}
            <a href="{{ url('books/' . $book->id) }}">
                <article class="card">
                    <span class="tag">{{ $book->genre }}</span>
                    <img src="{{ $book->cover }}">
                    <h2>{{$book->title}}</h2>
                    <p>by {{$book->author}}</p>
                </article>
            </a>
        @endforeach
    </div>
@endsection

