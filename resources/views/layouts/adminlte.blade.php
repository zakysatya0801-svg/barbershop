
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard') - GoBarberShop</title>

    <!-- Bootstrap 5 untuk grid, tombol, dan komponen layout. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- CSS utama AdminLTE. -->
    <link href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}"
          rel="stylesheet">

    <!-- Bootstrap Icons untuk ikon menu. -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
          rel="stylesheet">
</head>
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    <!-- Navbar bagian atas. -->
    <nav class="app-header navbar navbar-expand bg-body">
        <div class="container-fluid">
            <button class="btn btn-light" data-lte-toggle="sidebar" type="button"
                    aria-label="Buka atau tutup sidebar">
                <i class="bi bi-list"></i>
            </button>

            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="navbar-text fw-semibold">
                    GoBarberShop
                </span>

                <!-- Logout menggunakan POST agar sesi tidak berakhir melalui tautan GET. -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Sidebar navigasi. -->
    <aside class="app-sidebar bg-dark shadow" data-bs-theme="dark">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}"
               class="brand-link text-decoration-none">
                <img src="{{ asset('vendor/adminlte/assets/img/AdminLTELogo.png') }}"
                     alt="Logo AdminLTE"
                     class="brand-image opacity-75 shadow">
                <span class="brand-text fw-light">GoBarberShop</span>
            </a>
        </div>

        <div class="sidebar-wrapper">
            <nav class="mt-2">
                <ul class="nav sidebar-menu flex-column"
                    data-lte-toggle="treeview" role="menu">

                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link active">
                            <i class="nav-icon bi bi-speedometer2"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <!-- Menu sementara; halaman CRUD dibuat berikutnya. -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-shop"></i>
                            <p>Data Barbershop</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-person-badge"></i>
                            <p>Data Barber</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-scissors"></i>
                            <p>Layanan</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon bi bi-calendar-check"></i>
                            <p>Booking</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button
                                type="submit"
                                class="nav-link text-start w-100 border-0 bg-transparent text-danger"
                            >
                                <i class="nav-icon bi bi-box-arrow-right"></i>
                                <p>Logout</p>
                            </button>
                        </form>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <!-- Area konten halaman. -->
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <h3 class="mb-0">@yield('page-heading', 'Dashboard')</h3>
            </div>
        </div>

        <div class="app-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </main>

    <!-- Footer dashboard. -->
    <footer class="app-footer">
        <strong>GoBarberShop</strong> &copy; {{ date('Y') }}
        <span class="float-end">Sistem Informasi Layanan Barbershop</span>
    </footer>

</div>

<!-- Bootstrap dan JavaScript AdminLTE. -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('vendor/adminlte/js/adminlte.min.js') }}"></script>

</body>
</html>
