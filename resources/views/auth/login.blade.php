@extends('layouts.app')
@section('content')
    <h1> Manager Login</h1>
    <form method="POST"
        action="{{ route('login.store') }}">
        @csrf
        <label>Email</label>
        <input type="email" name="email"
        maxlength="255"
        required
        value="{{ old('email') }}"><br>
        <label>Password</label><br>
        <input type="password" name="password"
        maxlength="255"
        required><br>
        @error('password')
            <p class="error">{{$message}}</p>

        @enderror
        <button type="submit">Login</button>
    </form>
@endsection