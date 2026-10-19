
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoBarber - Pelanggan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <div>
            <h1>GoBarber</h1>
            <span>{{ $shop ?? 'Barbershop' }}</span>
        </div>
    </header>

    <main>
        {{ $slot ?? $content ?? '' }}
    </main>
</body>
</html>