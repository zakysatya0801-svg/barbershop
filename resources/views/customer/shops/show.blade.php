
@extends('layouts.customer')

@section('title', $barbershop->barbershop_name . ' - GoBarber')

@push('styles')
<style>
    .shop-detail { max-width:1440px; margin:auto; padding:36px 5% 20px; }
    .breadcrumb { display:flex; gap:8px; align-items:center; color:#8b919d; font-size:12px; margin-bottom:22px; }
    .breadcrumb a { color:#555d6b; }
    .breadcrumb a:hover { color:#101828; }
    .shop-hero { display:grid; grid-template-columns:minmax(0,1.55fr) minmax(280px,.75fr); gap:22px; }
    .shop-cover { min-height:390px; border-radius:22px; overflow:hidden; position:relative; background:#1b1f29; }
    .shop-cover img { width:100%; height:100%; object-fit:cover; display:block; }
    .shop-cover-placeholder { height:390px; display:grid; place-items:center; background:linear-gradient(135deg,#222936,#101828); color:#cbd0d8; font-size:82px; }
    .cover-overlay { position:absolute; inset:auto 0 0; padding:28px 30px 24px; background:linear-gradient(transparent,rgba(8,12,20,.88)); color:white; }
    .cover-overlay h1 { margin:5px 0 8px; font-size:34px; line-height:1.15; }
    .cover-location { display:flex; align-items:center; gap:7px; color:#e7e9ed; font-size:13px; }
    .open-badge { display:inline-flex; align-items:center; gap:7px; border-radius:30px; background:#eaf8f0; color:#18794e; padding:8px 12px; font-size:11px; font-weight:800; }
    .open-badge::before { content:''; width:7px; height:7px; border-radius:50%; background:#22a66a; }
    .shop-side { display:flex; flex-direction:column; gap:16px; }
    .info-card { background:white; border:1px solid #e8eaee; border-radius:18px; padding:22px; }
    .rating-row { display:flex; justify-content:space-between; align-items:center; }
    .rating-score { display:flex; align-items:center; gap:9px; }
    .rating-score strong { font-size:28px; }
    .stars { color:#f5a623; letter-spacing:1px; font-size:13px; }
    .review-count { color:#858c98; font-size:11px; }
    .info-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-top:18px; }
    .info-box { background:#f7f8fa; border-radius:12px; padding:14px; }
    .info-box small { display:block; color:#9299a5; font-size:10px; margin-bottom:5px; }
    .info-box strong { display:block; font-size:12px; }
    .booking-card { background:#101828; color:white; padding:24px; border-radius:18px; }
    .booking-card small { color:#bdc3cd; }
    .booking-card h2 { margin:5px 0 18px; font-size:20px; }
    .booking-card .btn { width:100%; background:#f4a623; color:#101828; }
    .booking-card .btn:hover { background:#ffc14d; }
    .detail-layout { display:grid; grid-template-columns:minmax(0,1fr) 340px; gap:22px; margin-top:24px; align-items:start; }
    .detail-card { background:white; border:1px solid #e8eaee; border-radius:18px; padding:24px; margin-bottom:18px; }
    .section-head { display:flex; justify-content:space-between; align-items:center; gap:15px; margin-bottom:18px; }
    .section-head h2 { margin:0; font-size:20px; }
    .section-head span { color:#9299a5; font-size:11px; }
    .description { color:#687080; line-height:1.8; font-size:13px; margin:0; }
    .service-list { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
    .service-card { border:1px solid #e7e9ed; border-radius:14px; padding:16px; display:flex; flex-direction:column; gap:13px; transition:.2s; }
    .service-card:hover { border-color:#101828; box-shadow:0 10px 24px rgba(16,24,40,.07); transform:translateY(-2px); }
    .service-title { display:flex; justify-content:space-between; gap:10px; }
    .service-title h3 { margin:0; font-size:14px; line-height:1.45; }
    .service-title strong { font-size:14px; white-space:nowrap; }
    .service-card p { color:#858c98; font-size:11px; line-height:1.65; margin:-5px 0 0; }
    .service-meta { display:flex; justify-content:space-between; align-items:center; color:#697180; font-size:11px; }
    .service-meta a { font-weight:800; color:#101828; }
    .barber-list { display:grid; grid-template-columns:repeat(3,1fr); gap:12px; }
    .barber-card { text-align:center; border:1px solid #ebedf0; border-radius:14px; padding:16px 10px; }
    .barber-avatar { width:72px; height:72px; border-radius:50%; object-fit:cover; background:#edf0f4; margin:0 auto 10px; display:grid; place-items:center; font-size:28px; }
    .barber-card h3 { font-size:13px; margin:0 0 5px; }
    .barber-card p { color:#8b919d; font-size:10px; margin:0; }
    .review-list { display:grid; gap:12px; }
    .review-item { border-bottom:1px solid #edf0f2; padding-bottom:14px; }
    .review-item:last-child { border-bottom:0; padding-bottom:0; }
    .review-item strong { display:block; font-size:12px; }
    .review-item .stars { margin:5px 0; display:block; }
    .review-item p { color:#697180; font-size:12px; line-height:1.7; margin:0; }
    .sticky-info { position:sticky; top:100px; }
    .amenity-list { display:grid; gap:10px; }
    .amenity { display:flex; align-items:center; gap:10px; color:#626b79; font-size:12px; }
    .amenity span { width:30px; height:30px; display:grid; place-items:center; background:#f3f5f7; border-radius:8px; }
    .empty-state { color:#858c98; text-align:center; padding:24px 10px; border:1px dashed #dfe3e8; border-radius:12px; grid-column:1/-1; font-size:12px; }
    @media(max-width:980px) {
        .shop-hero,.detail-layout { grid-template-columns:1fr; }
        .sticky-info { position:static; }
    }
    @media(max-width:650px) {
        .shop-detail { padding:24px 16px 10px; }
        .shop-cover,.shop-cover-placeholder { min-height:280px; height:280px; }
        .cover-overlay { padding:22px 20px; }
        .cover-overlay h1 { font-size:25px; }
        .service-list { grid-template-columns:1fr; }
        .barber-list { grid-template-columns:1fr 1fr; }
        .detail-card { padding:18px; }
    }
</style>
@endpush

@php
    $availableServices = $barbershop->services->where('is_available', true);
    $minimumPrice = $availableServices->min('price');
    $averageRating = round((float) ($barbershop->reviews_avg_rating ?? 0), 1);
@endphp

@section('content')
<div class="shop-detail">
    <nav class="breadcrumb" aria-label="Navigasi">
        <a href="{{ route('home') }}">Beranda</a><span>›</span>
        <a href="{{ route('shops.explore') }}">Jelajah Barbershop</a><span>›</span>
        <strong>{{ $barbershop->barbershop_name }}</strong>
    </nav>

    <section class="shop-hero">
        <div class="shop-cover">
            @if($barbershop->photo_url)
                <img src="{{ $barbershop->photo_url }}" alt="{{ $barbershop->barbershop_name }}">
            @else
                <div class="shop-cover-placeholder">💈</div>
            @endif
            <div class="cover-overlay">
                <span class="open-badge">Buka hari ini</span>
                <h1>{{ $barbershop->barbershop_name }}</h1>
                <div class="cover-location">
                    <span>📍</span>
                    <span>{{ $barbershop->location?->city ?? 'Lokasi belum tersedia' }}{{ $barbershop->location?->province ? ', ' . $barbershop->location->province : '' }}</span>
                </div>
            </div>
        </div>

        <aside class="shop-side">
            <div class="info-card">
                <div class="rating-row">
                    <div class="rating-score">
                        <strong>{{ number_format($averageRating, 1) }}</strong>
                        <div>
                            <div class="stars">★★★★★</div>
                            <div class="review-count">{{ $barbershop->reviews_count }} ulasan pelanggan</div>
                        </div>
                    </div>
                </div>
                <div class="info-grid">
                    <div class="info-box">
                        <small>JAM OPERASIONAL</small>
                        <strong>{{ \Illuminate\Support\Str::of($barbershop->open_time)->substr(0,5) }} - {{ \Illuminate\Support\Str::of($barbershop->close_time)->substr(0,5) }}</strong>
                    </div>
                    <div class="info-box">
                        <small>MULAI DARI</small>
                        <strong>{{ $minimumPrice !== null ? 'Rp' . number_format($minimumPrice, 0, ',', '.') : 'Lihat layanan' }}</strong>
                    </div>
                </div>
            </div>

            <div class="booking-card">
                <small>SIAP GROOMING?</small>
                <h2>Pesan Jadwalmu Sekarang</h2>
                <a href="{{ route('booking', $barbershop->go_barbershop_id) }}" class="btn">Pilih Layanan &amp; Booking</a>
            </div>
        </aside>
    </section>

    <div class="detail-layout">
        <div>
            <section class="detail-card">
                <div class="section-head">
                    <h2>Tentang Barbershop</h2>
                </div>
                <p class="description">{{ $barbershop->description ?: 'Barbershop terpercaya untuk perawatan rambut dan grooming pria dengan pelayanan profesional.' }}</p>
            </section>

            <section class="detail-card">
                <div class="section-head">
                    <h2>Layanan Tersedia</h2>
                    <span>{{ $availableServices->count() }} layanan</span>
                </div>
                <div class="service-list">
                    @forelse($availableServices as $service)
                        <article class="service-card">
                            <div class="service-title">
                                <h3>{{ $service->service_name }}</h3>
                                <strong>Rp{{ number_format($service->price, 0, ',', '.') }}</strong>
                            </div>
                            <p>{{ $service->description ?: 'Layanan perawatan profesional dengan hasil rapi dan nyaman.' }}</p>
                            <div class="service-meta">
                                <span>◷ {{ $service->duration }} menit</span>
                                <a href="{{ route('booking', $barbershop->go_barbershop_id) }}">Pilih →</a>
                            </div>
                        </article>
                    @empty
                        <div class="empty-state">Belum ada layanan yang tersedia untuk barbershop ini.</div>
                    @endforelse
                </div>
            </section>

            <section class="detail-card">
                <div class="section-head">
                    <h2>Tim Barber</h2>
                    <span>{{ $barbershop->barbers->count() }} kapster</span>
                </div>
                <div class="barber-list">
                    @forelse($barbershop->barbers as $barber)
                        <article class="barber-card">
                            @if($barber->photo)
                                <img class="barber-avatar" src="{{ asset('storage/' . $barber->photo) }}" alt="{{ $barber->barber_name }}">
                            @else
                                <div class="barber-avatar">✂</div>
                            @endif
                            <h3>{{ $barber->barber_name }}</h3>
                            <p>{{ $barber->specialty ?: 'Barber Profesional' }}</p>
                        </article>
                    @empty
                        <div class="empty-state">Informasi barber belum tersedia.</div>
                    @endforelse
                </div>
            </section>

            @if($barbershop->reviews->isNotEmpty())
                <section class="detail-card">
                    <div class="section-head">
                        <h2>Ulasan Pelanggan</h2>
                        <span>{{ $barbershop->reviews_count }} ulasan</span>
                    </div>
                    <div class="review-list">
                        @foreach($barbershop->reviews->take(4) as $review)
                            <article class="review-item">
                                <strong>Pelanggan terverifikasi</strong>
                                <span class="stars">{{ str_repeat('★', max(1, min(5, $review->rating))) }}{{ str_repeat('☆', max(0, 5 - $review->rating)) }}</span>
                                <p>{{ $review->comment ?: 'Pelanggan memberikan penilaian untuk layanan ini.' }}</p>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>

        <aside class="sticky-info">
            <section class="detail-card">
                <div class="section-head"><h2>Fasilitas</h2></div>
                <div class="amenity-list">
                    <div class="amenity"><span>✓</span> Kapster profesional</div>
                    <div class="amenity"><span>♨</span> Perawatan hot towel</div>
                    <div class="amenity"><span>⚡</span> Booking online</div>
                    <div class="amenity"><span>◈</span> Alat steril &amp; higienis</div>
                </div>
            </section>

            <section class="detail-card">
                <div class="section-head"><h2>Lokasi</h2></div>
                <p class="description">{{ $barbershop->location?->city ?? 'Kota belum tersedia' }}{{ $barbershop->location?->province ? ', ' . $barbershop->location->province : '' }}</p>
            </section>
        </aside>
    </div>
</div>
@endsection
