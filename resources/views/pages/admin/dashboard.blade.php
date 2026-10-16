
{{-- Menggunakan layout utama AdminLTE. --}}
@extends('layouts.adminlte')

{{-- Judul halaman browser. --}}
@section('title', 'Dashboard')

{{-- Judul di area konten. --}}
@section('page-heading', 'Dashboard GoBarberShop')

@section('content')

    <!-- Sambutan dashboard. -->
    <div class="card mb-4">
        <div class="card-body">
            <h4>Selamat Datang di GoBarberShop!</h4>
            <p class="mb-0">
                Kelola data barbershop, barber, layanan, dan booking
                melalui dashboard ini.
            </p>
        </div>
    </div>

    <!-- Ringkasan awal; angka masih berupa contoh, bukan data database. -->
    <div class="row">

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-primary">
                <div class="inner">
                    <h3>0</h3>
                    <p>Barbershop</p>
                </div>
                <i class="bi bi-shop small-box-icon"></i>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-success">
                <div class="inner">
                    <h3>0</h3>
                    <p>Barber</p>
                </div>
                <i class="bi bi-person-badge small-box-icon"></i>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-warning">
                <div class="inner">
                    <h3>0</h3>
                    <p>Layanan</p>
                </div>
                <i class="bi bi-scissors small-box-icon"></i>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box text-bg-danger">
                <div class="inner">
                    <h3>0</h3>
                    <p>Booking</p>
                </div>
                <i class="bi bi-calendar-check small-box-icon"></i>
            </div>
        </div>

    </div>

    <!-- Informasi pengembangan. -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Informasi Sistem</h5>
        </div>
        <div class="card-body">
            Dashboard AdminLTE berhasil disiapkan sebagai tampilan awal.
            Data akan dihubungkan dengan database pada tahap berikutnya.
        </div>
    </div>

@endsection
