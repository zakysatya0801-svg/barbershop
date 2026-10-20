<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard Owner') - GoBarberShop</title>

    {{-- Memuat CSS AdminLTE yang tersedia di public/vendor --}}
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/adminlte.min.css') }}">

    {{-- CSS tambahan agar dashboard tetap rapi tanpa Bootstrap terpisah --}}
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
            color: #343a40;
        }

        .app-navbar {
            height: 56px;
            padding: 16px 24px;
            background: #fff;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .app-sidebar {
            position: fixed;
            top: 56px;
            bottom: 0;
            left: 0;
            width: 240px;
            padding: 20px 12px;
            background: #343a40;
            color: white;
        }

        .app-brand {
            display: block;
            margin-bottom: 25px;
            color: white;
            font-size: 20px;
            font-weight: bold;
            text-decoration: none;
        }

        .app-owner {
            padding: 12px;
            margin-bottom: 15px;
            border-bottom: 1px solid #596168;
        }

        .app-menu {
            display: block;
            padding: 12px;
            margin-bottom: 6px;
            color: #c2c7d0;
            text-decoration: none;
            border-radius: 5px;
        }

        .app-menu:hover,
        .app-menu.active {
            color: white;
            background: #007bff;
        }

        .app-main {
            margin-left: 240px;
            padding: 24px;
        }

        .app-title {
            margin-bottom: 24px;
            font-size: 28px;
        }

        .app-cards {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .app-card {
            padding: 22px;
            color: white;
            border-radius: 6px;
            box-shadow: 0 2px 5px #00000015;
        }

        .app-card h2 {
            margin: 0 0 8px;
            font-size: 28px;
        }

        .app-info { background: #17a2b8; }
        .app-success { background: #28a745; }
        .app-warning { background: #ffc107; color: #343a40; }

        .app-panel {
            background: white;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            overflow: hidden;
        }

        .app-panel-title {
            padding: 16px 20px;
            border-bottom: 1px solid #dee2e6;
            font-weight: bold;
        }

        .app-table {
            width: 100%;
            border-collapse: collapse;
        }

        .app-table th,
        .app-table td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .app-table th { background: #f8f9fa; }
        .app-table tr:last-child td { border-bottom: none; }

        .app-logout {
            width: 100%;
            padding: 12px;
            color: #c2c7d0;
            text-align: left;
            background: transparent;
            border: 0;
            cursor: pointer;
            font-size: 15px;
        }

        .app-logout:hover {
            color: white;
            background: #dc3545;
            border-radius: 5px;
        }

        .app-footer {
            margin-left: 240px;
            padding: 18px 24px;
            background: white;
            border-top: 1px solid #dee2e6;
        }

        @media (max-width: 768px) {
            .app-sidebar {
                position: static;
                width: 100%;
            }

            .app-main,
            .app-footer {
                margin-left: 0;
            }

            .app-cards {
                grid-template-columns: 1fr;
            }

            .app-table {
                min-width: 650px;
            }

            .app-panel {
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>

    {{-- Navbar atas --}}
    <header class="app-navbar">
        <strong>GoBarberShop</strong>
        <span>{{ auth()->user()->name ?? 'Owner' }}</span>
    </header>

    {{-- Sidebar navigasi --}}
    <aside class="app-sidebar">
        <a href="{{ route('client.dashboard') }}" class="app-brand">
            GoBarberShop
        </a>

        <div class="app-owner">
            <small>LOGIN SEBAGAI OWNER</small>
            <div>{{ $owner->nama_owners ?? 'Owner' }}</div>
        </div>

        <a href="{{ route('client.dashboard') }}" class="app-menu active">
            Dashboard
        </a>

        <a href="#" class="app-menu">Barbershop</a>
        <a href="#" class="app-menu">Booking</a>
        <a href="#" class="app-menu">Barber</a>
        <a href="#" class="app-menu">Profil</a>

        {{-- Logout melalui route POST Laravel --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="app-logout">Logout</button>
        </form>
    </aside>

    {{-- Konten utama halaman --}}
    <main class="app-main">
        <h1 class="app-title">@yield('page-title', 'Dashboard')</h1>

        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="app-footer">
        <strong>GoBarberShop</strong> &copy; {{ date('Y') }}
        <span> — Dashboard Owner</span>
    </footer>

</body>
</html>