
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Gagal - GoBarber</title>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #0d0f14;
            color: #ffffff;
        }

        .navbar {
            background: #151821;
            padding: 18px 6%;
            font-size: 22px;
            font-weight: 800;
            border-bottom: 1px solid #262a35;
        }

        .container {
            max-width: 650px;
            margin: 55px auto;
            padding: 0 20px;
        }

        .card {
            background: #151821;
            border: 1px solid #262a35;
            padding: 35px;
            border-radius: 18px;
            text-align: center;
        }

        .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: rgba(220, 38, 38, 0.15);
            border: 1px solid rgba(220, 38, 38, 0.25);
            color: #f87171;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 45px;
            font-weight: 700;
        }

        h1 {
            margin: 0 0 12px;
            font-size: 25px;
            color: #ffffff;
        }

        .description {
            color: #a4a8b3;
            line-height: 1.7;
            font-size: 13px;
        }

        .info {
            background: #1c202b;
            border: 1px solid #262a35;
            border-radius: 12px;
            padding: 18px;
            text-align: left;
            margin: 25px 0;
        }

        .info p {
            margin: 10px 0;
            font-size: 13px;
            color: #a4a8b3;
        }

        .info strong {
            color: #ffffff;
        }

        .button {
            display: block;
            padding: 14px;
            background: #f5a623;
            color: #10131b;
            text-decoration: none;
            border-radius: 30px;
            font-weight: 800;
            margin-top: 12px;
            font-size: 13px;
            transition: 0.3s;
        }

        .button:hover {
            background: #ffc15a;
        }

        .button.secondary {
            background: transparent;
            color: #f5a623;
            border: 1px solid #f5a623;
        }

        .button.secondary:hover {
            background: rgba(245, 166, 35, 0.10);
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

    <div class="navbar">✂ GoBarber</div>

    <main class="container">
        <div class="card">

            <div class="icon">×</div>

            <h1>Pembayaran Gagal</h1>

            <p class="description">
                Maaf, pembayaran reservasi kamu belum berhasil.
                Kamu masih bisa mencoba melakukan pembayaran kembali.
            </p>

            <div class="info">
                <p>
                    <strong>Barbershop:</strong>
                    {{ $barbershop->barbershop_name }}
                </p>

                <p>
                    <strong>Barber:</strong>
                    {{ $booking['barber_name'] ?? '-' }}
                </p>

                <p>
                    <strong>Tanggal:</strong>
                    {{ $booking['booking_date'] ?? '-' }}
                </p>

                <p>
                    <strong>Jam:</strong>
                    {{ $booking['booking_time'] ?? '-' }}
                </p>

                <p>
                    <strong>Total:</strong>
                    Rp{{ number_format($total, 0, ',', '.') }}
                </p>

                <p>
                    <strong>Status pembayaran:</strong>
                    <span style="color:#f87171;">Gagal</span>
                </p>
            </div>

            <a href="{{ route('booking.payment', $barbershop->go_barbershop_id) }}"
               class="button">
                Coba Bayar Lagi
            </a>

            <a href="{{ route('booking.schedule', $barbershop->go_barbershop_id) }}"
               class="button secondary">
                Kembali ke Jadwal
            </a>

        </div>
    </main>

</body>
</html>
