
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoBarber - Portal Mitra</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div>
        <aside>
            <div>
                <h2>Mitra GoBarber</h2>
                <p>{{ $shop ?? 'Toko Saya' }}</p>
            </div>

            <nav>
                <a href="#">Dashboard</a>
                <a href="#">Layanan &amp; Harga</a>
                <a href="#">Jadwal Barber</a>
                <a href="#">Antrean &amp; Booking</a>
            </nav>
        </aside>

        <div>
            <header>
                <h1>{{ $header ?? 'Dashboard Pengelola' }}</h1>
                <div>Akses Portal Mitra</div>
            </header>

            <main>
                {{ $slot ?? $content ?? '' }}
            </main>
        </div>
    </div>
</body>
</html>