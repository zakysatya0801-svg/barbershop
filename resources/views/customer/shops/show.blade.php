
@extends('layouts.customer')

@section('title', 'Detail Barbershop - GoBarber')

@section('content')
@php
    $minimumPrice = $barbershop->services
        ->where('is_available', true)
        ->min('price');
@endphp

<style>
    .detail-page {
        background: #0d0f14;
        color: #f5f5f5;
        min-height: 100vh;
        padding-bottom: 80px;
        font-family: 'DM Sans', sans-serif;
    }

    .detail-container {
        width: min(1120px, 92%);
        margin: auto;
    }

    .detail-hero {
        padding: 45px 0 30px;
    }

    .detail-breadcrumb {
        color: #9296a3;
        font-size: 13px;
        margin-bottom: 22px;
    }

    .detail-breadcrumb a {
        color: #f5a623;
        text-decoration: none;
    }

    .detail-cover {
        height: 390px;
        border-radius: 20px;
        overflow: hidden;
        background: #1c202b;
        position: relative;
    }

    .detail-cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .detail-cover::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(transparent 55%, rgba(0,0,0,.55));
    }

    .detail-content {
        display: grid;
        grid-template-columns: 1.6fr .8fr;
        gap: 25px;
        margin-top: 30px;
    }

    .detail-card {
        background: #151821;
        border: 1px solid #262a35;
        border-radius: 16px;
        padding: 25px;
        margin-bottom: 22px;
    }

    .detail-title {
        font-size: 30px;
        font-weight: 800;
        margin: 0 0 12px;
    }

    .detail-location {
        color: #a4a8b3;
        font-size: 14px;
        margin-bottom: 18px;
    }

    .detail-description {
        color: #b5b8c2;
        line-height: 1.8;
        font-size: 14px;
    }

    .detail-heading {
        font-size: 19px;
        font-weight: 700;
        margin: 0 0 20px;
    }

    .detail-service {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 17px 0;
        border-bottom: 1px solid #292d38;
    }

    .detail-service:last-child {
        border-bottom: none;
    }

    .service-name {
        font-weight: 700;
        margin-bottom: 6px;
    }

    .service-duration {
        color: #9296a3;
        font-size: 13px;
    }

    .service-price {
        color: #f5a623;
        font-weight: 800;
        white-space: nowrap;
    }

    .detail-barber {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid #292d38;
    }

    .detail-barber:last-child {
        border-bottom: none;
    }

    .barber-photo {
        width: 55px;
        height: 55px;
        border-radius: 50%;
        object-fit: cover;
        background: #292d38;
    }

    .barber-name {
        font-weight: 700;
        margin-bottom: 5px;
    }

    .barber-specialty {
        color: #9296a3;
        font-size: 13px;
    }

    .booking-card {
        position: sticky;
        top: 100px;
    }

    .booking-price {
        font-size: 28px;
        font-weight: 800;
        color: #f5a623;
        margin: 10px 0;
    }

    .booking-note {
        color: #9296a3;
        font-size: 13px;
        margin-bottom: 22px;
    }

    .btn-booking {
        display: block;
        width: 100%;
        background: #f5a623;
        color: #171717;
        padding: 14px 18px;
        text-align: center;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 800;
        transition: .2s;
    }

    .btn-booking:hover {
        background: #ffc15a;
        color: #171717;
        transform: translateY(-2px);
    }

    .btn-back {
        display: inline-block;
        color: #f5a623;
        text-decoration: none;
        font-size: 14px;
        margin-top: 25px;
    }

    .empty-detail {
        color: #9296a3;
        font-size: 14px;
        padding: 10px 0;
    }

    @media(max-width: 768px) {
        .detail-content {
            grid-template-columns: 1fr;
        }

        .detail-cover {
            height: 240px;
        }

        .detail-title {
            font-size: 24px;
        }

        .booking-card {
            position: static;
        }
    }
</style>

<div class="detail-page">
    <div class="detail-container">

        <div class="detail-hero">
            <div class="detail-breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                /
                <a href="{{ route('shops.explore') }}">Jelajah Barbershop</a>
                /
                Detail Barbershop
            </div>

            <div class="detail-cover">
                @if($barbershop->photo)
                    <img
                        src="{{ asset('storage/' . $barbershop->photo) }}"
                        alt="{{ $barbershop->barbershop_name }}"
                    >
                @else
                    <img
                        src="https://placehold.co/1200x500/151821/f5a623?text=GoBarber+Shop"
                        alt="Foto Barbershop"
                    >
                @endif
            </div>
        </div>

        <div class="detail-content">

            <div>
                {{-- INFORMASI BARBERSHOP --}}
                <div class="detail-card">
                    <h1 class="detail-title">
                        {{ $barbershop->barbershop_name }}
                    </h1>

                    <div class="detail-location">
                        <i class="fa-solid fa-location-dot"></i>
                        {{ $barbershop->location->city ?? 'Lokasi belum tersedia' }}
                        @if(!empty($barbershop->location->province))
                            , {{ $barbershop->location->province }}
                        @endif
                    </div>

                    <p class="detail-description">
                        {{ $barbershop->description ?? 'Nikmati layanan potong rambut profesional dengan barber berpengalaman dan pelayanan terbaik.' }}
                    </p>
                </div>

                {{-- JAM OPERASIONAL --}}
                <div class="detail-card">
                    <h2 class="detail-heading">Jam Operasional</h2>

                    <p class="detail-description">
                        <i class="fa-regular fa-clock" style="color:#f5a623"></i>
                        {{ $barbershop->open_time ?? '-' }}
                        -
                        {{ $barbershop->close_time ?? '-' }}
                    </p>
                </div>

                {{-- DAFTAR LAYANAN --}}
                <div class="detail-card">
                    <h2 class="detail-heading">Layanan Barbershop</h2>

                    @forelse($barbershop->services->where('is_available', true) as $service)
                        <div class="detail-service">
                            <div>
                                <div class="service-name">
                                    {{ $service->service_name }}
                                </div>

                                <div class="service-duration">
                                    <i class="fa-regular fa-clock"></i>
                                    {{ $service->duration }} menit
                                </div>
                            </div>

                            <div class="service-price">
                                Rp{{ number_format($service->price, 0, ',', '.') }}
                            </div>
                        </div>
                    @empty
                        <p class="empty-detail">
                            Belum ada layanan yang tersedia.
                        </p>
                    @endforelse
                </div>

                {{-- DAFTAR BARBER --}}
                <div class="detail-card">
                    <h2 class="detail-heading">Barber Profesional</h2>

                    @forelse($barbershop->barbers as $barber)
                        <div class="detail-barber">
                            @if($barber->photo)
                                <img
                                    class="barber-photo"
                                    src="{{ asset('storage/' . $barber->photo) }}"
                                    alt="{{ $barber->barber_name }}"
                                >
                            @else
                                <div class="barber-photo"
                                     style="display:flex;align-items:center;justify-content:center;color:#f5a623">
                                    <i class="fa-solid fa-user"></i>
                                </div>
                            @endif

                            <div>
                                <div class="barber-name">
                                    {{ $barber->barber_name }}
                                </div>

                                <div class="barber-specialty">
                                    {{ $barber->specialty ?? 'Professional Barber' }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="empty-detail">
                            Informasi barber belum tersedia.
                        </p>
                    @endforelse
                </div>

                <a href="{{ route('shops.explore') }}" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kembali ke Jelajah Barbershop
                </a>
            </div>

            {{-- KARTU BOOKING --}}
            <div>
                <div class="detail-card booking-card">
                    <h2 class="detail-heading">Booking Sekarang</h2>

                    <p class="detail-description">
                        Mulai dari
                    </p>

                    <div class="booking-price">
                        @if($minimumPrice !== null)
                            Rp{{ number_format($minimumPrice, 0, ',', '.') }}
                        @else
                            Belum tersedia
                        @endif
                    </div>

                    <p class="booking-note">
                        Harga layanan dapat berbeda sesuai pilihan layanan.
                    </p>

                    @if($barbershop->services->where('is_available', true)->isNotEmpty())
                        <a
                            href="{{ route('booking', $barbershop->go_barbershop_id) }}"
                            class="btn-booking"
                        >
                            <i class="fa-solid fa-calendar-check"></i>
                            Booking Sekarang
                        </a>
                    @else
                        <div class="empty-detail">
                            Booking belum tersedia karena belum ada layanan aktif.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
