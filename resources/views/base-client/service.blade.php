
@extends('layouts.owner-adminlte')

@section('title', 'Data Service')
@section('page-heading', 'Data Service')

@section('content')

{{-- Pesan berhasil --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Pesan kesalahan validasi --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title fw-semibold">
            <i class="bi bi-scissors me-2"></i>
            Daftar Service
        </h3>

        {{-- Tombol menuju form tambah service --}}
        <a href="{{ route('owner.service.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Service
        </a>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>No.</th>
                    <th>Foto</th>
                    <th>Nama Service</th>
                    <th>Harga</th>
                    <th>Durasi</th>
                    <th>Barbershop</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($services as $service)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            @if ($service->photo)
                                <img
                                    src="{{ asset('storage/' . $service->photo) }}"
                                    alt="Foto {{ $service->service_name }}"
                                    width="50"
                                    height="50"
                                    class="rounded"
                                    style="object-fit: cover;"
                                >
                            @else
                                <i class="bi bi-image fs-2 text-secondary"></i>
                            @endif
                        </td>

                        <td class="fw-semibold">
                            {{ $service->service_name }}
                        </td>

                        <td>
                            Rp {{ number_format($service->price, 0, ',', '.') }}
                        </td>

                        <td>
                            {{ $service->duration }} menit
                        </td>

                        <td>
                            {{ $service->goBarbershop->barbershop_name ?? '-' }}
                        </td>

                        <td>
                            {{-- Form hapus service --}}
                            <form
                                action="{{ route('owner.service.destroy', $service->service_id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus service ini?')"
                            >
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="bi bi-trash"></i>
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <i class="bi bi-scissors fs-2 text-secondary"></i>
                            <p class="mb-0 mt-2">Belum ada data service.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
