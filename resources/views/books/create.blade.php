    @extends('layouts.app')

    @section('content')
        <h1>Add New Book</h1>
        <form class="form-panel" method="POST"
            action="{{ route('books.store') }}">
            @csrf
            <label>Book Title</label>
            <input type="text" name="title"
            maxlength="150"
            required
            value="{{ old('title') }}"><br>
            @error('title')
                <p class="error">{{$message}}</p>
            @enderror

            <label>Book Author</label>
            <input type="text" name="author"
            maxlength="100"
            required
            value="{{ old('author') }}"><br>
            @error('author')
                <p class="error">{{$message}}</p>
            @enderror

            <label>Book Genre</label>
            <input type="text" name="genre"
            maxlength="50"
            required
            value="{{ old('genre') }}"><br>
            @error('genre')
                <p class="error">{{$message}}</p>
            @enderror

            <label>Book Cover</label>
            <input type="text" name="cover"
            maxlength="2048"
            value="{{ old('cover') }}"><br>
            @error('cover')
                <p class="error">{{$message}}</p>
            @enderror
            <label for="publisher">Publisher</label>
            <select name="publisher_id" id="publisher">
                <option value="">Select publisher</option>
                @foreach ($publishers as $publisher)
                    <option value="{{ $publisher->id }}"
                        {{ old('publisher_id') == $publisher->id ? 'selected' : '' }}>
                        {{ $publisher->name }}
                    </option>
                @endforeach
            </select>
            @error('publisher_id')
                <p class="error">{{ $message }}</p>
            @enderror
            <button>Add Book</button>

        </form>
    @endsection
