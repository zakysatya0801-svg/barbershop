
@extends('layouts.customer')

@section('title', 'Jelajah Barbershop - GoBarber')

@section('content')
<style>
    .explore-wrap { max-width:1440px; margin:auto; padding:45px 5% 20px; }
    .explore-title { margin-bottom:30px; }
    .explore-title small { color:#b17b43; font-weight:800; font-size:12px; letter-spacing:1px; }
    .explore-title h1 { font-size:34px; margin:10px 0; }
    .explore-title p { color:#78808e; font-size:14px; margin:0; }
    .explore-search { display:flex; gap:10px; margin:25px 0 30px; }
    .explore-search input { flex:1; min-width:0; padding:15px 20px; border:1px solid #e3e6eb; border-radius:12px; outline:none; background:white; }
    .explore-search input:focus { border-color:#101828; }
    .explore-layout { display:grid; grid-template-columns:260px minmax(0,1fr); gap:25px; align-items:start; }
    .filter-panel { background:white; border:1px solid #e9ebef; border-radius:18px; padding:23px; }
    .filter-panel h3 { font-size:16px; margin:0 0 20px; }
    .filter-group { margin-bottom:20px; }
    .filter-group label { display:block; font-size:12px; font-weight:800; margin-bottom:9px; }
    .filter-group select, .filter-group input[type=number] { width:100%; padding:12px; border:1px solid #e2e5e9; border-radius:9px; background:white; outline:none; }
    .check-row { display:flex!important; align-items:center; gap:9px; font-weight:500!important; }
    .result-top { display:flex; justify-content:space-between; align-items:center; margin-bottom:17px; }
    .result-top h2 { font-size:19px; margin:0; }
    .result-top span { color:#7b8390; font-size:12px; }
    .shop-list { display:grid; gap:17px; }
    .shop-card { display:grid; grid-template-columns:210px minmax(0,1fr); gap:22px; padding:17px; border-radius:17px; background:white; border:1px solid #e9ebef; transition:.2s; }
    .shop-card:hover { transform:translateY(-3px); box-shadow:0 12px 30px #10182810; }
    .shop-photo { width:100%; height:175px; border-radius:12px; object-fit:cover; background:#e9e3da; }
    .shop-placeholder { display:grid; place-items:center; font-size:55px; }
    .shop-info { min-width:0; display:flex; flex-direction:column; }
    .shop-status { display:inline-block; font-size:10px; font-weight:800; color:#18794e; background:#e9f8ef; padding:6px 10px; border-radius:20px; width:max-content; }
    .shop-info h3 { font-size:19px; margin:10px 0 6px; }
    .shop-location { color:#78808e; font-size:12px; }
    .shop-description { color:#687080; font-size:12px; line-height:1.7; margin:10px 0; }
    .shop-bottom { display:flex; justify-content:space-between; align-items:end; gap:12px; margin-top:auto; }
    .shop-price small { display:block; color:#838b98; font-size:10px; }
    .shop-price strong { font-size:17px; }
    .shop-actions { display:flex; gap:8px; }
    .shop-actions a { padding:10px 15px; font-size:11px; }
    .empty-state { padding:50px 20px; text-align:center; background:white; border-radius:17px; color:#78808e; }
    .pagination { margin-top:25px; }
    @media(max-width:850px) {
        .explore-layout { grid-template-columns:1fr; }
        .shop-card { grid-template-columns:160px minmax(0,1fr); }
        .shop-photo { height:155px; }
    }
    @media(max-width:560px) {
        .explore-wrap { padding:30px 16px; }
        .explore-title h1 { font-size:27px; }
        .explore-search { flex-direction:column; }
        .shop-card { grid-template-columns:1fr; }
        .shop-photo { height:190px; }
        .shop-bottom { align-items:flex-start; flex-direction:column; }
    }
</style>

<div class="explore-wrap">
    <div class="explore-title">
        <small>GO BARBER / EXPLORE</small>
        <h1>Temukan Barbershop Terbaik</h1>
        <p>Pilih barbershop favoritmu dan nikmati pengalaman grooming yang lebih praktis.</p>
    </div>

    <form action="{{ route('shops.explore') }}" method="GET" class="explore-search">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama barbershop...">
        <button class="btn" type="submit">Cari Barbershop</button>
    </form>

    <div class="explore-layout">
        <aside class="filter-panel">
            <h3>Filter Pencarian</h3>

            <form action="{{ route('shops.explore') }}" method="GET">
                <div class="filter-group">
                    <label for="filter-search">Nama Barbershop</label>
                    <input id="filter-search" type="text" name="search"
                           value="{{ request('search') }}" placeholder="Nama barbershop">
                </div>

                <div class="filter-group">
                    <label for="filter-city">Lokasi Kota</label>
                    <select id="filter-city" name="city">
                        <option value="">Semua Kota</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" @selected(request('city') == $city)>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="filter-group">
                    <label for="filter-price">Harga Maksimal</label>
                    <input id="filter-price" type="number" name="max_price"
                           value="{{ request('max_price') }}" placeholder="Contoh: 100000" min="0">
                </div>

                <div class="filter-group">
                    <label class="check-row">
                        <input type="checkbox" name="open_now" value="1"
                               @checked(request()->boolean('open_now'))>
                        Hanya yang sedang buka
                    </label>
                </div>

                <button type="submit" class="btn" style="width:100%">Terapkan Filter</button>

                <a href="{{ route('shops.explore') }}" class="btn btn-light"
                   style="width:100%;margin-top:10px">Reset Filter</a>
            </form>
        </aside>

        <section>
            <div class="result-top">
                <h2>Daftar Barbershop</h2>
                <span>{{ $shops->total() }} barbershop ditemukan</span>
            </div>

            <div class="shop-list">
                @forelse($shops as $shop)
                    @php
                        $minimumPrice = $shop->services->min('price');
                        $photo = $shop->photo;
                    @endphp

                    <article class="shop-card">
                        @if($photo)
                            <img class="shop-photo"
                                 src="{{ asset('storage/' . $photo) }}"
                                 alt="{{ $shop->barbershop_name }}">
                        @else
                            <div class="shop-photo shop-placeholder">💈</div>
                        @endif

                        <div class="shop-info">
                            <span class="shop-status">
                                {{ $shop->open_time && $shop->close_time ? 'JAM OPERASIONAL TERSEDIA' : 'BARBERSHOP' }}
                            </span>

                            <h3>{{ $shop->barbershop_name }}</h3>

                            <div class="shop-location">
                                📍 {{ $shop->location->city ?? 'Lokasi belum tersedia' }}
                            </div>

                            <p class="shop-description">
                                {{ $shop->description ?: 'Temukan layanan grooming terbaik di barbershop ini.' }}
                            </p>

                            <div class="shop-bottom">
                                <div class="shop-price">
                                    <small>Mulai dari</small>
                                    <strong>
                                        {{ $minimumPrice !== null ? 'Rp' . number_format($minimumPrice, 0, ',', '.') : 'Lihat layanan' }}
                                    </strong>
                                </div>

                                <div class="shop-actions">
                                    @if(\Illuminate\Support\Facades\Route::has('shops.show'))
                                        <a class="btn btn-light"
                                           href="{{ route('shops.show', $shop->go_barbershop_id) }}">
                                            Detail
                                        </a>
                                    @endif

                                    @if(\Illuminate\Support\Facades\Route::has('booking'))
                                        <a class="btn"
                                           href="{{ route('booking', $shop->go_barbershop_id) }}">
                                            Booking
                                        </a>
                                    @else
                                        <a class="btn"
                                           href="{{ route('login') }}">
                                            Booking
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="empty-state">
                        <div style="font-size:45px">🔎</div>
                        <h3>Barbershop belum ditemukan</h3>
                        <p>Coba ubah kata kunci atau filter pencarianmu.</p>
                        <a href="{{ route('shops.explore') }}" class="btn">Lihat Semua Barbershop</a>
                    </div>
                @endforelse
            </div>

            <div class="pagination">
                {{ $shops->links() }}
            </div>
        </section>
    </div>
</div>
@endsection
