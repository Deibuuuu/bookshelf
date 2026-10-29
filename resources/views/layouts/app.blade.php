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
        <a href="{{ route('books.index') }}">Bookshelf</a>
    </header>

    <main class="container">
        @yield('content') {{-- placeholder --}}
    </main>

</body>
</html>