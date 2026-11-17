<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <!-- Menyesuaikan tampilan dengan ukuran layar perangkat. -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login | GoBarberShop</title>

    <!-- Memuat Bootstrap untuk mengatur tata letak form login. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Memuat stylesheet AdminLTE lokal milik project. -->
    <link href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}" rel="stylesheet">
</head>

<body class="login-page bg-body-secondary">

    <!-- Kontainer utama halaman login. -->
    <div class="login-box" style="width: 360px; max-width: 92%;">

        <div class="card card-outline card-primary">

            <div class="card-header text-center">
                <h2 class="mb-0">
                    <b>Go</b>BarberShop
                </h2>

                <p class="text-secondary mb-0 mt-2">
                    Masuk ke akun GoBarberShop
                </p>
            </div>


            <div class="card-body">

                {{-- Notifikasi registrasi berhasil --}}
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Pesan kesalahan login --}}
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Form Login --}}
                <form action="{{ route('login.process') }}" method="POST">

                    @csrf

                    {{-- Email --}}
                    <div class="input-group mb-3">

                        <input type="email" name="email" class="form-control" placeholder="Email"
                            value="{{ old('email', session('registered_email')) }}" autocomplete="username" required
                            autofocus>

                    </div>

                    {{-- Password --}}
                    <div class="input-group mb-3">

                        <input type="password" name="password" class="form-control" placeholder="Password"
                            autocomplete="current-password" required>

                    </div>

                    {{-- Tombol Login --}}
                    <div class="d-grid">

                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>

                    </div>

                </form>

                <hr>

                {{-- Link Registrasi --}}
                <div class="text-center mb-3">

                    <span class="text-secondary">
                        Belum memiliki akun?
                    </span>

                    <a href="{{ route('register') }}" class="text-primary fw-semibold">

                        Daftar Sekarang

                    </a>

                </div>

                <hr>

                <small class="text-secondary">
                    Gunakan email dan password yang telah didaftarkan
                    untuk masuk ke GoBarberShop.
                </small>

            </div>

        </div>
    </div>

</body>

</html>
