
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - GoBarber</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0d0f14;
            color: #f5f5f5;
        }

        .navbar {
            height: 62px;
            background: #151821;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 5.2%;
            border-bottom: 1px solid #262a35;
        }

        .logo {
            font-size: 21px;
            font-weight: 800;
            color: #f5a623;
            text-decoration: none;
        }

        .navbar a:last-child {
            font-size: 13px;
            color: #f5f5f5;
            text-decoration: none;
        }

        .navbar a:last-child:hover {
            color: #f5a623;
        }

        .page-heading {
            background: #151821;
            padding: 35px 5.2%;
        }

        .step-label,
        .section-label {
            color: #f5a623;
            font-size: 11px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .page-heading h1 {
            font-size: 27px;
            margin-bottom: 8px;
            color: #fff;
        }

        .page-heading p {
            color: #a4a8b3;
            font-size: 13px;
        }

        .steps {
            display: flex;
            justify-content: center;
            max-width: 850px;
            margin: 32px auto 0;
        }

        .step {
            flex: 1;
            text-align: center;
            color: #a4a8b3;
        }

        .step-circle {
            width: 36px;
            height: 36px;
            background: #292d38;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 9px;
            font-size: 13px;
            font-weight: 700;
        }

        .step.done .step-circle,
        .step.active .step-circle {
            background: #f5a623;
            color: #090d19;
        }

        .step.active .step-name {
            color: #f5a623;
        }

        .step.done .step-name {
            color: #d1d5db;
        }

        .step-name {
            font-size: 12px;
            font-weight: 700;
        }

        .content {
            max-width: 1140px;
            margin: 30px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1.5fr .9fr;
            gap: 25px;
            align-items: start;
        }

        .card {
            background: #151821;
            border: 1px solid #262a35;
            border-radius: 18px;
            padding: 25px;
        }

        .card h2 {
            font-size: 18px;
            margin-bottom: 8px;
            color: #fff;
        }

        .description {
            color: #a4a8b3;
            font-size: 12px;
            margin-bottom: 22px;
        }

        .payment-option {
            border: 1px solid #f5a623;
            border-radius: 12px;
            padding: 17px;
            display: flex;
            align-items: center;
            gap: 13px;
            background: #25232a;
        }

        .payment-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            background: #303441;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .payment-name {
            font-weight: 800;
            font-size: 14px;
            color: #fff;
        }

        .payment-description {
            font-size: 11px;
            color: #a4a8b3;
            margin-top: 5px;
        }

        .payment-badge {
            margin-left: auto;
            color: #f5a623;
            font-size: 11px;
            font-weight: 700;
        }

        .notice {
            margin-top: 17px;
            padding: 14px;
            background: #302718;
            border: 1px solid #59431e;
            border-radius: 10px;
            color: #f5cd83;
            font-size: 12px;
            line-height: 1.6;
        }

        .reservation-info {
            margin-top: 25px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 14px 0;
            border-bottom: 1px solid #303441;
            font-size: 12px;
        }

        .summary-row span:first-child {
            color: #a4a8b3;
        }

        .summary-row strong {
            text-align: right;
            font-size: 12px;
            color: #fff;
        }

        .service-item {
            padding: 12px 0;
            border-bottom: 1px solid #303441;
        }

        .service-name {
            font-size: 12px;
            font-weight: 700;
            color: #fff;
        }

        .service-detail {
            display: flex;
            justify-content: space-between;
            color: #a4a8b3;
            font-size: 11px;
            margin-top: 5px;
        }

        .service-detail strong {
            color: #f5a623;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 22px 0;
        }

        .total-row span {
            font-size: 13px;
            color: #fff;
        }

        .total-row strong {
            font-size: 23px;
            color: #f5a623;
        }

        .btn-pay,
        .btn-failed {
            width: 100%;
            border-radius: 30px;
            padding: 15px;
            font-family: inherit;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
        }

        .btn-pay {
            border: none;
            background: #f5a623;
            color: #111;
        }

        .btn-pay:hover {
            background: #ffc15a;
        }

        .btn-failed {
            margin-top: 12px;
            border: 1px solid #dc6262;
            background: #2b1c21;
            color: #fca5a5;
        }

        .btn-failed:hover {
            background: #44232a;
        }

        .btn-back {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #a4a8b3;
            font-size: 12px;
            text-decoration: none;
        }

        .btn-back:hover {
            color: #f5a623;
        }

        .summary-card {
            position: sticky;
            top: 20px;
        }

        @media (max-width: 800px) {
            .content {
                grid-template-columns: 1fr;
            }

            .summary-card {
                position: static;
            }
        }

        @media (max-width: 550px) {
            .page-heading {
                padding: 28px 20px;
            }

            .page-heading h1 {
                font-size: 22px;
            }

            .step-name {
                font-size: 10px;
            }

            .card {
                padding: 19px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">✂ GoBarber</a>
        <a href="{{ route('shops.explore') }}">Jelajah Barbershop</a>
    </nav>

    <!-- HEADER -->
    <section class="page-heading">
        <div class="step-label">LANGKAH 3 DARI 3</div>

        <h1>Pembayaran Reservasi</h1>

        <p>Selesaikan reservasi barbershop kamu.</p>

        <div class="steps">
            <div class="step done">
                <div class="step-circle">✓</div>
                <div class="step-name">Pilih Layanan</div>
            </div>

            <div class="step done">
                <div class="step-circle">✓</div>
                <div class="step-name">Barber & Jadwal</div>
            </div>

            <div class="step active">
                <div class="step-circle">3</div>
                <div class="step-name">Pembayaran</div>
            </div>
        </div>
    </section>

    <!-- KONTEN -->
    <main class="content">

        <!-- METODE PEMBAYARAN -->
        <section class="card">

            <div class="section-label">METODE PEMBAYARAN</div>

            <h2>Pilih Pembayaran</h2>

            <p class="description">
                Pilih metode pembayaran untuk menyelesaikan reservasi.
            </p>

            <div class="payment-option">
                <div class="payment-icon">📱</div>

                <div>
                    <div class="payment-name">QRIS</div>
                    <div class="payment-description">
                        Pembayaran menggunakan QRIS
                    </div>
                </div>

                <div class="payment-badge">Dipilih</div>
            </div>

            <div class="notice">
                <strong>Informasi pembayaran</strong><br>
                Saat ini pembayaran masih berupa simulasi untuk keperluan
                pengujian aplikasi. Belum ada transaksi uang sungguhan
                atau verifikasi pembayaran QRIS.
            </div>

            <!-- INFORMASI RESERVASI -->
            <div class="reservation-info">

                <div class="section-label">INFORMASI RESERVASI</div>

                <div class="summary-row">
                    <span>Barbershop</span>
                    <strong>{{ $barbershop->barbershop_name }}</strong>
                </div>

                <div class="summary-row">
                    <span>Nama Barber</span>
                    <strong>{{ $booking['barber_name'] ?? '-' }}</strong>
                </div>

                <div class="summary-row">
                    <span>Tanggal</span>
                    <strong>
                        {{ \Carbon\Carbon::parse($booking['booking_date'])->translatedFormat('d F Y') }}
                    </strong>
                </div>

                <div class="summary-row">
                    <span>Jam</span>
                    <strong>{{ $booking['booking_time'] ?? '-' }}</strong>
                </div>

            </div>

        </section>

        <!-- RINGKASAN PESANAN -->
        <aside class="card summary-card">

            <div class="section-label">RINGKASAN PESANAN</div>

            <h2>Rincian Pembayaran</h2>

            <div style="margin-top:15px;">

                @forelse ($services as $service)

                    <div class="service-item">

                        <div class="service-name">
                            {{ $service->service_name }}
                        </div>

                        <div class="service-detail">
                            <span>{{ $service->duration }} menit</span>

                            <strong>
                                Rp{{ number_format($service->price, 0, ',', '.') }}
                            </strong>
                        </div>

                    </div>

                @empty

                    <p style="font-size:12px; color:#f87171;">
                        Layanan booking tidak ditemukan.
                    </p>

                @endforelse

            </div>

            <div class="summary-row">
                <span>Jumlah Layanan</span>
                <strong>{{ $services->count() }} layanan</strong>
            </div>

            <div class="summary-row">
                <span>Total Durasi</span>
                <strong>{{ $duration }} menit</strong>
            </div>

            <div class="total-row">
                <span>Total Pembayaran</span>

                <strong>
                    Rp{{ number_format($total, 0, ',', '.') }}
                </strong>
            </div>

            <!-- FORM PEMBAYARAN BERHASIL -->
            <form
                action="{{ route('booking.payment.confirm', $barbershop->go_barbershop_id) }}"
                method="POST"
                onsubmit="return confirm('Apakah kamu yakin ingin mengonfirmasi reservasi ini?')"
            >
                @csrf

                <button type="submit" class="btn-pay">
                    Konfirmasi Pembayaran →
                </button>
            </form>

            <!-- FORM SIMULASI PEMBAYARAN GAGAL -->
            <form
                action="{{ route('booking.payment.failed', $barbershop->go_barbershop_id) }}"
                method="POST"
                onsubmit="return confirm('Apakah kamu ingin menyimulasikan pembayaran gagal?')"
            >
                @csrf

                <button type="submit" class="btn-failed">
                    Simulasikan Pembayaran Gagal
                </button>
            </form>

            <!-- KEMBALI KE JADWAL -->
            <a
                href="{{ route('booking.schedule', $barbershop->go_barbershop_id) }}"
                class="btn-back"
            >
                ← Kembali ke Barber & Jadwal
            </a>

        </aside>

    </main>

</body>
</html>
