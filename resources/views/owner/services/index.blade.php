
@extends('layouts.client')

@section('content')
<style>
    .service-page {
        padding: 28px;
        color: #1f2937;
    }

    .service-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .service-header h1 {
        font-size: 26px;
        font-weight: 700;
        margin: 0 0 6px;
    }

    .service-header p {
        color: #6b7280;
        margin: 0;
        font-size: 14px;
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #183b35;
        color: white;
        padding: 11px 18px;
        border-radius: 9px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
    }

    .btn-add:hover {
        background: #24564c;
        color: white;
    }

    .service-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 13px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(0,0,0,.035);
    }

    .service-card-header {
        padding: 20px 22px;
        border-bottom: 1px solid #e5e7eb;
    }

    .service-card-header h2 {
        font-size: 17px;
        font-weight: 700;
        margin: 0;
    }

    .service-card-header p {
        color: #6b7280;
        font-size: 13px;
        margin: 5px 0 0;
    }

    .service-table {
        width: 100%;
        border-collapse: collapse;
    }

    .service-table th {
        background: #f9fafb;
        color: #6b7280;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .04em;
        padding: 15px 20px;
        text-align: left;
        white-space: nowrap;
    }

    .service-table td {
        padding: 17px 20px;
        border-top: 1px solid #f0f1f3;
        font-size: 14px;
        vertical-align: middle;
    }

    .service-table tbody tr:hover {
        background: #fafcfb;
    }

    .service-number {
        color: #9ca3af;
        font-weight: 600;
    }

    .service-name {
        font-weight: 700;
        color: #1f2937;
    }

    .service-price {
        font-weight: 700;
        color: #183b35;
    }

    .status-available {
        display: inline-block;
        background: #dcfce7;
        color: #15803d;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .status-unavailable {
        display: inline-block;
        background: #fee2e2;
        color: #b91c1c;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-edit, .btn-delete {
        border: 0;
        border-radius: 7px;
        padding: 7px 12px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }

    .btn-edit {
        background: #eff6ff;
        color: #2563eb;
    }

    .btn-delete {
        background: #fef2f2;
        color: #dc2626;
    }

    .empty-services {
        text-align: center;
        padding: 45px 20px;
        color: #6b7280;
    }

    .empty-services strong {
        display: block;
        color: #374151;
        margin-bottom: 6px;
    }

    .service-table-wrapper {
        overflow-x: auto;
    }

    @media (max-width: 768px) {
        .service-page {
            padding: 16px;
        }
        .service-table th,
        .service-table td {
            padding: 13px;
        }
    }
</style>

<div class="service-page">

    <div class="service-header">
        <div>
            <h1>Kelola Layanan</h1>
            <p>Atur layanan, harga, dan durasi layanan barbershop kamu.</p>
        </div>

        <a href="{{ route('owner.layanan.create') }}" class="btn-add">
            <span>＋</span> Tambah Layanan
        </a>
    </div>

    @if (session('success'))
        <div style="background:#dcfce7;color:#166534;padding:13px 16px;border-radius:9px;margin-bottom:18px;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div style="background:#fee2e2;color:#991b1b;padding:13px 16px;border-radius:9px;margin-bottom:18px;">
            <ul style="margin:0;padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="service-card">
        <div class="service-card-header">
            <h2>Daftar Layanan</h2>
            <p>Total {{ $services->total() }} layanan terdaftar</p>
        </div>

        <div class="service-table-wrapper">
            <table class="service-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Layanan</th>
                        <th>Harga</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($services as $index => $service)
                        <tr>
                            <td class="service-number">
                                {{ $services->firstItem() + $index }}
                            </td>

                            <td>
                                <span class="service-name">
                                    {{ $service->service_name }}
                                </span>
                            </td>

                            <td class="service-price">
                                Rp{{ number_format($service->price, 0, ',', '.') }}
                            </td>

                            <td>{{ $service->duration }} menit</td>

                            <td>
                                @if ($service->is_available)
                                    <span class="status-available">Tersedia</span>
                                @else
                                    <span class="status-unavailable">Tidak tersedia</span>
                                @endif
                            </td>

                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('owner.layanan.edit', $service->service_id) }}"
                                       class="btn-edit">
                                        Edit
                                    </a>

                                    <form action="{{ route('owner.layanan.destroy', $service->service_id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus layanan ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn-delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-services">
                                    <strong>Belum ada layanan</strong>
                                    Silakan tambahkan layanan barbershop terlebih dahulu.
                                    <br><br>
                                    <a href="{{ route('owner.layanan.create') }}" class="btn-add">
                                        ＋ Tambah Layanan
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($services->hasPages())
            <div style="padding:18px 22px;border-top:1px solid #e5e7eb;">
                {{ $services->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
