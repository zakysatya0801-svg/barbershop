
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Gagal - GoBarber</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f3f5f7;
            color: #18324b;
        }
        .navbar {
            background: white;
            padding: 18px 6%;
            font-size: 22px;
            font-weight: 800;
        }
        .container {
            max-width: 650px;
            margin: 55px auto;
            padding: 0 20px;
        }
        .card {
            background: white;
            padding: 35px;
            border-radius: 18px;
            text-align: center;
            box-shadow: 0 8px 30px rgba(0,0,0,.05);
        }
        .icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 20px;
            border-radius: 50%;
            background: #fee2e2;
            color: #dc2626;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 45px;
            font-weight: 700;
        }
        h1 { margin: 0 0 12px; font-size: 25px; }
        .description {
            color: #667085;
            line-height: 1.7;
            font-size: 13px;
        }
        .info {
            background: #f8fafc;
            border-radius: 12px;
            padding: 18px;
            text-align: left;
            margin: 25px 0;
        }
        .info p {
            margin: 10px 0;
            font-size: 13px;
        }
        .info strong { color: #18324b; }
        .button {
            display: block;
            padding: 14px;
            background: #18324b;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 700;
            margin-top: 12px;
            font-size: 13px;
        }
        .button.secondary {
            background: white;
            color: #18324b;
            border: 1px solid #cbd5e1;
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
                    <span style="color:#dc2626;">Gagal</span>
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
