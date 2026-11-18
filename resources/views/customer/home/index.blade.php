
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoBarber - Booking Barbershop Premium</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --bg: #0d0f14;
            --surface: #151821;
            --surface-2: #1c202b;
            --orange: #f5a623;
            --orange-light: #ffc15a;
            --text: #f8f8fa;
            --muted: #a1a5b2;
            --border: rgba(255,255,255,.09);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button, input, select {
            font: inherit;
        }

        .container {
            width: min(1200px, 91%);
            margin: auto;
        }

        /* NAVBAR */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(13,15,20,.94);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid var(--border);
        }

        .nav-inner {
            min-height: 76px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 25px;
        }

        .logo {
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -1px;
            white-space: nowrap;
        }

        .logo span {
            color: var(--orange);
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .nav-menu a {
            font-size: 13px;
            color: #c5c7ce;
            transition: .2s;
        }

        .nav-menu a:hover {
            color: var(--orange);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .login-link {
            font-size: 13px;
            font-weight: 700;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border: 0;
            cursor: pointer;
            border-radius: 8px;
            padding: 12px 20px;
            font-size: 13px;
            font-weight: 800;
            transition: .25s;
        }

        .btn-orange {
            color: #171717;
            background: var(--orange);
        }

        .btn-orange:hover {
            background: var(--orange-light);
            transform: translateY(-2px);
        }

        .btn-dark {
            color: white;
            background: #080a10;
            border: 1px solid rgba(255,255,255,.12);
        }

        .btn-dark:hover {
            background: var(--orange);
            color: #171717;
        }

        .btn-outline {
            color: white;
            border: 1px solid rgba(255,255,255,.25);
            background: transparent;
        }

        .btn-outline:hover {
            border-color: var(--orange);
            color: var(--orange);
        }

        /* HERO */
        .hero {
            position: relative;
            padding: 75px 0 95px;
            background:
                radial-gradient(circle at 85% 35%, rgba(245,166,35,.13), transparent 32%),
                linear-gradient(135deg, #11141d, #0d0f14 65%);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr .9fr;
            align-items: center;
            gap: 65px;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--orange);
            background: rgba(245,166,35,.1);
            border: 1px solid rgba(245,166,35,.23);
            padding: 8px 13px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.2px;
            margin-bottom: 23px;
        }

        .hero h1 {
            font-size: clamp(38px, 5vw, 58px);
            line-height: 1.12;
            letter-spacing: -2px;
            font-weight: 800;
            margin-bottom: 20px;
        }

        .hero h1 span {
            color: var(--orange);
        }

        .hero-description {
            max-width: 540px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.9;
            margin-bottom: 28px;
        }

        .hero-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .hero-image-wrap {
            position: relative;
            padding: 12px 15px 25px 0;
        }

        .hero-image {
            width: 100%;
            height: 390px;
            object-fit: cover;
            border-radius: 18px;
            display: block;
            border: 1px solid rgba(255,255,255,.15);
            box-shadow: 0 25px 65px rgba(0,0,0,.4);
        }

        .rating-floating {
            position: absolute;
            top: 28px;
            right: 0;
            background: #090b11;
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 12px 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,.3);
        }

        .rating-floating strong {
            font-size: 14px;
        }

        .rating-floating i {
            color: var(--orange);
            font-size: 12px;
        }

        .rating-floating small {
            display: block;
            color: var(--muted);
            font-size: 9px;
            margin-top: 3px;
        }

        .queue-floating {
            position: absolute;
            left: -35px;
            bottom: 0;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            background: #1a1e28;
            border: 1px solid var(--border);
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0,0,0,.35);
        }

        .queue-icon {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            color: var(--orange);
            background: rgba(245,166,35,.12);
        }

        .queue-floating small {
            display: block;
            color: var(--orange);
            font-size: 9px;
            font-weight: 800;
            margin-bottom: 4px;
        }

        .queue-floating strong {
            font-size: 12px;
        }

        /* SEARCH BOX */
        .search-section {
            position: relative;
            z-index: 3;
            margin-top: -37px;
        }

        .search-box {
            display: grid;
            grid-template-columns: 1.15fr 1.15fr 1fr auto;
            gap: 10px;
            background: #1a1e28;
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 13px;
            box-shadow: 0 18px 45px rgba(0,0,0,.35);
        }

        .search-field {
            min-width: 0;
            display: flex;
            align-items: center;
            gap: 11px;
            background: #252a36;
            padding: 12px 14px;
            border-radius: 9px;
        }

        .search-field > i {
            color: var(--orange);
            font-size: 15px;
        }

        .search-field label {
            display: block;
            color: #9298a7;
            font-size: 9px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .search-field input,
        .search-field select {
            width: 100%;
            min-width: 0;
            color: white;
            background: transparent;
            border: 0;
            outline: 0;
            font-size: 11px;
        }

        .search-field input::placeholder {
            color: #d1d2d8;
        }

        .search-field select option {
            background: #1a1e28;
        }

        .search-submit {
            padding: 0 22px;
            white-space: nowrap;
        }

        /* SECTION GENERAL */
        .section {
            padding: 85px 0;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: end;
            gap: 20px;
            margin-bottom: 30px;
        }

        .section-kicker {
            display: block;
            color: var(--orange);
            font-size: 10px;
            letter-spacing: 1.5px;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 9px;
        }

        .section-heading h2 {
            font-size: clamp(24px, 3vw, 32px);
            letter-spacing: -.8px;
        }

        .section-heading p {
            color: var(--muted);
            font-size: 12px;
            margin-top: 8px;
        }

        .text-link {
            color: var(--orange);
            font-size: 12px;
            font-weight: 800;
            white-space: nowrap;
        }

        .text-link:hover {
            color: var(--orange-light);
        }

        /* POPULAR SHOPS */
        .popular-section {
            background: #11141b;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .shop-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .shop-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            overflow: hidden;
            transition: .25s;
        }

        .shop-card:hover {
            transform: translateY(-5px);
            border-color: rgba(245,166,35,.55);
            box-shadow: 0 15px 35px rgba(0,0,0,.25);
        }

        .shop-image-wrap {
            height: 205px;
            position: relative;
            overflow: hidden;
        }

        .shop-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: .4s;
        }

        .shop-card:hover .shop-image {
            transform: scale(1.05);
        }

        .open-badge {
            position: absolute;
            left: 12px;
            top: 12px;
            padding: 7px 10px;
            background: rgba(7,12,12,.88);
            color: #7de0a3;
            font-size: 9px;
            font-weight: 800;
            border-radius: 20px;
        }

        .rating-badge {
            position: absolute;
            right: 12px;
            top: 12px;
            padding: 7px 10px;
            background: #080a10;
            color: white;
            font-size: 10px;
            border-radius: 20px;
        }

        .rating-badge i {
            color: var(--orange);
        }

        .shop-info {
            padding: 19px;
        }

        .shop-title-row {
            display: flex;
            justify-content: space-between;
            align-items: start;
            gap: 8px;
            margin-bottom: 9px;
        }

        .shop-title-row h3 {
            font-size: 16px;
        }

        .city-badge {
            color: var(--orange);
            background: rgba(245,166,35,.1);
            padding: 5px 8px;
            border-radius: 20px;
            font-size: 9px;
            white-space: nowrap;
        }

        .shop-location {
            color: var(--muted);
            font-size: 10px;
            min-height: 30px;
            line-height: 1.6;
        }

        .shop-location i {
            color: var(--orange);
            margin-right: 5px;
        }

        .shop-bottom {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 10px;
            margin-top: 18px;
        }

        .shop-price small {
            display: block;
            color: var(--muted);
            font-size: 9px;
            margin-bottom: 3px;
        }

        .shop-price strong {
            font-size: 15px;
        }

        .shop-bottom .btn {
            padding: 10px 13px;
            font-size: 10px;
        }

        /* PROMO */
        .promo-section {
            padding: 65px 0;
        }

        .promo-box {
            position: relative;
            display: grid;
            grid-template-columns: 1.5fr .8fr;
            gap: 30px;
            align-items: center;
            padding: 45px;
            border-radius: 17px;
            overflow: hidden;
            background:
                radial-gradient(circle at 85% 20%, rgba(245,166,35,.2), transparent 35%),
                linear-gradient(110deg, #171b27, #080a10);
            border: 1px solid rgba(245,166,35,.2);
            box-shadow: 0 20px 45px rgba(0,0,0,.3);
        }

        .promo-label {
            display: inline-block;
            background: var(--orange);
            color: #171717;
            border-radius: 30px;
            padding: 7px 12px;
            font-size: 9px;
            font-weight: 800;
            margin-bottom: 17px;
        }

        .promo-content h2 {
            font-size: clamp(24px, 3vw, 34px);
            line-height: 1.25;
            margin-bottom: 13px;
        }

        .promo-content p {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
            max-width: 540px;
        }

        .voucher {
            display: inline-flex;
            gap: 12px;
            align-items: center;
            background: #252a36;
            border: 1px dashed rgba(245,166,35,.5);
            padding: 12px 15px;
            border-radius: 9px;
            margin-top: 20px;
            font-size: 11px;
        }

        .voucher strong {
            color: var(--orange);
            letter-spacing: 1px;
        }

        .promo-side {
            background: rgba(255,255,255,.07);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 25px;
            text-align: center;
        }

        .promo-side i {
            font-size: 28px;
            color: var(--orange);
            margin-bottom: 12px;
        }

        .promo-side h3 {
            font-size: 16px;
            margin-bottom: 8px;
        }

        .promo-side p {
            color: var(--muted);
            font-size: 10px;
            line-height: 1.7;
            margin-bottom: 17px;
        }

        /* HOW IT WORKS */
        .steps-section {
            background: #11141b;
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
        }

        .center-heading {
            text-align: center;
            margin: 0 auto 35px;
        }

        .center-heading p {
            max-width: 560px;
            margin: 10px auto 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .step-card {
            padding: 23px 20px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 13px;
            transition: .25s;
        }

        .step-card:hover {
            border-color: rgba(245,166,35,.45);
            transform: translateY(-4px);
        }

        .step-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 23px;
        }

        .step-number {
            color: rgba(245,166,35,.55);
            font-size: 27px;
            font-weight: 800;
        }

        .step-icon {
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            background: #252a36;
            border-radius: 9px;
            color: var(--orange);
        }

        .step-card h3 {
            font-size: 14px;
            margin-bottom: 9px;
        }

        .step-card p {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.8;
            min-height: 60px;
        }

        .step-note {
            display: block;
            color: var(--orange);
            font-size: 10px;
            font-weight: 700;
            margin-top: 15px;
        }

        /* CTA */
        .cta-section {
            padding: 80px 0;
        }

        .cta-box {
            max-width: 850px;
            margin: auto;
            text-align: center;
            padding: 55px 25px;
            background:
                radial-gradient(circle at 50% 0%, rgba(245,166,35,.12), transparent 60%),
                #191d27;
            border: 1px solid var(--border);
            border-radius: 17px;
        }

        .cta-box > i {
            color: var(--orange);
            font-size: 27px;
            margin-bottom: 18px;
        }

        .cta-box h2 {
            font-size: clamp(23px, 3vw, 30px);
            margin-bottom: 12px;
        }

        .cta-box p {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.8;
            margin: 0 auto 24px;
            max-width: 520px;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        /* FOOTER */
        .footer {
            background: #080a0f;
            border-top: 1px solid var(--border);
            padding: 48px 0 20px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr;
            gap: 35px;
            padding-bottom: 35px;
        }

        .footer-about p {
            max-width: 300px;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.9;
            margin-top: 14px;
        }

        .footer-col h4 {
            font-size: 12px;
            margin-bottom: 17px;
        }

        .footer-col a {
            display: block;
            color: var(--muted);
            font-size: 11px;
            margin-bottom: 12px;
            transition: .2s;
        }

        .footer-col a:hover {
            color: var(--orange);
        }

        .payment-list {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-top: 12px;
        }

        .payment-list span {
            background: #1d222d;
            color: #d6d8df;
            padding: 6px 9px;
            border-radius: 5px;
            font-size: 9px;
            font-weight: 700;
        }

        .footer-bottom {
            border-top: 1px solid var(--border);
            padding-top: 18px;
            display: flex;
            justify-content: space-between;
            gap: 15px;
            color: #777e8c;
            font-size: 10px;
        }

        /* RESPONSIVE TABLET */
        @media (max-width: 950px) {
            .nav-menu {
                gap: 16px;
            }

            .hero-grid {
                gap: 35px;
            }

            .hero-image {
                height: 340px;
            }

            .search-box {
                grid-template-columns: 1fr 1fr;
            }

            .search-submit {
                min-height: 48px;
            }

            .steps-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* RESPONSIVE MOBILE */
        @media (max-width: 650px) {
            .nav-inner {
                min-height: auto;
                padding: 16px 0;
                flex-wrap: wrap;
            }

            .nav-menu {
                order: 3;
                width: 100%;
                overflow-x: auto;
                padding: 8px 0 2px;
                gap: 22px;
            }

            .nav-menu a {
                white-space: nowrap;
                font-size: 11px;
            }

            .nav-actions {
                margin-left: auto;
            }

            .login-link {
                font-size: 11px;
            }

            .nav-actions .btn {
                padding: 9px 12px;
                font-size: 10px;
            }

            .hero {
                padding: 55px 0 65px;
            }

            .hero-grid {
                grid-template-columns: 1fr;
                gap: 38px;
            }

            .hero h1 {
                font-size: 42px;
            }

            .hero-description {
                font-size: 12px;
            }

            .hero-image-wrap {
                padding: 0 5px 22px 0;
            }

            .hero-image {
                height: 290px;
            }

            .queue-floating {
                left: 5px;
                padding: 10px 12px;
            }

            .rating-floating {
                right: 0;
                top: 12px;
            }

            .search-section {
                margin-top: -25px;
            }

            .search-box {
                grid-template-columns: 1fr;
                padding: 10px;
            }

            .search-submit {
                min-height: 45px;
            }

            .section {
                padding: 60px 0;
            }

            .section-heading {
                align-items: flex-start;
                flex-direction: column;
            }

            .section-heading h2 {
                font-size: 25px;
            }

            .shop-grid {
                grid-template-columns: 1fr;
            }

            .shop-image-wrap {
                height: 220px;
            }

            .promo-box {
                grid-template-columns: 1fr;
                padding: 27px 22px;
            }

            .promo-content h2 {
                font-size: 25px;
            }

            .steps-grid {
                grid-template-columns: 1fr;
            }

            .step-card p {
                min-height: auto;
            }

            .cta-section {
                padding: 55px 0;
            }

            .cta-box {
                padding: 40px 20px;
            }

            .footer-grid {
                grid-template-columns: 1fr 1fr;
                gap: 28px 18px;
            }

            .footer-about {
                grid-column: 1 / -1;
            }

            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 380px) {
            .hero h1 {
                font-size: 35px;
            }

            .hero-buttons .btn {
                width: 100%;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .footer-about {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <header class="navbar">
        <div class="container nav-inner">

            <a href="{{ url('/') }}" class="logo">
                Go<span>Barber.</span>
            </a>

            <nav class="nav-menu">
                <a href="{{ url('/') }}">Home</a>
                <a href="{{ route('shops.explore') }}">Jelajah Barbershop</a>
                <a href="#barbershop">Barbershop Populer</a>
                <a href="#cara-kerja">Cara Booking</a>
            </nav>

            <div class="nav-actions">
                <a href="{{ url('/login') }}" class="login-link">Masuk</a>
                <a href="{{ route('shops.explore') }}" class="btn btn-orange">
                    Booking Sekarang
                </a>
            </div>

        </div>
    </header>


    <!-- HERO -->
    <section class="hero">
        <div class="container hero-grid">

            <div class="hero-content">

                <div class="eyebrow">
                    <i class="fas fa-circle" style="font-size:6px"></i>
                    SOLUSI RESERVASI GROOMING #1 INDONESIA
                </div>

                <h1>
                    Booking Barbershop Premium
                    <span>Tanpa Perlu Antre</span>
                </h1>

                <p class="hero-description">
                    Pilih barbershop terbaik di sekitarmu, tentukan kapster favorit,
                    pilih jam sesuai agendamu, dan lakukan reservasi dengan mudah
                    melalui GoBarber.
                </p>

                <div class="hero-buttons">
                    <a href="{{ route('shops.explore') }}" class="btn btn-orange">
                        <i class="fas fa-search"></i>
                        Cari Barbershop
                    </a>

                    <a href="#cara-kerja" class="btn btn-outline">
                        Pelajari Cara Booking
                    </a>
                </div>

            </div>

            <div class="hero-image-wrap">

                <img
                    class="hero-image"
                    src="https://images.unsplash.com/photo-1503951914875-452162b0f3f1?auto=format&fit=crop&w=1100&q=90"
                    alt="Barber profesional sedang memotong rambut"
                >

                <div class="rating-floating">
                    <strong><i class="fas fa-star"></i> 4.9 / 5.0</strong>
                    <small>Barbershop pilihan pelanggan</small>
                </div>

                <div class="queue-floating">
                    <div class="queue-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div>
                        <small>RESERVASI ONLINE</small>
                        <strong>Jadwalkan kunjunganmu</strong>
                    </div>
                </div>

            </div>

        </div>
    </section>


    <!-- SEARCH RESERVATION -->
    <section class="search-section">
        <div class="container">

            <form action="{{ route('shops.explore') }}" method="GET" class="search-box">

                <div class="search-field">
                    <i class="fas fa-map-marker-alt"></i>
                    <div style="width:100%">
                        <label>AREA / LOKASI</label>
                        <input
                            type="text"
                            name="city"
                            placeholder="Masukkan kota atau lokasi"
                        >
                    </div>
                </div>

                <div class="search-field">
                    <i class="fas fa-cut"></i>
                    <div style="width:100%">
                        <label>CARI BARBERSHOP</label>
                        <input
                            type="text"
                            name="search"
                            placeholder="Nama barbershop"
                        >
                    </div>
                </div>

                <div class="search-field">
                    <i class="far fa-calendar-alt"></i>
                    <div style="width:100%">
                        <label>RENCANA RESERVASI</label>
                        <input
                            type="date"
                            min="{{ date('Y-m-d') }}"
                            aria-label="Tanggal rencana reservasi"
                        >
                    </div>
                </div>

                <button type="submit" class="btn btn-orange search-submit">
                    <i class="fas fa-search"></i>
                    Cari Jadwal
                </button>

            </form>

        </div>
    </section>


    <!-- BARBERSHOP POPULER -->
    <section class="section popular-section" id="barbershop">
        <div class="container">

            <div class="section-heading">
                <div>
                    <span class="section-kicker">KURASI MITRA PILIHAN</span>
                    <h2>Barbershop Terpopuler</h2>
                    <p>Temukan tempat grooming favorit untuk penampilan terbaikmu.</p>
                </div>

                <a href="{{ route('shops.explore') }}" class="text-link">
                    Lihat Semua Barbershop <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <div class="shop-grid">

                <article class="shop-card">
                    <div class="shop-image-wrap">
                        <img
                            class="shop-image"
                            src="https://images.unsplash.com/photo-1599351431202-1e0f0137899a?auto=format&fit=crop&w=800&q=85"
                            alt="Interior barbershop"
                            loading="lazy"
                        >
                        <span class="open-badge">
                            <i class="fas fa-circle" style="font-size:6px"></i>
                            Buka Sekarang
                        </span>
                        <span class="rating-badge">
                            <i class="fas fa-star"></i> Pilihan
                        </span>
                    </div>

                    <div class="shop-info">
                        <div class="shop-title-row">
                            <h3>Gamoen Barbershop</h3>
                            <span class="city-badge">Populer</span>
                        </div>

                        <p class="shop-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Temukan lokasi dan detail barbershop
                        </p>

                        <div class="shop-bottom">
                            <div class="shop-price">
                                <small>Mulai dari</small>
                                <strong>Lihat harga</strong>
                            </div>

                            <a href="{{ route('shops.explore') }}" class="btn btn-dark">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </article>


                <article class="shop-card">
                    <div class="shop-image-wrap">
                        <img
                            class="shop-image"
                            src="https://images.unsplash.com/photo-1621605815971-fbc98d665033?auto=format&fit=crop&w=800&q=85"
                            alt="Barber sedang melayani pelanggan"
                            loading="lazy"
                        >
                        <span class="open-badge">
                            <i class="fas fa-circle" style="font-size:6px"></i>
                            Buka Sekarang
                        </span>
                        <span class="rating-badge">
                            <i class="fas fa-star"></i> Pilihan
                        </span>
                    </div>

                    <div class="shop-info">
                        <div class="shop-title-row">
                            <h3>King's Cut Barbershop</h3>
                            <span class="city-badge">Favorit</span>
                        </div>

                        <p class="shop-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Temukan lokasi dan detail barbershop
                        </p>

                        <div class="shop-bottom">
                            <div class="shop-price">
                                <small>Mulai dari</small>
                                <strong>Lihat harga</strong>
                            </div>

                            <a href="{{ route('shops.explore') }}" class="btn btn-dark">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </article>


                <article class="shop-card">
                    <div class="shop-image-wrap">
                        <img
                            class="shop-image"
                            src="https://images.unsplash.com/photo-1503951914875-452162b0f3f1?auto=format&fit=crop&w=800&q=85"
                            alt="Barbershop modern"
                            loading="lazy"
                        >
                        <span class="open-badge">
                            <i class="fas fa-circle" style="font-size:6px"></i>
                            Buka Sekarang
                        </span>
                        <span class="rating-badge">
                            <i class="fas fa-star"></i> Pilihan
                        </span>
                    </div>

                    <div class="shop-info">
                        <div class="shop-title-row">
                            <h3>Urban Fade Co.</h3>
                            <span class="city-badge">Modern</span>
                        </div>

                        <p class="shop-location">
                            <i class="fas fa-map-marker-alt"></i>
                            Temukan lokasi dan detail barbershop
                        </p>

                        <div class="shop-bottom">
                            <div class="shop-price">
                                <small>Mulai dari</small>
                                <strong>Lihat harga</strong>
                            </div>

                            <a href="{{ route('shops.explore') }}" class="btn btn-dark">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </article>

            </div>

        </div>
    </section>


    <!-- PROMO -->
    <section class="promo-section">
        <div class="container">

            <div class="promo-box">

                <div class="promo-content">
                    <span class="promo-label">PROMO SPESIAL</span>

                    <h2>Tampil Lebih Percaya Diri dengan Gaya Terbaikmu</h2>

                    <p>
                        Temukan layanan grooming pilihan di barbershop favoritmu.
                        Jelajahi berbagai layanan dan pilih yang paling sesuai
                        dengan kebutuhan penampilanmu.
                    </p>

                    <div class="voucher">
                        <i class="fas fa-gift" style="color:var(--orange)"></i>
                        <span>Jelajahi layanan dan penawaran barbershop</span>
                    </div>
                </div>

                <div class="promo-side">
                    <i class="fas fa-cut"></i>
                    <h3>Waktunya Grooming!</h3>
                    <p>
                        Pilih barbershop favorit dan jadwalkan kunjunganmu
                        melalui GoBarber.
                    </p>

                    <a href="{{ route('shops.explore') }}" class="btn btn-orange">
                        Jelajahi Sekarang
                    </a>
                </div>

            </div>

        </div>
    </section>


    <!-- CARA KERJA -->
    <section class="section steps-section" id="cara-kerja">
        <div class="container">

            <div class="center-heading">
                <span class="section-kicker">SIMPLE & PRAKTIS</span>
                <h2>Cara Kerja GoBarber</h2>
                <p>
                    Empat langkah mudah untuk mendapatkan layanan grooming
                    dari barbershop pilihan tanpa perlu mengantre.
                </p>
            </div>

            <div class="steps-grid">

                <div class="step-card">
                    <div class="step-top">
                        <span class="step-number">01</span>
                        <span class="step-icon"><i class="fas fa-search"></i></span>
                    </div>
                    <h3>Pilih Barbershop</h3>
                    <p>
                        Jelajahi berbagai barbershop berdasarkan lokasi,
                        foto, dan layanan yang tersedia.
                    </p>
                    <span class="step-note">
                        <i class="fas fa-check-circle"></i> Temukan pilihanmu
                    </span>
                </div>

                <div class="step-card">
                    <div class="step-top">
                        <span class="step-number">02</span>
                        <span class="step-icon"><i class="fas fa-user"></i></span>
                    </div>
                    <h3>Tentukan Kapster & Jadwal</h3>
                    <p>
                        Pilih kapster yang kamu inginkan, layanan,
                        serta jadwal reservasi.
                    </p>
                    <span class="step-note">
                        <i class="fas fa-calendar-check"></i> Atur jadwalmu
                    </span>
                </div>

                <div class="step-card">
                    <div class="step-top">
                        <span class="step-number">03</span>
                        <span class="step-icon"><i class="fas fa-qrcode"></i></span>
                    </div>
                    <h3>Pembayaran</h3>
                    <p>
                        Selesaikan proses pembayaran sesuai metode
                        yang tersedia pada sistem.
                    </p>
                    <span class="step-note">
                        <i class="fas fa-lock"></i> Transaksi praktis
                    </span>
                </div>

                <div class="step-card">
                    <div class="step-top">
                        <span class="step-number">04</span>
                        <span class="step-icon"><i class="fas fa-store"></i></span>
                    </div>
                    <h3>Datang ke Lokasi</h3>
                    <p>
                        Datang sesuai jadwal reservasi dan nikmati
                        layanan grooming pilihanmu.
                    </p>
                    <span class="step-note">
                        <i class="fas fa-check"></i> Siap tampil keren
                    </span>
                </div>

            </div>

        </div>
    </section>


    <!-- CTA -->
    <section class="cta-section">
        <div class="container">

            <div class="cta-box">
                <i class="fas fa-cut"></i>

                <h2>Sudah Waktunya Rapikan Rambut Anda?</h2>

                <p>
                    Temukan kapster terbaik dan pesan slot reservasi
                    sesuai jadwalmu. Lebih praktis, nyaman, dan terpercaya.
                </p>

                <div class="cta-buttons">
                    <a href="{{ route('shops.explore') }}" class="btn btn-orange">
                        Mulai Booking Sekarang
                    </a>

                    <a href="{{ route('shops.explore') }}" class="btn btn-outline">
                        Lihat Barbershop
                    </a>
                </div>
            </div>

        </div>
    </section>


    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">

            <div class="footer-grid">

                <div class="footer-about">
                    <a href="{{ url('/') }}" class="logo">
                        Go<span>Barber.</span>
                    </a>

                    <p>
                        Platform digital reservasi dan antrean grooming pria.
                        Temukan barbershop terbaik, pilih kapster favorit,
                        dan atur jadwal dengan lebih praktis.
                    </p>
                </div>

                <div class="footer-col">
                    <h4>Kategori Treatment</h4>
                    <a href="{{ route('shops.explore') }}">Gentlemen Haircut</a>
                    <a href="{{ route('shops.explore') }}">Beard Trimming</a>
                    <a href="{{ route('shops.explore') }}">Hair Styling</a>
                    <a href="{{ route('shops.explore') }}">Hair Coloring</a>
                </div>

                <div class="footer-col">
                    <h4>Mitra & Jaringan</h4>
                    <a href="{{ route('shops.explore') }}">Jelajah Barbershop</a>
                    <a href="{{ route('shops.explore') }}">Barbershop Terdekat</a>
                    <a href="{{ route('shops.explore') }}">Daftar Barbershop</a>
                </div>

                <div class="footer-col">
                    <h4>Bantuan & Kontak</h4>
                    <a href="{{ url('/login') }}">Pusat Bantuan</a>
                    <a href="{{ url('/login') }}">Syarat & Ketentuan</a>
                    <a href="{{ url('/login') }}">Kebijakan Privasi</a>
                    <a href="mailto:support@gobarber.id">support@gobarber.id</a>
                </div>

            </div>

            <div class="footer-bottom">
                <span>© {{ date('Y') }} GoBarber. Hak Cipta Dilindungi.</span>
                <span>Designed for a better grooming experience.</span>
            </div>

        </div>
    </footer>

</body>
</html>
