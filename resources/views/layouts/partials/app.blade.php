<!DOCTYPE html>
<html lang="id" class="h-full bg-zinc-50 text-zinc-900 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'GoBarber - Booking & Antrean Barbershop' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                    <svg class="size-3.5 text-zinc-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    </svg>
                    <span>Jakarta Selatan</span>
                </div>
            </div>

            <!-- Nav Links -->
            <nav class="hidden items-center gap-2 lg:flex">
                <a href="{{ route('shops.explore') }}" class="rounded-full bg-zinc-950 px-4 py-2 text-xs font-bold text-white transition">
                    Jelajah Barbershop
                </a>
                <a href="#" class="rounded-full px-3 py-2 text-xs font-medium text-zinc-600 hover:text-zinc-900">
                    Layanan & Promo
                </a>
                <a href="#" class="rounded-full px-3 py-2 text-xs font-medium text-zinc-600 hover:text-zinc-900">
                    Cek Reservasi
                </a>
                <a href="#" class="rounded-full px-3 py-2 text-xs font-medium text-zinc-600 hover:text-zinc-900">
                    Bantuan
                </a>
            </nav>

            <!-- Aksi Pengguna / Auth -->
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
    <footer class="mt-20 border-t border-zinc-200 bg-white pt-12 text-zinc-600">
        <div class="mx-auto max-w-7xl px-4 pb-12 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4 lg:grid-cols-5">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2 text-lg font-black text-zinc-950">
                        <span>💈</span> GoBarber
                    </div>
                    <p class="mt-3 max-w-sm text-xs leading-relaxed text-zinc-500">
                        Platform digital reservasi dan antrean potong rambut pria terpercaya di Indonesia.
                    </p>
                    <div class="mt-4">
                        <p class="text-[11px] font-bold uppercase tracking-wider text-zinc-400">Metode Pembayaran Resmi</p>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="rounded border border-zinc-200 px-2 py-0.5 text-xs font-bold text-zinc-700">QRIS</span>
                            <span class="rounded border border-zinc-200 px-2 py-0.5 text-xs font-bold text-zinc-700">GoPay</span>
                            <span class="rounded border border-zinc-200 px-2 py-0.5 text-xs font-bold text-zinc-700">OVO</span>
                            <span class="rounded border border-zinc-200 px-2 py-0.5 text-xs font-bold text-zinc-700">BCA VA</span>
                        </div>
                    </div>
                </div>
                <div>
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-zinc-900">Kategori Treatment</h4>
                    <ul class="mt-3 space-y-2 text-xs">
                        <li>Haircut & Styling Pria</li>
                        <li>Shaving & Beard Trim</li>
                        <li>Gentleman Creambath & Spa</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-zinc-900">Mitra & Jaringan</h4>
                    <ul class="mt-3 space-y-2 text-xs">
                        <li>Jakarta Selatan</li>
                        <li>Bandung Kota</li>
                        <li>Surabaya & Malang</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-extrabold uppercase tracking-wider text-zinc-900">Bantuan</h4>
                    <ul class="mt-3 space-y-2 text-xs">
                        <li>Pusat Bantuan</li>
                        <li>Syarat & Ketentuan</li>
                        <li>WhatsApp CS</li>
                    </ul>
                </div>
            </div>
            <div class="mt-12 border-t border-zinc-200 pt-6 text-center text-xs text-zinc-400">
                &copy; {{ date('Y') }} PT GoBarber Digital Nusantara. Hak Cipta Dilindungi.
            </div>
        </div>
    </footer>
</body>
</html>