
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Berhasil - GoBarber</title>

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
            color: #ffffff;
        }

        nav {
            background: #151821;
            padding: 20px 6%;
            border-bottom: 1px solid #262a35;
        }

        nav a {
            color: #ffffff;
            font-size: 21px;
            font-weight: 800;
            text-decoration: none;
        }

        .container {
            max-width: 650px;
            margin: 55px auto;
            padding: 0 20px;
        }

        .card {
            background: #151821;
            border: 1px solid #262a35;
            border-radius: 20px;
            padding: 35px;
            text-align: center;
        }

        .success-icon {
            width: 75px;
            height: 75px;
            background: rgba(22, 163, 74, 0.15);
            color: #4ade80;
            border: 1px solid rgba(74, 222, 128, 0.25);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            margin: 0 auto 22px;
        }

        h1 {
            font-size: 25px;
            margin-bottom: 10px;
            color: #ffffff;
        }

        .description {
            color: #a4a8b3;
            font-size: 13px;
            line-height: 1.7;
        }

        .booking-code {
            background: #1c202b;
            border: 1px dashed #f5a623;
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
        }

        .booking-code small {
            color: #a4a8b3;
            font-size: 11px;
        }

        .booking-code h2 {
            margin-top: 8px;
            color: #f5a623;
            letter-spacing: 2px;
        }

        .details {
            text-align: left;
            margin-top: 25px;
        }

        .details h3 {
            font-size: 15px;
            margin-bottom: 12px;
            color: #ffffff;
        }

        .row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 12px 0;
            border-bottom: 1px solid #262a35;
            font-size: 12px;
        }

        .row span {
            color: #a4a8b3;
        }

        .row strong {
            color: #ffffff;
            text-align: right;
        }

        .total {
            font-size: 17px;
            color: #f5a623 !important;
        }

        .notice {
            background: rgba(245, 166, 35, 0.10);
            border: 1px solid rgba(245, 166, 35, 0.20);
            color: #ffc15a;
            border-radius: 10px;
            padding: 14px;
            margin-top: 22px;
            font-size: 11px;
            line-height: 1.7;
            text-align: left;
        }

        .btn {
            display: block;
            background: #f5a623;
            color: #10131b;
            text-decoration: none;
            padding: 15px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 800;
            margin-top: 25px;
            transition: 0.3s;
        }

        .btn:hover {
            background: #ffc15a;
        }

        @media(max-width: 500px) {
            .card {
                padding: 23px;
            }

            h1 {
                font-size: 21px;
            }
        }
    </style>
</head>

<body>

<nav>
    <a href="{{ route('home') }}">✂ GoBarber</a>
</nav>

<main class="container">
    <section class="card">

        <div class="success-icon">✓</div>

        <h1>Booking Berhasil!</h1>

        <p class="description">
            Terima kasih telah melakukan reservasi di GoBarber.
            Simpan kode booking berikut sebagai bukti reservasi kamu.
        </p>

        <div class="booking-code">
            <small>KODE BOOKING KAMU</small>
            <h2>{{ $booking['booking_code'] }}</h2>
        </div>

        <div class="details">
            <h3>Detail Reservasi</h3>

            <div class="row">
                <span>Barbershop</span>
                <strong>{{ $barbershop->barbershop_name }}</strong>
            </div>

            <div class="row">
                <span>Barber</span>
                <strong>{{ $booking['barber_name'] }}</strong>
            </div>

            <div class="row">
                <span>Tanggal</span>
                <strong>
                    {{ \Carbon\Carbon::parse($booking['booking_date'])->translatedFormat('d F Y') }}
                </strong>
            </div>

            <div class="row">
                <span>Jam</span>
                <strong>{{ $booking['booking_time'] }}</strong>
            </div>

            <div class="row">
                <span>Layanan</span>
                <strong>{{ $services->count() }} layanan</strong>
            </div>

            @foreach ($services as $service)
                <div class="row">
                    <span>{{ $service->service_name }}</span>
                    <strong>
                        Rp{{ number_format($service->price, 0, ',', '.') }}
                    </strong>
                </div>
            @endforeach

            <div class="row">
                <span>Status Pembayaran</span>
                <strong>Simulasi</strong>
            </div>

            <div class="row">
                <span>Status Reservasi</span>
                <strong>Menunggu Verifikasi</strong>
            </div>

            <div class="row">
                <span>Total Pembayaran</span>
                <strong class="total">
                    Rp{{ number_format($total, 0, ',', '.') }}
                </strong>
            </div>
        </div>

        <div class="notice">
            <strong>Informasi:</strong>
            Pembayaran ini masih berupa simulasi. Belum ada transaksi
            QRIS sungguhan. Reservasi kamu berstatus menunggu verifikasi.
        </div>

        <a href="{{ route('home') }}" class="btn">
            Kembali ke Beranda
        </a>

    </section>
</main>

</body>
</html>
