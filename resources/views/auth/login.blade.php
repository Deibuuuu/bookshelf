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

            <div class="form-group">
                <label for="password">Password</label>
                <div class="password-wrapper">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        maxlength="255"
                        required
                        autocomplete="current-password"
                    >
                    <button
                        type="button"
                        id="togglePassword"
                        class="password-toggle-btn"
                        aria-label="Toggle password visibility"
                        data-eye-open="{{ asset('images/icons/eye.svg') }}"
                        data-eye-closed="{{ asset('images/icons/eye-closed.svg') }}"
                    >
                        <img
                            id="eyeIcon"
                            src="{{ asset('images/icons/eye-closed.svg') }}"
                            alt="Show password"
                            class="eye-icon"
                            width="18"
                            height="18"
                        >
                    </button>
                </div>
            </div>

            <button type="submit">Login</button>
            @if ($errors->has('email') || $errors->has('password'))
                <p class="error">{{ $errors->first('email') ?: $errors->first('password') }}</p>
            @endif
        </form>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
@endsection
