@extends('layouts.app')

@section('content')
    <h1>Edit Book</h1>
    <form class="form-panel" method="POST"
        action="{{ route('books.update', $book) }}">
        @csrf
        @method('PUT')
        <label>Book Title</label>
        <input type="text" name="title"
        maxlength="150"
        required
        value="{{ $book->title }}"><br>
        @error('title')
            <p class="error">{{$message}}</p>
        @enderror

        <label>Book Author</label>
        <input type="text" name="author"
         maxlength="100"
        required
        value="{{ $book->author }}"><br>
         @error('author')
            <p class="error">{{$message}}</p>
        @enderror

        <label>Book Genre</label>
        <input type="text" name="genre"
         maxlength="50"
        required
        value="{{ $book->genre }}"><br>
        @error('genre')
            <p class="error">{{$message}}</p>
        @enderror

        <label>Book Cover</label>
        <input type="text" name="cover"
         maxlength="2048"
        value="{{ $book->cover }}"><br>
         @error('cover')
            <p class="error">{{$message}}</p>
        @enderror

        <button>Update Book</button>

    </form>
@endsection
