
@extends('layouts.customer')

@section('content')
<div class="container" style="max-width: 1100px; margin: 40px auto; padding: 20px;">

    <a href="{{ route('shops.explore') }}">← Kembali ke Jelajah</a>

    <h1 style="margin-top: 25px;">
        {{ $barbershop->barbershop_name }}
    </h1>

    <p>
        {{ $barbershop->location->city ?? 'Lokasi belum tersedia' }}
    </p>

    <p>
        {{ $barbershop->description ?? 'Belum ada deskripsi.' }}
    </p>

    <p>
        Rating:
        {{ number_format($barbershop->reviews_avg_rating ?? 0, 1) }}
        / 5 ({{ $barbershop->reviews_count }} ulasan)
    </p>

    <h2>Layanan</h2>

    @forelse ($barbershop->services as $service)
        <div style="padding: 15px; border: 1px solid #ddd; margin-bottom: 10px; border-radius: 10px;">
            <strong>{{ $service->service_name }}</strong>
            <p>Rp{{ number_format($service->price, 0, ',', '.') }}</p>
        </div>
    @empty
        <p>Belum ada layanan tersedia.</p>
    @endforelse

    <h2>Barber</h2>

    @forelse ($barbershop->barbers as $barber)
        <p>{{ $barber->barber_name }}</p>
    @empty
        <p>Belum ada barber tersedia.</p>
    @endforelse

    <a href="{{ route('booking', $barbershop->go_barbershop_id) }}"
       style="display: inline-block; margin-top: 20px; padding: 12px 24px; background: #18324B; color: white; border-radius: 8px; text-decoration: none;">
        Booking Sekarang
    </a>

</div>
@endsection
