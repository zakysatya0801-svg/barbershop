{{-- Menggunakan layout utama AdminLTE. --}}
@extends('layouts.adminlte')

{{-- Judul halaman browser. --}}
@section('title', 'Dashboard')

{{-- Judul di area konten. --}}
@section('page-heading', 'QR Code Barbershop')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="status">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->has('expires_at'))
        <div class="alert alert-danger" role="alert">
            {{ $errors->first('expires_at') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <h4>Kelola QR Code barbershop</h4>
            <p class="mb-0">
                Buat QR Code untuk dibagikan atau dipasang di barbershop.
                QR yang baru akan menonaktifkan QR aktif sebelumnya.
            </p>
        </div>
    </div>

    @if ($barbershops->isEmpty())
        <div class="alert alert-info" role="status">
            Belum ada data barbershop yang dapat dibuatkan QR Code.
        </div>
    @else
        <div class="row g-4">
            @foreach ($barbershops as $barbershop)
                <div class="col-12 col-xl-6">
                    <section class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ $barbershop->barbershop_name }}</h5>
                        </div>

                        <div class="card-body">
                            @if ($barbershop->activeToken)
                                <div class="d-flex flex-column align-items-center gap-3 mb-4">
                                    <img
                                        src="{{ $qrImageUrls[$barbershop->go_barbershop_id] }}"
                                        alt="QR Code {{ $barbershop->barbershop_name }}"
                                        class="img-fluid border rounded p-2"
                                        style="max-width: 260px"
                                    >
                                    <div class="text-center">
                                        <span class="badge text-bg-success">Aktif</span>
                                        @if ($barbershop->activeToken->expires_at)
                                            <p class="mb-0 mt-2">
                                                Berlaku sampai
                                                {{ $barbershop->activeToken->expires_at->format('d-m-Y H:i') }}
                                            </p>
                                        @else
                                            <p class="mb-0 mt-2">Tidak memiliki batas kedaluwarsa</p>
                                        @endif
                                    </div>
                                    <a
                                        href="{{ $qrImageUrls[$barbershop->go_barbershop_id] }}"
                                        class="btn btn-outline-primary btn-sm"
                                        download
                                    >
                                        Unduh SVG
                                    </a>
                                </div>
                            @else
                                <p class="text-body-secondary">
                                    Belum ada QR aktif untuk barbershop ini.
                                </p>
                            @endif

                            <form
                                action="{{ route('admin.barbershops.qr-code.store', $barbershop) }}"
                                method="POST"
                            >
                                @csrf

                                <div class="mb-3">
                                    <label
                                        for="expires-at-{{ $barbershop->go_barbershop_id }}"
                                        class="form-label"
                                    >
                                        Masa berlaku (opsional)
                                    </label>
                                    <input
                                        id="expires-at-{{ $barbershop->go_barbershop_id }}"
                                        type="datetime-local"
                                        name="expires_at"
                                        class="form-control"
                                        min="{{ now()->format('Y-m-d\TH:i') }}"
                                        value="{{ old('expires_at') }}"
                                    >
                                    <div class="form-text">
                                        Kosongkan jika QR tidak perlu kedaluwarsa.
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    {{ $barbershop->activeToken ? 'Buat QR Baru' : 'Buat QR Code' }}
                                </button>
                            </form>
                        </div>
                    </section>
                </div>
            @endforeach
        </div>
    @endif
@endsection
