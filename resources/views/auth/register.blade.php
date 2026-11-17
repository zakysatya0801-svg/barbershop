<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register | GoBarberShop</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}"
          rel="stylesheet">
</head>

<body class="login-page bg-body-secondary">

    <div class="login-box" style="width: 400px; max-width: 94%;">

        <div class="card card-outline card-primary">

            <div class="card-header text-center">

                <h2 class="mb-0">
                    <b>Go</b>BarberShop
                </h2>

                <p class="text-secondary mt-2 mb-0">
                    Buat akun GoBarberShop
                </p>

            </div>

            <div class="card-body">

                {{-- Menampilkan pesan kesalahan --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('register.process') }}"
                      method="POST">

                    @csrf

                    {{-- Nama --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Nama Lengkap
                        </label>

                        <input
                            type="text"
                            name="name"
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Masukkan nama lengkap"
                            value="{{ old('name') }}"
                            autocomplete="name"
                            required
                        >

                    </div>

                    {{-- Email --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Masukkan email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            required
                        >

                    </div>

                    {{-- Nomor HP --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Nomor HP
                        </label>

                        <input
                            type="tel"
                            name="phone"
                            class="form-control @error('phone') is-invalid @enderror"
                            placeholder="Masukkan nomor HP"
                            value="{{ old('phone') }}"
                            autocomplete="tel"
                            required
                        >

                    </div>

                    {{-- Password --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Password
                        </label>

                        <input
                            type="password"
                            name="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimal 8 karakter"
                            autocomplete="new-password"
                            required
                        >

                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="mb-3">

                        <label class="form-label">
                            Konfirmasi Password
                        </label>

                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Ulangi password"
                            autocomplete="new-password"
                            required
                        >

                    </div>

                    {{-- Tombol Registrasi --}}
                    <div class="d-grid">

                        <button type="submit"
                                class="btn btn-primary">

                            Buat Akun

                        </button>

                    </div>

                </form>

                <hr>

                <div class="text-center">

                    <span class="text-secondary">
                        Sudah memiliki akun?
                    </span>

                    <a href="{{ route('login') }}"
                       class="text-primary fw-semibold">

                        Login sekarang

                    </a>

                </div>

            </div>

        </div>

    </div>

</body>
</html>
