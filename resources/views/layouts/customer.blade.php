
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GoBarber')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #171923;
            background: #f6f7f9;
        }
        a { color: inherit; text-decoration: none; }
        button, input, select { font: inherit; }
        .site-header {
            position: sticky; top: 0; z-index: 100;
            background: rgba(255,255,255,.97);
            border-bottom: 1px solid #e8e9ed;
        }
        .nav-wrap {
            max-width: 1440px; min-height: 76px; margin: auto;
            padding: 0 5%; display: flex; align-items: center; gap: 28px;
        }
        .brand { display:flex; align-items:center; gap:10px; font-size:22px; font-weight:800; white-space:nowrap; }
        .brand-icon {
            width:39px; height:39px; display:grid; place-items:center;
            background:#101828; color:white; border-radius:12px;
        }
        .nav-links { display:flex; align-items:center; gap:8px; margin-left:auto; }
        .nav-links a {
            padding:11px 15px; border-radius:30px; font-size:13px;
            font-weight:700; color:#596071; transition:.2s;
        }
        .nav-links a:hover, .nav-links a.active { background:#101828; color:white; }
        .btn {
            display:inline-flex; justify-content:center; align-items:center;
            border:0; border-radius:30px; padding:13px 22px;
            background:#101828; color:white; font-weight:700;
            cursor:pointer; transition:.2s;
        }
        .btn:hover { background:#344054; transform:translateY(-1px); }
        .btn-light { background:white; color:#101828; border:1px solid #e3e5e9; }
        .btn-light:hover { background:#f0f1f4; }
        .page-main { min-height:55vh; }
        .site-footer { background:#101828; color:white; margin-top:70px; }
        .footer-inner { max-width:1440px; margin:auto; padding:55px 5% 25px; }
        .footer-grid { display:grid; grid-template-columns:1.6fr 1fr 1fr 1fr; gap:35px; }
        .footer-grid h3 { font-size:14px; margin:0 0 18px; }
        .footer-grid p, .footer-grid li {
            color:#aab2c0; font-size:12px; line-height:2;
        }
        .footer-grid ul { list-style:none; padding:0; margin:0; }
        .footer-grid a:hover { color:white; }
        .footer-bottom {
            margin-top:35px; padding-top:20px; border-top:1px solid #344054;
            display:flex; justify-content:space-between; gap:15px;
            color:#aab2c0; font-size:11px;
        }
        .mobile-menu { display:none; }
        @media(max-width:900px) {
            .nav-wrap { flex-wrap:wrap; padding:14px 5%; gap:12px; }
            .nav-links { order:3; width:100%; overflow-x:auto; margin:0; }
            .nav-links a { white-space:nowrap; }
            .footer-grid { grid-template-columns:1fr 1fr; }
        }
        @media(max-width:560px) {
            .brand { font-size:19px; }
            .nav-wrap > .btn { margin-left:auto; padding:10px 14px; font-size:12px; }
            .nav-links { gap:2px; }
            .nav-links a { padding:9px 11px; font-size:11px; }
            .footer-grid { grid-template-columns:1fr; }
            .footer-bottom { flex-direction:column; }
        }
    </style>

    @stack('styles')
</head>
<body>

<header class="site-header">
    <div class="nav-wrap">
        <a href="{{ route('home') }}" class="brand">
            <span class="brand-icon">💈</span>
            GoBarber
        </a>

        <nav class="nav-links">
            <a href="{{ route('home') }}"
               class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>

            <a href="{{ route('shops.explore') }}"
               class="{{ request()->routeIs('shops.*') ? 'active' : '' }}">Jelajah Barbershop</a>

            <a href="{{ route('shops.explore') }}#kategori">Layanan &amp; Promo</a>
            <a href="{{ route('login') }}">Cek Reservasi</a>
            <a href="{{ route('login') }}">Bantuan</a>
        </nav>

        <a href="{{ route('login') }}" class="btn">Masuk / Daftar</a>
    </div>
</header>

<main class="page-main">
    @yield('content')
</main>

<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-grid">
            <div>
                <a href="{{ route('home') }}" class="brand">
                    <span class="brand-icon">💈</span> GoBarber
                </a>
                <p>Platform digital reservasi dan antrean potong rambut pria. Temukan barbershop terbaik, pilih layanan, dan reservasi dengan mudah.</p>
                <h3>Metode pembayaran digital</h3>
                <p>QRIS &nbsp; GoPay &nbsp; OVO &nbsp; BCA VA</p>
            </div>

            <div>
                <h3>Kategori Treatment</h3>
                <ul>
                    <li><a href="{{ route('shops.explore') }}">Gentlemen Haircut &amp; Wash</a></li>
                    <li><a href="{{ route('shops.explore') }}">Beard Trim &amp; Hot Towel</a></li>
                    <li><a href="{{ route('shops.explore') }}">Head Massage &amp; Creambath</a></li>
                    <li><a href="{{ route('shops.explore') }}">Hair Coloring</a></li>
                </ul>
            </div>

            <div>
                <h3>Mitra &amp; Jaringan</h3>
                <ul>
                    <li>Jakarta &amp; Tangerang</li>
                    <li>Bandung Kota</li>
                    <li>Surabaya &amp; Malang</li>
                    <li><a href="{{ route('login') }}">Daftar Jadi Mitra</a></li>
                </ul>
            </div>

            <div>
                <h3>Bantuan &amp; Kontak</h3>
                <ul>
                    <li><a href="{{ route('login') }}">Pusat Bantuan</a></li>
                    <li>Syarat &amp; Ketentuan Booking</li>
                    <li>Kebijakan Privasi</li>
                    <li>WhatsApp: 0812-8899-7700</li>
                    <li>support@gobarber.id</li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <span>© {{ date('Y') }} PT GoBarber Digital Nusantara. Hak Cipta Dilindungi.</span>
            <span>Unduh Aplikasi: &nbsp; Google Play &nbsp; | &nbsp; App Store</span>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>
