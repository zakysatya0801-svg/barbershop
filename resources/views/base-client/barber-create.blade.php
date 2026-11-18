
@extends('layouts.owner-adminlte')

@section('title', 'Tambah Barber')

@section('content_header')
    <h1>Tambah Barber</h1>
@stop

@section('content')

    {{-- Menampilkan pesan kesalahan validasi --}}
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

    {{-- Jika Owner belum mempunyai barbershop --}}
    @if ($barbershops->isEmpty())

        <div class="alert alert-warning">
            Kamu belum memiliki barbershop.
            Silakan tambahkan barbershop terlebih dahulu sebelum menambahkan barber.
        </div>

        <a href="{{ route('owner.barbershop.create') }}"
           class="btn btn-primary">
            Tambah Barbershop
        </a>

    @else

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Data Barber</h3>
            </div>

            {{-- Form dikirim ke BarberController method store --}}
            <form action="{{ route('owner.barber.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="card-body">

                    {{-- Memilih barbershop tempat barber bekerja --}}
                    <div class="form-group mb-3">
                        <label for="go_barbershop_id">
                            Pilih Barbershop
                        </label>

                        <select
                            name="go_barbershop_id"
                            id="go_barbershop_id"
                            class="form-control @error('go_barbershop_id') is-invalid @enderror"
                            required
                        >
                            <option value="">-- Pilih Barbershop --</option>

                            @foreach ($barbershops as $barbershop)
                                <option
                                    value="{{ $barbershop->go_barbershop_id }}"
                                    {{ old('go_barbershop_id') == $barbershop->go_barbershop_id ? 'selected' : '' }}
                                >
                                    {{ $barbershop->barbershop_name }}
                                </option>
                            @endforeach
                        </select>

                        @error('go_barbershop_id')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Nama barber --}}
                    <div class="form-group mb-3">
                        <label for="barber_name">Nama Barber</label>

                        <input
                            type="text"
                            name="barber_name"
                            id="barber_name"
                            class="form-control @error('barber_name') is-invalid @enderror"
                            value="{{ old('barber_name') }}"
                            placeholder="Masukkan nama barber"
                            required
                        >

                        @error('barber_name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Keahlian barber --}}
                    <div class="form-group mb-3">
                        <label for="specialty">Keahlian</label>

                        <input
                            type="text"
                            name="specialty"
                            id="specialty"
                            class="form-control @error('specialty') is-invalid @enderror"
                            value="{{ old('specialty') }}"
                            placeholder="Contoh: Haircut, Hair Styling"
                            required
                        >

                        @error('specialty')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Foto barber --}}
                    <div class="form-group mb-3">
                        <label for="photo">Foto Barber</label>

                        <input
                            type="file"
                            name="photo"
                            id="photo"
                            class="form-control @error('photo') is-invalid @enderror"
                            accept="image/*"
                        >

                        <small class="text-muted">
                            Format JPG, JPEG, atau PNG. Maksimal 2 MB.
                        </small>

                        @error('photo')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                <div class="card-footer">

                    {{-- Kembali ke daftar barber --}}
                    <a href="{{ route('owner.barber') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                    {{-- Menyimpan data barber --}}
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Simpan Barber
                    </button>

                </div>
            </form>
        </div>

    @endif

@stop
