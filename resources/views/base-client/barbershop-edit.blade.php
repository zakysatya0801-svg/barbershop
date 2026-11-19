
@extends('layouts.owner-adminlte')

@section('title', 'Edit Barbershop')

@section('content')
<div class="container-fluid">

    <h3 class="mb-4">Edit Barbershop</h3>

    <div class="card">
        <div class="card-body">

            {{-- Form memperbarui barbershop berdasarkan ID yang dipilih. --}}
            <form
                action="{{ route('owner.barbershop.update', $barbershop->go_barbershop_id) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                @method('PUT')

                {{-- Nama barbershop. --}}
                <div class="mb-3">
                    <label class="form-label">Nama Barbershop</label>

                    <input
                        type="text"
                        name="barbershop_name"
                        class="form-control @error('barbershop_name') is-invalid @enderror"
                        value="{{ old('barbershop_name', $barbershop->barbershop_name) }}"
                        required
                    >

                    @error('barbershop_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Deskripsi barbershop. --}}
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>

                    <textarea
                        name="description"
                        class="form-control @error('description') is-invalid @enderror"
                        rows="4"
                    >{{ old('description', $barbershop->description) }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Menampilkan foto lama jika tersedia. --}}
                @if ($barbershop->photo)
                    <div class="mb-3">
                        <label class="form-label">Foto Saat Ini</label>
                        <div>
                            <img
                                src="{{ asset('storage/' . $barbershop->photo) }}"
                                alt="Foto barbershop"
                                width="150"
                                style="object-fit: cover;"
                            >
                        </div>
                    </div>
                @endif

                {{-- Upload foto baru bersifat opsional. --}}
                <div class="mb-3">
                    <label class="form-label">Ganti Foto Barbershop</label>

                    <input
                        type="file"
                        name="photo"
                        class="form-control @error('photo') is-invalid @enderror"
                        accept="image/*"
                    >

                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    {{-- Jam buka. --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jam Buka</label>

                        <input
                            type="time"
                            name="open_time"
                            class="form-control @error('open_time') is-invalid @enderror"
                            value="{{ old('open_time', substr($barbershop->open_time, 0, 5)) }}"
                            required
                        >

                        @error('open_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jam tutup. --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jam Tutup</label>

                        <input
                            type="time"
                            name="close_time"
                            class="form-control @error('close_time') is-invalid @enderror"
                            value="{{ old('close_time', substr($barbershop->close_time, 0, 5)) }}"
                            required
                        >

                        @error('close_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Tombol simpan perubahan. --}}
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Perubahan
                </button>

                <a href="{{ route('owner.barbershop') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

            </form>
        </div>
    </div>
</div>
@endsection
