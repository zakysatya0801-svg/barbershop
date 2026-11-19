
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoBarber - Temukan Barbershop Terbaik</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --dark: #17251f;
            --green: #1c7652;
            --lime: #d9f36a;
            --muted: #747d78;
            --light: #f7f8f5;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #fff;
            color: var(--dark);
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            width: min(1160px, 90%);
            margin: auto;
        }

        /* NAVBAR */
        .navbar {
            height: 82px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: white;
            position: sticky;
            top: 0;
            z-index: 100;
            border-bottom: 1px solid #eeeeea;
        }

        .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .logo {
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -1.5px;
        }

        .logo span {
            color: var(--green);
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 32px;
            font-size: 13px;
            font-weight: 600;
            color: #626b65;
        }

        .nav-menu a:hover {
            color: var(--green);
        }

        .nav-actions {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .btn-login {
            font-size: 13px;
            font-weight: 700;
            padding: 12px 18px;
        }

        .btn-register {
            background: var(--dark);
            color: white;
            padding: 13px 21px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
        }

        /* HERO */
        .hero {
            background: var(--light);
            padding: 75px 0 85px;
            overflow: hidden;
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            align-items: center;
            gap: 50px;
        }

        .hero-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #e9f2e9;
            color: var(--green);
            border-radius: 30px;
            padding: 9px 15px;
            font-size: 11px;
            font-weight: 800;
            margin-bottom: 25px;
            letter-spacing: .5px;
        }

        .hero h1 {
            font-size: clamp(38px, 5vw, 63px);
            line-height: 1.13;
            letter-spacing: -3px;
            font-weight: 800;
            max-width: 590px;
        }

        .hero h1 span {
            color: var(--green);
        }

        .hero-desc {
            color: var(--muted);
            font-size: 15px;
            line-height: 1.9;
            max-width: 490px;
            margin: 23px 0 30px;
        }

        .hero-buttons {
            display: flex;
            align-items: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: var(--green);
            color: white;
            padding: 16px 24px;
            border-radius: 11px;
            font-weight: 700;
            font-size: 13px;
            display: inline-block;
            transition: .2s;
        }

        .btn-primary:hover {
            background: #155b3e;
            transform: translateY(-2px);
        }

        .btn-secondary {
            border: 1px solid #dce1da;
            background: white;
            padding: 15px 22px;
            border-radius: 11px;
            font-size: 13px;
            font-weight: 700;
        }

        .hero-image {
            height: 420px;
            border-radius: 25px;
            overflow: hidden;
            position: relative;
            background: #26372d;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hero-floating {
            position: absolute;
            bottom: 22px;
            left: 22px;
            right: 22px;
            padding: 18px;
            background: rgba(255,255,255,.94);
            backdrop-filter: blur(10px);
            border-radius: 15px;
        }

        .hero-floating strong {
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
        }

        .hero-floating small {
            color: var(--muted);
            font-size: 11px;
        }

        /* SEARCH */
        .search-wrap {
            margin-top: -35px;
            position: relative;
            z-index: 5;
        }

        .search-box {
            background: white;
            border-radius: 16px;
            padding: 17px;
            box-shadow: 0 12px 40px rgba(22, 40, 29, .10);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .search-icon {
            width: 45px;
            height: 45px;
            background: #edf5ed;
            color: var(--green);
            display: grid;
            place-items: center;
            border-radius: 12px;
            font-size: 20px;
        }

        .search-text {
            flex: 1;
        }

        .search-text strong {
            display: block;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .search-text span {
            font-size: 11px;
            color: var(--muted);
        }

        .search-button {
            background: var(--dark);
            color: white;
            border: 0;
            border-radius: 10px;
            padding: 15px 25px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
        }

        /* SECTION */
        .section {
            padding: 85px 0;
        }

        .section-heading {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 32px;
        }

        .eyebrow {
            color: var(--green);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1.5px;
            margin-bottom: 12px;
        }

        .section-heading h2 {
            font-size: 32px;
            letter-spacing: -1.3px;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.8;
            margin-top: 9px;
        }

        .text-link {
            color: var(--green);
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        /* CATEGORY */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
        }

        .category-card {
            padding: 27px 20px;
            border: 1px solid #edf0eb;
            border-radius: 16px;
            transition: .2s;
        }

        .category-card:hover {
            border-color: var(--green);
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(0,0,0,.05);
        }

        .category-icon {
            width: 54px;
            height: 54px;
            background: #edf5ed;
            display: grid;
            place-items: center;
            border-radius: 15px;
            font-size: 25px;
            margin-bottom: 18px;
        }

        .category-card h3 {
            font-size: 14px;
            margin-bottom: 7px;
        }

        .category-card p {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.7;
        }

        /* WHY */
        .why-section {
            background: var(--dark);
            color: white;
            padding: 75px 0;
        }

        .why-section .eyebrow {
            color: var(--lime);
        }

        .why-section .section-heading p {
            color: #b9c4bd;
        }

        .why-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .why-card {
            padding: 27px;
            background: #23352c;
            border: 1px solid #34483c;
            border-radius: 16px;
        }

        .why-card .number {
            color: var(--lime);
            font-size: 12px;
            font-weight: 800;
            margin-bottom: 25px;
        }

        .why-card h3 {
            font-size: 17px;
            margin-bottom: 11px;
        }

        .why-card p {
            color: #b9c4bd;
            font-size: 12px;
            line-height: 1.9;
        }

        /* CTA */
        .cta {
            padding: 75px 0;
        }

        .cta-box {
            background: #eaf3e9;
            border-radius: 23px;
            padding: 55px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
        }

        .cta-box h2 {
            font-size: 31px;
            letter-spacing: -1px;
            max-width: 550px;
        }

        .cta-box p {
            font-size: 13px;
            color: var(--muted);
            margin-top: 12px;
            line-height: 1.8;
        }

        /* FOOTER */
        footer {
            background: #14221b;
            color: white;
            padding: 55px 0 25px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 50px;
            padding-bottom: 40px;
        }

        .footer-about p {
            max-width: 350px;
            color: #aebbb2;
            font-size: 12px;
            line-height: 1.9;
            margin-top: 15px;
        }

        .footer-col h4 {
            font-size: 13px;
            margin-bottom: 18px;
        }

        .footer-col a {
            display: block;
            color: #aebbb2;
            font-size: 12px;
            margin-bottom: 13px;
        }

        .footer-bottom {
            border-top: 1px solid #344239;
            padding-top: 22px;
            color: #aebbb2;
            font-size: 11px;
        }

        @media(max-width: 800px) {
            .nav-menu {
                display: none;
            }

            .hero {
                padding: 50px 0 70px;
            }

            .hero-grid {
                grid-template-columns: 1fr;
                gap: 35px;
            }

            .hero-image {
                height: 330px;
            }

            .category-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .why-grid {
                grid-template-columns: 1fr;
            }

            .cta-box {
                padding: 35px 25px;
                flex-direction: column;
                align-items: flex-start;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
            }

            .footer-about {
                grid-column: 1 / -1;
            }
        }

        @media(max-width: 480px) {
            .navbar {
                height: 70px;
            }

            .logo {
                font-size: 22px;
            }

            .btn-login {
                padding: 10px;
            }

            .btn-register {
                padding: 11px 13px;
                font-size: 11px;
            }

            .hero h1 {
                font-size: 42px;
                letter-spacing: -2px;
            }

            .hero-desc {
                font-size: 13px;
            }

            .hero-image {
                height: 270px;
            }

            .search-box {
                flex-wrap: wrap;
            }

            .search-button {
                width: 100%;
            }

            .section {
                padding: 60px 0;
            }

            .section-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .section-heading h2 {
                font-size: 26px;
            }

            .category-card {
                padding: 20px 15px;
            }

            .cta-box h2 {
                font-size: 25px;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 25px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="container nav-inner">
            <a href="{{ url('/') }}" class="logo">💈 Go<span>Barber.</span></a>

            <nav class="nav-menu">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ route('shops.explore') }}">Jelajah Barbershop</a>
                <a href="#layanan">Layanan</a>
                <a href="#tentang">Tentang Kami</a>
            </nav>

            <div class="nav-actions">
                <a href="{{ url('/login') }}" class="btn-login">Masuk</a>
                <a href="{{ route('shops.explore') }}" class="btn-register">Mulai Booking</a>
            </div>
        </div>
    </header>

    <!-- HERO -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <div class="hero-label">✦ PLATFORM BOOKING BARBERSHOP</div>

                <h1>
                    Tampil Lebih
                    <span>Percaya Diri</span>
                    Dimulai dari Sini.
                </h1>

                <p class="hero-desc">
                    Temukan barbershop terbaik di sekitarmu, pilih layanan
                    favorit, tentukan barber pilihan, dan booking jadwalmu
                    dengan lebih mudah melalui GoBarber.
                </p>

                <div class="hero-buttons">
                    <a href="{{ route('shops.explore') }}" class="btn-primary">
                        Jelajahi Barbershop →
                    </a>

                    <a href="#cara-booking" class="btn-secondary">
                        Cara Booking
                    </a>
                </div>
            </div>

            <div class="hero-image">
                <img
                    src="https://images.unsplash.com/photo-1503951914875-452162b0f3f1?auto=format&fit=crop&w=1000&q=85"
                    alt="Interior barbershop"
                >

                <div class="hero-floating">
                    <strong>Good Hair, Good Mood.</strong>
                    <small>Temukan pengalaman grooming terbaik bersama GoBarber.</small>
                </div>
            </div>
        </div>
    </section>

    <!-- SEARCH CTA -->
    <div class="container search-wrap">
        <div class="search-box">
            <div class="search-icon">⌕</div>

            <div class="search-text">
                <strong>Sedang mencari barbershop?</strong>
                <span>Temukan tempat potong rambut favoritmu.</span>
            </div>

            <a href="{{ route('shops.explore') }}" class="search-button">
                Cari Sekarang →
            </a>
        </div>
    </div>

    <!-- CATEGORY -->
    <section class="section" id="layanan">
        <div class="container">
            <div class="section-heading">
                <div>
                    <div class="eyebrow">PILIH GAYA FAVORITMU</div>
                    <h2>Layanan untuk Setiap Gaya</h2>
                    <p>Rawat penampilanmu dengan layanan grooming pilihan.</p>
                </div>

                <a href="{{ route('shops.explore') }}" class="text-link">
                    Lihat Barbershop →
                </a>
            </div>

            <div class="category-grid">
                <div class="category-card">
                    <div class="category-icon">✂️</div>
                    <h3>Haircut</h3>
                    <p>Potongan rambut sesuai gaya dan karakter kamu.</p>
                </div>

                <div class="category-card">
                    <div class="category-icon">🪒</div>
                    <h3>Shaving</h3>
                    <p>Perawatan jenggot dan kumis agar lebih rapi.</p>
                </div>

                <div class="category-card">
                    <div class="category-icon">💈</div>
                    <h3>Hair Styling</h3>
                    <p>Tata rambut untuk penampilan yang lebih maksimal.</p>
                </div>

                <div class="category-card">
                    <div class="category-icon">🧴</div>
                    <h3>Hair Treatment</h3>
                    <p>Perawatan rambut agar tetap sehat dan terawat.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CARA BOOKING -->
    <section class="why-section" id="cara-booking">
        <div class="container">
            <div class="section-heading">
                <div>
                    <div class="eyebrow">BOOKING TANPA RIBET</div>
                    <h2>Potong Rambut Jadi Lebih Mudah.</h2>
                    <p>Hanya dengan beberapa langkah, jadwal grooming-mu siap.</p>
                </div>
            </div>

            <div class="why-grid">
                <div class="why-card">
                    <div class="number">01 / TEMUKAN</div>
                    <h3>Pilih Barbershop</h3>
                    <p>Jelajahi berbagai barbershop dan temukan tempat yang paling sesuai dengan kebutuhanmu.</p>
                </div>

                <div class="why-card">
                    <div class="number">02 / TENTUKAN</div>
                    <h3>Pilih Layanan & Jadwal</h3>
                    <p>Tentukan layanan, barber favorit, tanggal, dan waktu booking yang kamu inginkan.</p>
                </div>

                <div class="why-card">
                    <div class="number">03 / SELESAI</div>
                    <h3>Konfirmasi Booking</h3>
                    <p>Lanjutkan proses pembayaran dan simpan informasi reservasi untuk kunjunganmu.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="cta" id="tentang">
        <div class="container">
            <div class="cta-box">
                <div>
                    <h2>Waktunya Upgrade Penampilanmu!</h2>
                    <p>
                        Jangan tunggu rambut berantakan. Temukan barbershop
                        pilihanmu dan atur jadwal grooming sekarang.
                    </p>
                </div>

                <a href="{{ route('shops.explore') }}" class="btn-primary">
                    Temukan Barbershop →
                </a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer>
        <div class="container">
            <div class="footer-grid">
                <div class="footer-about">
                    <a href="{{ url('/') }}" class="logo">💈 Go<span>Barber.</span></a>
                    <p>
                        GoBarber membantu kamu menemukan barbershop,
                        memilih layanan, dan melakukan reservasi dengan
                        lebih praktis dalam satu platform.
                    </p>
                </div>

                <div class="footer-col">
                    <h4>Navigasi</h4>
                    <a href="{{ url('/') }}">Home</a>
                    <a href="{{ route('shops.explore') }}">Jelajah Barbershop</a>
                    <a href="#layanan">Layanan</a>
                </div>

                <div class="footer-col">
                    <h4>Bantuan</h4>
                    <a href="#tentang">Tentang GoBarber</a>
                    <a href="{{ url('/login') }}">Masuk</a>
                    <a href="{{ route('shops.explore') }}">Mulai Booking</a>
                </div>
            </div>

            <div class="footer-bottom">
                © {{ date('Y') }} GoBarber. All rights reserved.
            </div>
        </div>
    </footer>

</body>
</html>
