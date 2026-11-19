
@extends('layouts.owner-adminlte')

@section('title', 'Data Barber')
@section('page-heading', 'Data Barber')

@section('content')

{{-- Menampilkan pesan sukses setelah proses penyimpanan atau penghapusan --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Menampilkan pesan validasi jika ada kesalahan input --}}
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
            <i class="bi bi-people me-2"></i>
            Daftar Barber
        </h3>

        {{-- Tombol menuju form tambah barber --}}
        <a href="{{ route('owner.barber.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Barber
        </a>
    </div>

    <div class="card-body table-responsive p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>No.</th>
                    <th>Foto</th>
                    <th>Nama Barber</th>
                    <th>Keahlian</th>
                    <th>Barbershop</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($barbers as $barber)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            @if ($barber->photo)
                                <img
                                    src="{{ asset('storage/' . $barber->photo) }}"
                                    alt="Foto {{ $barber->barber_name }}"
                                    width="50"
                                    height="50"
                                    class="rounded-circle"
                                    style="object-fit: cover;"
                                >
                            @else
                                <i class="bi bi-person-circle fs-2 text-secondary"></i>
                            @endif
                        </td>

                        <td class="fw-semibold">
                            {{ $barber->barber_name }}
                        </td>

                        <td>{{ $barber->specialty }}</td>

                        <td>
                            {{ $barber->goBarbershop->barbershop_name ?? '-' }}
                        </td>

                        <td>
                            {{-- Form hapus menggunakan HTTP DELETE --}}
                            <form
                                action="{{ route('owner.barber.destroy', $barber->barber_id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus barber ini?')"
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
                        <td colspan="6" class="text-center py-4">
                            <i class="bi bi-people fs-2 text-secondary"></i>
                            <p class="mb-0 mt-2">Belum ada data barber.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
