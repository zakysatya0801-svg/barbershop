{{-- Menggunakan layout dashboard Owner --}}
@extends('layouts.client')

@section('title', 'Dashboard Owner')
@section('page-title', 'Dashboard Owner')

@section('content')

    {{-- Kartu ringkasan dashboard --}}
    <div class="app-cards">

        <div class="app-card app-info">
            <h2>{{ $barbershops->count() }}</h2>
            <div>Total Barbershop</div>
        </div>

        <div class="app-card app-success">
            <h2>{{ $owner->nama_owners }}</h2>
            <div>Nama Owner</div>
        </div>

        <div class="app-card app-warning">
            <h2>Aktif</h2>
            <div>Status Dashboard</div>
        </div>

    </div>

    {{-- Tabel barbershop milik Owner --}}
    <section class="app-panel">
        <div class="app-panel-title">Daftar Barbershop Saya</div>

        <table class="app-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Barbershop</th>
                    <th>Deskripsi</th>
                    <th>Jam Buka</th>
                    <th>Jam Tutup</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($barbershops as $barbershop)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $barbershop->barbershop_name }}</td>
                        <td>{{ $barbershop->description ?? '-' }}</td>
                        <td>{{ $barbershop->open_time ?? '-' }}</td>
                        <td>{{ $barbershop->close_time ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Belum ada data barbershop.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </section>

@endsection
