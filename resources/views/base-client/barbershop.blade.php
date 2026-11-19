
@extends('layouts.owner-adminlte')

@section('title', 'Manajemen Barbershop')

@section('content')
<div class="container-fluid">

    {{-- Judul halaman dan tombol tambah barbershop. --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Manajemen Barbershop</h3>
            <p class="text-muted mb-0">
                Kelola seluruh barbershop yang kamu miliki.
            </p>
        </div>

        <a href="{{ route('owner.barbershop.create') }}"
           class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Barbershop
        </a>
    </div>

    {{-- Menampilkan notifikasi ketika data berhasil disimpan. --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Menampilkan daftar barbershop milik Owner. --}}
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Barbershop</h5>
        </div>

        <div class="card-body">

            {{-- Jika Owner belum mempunyai barbershop. --}}
            @if ($barbershops->isEmpty())
                <div class="text-center py-5">
                    <i class="fas fa-store fa-3x text-secondary mb-3"></i>

                    <h5>Belum Ada Barbershop</h5>

                    <p class="text-muted">
                        Silakan tambahkan data barbershop pertama kamu.
                    </p>

                    <a href="{{ route('owner.barbershop.create') }}"
                       class="btn btn-primary">
                        Tambah Barbershop
                    </a>
                </div>
            @else

                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Foto</th>
                                <th>Nama Barbershop</th>
                                <th>Jam Buka</th>
                                <th>Jam Tutup</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($barbershops as $index => $shop)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>
                                        {{-- Foto ditampilkan jika tersedia. --}}
                                        @if ($shop->photo_url)
                                            <img
                                                src="{{ $shop->photo_url }}"
                                                alt="Foto {{ $shop->barbershop_name }}"
                                                width="70"
                                                height="60"
                                                style="object-fit: cover;"
                                            >
                                        @else
                                            <span class="text-muted">
                                                Belum ada foto
                                            </span>
                                        @endif
                                    </td>

                                    <td>{{ $shop->barbershop_name }}</td>

                                    <td>{{ \Carbon\Carbon::parse($shop->open_time)->format('H:i') }}</td>

                                    <td>{{ \Carbon\Carbon::parse($shop->close_time)->format('H:i') }}</td>

                                    <td>{{ $shop->description ?: '-' }}</td>

                                    <td>
                                        <a
                                            href="{{ route('owner.barbershop.edit', $shop->go_barbershop_id) }}"
                                            class="btn btn-warning btn-sm"
                                        >
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
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
