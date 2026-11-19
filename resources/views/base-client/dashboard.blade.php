
@extends('layouts.owner-adminlte')

@section('title', 'Dashboard Owner')
@section('page-heading', 'Dashboard Owner')
@section('breadcrumb', 'Dashboard')

@section('content')

{{-- ================= KARTU RINGKASAN ================= --}}
<div class="row">

    {{-- Total Barbershop --}}
    <div class="col-lg-4 col-md-6 col-12">
        <div class="small-box text-bg-primary">

            <div class="inner">
                <h3>{{ $totalBarbershops }}</h3>
                <p>Total Barbershop</p>
            </div>

            <div class="small-box-icon">
                <i class="bi bi-shop"></i>
            </div>

        </div>
    </div>


    {{-- Nama Owner --}}
    <div class="col-lg-4 col-md-6 col-12">
        <div class="small-box text-bg-success">

            <div class="inner">
                <h3 class="fs-4">
                    {{ $owner->nama_owners }}
                </h3>

                <p>Nama Owner</p>
            </div>

            <div class="small-box-icon">
                <i class="bi bi-person-badge"></i>
            </div>

        </div>
    </div>


    {{-- Status Pengelolaan --}}
    <div class="col-lg-4 col-md-6 col-12">
        <div class="small-box text-bg-warning">

            <div class="inner">
                <h3 class="fs-4">
                    Dashboard Owner
                </h3>

                <p>Status Pengelolaan</p>
            </div>

            <div class="small-box-icon">
                <i class="bi bi-speedometer2"></i>
            </div>

        </div>
    </div>

</div>


{{-- ================= DAFTAR BARBERSHOP ================= --}}
<div class="card">

    {{-- Header Card --}}
    <div class="card-header">

        <h3 class="card-title fw-semibold">
            <i class="bi bi-shop me-2"></i>
            Daftar Barbershop Saya
        </h3>

        <div class="card-tools">
            <span class="badge text-bg-primary">
                {{ $totalBarbershops }} Barbershop
            </span>
        </div>

    </div>


    {{-- Body Card --}}
    <div class="card-body table-responsive p-0">

        <table class="table table-hover align-middle mb-0">

            {{-- Header Tabel --}}
            <thead class="table-light">

                <tr>
                    <th style="width: 60px;">No.</th>
                    <th>Nama Barbershop</th>
                    <th>Deskripsi</th>
                    <th>Jam Buka</th>
                    <th>Jam Tutup</th>
                </tr>

            </thead>


            {{-- Isi Tabel --}}
            <tbody>

                @forelse ($barbershops as $barbershop)

                    <tr>

                        <td>
                            {{ $loop->iteration }}
                        </td>

                        <td class="fw-semibold">
                            {{ $barbershop->barbershop_name }}
                        </td>

                        <td style="min-width: 200px;">
                            {{ $barbershop->description ?? '-' }}
                        </td>

                        <td>
                            {{ $barbershop->open_time ?? '-' }}
                        </td>

                        <td>
                            {{ $barbershop->close_time ?? '-' }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center py-4">

                            <i class="bi bi-shop fs-2 text-secondary"></i>

                            <p class="mb-0 mt-2">
                                Belum ada data barbershop.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- Footer Card --}}
    <div class="card-footer text-secondary">
        <small>
            <i class="bi bi-info-circle me-1"></i>
            Data yang ditampilkan merupakan barbershop milik akun Owner yang sedang login.
        </small>
    </div>

</div>

@endsection
