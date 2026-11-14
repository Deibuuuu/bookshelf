<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookshelf</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <header class="site-header">
        <a href="{{ route('books.index') }}" id="logo">Bookshelf</a>
        @guest
            <a href="{{ route('login') }}" id="button">Login</a>
        @endguest

        @auth
            <p>Hello, {{ auth()->user()->name }}</p>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button>Log out</button>
            </form>
        @endauth
    </header>

    <main class="container">
        @yield('content') {{-- placeholder --}}
    </main>

</body>
</html>