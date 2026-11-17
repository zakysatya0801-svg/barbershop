
@extends('layouts.client')

@section('content')
<style>
    .edit-page {
        padding: 28px;
        max-width: 1050px;
        margin: auto;
        color: #1f2937;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        color: #64748b;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 22px;
    }

    .back-link:hover {
        color: #183b35;
    }

    .edit-heading {
        margin-bottom: 22px;
    }

    .edit-heading h1 {
        font-size: 26px;
        font-weight: 750;
        margin: 0 0 6px;
    }

    .edit-heading p {
        color: #6b7280;
        font-size: 14px;
        margin: 0;
    }

    .edit-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0,0,0,.04);
        overflow: hidden;
    }

    .edit-card-header {
        padding: 20px 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .edit-card-header h2 {
        margin: 0;
        font-size: 17px;
        font-weight: 700;
    }

    .edit-card-header p {
        margin: 5px 0 0;
        color: #6b7280;
        font-size: 13px;
    }

    .edit-form {
        padding: 25px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 650;
        color: #374151;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        padding: 11px 13px;
        font-size: 14px;
        color: #1f2937;
        background: #fff;
        outline: none;
        transition: .2s;
    }

    .form-control:focus {
        border-color: #24564c;
        box-shadow: 0 0 0 3px rgba(36,86,76,.10);
    }

    textarea.form-control {
        min-height: 110px;
        resize: vertical;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .form-hint {
        display: block;
        color: #9ca3af;
        font-size: 12px;
        margin-top: 6px;
    }

    .field-error {
        color: #dc2626;
        font-size: 12px;
        margin-top: 6px;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        border-top: 1px solid #e5e7eb;
        padding-top: 22px;
        margin-top: 10px;
    }

    .btn-save, .btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 8px;
        padding: 11px 18px;
        font-size: 14px;
        font-weight: 650;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-save {
        background: #183b35;
        color: #fff;
    }

    .btn-save:hover {
        background: #24564c;
    }

    .btn-cancel {
        background: #f3f4f6;
        color: #4b5563;
    }

    .btn-cancel:hover {
        background: #e5e7eb;
    }

    @media (max-width: 650px) {
        .edit-page {
            padding: 16px;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .edit-form {
            padding: 18px;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn-save, .btn-cancel {
            width: 100%;
        }
    }
</style>

<div class="edit-page">

    <a href="{{ route('owner.layanan.index') }}" class="back-link">
        ← Kembali ke daftar layanan
    </a>

    <div class="edit-heading">
        <h1>Edit Layanan</h1>
        <p>Perbarui informasi layanan barbershop kamu.</p>
    </div>

    @if ($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:14px 18px;border-radius:9px;margin-bottom:18px;">
            <strong>Periksa kembali data yang kamu masukkan:</strong>
            <ul style="margin:8px 0 0;padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="edit-card">
        <div class="edit-card-header">
            <h2>Informasi Layanan</h2>
            <p>Ubah detail layanan yang ingin diperbarui.</p>
        </div>

        <form action="{{ route('owner.layanan.update', $service->service_id) }}"
              method="POST"
              class="edit-form">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="service_name">Nama Layanan</label>
                <input
                    type="text"
                    id="service_name"
                    name="service_name"
                    class="form-control"
                    value="{{ old('service_name', $service->service_name) }}"
                    placeholder="Contoh: Classic Haircut"
                    required
                >
                @error('service_name')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Harga (Rp)</label>
                    <input
                        type="number"
                        id="price"
                        name="price"
                        class="form-control"
                        value="{{ old('price', $service->price) }}"
                        min="0"
                        placeholder="35000"
                        required
                    >
                    @error('price')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="duration">Durasi (menit)</label>
                    <input
                        type="number"
                        id="duration"
                        name="duration"
                        class="form-control"
                        value="{{ old('duration', $service->duration) }}"
                        min="1"
                        placeholder="30"
                        required
                    >
                    @error('duration')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea
                    id="description"
                    name="description"
                    class="form-control"
                    placeholder="Jelaskan detail layanan..."
                >{{ old('description', $service->description) }}</textarea>
                    @error('description')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
            </div>

            <div class="form-group">
                <label for="photo">URL Foto Layanan</label>
                <input
                    type="text"
                    id="photo"
                    name="photo"
                    class="form-control"
                    value="{{ old('photo', $service->photo) }}"
                    placeholder="https://contoh.com/foto.jpg"
                >
                <span class="form-hint">Masukkan tautan gambar jika layanan memiliki foto.</span>
                @error('photo')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="is_available">Status Ketersediaan</label>
                <select id="is_available" name="is_available" class="form-control" required>
                    <option value="1" {{ (string) old('is_available', (int) $service->is_available) === '1' ? 'selected' : '' }}>
                        Tersedia
                    </option>
                    <option value="0" {{ (string) old('is_available', (int) $service->is_available) === '0' ? 'selected' : '' }}>
                        Tidak tersedia
                    </option>
                </select>
                @error('is_available')
                    <div class="field-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('owner.layanan.index') }}" class="btn-cancel">
                    Batal
                </a>

                <button type="submit" class="btn-save">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
