
@extends('layouts.customer')

@section('title', 'Home - GoBarber')

@section('content')

<style>
    .hero {
        background: linear-gradient(120deg, #101828, #34445e);
        color: white;
        padding: 90px 7%;
    }

    .hero-content {
        max-width: 1250px;
        margin: auto;
    }

    .hero h1 {
        font-size: clamp(38px, 5vw, 65px);
        line-height: 1.2;
        margin: 20px 0;
    }

    .hero h1 span {
        color: #f5bd65;
    }

    .hero p {
        max-width: 580px;
        color: #d1d5db;
        line-height: 1.8;
    }

    .hero-btn {
        display: inline-block;
        margin-top: 25px;
        padding: 15px 25px;
        background: #f5bd65;
        color: #101828;
        border-radius: 30px;
        font-weight: 800;
    }

    .home-section {
        max-width: 1250px;
        margin: 60px auto;
        padding: 0 25px;
    }

    .home-section h2 {
        font-size: 27px;
        margin-bottom: 10px;
    }

    .category-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-top: 25px;
    }

    .category {
        background: white;
        padding: 25px;
        border-radius: 18px;
        border: 1px solid #e8e8e8;
        transition: .2s;
    }

    .category:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px #0001;
    }

    .category .icon {
        font-size: 35px;
    }

    .category h3 {
        font-size: 15px;
    }

    .category p {
        color: #777;
        font-size: 12px;
        line-height: 1.7;
    }

    .promo {
        background: #f4e8d8;
        padding: 35px;
        border-radius: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    @media(max-width:700px) {
        .category-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .promo {
            flex-direction: column;
            align-items: flex-start;
        }
    }
</style>

<section class="hero">
    <div class="hero-content">
        <p>💈 PLATFORM RESERVASI BARBERSHOP</p>

        <h1>
            Good Hair.<br>
            <span>Good Mood.</span><br>
            Good Day.
        </h1>

        <p>
            Temukan barbershop terbaik di sekitarmu.
            Pilih layanan, tentukan jadwal, dan booking
            potong rambut dengan mudah tanpa antre lama.
        </p>

        <a href="{{ route('shops.explore') }}" class="hero-btn">
            Jelajahi Barbershop →
        </a>
    </div>
</section>

<section class="home-section" id="kategori">
    <h2>Temukan Treatment Favoritmu</h2>
    <p style="color:#777">Pilih perawatan sesuai kebutuhan penampilanmu.</p>

    <div class="category-grid">
        <a href="{{ route('shops.explore', ['search' => 'haircut']) }}" class="category">
            <div class="icon">✂️</div>
            <h3>Haircut & Wash</h3>
            <p>Potongan rambut rapi dan perawatan rambut.</p>
        </a>

        <a href="{{ route('shops.explore', ['search' => 'beard']) }}" class="category">
            <div class="icon">🧔</div>
            <h3>Beard Trim</h3>
            <p>Rapikan jenggot dan kumis.</p>
        </a>

        <a href="{{ route('shops.explore', ['search' => 'creambath']) }}" class="category">
            <div class="icon">🧖</div>
            <h3>Creambath</h3>
            <p>Perawatan dan relaksasi kulit kepala.</p>
        </a>

        <a href="{{ route('shops.explore', ['search' => 'coloring']) }}" class="category">
            <div class="icon">🎨</div>
            <h3>Hair Coloring</h3>
            <p>Eksplorasi warna rambut sesuai gayamu.</p>
        </a>
    </div>
</section>

<section class="home-section">
    <div class="promo">
        <div>
            <h2>Waktunya tampil lebih percaya diri!</h2>
            <p>Temukan barbershop favorit dan pesan jadwalmu sekarang.</p>
        </div>

        <a href="{{ route('shops.explore') }}" class="hero-btn">
            Cari Barbershop →
        </a>
    </div>
</section>

<section class="home-section">
    <h2>Booking Semudah 1-2-3</h2>

    <div class="category-grid">
        <div class="category">
            <h3>01. Temukan</h3>
            <p>Cari barbershop sesuai lokasi dan kebutuhanmu.</p>
        </div>

        <div class="category">
            <h3>02. Reservasi</h3>
            <p>Pilih layanan dan jadwal yang tersedia.</p>
        </div>

        <div class="category">
            <h3>03. Grooming</h3>
            <p>Datang sesuai jadwal dan nikmati layanan.</p>
        </div>

        <div class="category">
            <h3>04. Selesai</h3>
            <p>Tampil lebih rapi dan percaya diri.</p>
        </div>
    </div>
</section>

@endsection
