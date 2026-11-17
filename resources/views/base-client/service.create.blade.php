
@extends('layouts.owner-adminlte')

@section('title', 'Tambah Service')
@section('page-heading', 'Tambah Service')

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title fw-semibold">
            <i class="bi bi-plus-circle me-2"></i>
            Form Tambah Service
        </h3>
    </div>

    <form action="{{ route('owner.service.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card-body">

            {{-- Memilih barbershop pemilik layanan --}}
            <div class="mb-3">
                <label for="go_barbershop_id" class="form-label">
                    Pilih Barbershop
                </label>

                <select
                    name="go_barbershop_id"
                    id="go_barbershop_id"
                    class="form-select @error('go_barbershop_id') is-invalid @enderror"
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
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Nama service --}}
            <div class="mb-3">
                <label for="service_name" class="form-label">
                    Nama Service
                </label>

                <input
                    type="text"
                    name="service_name"
                    id="service_name"
                    class="form-control @error('service_name') is-invalid @enderror"
                    value="{{ old('service_name') }}"
                    placeholder="Contoh: Haircut"
                    required
                >

                @error('service_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Harga service --}}
            <div class="mb-3">
                <label for="price" class="form-label">Harga (Rp)</label>

                <input
                    type="number"
                    name="price"
                    id="price"
                    class="form-control @error('price') is-invalid @enderror"
                    value="{{ old('price') }}"
                    placeholder="Contoh: 35000"
                    min="0"
                    step="0.01"
                    required
                >

                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Durasi pengerjaan --}}
            <div class="mb-3">
                <label for="duration" class="form-label">
                    Durasi (Menit)
                </label>

                <input
                    type="number"
                    name="duration"
                    id="duration"
                    class="form-control @error('duration') is-invalid @enderror"
                    value="{{ old('duration') }}"
                    placeholder="Contoh: 30"
                    min="1"
                    required
                >

                @error('duration')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Foto service --}}
            <div class="mb-3">
                <label for="photo" class="form-label">Foto Service</label>

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
                Simpan Service
            </button>

            <a href="{{ route('owner.service') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>
    </form>
</div>

@endsection
