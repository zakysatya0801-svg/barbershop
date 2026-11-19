
@extends('layouts.owner-adminlte')

@section('title', 'Data Booking')
@section('page-heading', 'Data Booking')

@section('content')
<div class="container-fluid">

    {{-- Notifikasi jika ada pesan dari controller. --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Booking Customer</h3>
        </div>

        <div class="card-body">

            {{-- Tampilkan pesan jika belum ada booking. --}}
            @if ($bookings->isEmpty())
                <div class="alert alert-info mb-0">
                    Belum ada booking untuk barbershop Anda.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Customer</th>
                                <th>Barbershop</th>
                                <th>Service</th>
                                <th>Barber</th>
                                <th>Tanggal</th>
                                <th>Jam</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($bookings as $booking)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    {{-- Nama customer dari relasi customer. --}}
                                    <td>
                                        {{ $booking->customer->name ?? '-' }}
                                    </td>

                                    {{-- Nama barbershop dari relasi goBarberShop. --}}
                                    <td>
                                        {{ $booking->goBarberShop->barbershop_name ?? '-' }}
                                    </td>

                                    {{-- Nama layanan dari relasi service. --}}
                                    <td>
                                        {{ $booking->service->service_name ?? '-' }}
                                    </td>

                                    {{-- Nama barber dari relasi barber. --}}
                                    <td>
                                        {{ $booking->barber->barber_name ?? '-' }}
                                    </td>

                                    {{-- Format tanggal booking. --}}
                                    <td>
                                        {{ $booking->booking_date?->format('d-m-Y') ?? '-' }}
                                    </td>

                                    {{-- Jam booking sesuai time_slot. --}}
                                    <td>{{ $booking->time_slot }}</td>

                                    {{-- Status booking. --}}
                                    <td>
                                        @php
                                            $statusClass = match ($booking->status) {
                                                'pending' => 'warning',
                                                'confirmed' => 'success',
                                                'completed' => 'primary',
                                                'cancelled' => 'danger',
                                                default => 'secondary',
                                            };
                                        @endphp

                                        <span class="badge bg-{{ $statusClass }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
