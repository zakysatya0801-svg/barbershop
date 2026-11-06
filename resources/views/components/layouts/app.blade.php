<!DOCTYPE html>
<html lang="id" class="h-full bg-zinc-50 text-zinc-900 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'GoBarber - Booking & Antrean Barbershop' }}</title>
    <script src="[suspicious link removed]"></script>
</head>
<body class="flex min-h-screen flex-col font-sans">
    <!-- Navbar Header GoBarber -->
    <header class="sticky top-0 z-30 border-b border-zinc-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-6">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-black tracking-tight text-zinc-950">
                    <span class="flex size-7 items-center justify-center rounded-full bg-zinc-950 text-white">💈</span>
                    GoBarber
                </a>

                <div class="hidden items-center gap-1 rounded-full border border-zinc-200 bg-zinc-50 px-3 py-1.5 text-xs font-semibold text-zinc-700 md:flex">
                    <span>Jakarta Selatan</span>
                </div>
            </div>

            <nav class="hidden items-center gap-2 lg:flex">
                <a href="{{ route('shops.explore') }}" class="rounded-full bg-zinc-950 px-4 py-2 text-xs font-bold text-white">
                    Jelajah Barbershop
                </a>
                <a href="#" class="rounded-full px-3 py-2 text-xs font-medium text-zinc-600 hover:text-zinc-900">
                    Layanan & Promo
                </a>
                <a href="#" class="rounded-full px-3 py-2 text-xs font-medium text-zinc-600 hover:text-zinc-900">
                    Bantuan
                </a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="rounded-full bg-zinc-950 px-4 py-2 text-xs font-bold text-white hover:bg-zinc-800">
                    Masuk / Daftar
                </a>
            </div>
        </div>
    </header>

    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Footer GoBarber -->
    <footer class="mt-20 border-t border-zinc-200 bg-white py-8 text-center text-xs text-zinc-400">
        &copy; {{ date('Y') }} PT GoBarber Digital Nusantara. Hak Cipta Dilindungi.
    </footer>
</body>
</html>