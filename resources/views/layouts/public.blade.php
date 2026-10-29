<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'GoBarberShop')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}">
</head>
<body class="bg-light">
    <header class="bg-white border-bottom">
        <nav class="container py-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('home') }}" class="fw-bold fs-4 text-decoration-none text-dark">
                GoBarberShop
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline-primary">
                Login
            </a>
        </nav>
    </header>

    <main class="container py-4 py-md-5">
        @yield('content')
    </main>
</body>
</html>