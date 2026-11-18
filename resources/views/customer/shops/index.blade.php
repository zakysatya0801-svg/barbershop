
@extends('layouts.customer')

@section('title', 'Jelajah Barbershop - GoBarber')

@section('content')

<style>
    :root {
        --bg: #0d0f14;
        --surface: #151821;
        --surface-light: #1c202b;
        --orange: #f5a623;
        --orange-dark: #d98200;
        --white: #ffffff;
        --muted: #9ca3af;
        --border: rgba(255,255,255,.09);
    }

    .explore-page {
        background: var(--bg);
        color: var(--white);
        min-height: 100vh;
        padding-bottom: 70px;
        font-family: 'DM Sans', sans-serif;
    }

    .explore-container {
        width: min(1180px, 92%);
        margin: auto;
    }

    .explore-hero {
        padding: 65px 0 45px;
        background:
            radial-gradient(circle at 85% 15%, rgba(245,166,35,.13), transparent 30%),
            linear-gradient(135deg, #11141c, #0d0f14);
    }

    .explore-label {
        display: inline-block;
        color: var(--orange);
        background: rgba(245,166,35,.12);
        border: 1px solid rgba(245,166,35,.2);
        padding: 8px 15px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 1px;
        margin-bottom: 18px;
    }

    .explore-hero h1 {
        font-size: clamp(30px, 5vw, 48px);
        font-weight: 800;
        line-height: 1.2;
        margin: 0 0 15px;
    }

    .explore-hero h1 span {
        color: var(--orange);
    }

    .explore-hero p {
        color: var(--muted);
        max-width: 570px;
        line-height: 1.8;
        margin: 0;
    }

    .search-panel {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 20px;
        margin-top: 30px;
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr auto;
        gap: 12px;
    }

    .search-field {
        min-width: 0;
    }

    .search-field label {
        display: block;
        color: #d1d5db;
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 9px;
    }

    .search-field input,
    .search-field select {
        width: 100%;
        height: 45px;
        padding: 0 13px;
        border-radius: 9px;
        border: 1px solid var(--border);
        background: #10131b;
        color: white;
        outline: none;
        font-size: 13px;
    }

    .search-field input:focus,
    .search-field select:focus {
        border-color: var(--orange);
    }

    .search-field input::placeholder {
        color: #737987;
    }

    .search-button {
        align-self: end;
        height: 45px;
        padding: 0 23px;
        border: none;
        border-radius: 9px;
        background: var(--orange);
        color: #171717;
        font-weight: 800;
        cursor: pointer;
        transition: .2s;
    }

    .search-button:hover {
        background: #ffbd4a;
        transform: translateY(-2px);
    }

    .explore-content {
        padding-top: 48px;
    }

    .section-heading {
        display: flex;
        align-items: end;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 25px;
    }

    .section-heading h2 {
        font-size: 25px;
        font-weight: 800;
        margin: 0 0 7px;
    }

    .section-heading p {
        color: var(--muted);
        font-size: 13px;
        margin: 0;
    }

    .result-count {
        color: var(--orange);
        font-size: 13px;
        font-weight: 700;
    }

    .shop-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 22px;
    }

    .shop-card {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        overflow: hidden;
        transition: .25s;
        min-width: 0;
    }

    .shop-card:hover {
        transform: translateY(-6px);
        border-color: rgba(245,166,35,.5);
        box-shadow: 0 15px 35px rgba(0,0,0,.25);
    }

    .shop-image {
        height: 205px;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #292d38, #171a23);
    }

    .shop-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: .4s;
    }

    .shop-card:hover .shop-image img {
        transform: scale(1.06);
    }

    .shop-image-placeholder {
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--orange);
        font-size: 48px;
    }

    .shop-tag {
        position: absolute;
        top: 13px;
        left: 13px;
        background: var(--orange);
        color: #171717;
        padding: 7px 11px;
        border-radius: 30px;
        font-size: 10px;
        font-weight: 800;
    }

    .shop-info {
        padding: 19px;
    }

    .shop-location {
        color: var(--orange);
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 9px;
    }

    .shop-info h3 {
        font-size: 18px;
        font-weight: 800;
        margin: 0 0 10px;
        color: white;
    }

    .shop-description {
        color: var(--muted);
        font-size: 12px;
        line-height: 1.7;
        min-height: 42px;
        margin-bottom: 15px;
    }

    .shop-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
        padding: 13px 0;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
    }

    .shop-meta small {
        display: block;
        color: var(--muted);
        font-size: 10px;
        margin-bottom: 5px;
    }

    .shop-meta strong {
        font-size: 13px;
        color: white;
    }

    .shop-price {
        color: var(--orange) !important;
    }

    .shop-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 9px;
        margin-top: 15px;
    }

    .shop-btn {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 40px;
        border-radius: 8px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 800;
        transition: .2s;
    }

    .btn-detail {
        border: 1px solid var(--border);
        color: white;
        background: var(--surface-light);
    }

    .btn-detail:hover {
        border-color: var(--orange);
        color: var(--orange);
    }

    .btn-booking {
        background: var(--orange);
        color: #171717;
    }

    .btn-booking:hover {
        background: #ffbd4a;
        color: #171717;
    }

    .empty-state {
        background: var(--surface);
        border: 1px solid var(--border);
        border-radius: 16px;
        padding: 55px 20px;
        text-align: center;
        color: var(--muted);
    }

    .empty-state h3 {
        color: white;
        margin: 15px 0 8px;
    }

    .empty-icon {
        font-size: 42px;
    }

    .pagination {
        margin-top: 35px;
    }

    .pagination nav {
        display: flex;
        justify-content: center;
    }

    .pagination svg {
        width: 18px;
    }

    .pagination span,
    .pagination a {
        background: var(--surface) !important;
        color: white !important;
        border-color: var(--border) !important;
    }

    .pagination [aria-current="page"] span {
        background: var(--orange) !important;
        color: #171717 !important;
    }

    @media (max-width: 900px) {
        .shop-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .search-panel {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 600px) {
        .explore-hero {
            padding: 45px 0 30px;
        }

        .search-panel {
            grid-template-columns: 1fr;
            padding: 15px;
        }

        .search-button {
            width: 100%;
        }

        .shop-grid {
            grid-template-columns: 1fr;
        }

        .shop-image {
            height: 220px;
        }

        .section-heading {
            align-items: start;
            flex-direction: column;
        }

        .explore-content {
            padding-top: 35px;
        }
    }
</style>

<div class="explore-page">

    {{-- HERO DAN PENCARIAN --}}
    <section class="explore-hero">
        <div class="explore-container">

            <span class="explore-label">EXPLORE GOBARBER</span>

            <h1>
                Temukan Barbershop<br>
                <span>Favoritmu.</span>
            </h1>

            <p>
                Cari barbershop terbaik di sekitarmu, lihat layanan,
                pilih barber favorit, dan pesan jadwal potong rambut
                dengan lebih mudah.
            </p>

            <form action="{{ route('shops.explore') }}" method="GET" class="search-panel">

                <div class="search-field">
                    <label>Nama Barbershop</label>
                    <input
                        type="text"
                        name="search"
                        placeholder="Cari nama barbershop..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="search-field">
                    <label>Kota</label>
                    <select name="city">
                        <option value="">Semua Kota</option>
                        @foreach(($cities ?? []) as $city)
                            <option value="{{ $city }}"
                                @selected(request('city') == $city)>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="search-field">
                    <label>Harga Maksimal</label>
                    <select name="max_price">
                        <option value="">Semua Harga</option>
                        <option value="30000" @selected(request('max_price') == '30000')>
                            Maks. Rp30.000
                        </option>
                        <option value="50000" @selected(request('max_price') == '50000')>
                            Maks. Rp50.000
                        </option>
                        <option value="75000" @selected(request('max_price') == '75000')>
                            Maks. Rp75.000
                        </option>
                        <option value="100000" @selected(request('max_price') == '100000')>
                            Maks. Rp100.000
                        </option>
                    </select>
                </div>

                <button type="submit" class="search-button">
                    Cari Barbershop
                </button>

            </form>
        </div>
    </section>

    {{-- DAFTAR BARBERSHOP --}}
    <section class="explore-container explore-content">

        <div class="section-heading">
            <div>
                <h2>Jelajahi Barbershop</h2>
                <p>Pilih tempat terbaik untuk gaya rambutmu.</p>
            </div>

            <span class="result-count">
                {{ $shops->total() ?? $shops->count() }} Barbershop
            </span>
        </div>

        @if(isset($shops) && $shops->count() > 0)

            <div class="shop-grid">

                @foreach($shops as $shop)

                    @php
                        $minimumPrice = $shop->services
                            ->where('is_available', true)
                            ->min('price');
                    @endphp

                    <article class="shop-card">

                        <div class="shop-image">

                            @if($shop->photo)
                                <img
                                    src="{{ asset('storage/' . $shop->photo) }}"
                                    alt="{{ $shop->barbershop_name }}"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                                >
                                <div class="shop-image-placeholder" style="display:none;">
                                    ✂
                                </div>
                            @else
                                <div class="shop-image-placeholder">
                                    ✂
                                </div>
                            @endif

                            <span class="shop-tag">GOBARBER</span>

                        </div>

                        <div class="shop-info">

                            <div class="shop-location">
                                📍 {{ $shop->location->city ?? 'Lokasi belum tersedia' }}
                            </div>

                            <h3>{{ $shop->barbershop_name }}</h3>

                            <p class="shop-description">
                                {{ $shop->description
                                    ? \Illuminate\Support\Str::limit($shop->description, 90)
                                    : 'Nikmati layanan potong rambut profesional bersama barber berpengalaman.' }}
                            </p>

                            <div class="shop-meta">
                                <div>
                                    <small>Mulai dari</small>
                                    <strong class="shop-price">
                                        {{ $minimumPrice !== null
                                            ? 'Rp' . number_format($minimumPrice, 0, ',', '.')
                                            : 'Belum tersedia' }}
                                    </strong>
                                </div>

                                <div style="text-align:right;">
                                    <small>Jam Operasional</small>
                                    <strong>
                                        {{ $shop->open_time
                                            ? \Illuminate\Support\Str::substr($shop->open_time, 0, 5)
                                            : '--:--' }}
                                        -
                                        {{ $shop->close_time
                                            ? \Illuminate\Support\Str::substr($shop->close_time, 0, 5)
                                            : '--:--' }}
                                    </strong>
                                </div>
                            </div>

                            <div class="shop-actions">

                                <a
                                    href="{{ route('shops.show', $shop->go_barbershop_id) }}"
                                    class="shop-btn btn-detail"
                                >
                                    Lihat Detail
                                </a>

                                <a
                                    href="{{ route('booking', $shop->go_barbershop_id) }}"
                                    class="shop-btn btn-booking"
                                >
                                    Booking
                                </a>

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>

            <div class="pagination">
                {{ $shops->withQueryString()->links() }}
            </div>

        @else

            <div class="empty-state">
                <div class="empty-icon">💈</div>
                <h3>Barbershop Belum Ditemukan</h3>
                <p>
                    Coba gunakan kata kunci atau filter pencarian yang berbeda.
                </p>
            </div>

        @endif

    </section>

</div>

@endsection
