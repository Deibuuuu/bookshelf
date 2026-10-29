@extends('layouts.app')

@section('content')
    <span class="tag">{{ $book->genre }}</span>
    <img src="{{ $book->cover }}">
    <h2>{{$book->title}}</h2>
    <p>by {{$book->author}}</p>
@endsection

