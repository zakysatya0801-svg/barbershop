
@extends('layouts.customer')

@section('title', 'Home - GoBarber')

@section('content')
<style>
    .home-hero {
        background:linear-gradient(115deg,#101828 0%,#202d43 60%,#34445e 100%);
        color:white; padding:85px 7%; overflow:hidden;
    }
    .hero-inner { max-width:1300px; margin:auto; display:grid; grid-template-columns:1.2fr .8fr; align-items:center; gap:40px; }
    .hero-tag { display:inline-block; background:#ffffff18; border:1px solid #ffffff30; padding:9px 15px; border-radius:30px; font-size:12px; }
    .home-hero h1 { font-size:clamp(36px,5vw,62px); line-height:1.15; margin:22px 0; font-weight:800; }
    .home-hero h1 span { color:#f5bd65; }
    .home-hero p { color:#d1d7e0; line-height:1.8; max-width:570px; font-size:15px; }
    .hero-actions { display:flex; flex-wrap:wrap; gap:12px; margin-top:28px; }
    .hero-visual { min-height:320px; border-radius:30px; background:linear-gradient(145deg,#e4b77d,#8e5d3b); display:grid; place-items:center; font-size:130px; box-shadow:0 25px 70px #0005; }
    .home-section { max-width:1300px; margin:65px auto; padding:0 5%; }
    .section-heading { display:flex; justify-content:space-between; align-items:end; gap:15px; margin-bottom:25px; }
    .section-heading h2 { margin:0; font-size:27px; }
    .section-heading p { color:#747d8d; font-size:13px; margin:8px 0 0; }
    .text-link { color:#a36b2d; font-size:13px; font-weight:800; }
    .category-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:18px; }
    .category-card { background:white; border:1px solid #eceef2; border-radius:18px; padding:25px 18px; transition:.2s; }
    .category-card:hover { transform:translateY(-5px); box-shadow:0 12px 30px #10182812; }
    .category-icon { width:52px; height:52px; display:grid; place-items:center; background:#f5eee5; border-radius:15px; font-size:25px; }
    .category-card h3 { font-size:14px; margin:17px 0 7px; }
    .category-card p { color:#7a8290; font-size:12px; line-height:1.6; margin:0; }
    .promo-banner { background:#f4e8d8; border-radius:24px; padding:35px; display:flex; align-items:center; justify-content:space-between; gap:20px; }
    .promo-banner h2 { margin:0 0 10px; font-size:25px; }
    .promo-banner p { margin:0; color:#6e6255; font-size:13px; }
    .steps-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:20px; }
    .step-card { background:white; border-radius:18px; padding:25px; border:1px solid #eceef2; }
    .step-number { color:#bd8547; font-size:13px; font-weight:800; }
    .step-card h3 { font-size:16px; }
    .step-card p { font-size:13px; color:#7a8290; line-height:1.7; }
    @media(max-width:750px) {
        .hero-inner { grid-template-columns:1fr; }
        .hero-visual { min-height:200px; font-size:90px; }
        .category-grid { grid-template-columns:repeat(2,1fr); }
        .steps-grid { grid-template-columns:1fr; }
        .promo-banner { align-items:flex-start; flex-direction:column; }
    }
</style>

<section class="home-hero">
    <div class="hero-inner">
        <div>
            <span class="hero-tag">💈 Platform Reservasi Barbershop</span>
            <h1>Good Hair.<br><span>Good Mood.</span><br>Good Day.</h1>
            <p>Temukan barbershop terbaik di sekitarmu. Pilih kapster, tentukan layanan, dan booking jadwal potong rambut tanpa harus antre lama.</p>

            <div class="hero-actions">
                <a href="{{ route('shops.explore') }}" class="btn">Jelajahi Barbershop →</a>
                <a href="#cara-booking" class="btn btn-light">Cara Booking</a>
            </div>
        </div>
        <div class="hero-visual">💈</div>
    </div>
</section>

<section class="home-section" id="kategori">
    <div class="section-heading">
        <div>
            <h2>Temukan Treatment Favoritmu</h2>
            <p>Pilih perawatan yang sesuai dengan kebutuhan penampilanmu.</p>
        </div>
        <a class="text-link" href="{{ route('shops.explore') }}">Lihat semua →</a>
    </div>

    <div class="category-grid">
        <a class="category-card" href="{{ route('shops.explore', ['search' => 'haircut']) }}">
            <div class="category-icon">✂️</div>
            <h3>Haircut &amp; Wash</h3>
            <p>Potongan rambut rapi dan perawatan rambut.</p>
        </a>
        <a class="category-card" href="{{ route('shops.explore', ['search' => 'beard']) }}">
            <div class="category-icon">🧔</div>
            <h3>Beard Trim</h3>
            <p>Rapikan jenggot dan kumis agar lebih stylish.</p>
        </a>
        <a class="category-card" href="{{ route('shops.explore', ['search' => 'creambath']) }}">
            <div class="category-icon">🧖</div>
            <h3>Creambath</h3>
            <p>Perawatan dan relaksasi kulit kepala.</p>
        </a>
        <a class="category-card" href="{{ route('shops.explore', ['search' => 'coloring']) }}">
            <div class="category-icon">🎨</div>
            <h3>Hair Coloring</h3>
            <p>Eksplorasi warna rambut sesuai gayamu.</p>
        </a>
    </div>
</section>

<section class="home-section">
    <div class="promo-banner">
        <div>
            <h2>Waktunya tampil lebih percaya diri!</h2>
            <p>Temukan tempat grooming pilihanmu dan pesan jadwal dengan praktis.</p>
        </div>
        <a href="{{ route('shops.explore') }}" class="btn">Cari Barbershop</a>
    </div>
</section>

<section class="home-section" id="cara-booking">
    <div class="section-heading">
        <div>
            <h2>Booking Semudah 1-2-3</h2>
            <p>Tiga langkah praktis untuk mendapatkan penampilan terbaik.</p>
        </div>
    </div>

    <div class="steps-grid">
        <div class="step-card">
            <span class="step-number">LANGKAH 01</span>
            <h3>Temukan Barbershop</h3>
            <p>Jelajahi barbershop dan pilih lokasi yang paling sesuai untukmu.</p>
        </div>
        <div class="step-card">
            <span class="step-number">LANGKAH 02</span>
            <h3>Pilih Layanan &amp; Jadwal</h3>
            <p>Tentukan treatment, kapster, tanggal, dan waktu reservasi.</p>
        </div>
        <div class="step-card">
            <span class="step-number">LANGKAH 03</span>
            <h3>Datang &amp; Grooming</h3>
            <p>Datang sesuai jadwal dan nikmati pengalaman grooming-mu.</p>
        </div>
    </div>
</section>
@endsection
