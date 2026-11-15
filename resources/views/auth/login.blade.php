@extends('layouts.app')
@section('content')
    <div class="form-panel login-card">
        <h1>Manager Login</h1>
        <form method="POST" action="{{ route('login.store') }}">
            @csrf
            <label for="email">Email</label>
            <input
                type="email"
                id="email"
                name="email"
                maxlength="255"
                required
                autocomplete="email"
                value="{{ old('email') }}"
            >
            @error('email')
                <p class="error">{{ $message }}</p>
            @enderror

            <label for="password">Password</label>
            <input
                type="password"
                id="password"
                name="password"
                maxlength="255"
                required
                autocomplete="current-password"
            >
            @error('password')
                <p class="error">{{ $message }}</p>
            @enderror

            <button type="submit">Login</button>
        </form>
    </div>
@endsection
