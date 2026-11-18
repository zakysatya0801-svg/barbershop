
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pilih Layanan - GoBarber</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: #0d0f14;
            color: #f5f5f5;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        header {
            background: #151821;
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #262a35;
        }

        .logo { font-size: 21px; font-weight: 800; color: #f5a623; }

        header a {
            text-decoration: none;
            color: #f5f5f5;
            font-size: 13px;
        }

        header a:hover { color: #f5a623; }

        .hero {
            padding: 35px 5%;
            background: #151821;
        }

        .label {
            color: #f5a623;
            font-size: 11px;
            font-weight: 800;
        }

        h1 { font-size: 27px; margin: 8px 0; color: #fff; }

        .subtitle { color: #a4a8b3; font-size: 13px; }

        .steps {
            display: flex;
            justify-content: space-between;
            max-width: 850px;
            margin: 35px auto 0;
            text-align: center;
            font-size: 12px;
            font-weight: 700;
            color: #a4a8b3;
        }

        .step { width: 33%; }

        .circle {
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            margin: 0 auto 9px;
            border-radius: 50%;
            background: #292d38;
            color: #fff;
        }

        .step.active .circle {
            background: #f5a623;
            color: #111;
        }

        .step.active { color: #f5a623; }

        .container {
            max-width: 1250px;
            margin: 30px auto 70px;
            padding: 0 5%;
            display: grid;
            grid-template-columns: 1.5fr .8fr;
            gap: 25px;
        }

        .card {
            background: #151821;
            padding: 25px;
            border: 1px solid #262a35;
            border-radius: 17px;
            margin-bottom: 20px;
        }

        h2 { font-size: 18px; margin: 7px 0 20px; color: #fff; }

        .service {
            display: flex;
            align-items: center;
            gap: 15px;
            border: 1.5px solid #303441;
            background: #1c202b;
            padding: 16px;
            border-radius: 14px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: .2s;
        }

        .service:has(input:checked) {
            border: 2px solid #f5a623;
            background: #25232a;
        }

        .service input {
            width: 19px;
            height: 19px;
            accent-color: #f5a623;
        }

        .service-info { flex: 1; }

        .service-info strong {
            display: block;
            font-size: 14px;
            color: #fff;
        }

        .service-info small {
            display: block;
            color: #a4a8b3;
            font-size: 11px;
            margin-top: 5px;
        }

        .price {
            font-weight: 800;
            font-size: 14px;
            white-space: nowrap;
            color: #f5a623;
        }

        .summary {
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            font-size: 12px;
            padding: 12px 0;
            border-bottom: 1px solid #303441;
            color: #f5f5f5;
        }

        .summary-row span { color: #a4a8b3; }

        .summary-row strong { color: #fff; }

        .total {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 22px;
            color: #fff;
        }

        .total strong { font-size: 22px; color: #f5a623; }

        .total small { color: #d1d5db; }

        button {
            width: 100%;
            padding: 16px;
            margin-top: 23px;
            border: none;
            border-radius: 30px;
            background: #f5a623;
            color: #111;
            font-weight: 700;
            cursor: pointer;
            transition: .2s;
        }

        button:hover { background: #ffc15a; }

        .error { color: #f87171; font-size: 12px; margin-top: 10px; }

        footer {
            background: #151821;
            padding: 35px 5%;
            color: #a4a8b3;
            font-size: 12px;
            border-top: 1px solid #262a35;
        }

        @media(max-width: 800px) {
            .container { grid-template-columns: 1fr; }
            .summary { position: static; }
        }

        @media(max-width: 500px) {
            h1 { font-size: 22px; }
            .card { padding: 17px; }
            .service { gap: 9px; padding: 12px; }
            .price { font-size: 12px; }
        }
    </style>
</head>
<body>

<header>
    <div class="logo">✂ GoBarber</div>
    <a href="{{ route('shops.explore') }}">Jelajah Barbershop</a>
</header>

<section class="hero">
    <div class="label">LANGKAH 1 DARI 3</div>
    <h1>Pilih Layanan Barbershop</h1>
    <div class="subtitle">
        Pilih treatment yang ingin kamu nikmati di {{ $barbershop->barbershop_name }}.
    </div>

    <div class="steps">
        <div class="step active">
            <div class="circle">1</div>
            Pilih Layanan
        </div>
        <div class="step">
            <div class="circle">2</div>
            Barber & Jadwal
        </div>
        <div class="step">
            <div class="circle">3</div>
            Pembayaran
        </div>
    </div>
</section>

<form action="{{ route('booking.services.store', $barbershop->go_barbershop_id) }}" method="POST">
    @csrf

    <main class="container">
        <section class="card">
            <div class="label">DAFTAR TREATMENT</div>
            <h2>Pilih Layanan yang Kamu Inginkan</h2>

            @forelse($services as $service)
                <label class="service">
                    <input
                        type="checkbox"
                        name="service_ids[]"
                        value="{{ $service->service_id }}"
                        data-price="{{ $service->price }}"
                        data-duration="{{ $service->duration }}"
                    >

                    <div class="service-info">
                        <strong>{{ $service->service_name }}</strong>
                        <small>Estimasi {{ $service->duration }} menit</small>
                    </div>

                    <div class="price">
                        Rp {{ number_format($service->price, 0, ',', '.') }}
                    </div>
                </label>
            @empty
                <p>Belum ada layanan tersedia di barbershop ini.</p>
            @endforelse

            @error('service_ids')
                <div class="error">{{ $message }}</div>
            @enderror

            @error('service_ids.*')
                <div class="error">{{ $message }}</div>
            @enderror
        </section>

        <aside class="card summary">
            <div class="label">RINGKASAN PESANAN</div>
            <h2>Rincian Reservasi</h2>

            <div class="summary-row">
                <span>Barbershop</span>
                <strong>{{ $barbershop->barbershop_name }}</strong>
            </div>

            <div class="summary-row">
                <span>Jumlah Layanan</span>
                <strong id="count">0 layanan</strong>
            </div>

            <div class="summary-row">
                <span>Total Durasi</span>
                <strong id="duration">0 menit</strong>
            </div>

            <div class="total">
                <div>
                    <small>Total Pembayaran</small>
                    <div style="font-size:10px;color:#34d399">Harga layanan</div>
                </div>
                <strong id="total">Rp 0</strong>
            </div>

            <button type="submit">Lanjut Pilih Barber & Jadwal →</button>
        </aside>
    </main>
</form>

<footer>
    <strong style="color:#f5a623;font-size:17px">✂ GoBarber</strong>
    <p>Platform digital reservasi dan antrean potong rambut.</p>
    © 2025 GoBarber. Hak Cipta Dilindungi.
</footer>

<script>
    const checkboxes = document.querySelectorAll('.service input[type="checkbox"]');
    const totalElement = document.getElementById('total');
    const countElement = document.getElementById('count');
    const durationElement = document.getElementById('duration');

    function updateSummary() {
        let total = 0;
        let duration = 0;
        let count = 0;

        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                total += Number(checkbox.dataset.price);
                duration += Number(checkbox.dataset.duration);
                count++;
            }
        });

        totalElement.textContent = 'Rp ' + total.toLocaleString('id-ID');
        countElement.textContent = count + ' layanan';
        durationElement.textContent = duration + ' menit';
    }

    checkboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', updateSummary);
    });
</script>

</body>
</html>
