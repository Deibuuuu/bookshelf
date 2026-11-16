@extends('layouts.app')

@section('content')
    <a class="button button-accent" href="{{ route('books.index') }}">Go back</a>
    <div class="show-panel">
        <span class="tag">{{ $book->genre }}</span>
        <div class="show-image-container">
            @if ($book->cover)
                <img src="{{ str_starts_with($book->cover, 'http') 
                    ? $book->cover 
                    : Storage::url($book->cover) }}" 
                    alt="{{ $book->title }}"
                    class="show-image">
            @else
                <div class="card-image-placeholder show-placeholder">No Cover Available</div>
            @endif
        </div>
       
        <h2>{{ $book->title }}</h2>
        <p>by {{ $book->author }}</p>
    </div>
@endsection

