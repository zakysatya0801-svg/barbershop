
@extends('layouts.owner-adminlte')

@section('title', 'Profil Owner')
@section('page-heading', 'Profil Owner')

@section('content')
<div class="container-fluid">

    {{-- Menampilkan notifikasi jika profil berhasil diperbarui. --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Menampilkan pesan error validasi. --}}
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
        <div class="card-header">
            <h3 class="card-title">Informasi Profil</h3>
        </div>

        <form action="{{ route('owner.profil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">

                {{-- Nama Owner sesuai kolom nama_owners. --}}
                <div class="form-group mb-3">
                    <label for="nama_owners">Nama Lengkap</label>
                    <input
                        type="text"
                        name="nama_owners"
                        id="nama_owners"
                        class="form-control @error('nama_owners') is-invalid @enderror"
                        value="{{ old('nama_owners', $owner->nama_owners) }}"
                        required
                    >
                    @error('nama_owners')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email Owner sesuai kolom email. --}}
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', $owner->email) }}"
                        required
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nomor telepon Owner sesuai kolom phone. --}}
                <div class="form-group mb-3">
                    <label for="phone">Nomor Telepon</label>
                    <input
                        type="text"
                        name="phone"
                        id="phone"
                        class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', $owner->phone) }}"
                        required
                    >
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
