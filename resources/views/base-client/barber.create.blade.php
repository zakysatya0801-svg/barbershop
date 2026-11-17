
@extends('layouts.owner-adminlte')

@section('title', 'Tambah Barber')
@section('page-heading', 'Tambah Barber')

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title fw-semibold">
            <i class="bi bi-person-plus me-2"></i>
            Form Tambah Barber
        </h3>
    </div>

    <form action="{{ route('owner.barber.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card-body">

            {{-- Memilih barbershop tempat barber bekerja --}}
            <div class="mb-3">
                <label for="go_barbershop_id" class="form-label">
                    Pilih Barbershop
                </label>

                <select name="go_barbershop_id" id="go_barbershop_id"
                    class="form-select @error('go_barbershop_id') is-invalid @enderror" required>

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
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input nama barber --}}
            <div class="mb-3">
                <label for="barber_name" class="form-label">Nama Barber</label>

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
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Input keahlian barber --}}
            <div class="mb-3">
                <label for="specialty" class="form-label">Keahlian</label>

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
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Upload foto barber --}}
            <div class="mb-3">
                <label for="photo" class="form-label">Foto Barber</label>

                <input
                    type="file"
                    name="photo"
                    id="photo"
                    class="form-control @error('photo') is-invalid @enderror"
                    accept="image/*"
                >

                <small class="text-secondary">
                    Format gambar dan ukuran maksimal 2 MB.
                </small>

                @error('photo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i>
                Simpan Barber
            </button>

            <a href="{{ route('owner.barber') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </form>
</div>

@endsection
