
@extends('layouts.owner-adminlte')

@section('title', 'Tambah Barbershop')

@section('content_header')
    <h1>Tambah Barbershop</h1>
@stop

@section('content')

    {{-- Menampilkan pesan validasi jika ada kesalahan input --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Periksa kembali data yang dimasukkan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Form Data Barbershop</h3>
        </div>

        <form action="{{ route('owner.barbershop.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="card-body">

                {{-- Nama barbershop --}}
                <div class="form-group mb-3">
                    <label for="barbershop_name">Nama Barbershop</label>

                    <input
                        type="text"
                        name="barbershop_name"
                        id="barbershop_name"
                        class="form-control @error('barbershop_name') is-invalid @enderror"
                        value="{{ old('barbershop_name') }}"
                        placeholder="Masukkan nama barbershop"
                        required
                    >

                    @error('barbershop_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi barbershop --}}
                <div class="form-group mb-3">
                    <label for="description">Deskripsi</label>

                    <textarea
                        name="description"
                        id="description"
                        class="form-control @error('description') is-invalid @enderror"
                        rows="4"
                        placeholder="Masukkan deskripsi barbershop"
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Foto barbershop --}}
                <div class="form-group mb-3">
                    <label for="photo">Foto Barbershop</label>

                    <input
                        type="file"
                        name="photo"
                        id="photo"
                        class="form-control @error('photo') is-invalid @enderror"
                        accept="image/*"
                    >

                    <small class="text-muted">
                        Format gambar JPG, JPEG, PNG. Maksimal 2 MB.
                    </small>

                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jam buka --}}
                <div class="form-group mb-3">
                    <label for="open_time">Jam Buka</label>

                    <input
                        type="time"
                        name="open_time"
                        id="open_time"
                        class="form-control @error('open_time') is-invalid @enderror"
                        value="{{ old('open_time') }}"
                        required
                    >

                    @error('open_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Jam tutup --}}
                <div class="form-group mb-3">
                    <label for="close_time">Jam Tutup</label>

                    <input
                        type="time"
                        name="close_time"
                        id="close_time"
                        class="form-control @error('close_time') is-invalid @enderror"
                        value="{{ old('close_time') }}"
                        required
                    >

                    @error('close_time')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <div class="card-footer">
                {{-- Tombol kembali ke daftar barbershop --}}
                <a href="{{ route('owner.barbershop') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

                {{-- Tombol menyimpan data --}}
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Barbershop
                </button>
            </div>

        </form>
    </div>

@stop
