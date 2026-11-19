
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard Owner') - GoBarberShop</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

    {{-- AdminLTE 4 --}}
    <link href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}"
          rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
          rel="stylesheet">

    @stack('styles')
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    {{-- ================= NAVBAR ================= --}}
    <nav class="app-header navbar navbar-expand bg-body shadow-sm">

        <div class="container-fluid">

            {{-- Tombol sidebar --}}
            <button class="btn btn-light"
                    type="button"
                    data-lte-toggle="sidebar"
                    aria-label="Buka atau tutup sidebar">
                <i class="bi bi-list fs-5"></i>
            </button>

            {{-- Informasi pengguna --}}
            <div class="ms-auto d-flex align-items-center gap-3">

                <span class="fw-semibold text-dark d-none d-sm-inline">
                    <i class="bi bi-shop me-1"></i>
                    GoBarberShop
                </span>

                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle"
                            type="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">

                        <i class="bi bi-person-circle me-1"></i>
                        {{ auth()->user()->name }}
                    </button>

                    <ul class="dropdown-menu dropdown-menu-end">

                        <li>
                            <span class="dropdown-item-text text-secondary">
                                Login sebagai Owner
                            </span>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf

                                <button type="submit"
                                        class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Logout
                                </button>
                            </form>
                        </li>

                    </ul>
                </div>

            </div>

        </div>
    </nav>


    {{-- ================= SIDEBAR ================= --}}
    <aside class="app-sidebar bg-dark shadow"
           data-bs-theme="dark">

        {{-- Logo / Brand --}}
        <div class="sidebar-brand">

            <a href="{{ route('client.dashboard') }}"
               class="brand-link text-decoration-none">

                <i class="bi bi-scissors fs-4 me-2"></i>

                <span class="brand-text fw-semibold">
                    GoBarberShop
                </span>

            </a>

        </div>


        <div class="sidebar-wrapper">

            {{-- Informasi Owner --}}
            <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center px-3">

                <div class="image">
                    <i class="bi bi-person-circle fs-2 text-white"></i>
                </div>

                <div class="info ms-2">

                    <span class="d-block text-white fw-semibold">
                        {{ auth()->user()->name }}
                    </span>

                    <small class="text-secondary">
                        Owner Barbershop
                    </small>

                </div>

            </div>


            {{-- Menu Navigasi --}}
            <nav class="mt-2">

                <ul class="nav sidebar-menu flex-column"
                    data-lte-toggle="treeview"
                    role="menu">

                    {{-- Dashboard --}}
                    <li class="nav-item">

                        <a href="{{ route('client.dashboard') }}"
                           class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">

                            <i class="nav-icon bi bi-speedometer2"></i>

                            <p>Dashboard</p>

                        </a>

                    </li>


                    {{-- Barbershop --}}
                    <li class="nav-item">

                        <a href="{{ route('owner.barbershop') }}"
                           class="nav-link {{ request()->routeIs('owner.barbershop') ? 'active' : '' }}">

                            <i class="nav-icon bi bi-shop"></i>

                            <p>Barbershop Saya</p>

                        </a>

                    </li>


{{-- Menu Data Barber --}}
<li class="nav-item">
    <a href="{{ route('owner.barber') }}"
       class="nav-link {{ request()->routeIs('owner.barber*') ? 'active' : '' }}">
        <i class="nav-icon bi bi-people"></i>
        <p>Data Barber</p>
    </a>
</li>

{{-- Menu Data Service --}}
<li class="nav-item">
    <a href="{{ route('owner.service') }}"
       class="nav-link {{ request()->routeIs('owner.service*') ? 'active' : '' }}">
        <i class="nav-icon bi bi-scissors"></i>
        <p>Data Service</p>
    </a>
</li>

                    {{-- Booking --}}
                    <li class="nav-item">

                        <a href="{{ route('owner.booking') }}"
                           class="nav-link {{ request()->routeIs('owner.booking') ? 'active' : '' }}">

                            <i class="nav-icon bi bi-calendar-check"></i>

                            <p>Booking</p>

                        </a>

                    </li>


                    {{-- Profil --}}
                    <li class="nav-item">

                        <a href="{{ route('owner.profil') }}"
                           class="nav-link {{ request()->routeIs('owner.profil') ? 'active' : '' }}">

                            <i class="nav-icon bi bi-person-circle"></i>

                            <p>Profil</p>

                        </a>

                    </li>


                    {{-- Logout --}}
                    <li class="nav-item mt-3">

                        <form action="{{ route('logout') }}" method="POST">

                            @csrf

                            <button type="submit"
                                    class="nav-link text-danger w-100 text-start border-0 bg-transparent">

                                <i class="nav-icon bi bi-box-arrow-right"></i>

                                <p>Logout</p>

                            </button>

                        </form>

                    </li>

                </ul>

            </nav>

        </div>

    </aside>


    {{-- ================= MAIN CONTENT ================= --}}
    <main class="app-main">

        {{-- Judul halaman --}}
        <div class="app-content-header">

            <div class="container-fluid">

                <div class="row">

                    <div class="col-sm-6">
                        <h3 class="mb-0">
                            @yield('page-heading', 'Dashboard Owner')
                        </h3>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end mb-0">

                            <li class="breadcrumb-item">
                                <a href="{{ route('client.dashboard') }}">
                                    Home
                                </a>
                            </li>

                            <li class="breadcrumb-item active">
                                @yield('breadcrumb', 'Dashboard')
                            </li>

                        </ol>
                    </div>

                </div>

            </div>

        </div>


        {{-- Isi halaman --}}
        <div class="app-content">

            <div class="container-fluid">

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show"
                         role="alert">

                        <i class="bi bi-check-circle me-2"></i>

                        {{ session('success') }}

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close">
                        </button>

                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show"
                         role="alert">

                        <i class="bi bi-exclamation-circle me-2"></i>

                        {{ session('error') }}

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert"
                                aria-label="Close">
                        </button>

                    </div>
                @endif

                @yield('content')

            </div>

        </div>

    </main>


    {{-- ================= FOOTER ================= --}}
    <footer class="app-footer">

        <div class="float-end d-none d-sm-inline">
            Sistem Informasi Layanan Barbershop
        </div>

        <strong>
            GoBarberShop &copy; {{ date('Y') }}
        </strong>

        <span class="text-secondary">
            All rights reserved.
        </span>

    </footer>

</div>


{{-- Bootstrap JavaScript --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

{{-- AdminLTE JavaScript --}}
<script src="{{ asset('vendor/adminlte/js/adminlte.min.js') }}"></script>

@stack('scripts')

</body>
</html>
