
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Barber & Jadwal - GoBarber</title>

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

        .step-label {
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
            align-items: center;
            max-width: 850px;
            margin: 32px auto 0;
        }

        .step {
            flex: 1;
            text-align: center;
            position: relative;
            z-index: 1;
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
            grid-template-columns: 1.7fr .9fr;
            gap: 25px;
            align-items: start;
        }

        .card {
            background: #151821;
            border: 1px solid #262a35;
            border-radius: 18px;
            padding: 25px;
        }

        .section-label {
            color: #f5a623;
            font-size: 11px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .card h2 {
            font-size: 18px;
            margin-bottom: 8px;
            color: #fff;
        }

        .section-description {
            color: #a4a8b3;
            font-size: 12px;
            margin-bottom: 23px;
        }

        .barber-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
        }

        .barber-option {
            display: block;
            cursor: pointer;
        }

        .barber-option input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .barber-box {
            display: flex;
            align-items: center;
            gap: 13px;
            border: 1px solid #303441;
            background: #1c202b;
            border-radius: 12px;
            padding: 13px;
            transition: .2s;
            min-height: 91px;
        }

        .barber-option input:checked + .barber-box {
            border: 2px solid #f5a623;
            background: #25232a;
        }

        .barber-option input:focus-visible + .barber-box {
            outline: 3px solid rgba(245,166,35,.3);
        }

        .barber-photo {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            object-fit: cover;
            background: #292d38;
            flex-shrink: 0;
        }

        .barber-initial {
            width: 58px;
            height: 58px;
            border-radius: 50%;
            background: #292d38;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 19px;
            color: #f5a623;
            flex-shrink: 0;
        }

        .barber-name {
            font-size: 13px;
            font-weight: 800;
            margin-bottom: 5px;
            color: #fff;
        }

        .barber-specialty {
            color: #a4a8b3;
            font-size: 11px;
        }

        .selected-check {
            margin-left: auto;
            color: #f5a623;
            font-size: 18px;
            font-weight: 800;
        }

        .schedule-section {
            margin-top: 30px;
            border-top: 1px solid #303441;
            padding-top: 25px;
        }

        .form-group {
            margin-bottom: 19px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 9px;
            color: #f5f5f5;
        }

        .form-control {
            width: 100%;
            padding: 13px;
            border: 1px solid #303441;
            border-radius: 9px;
            font-family: inherit;
            font-size: 13px;
            background: #1c202b;
            color: #f5f5f5;
        }

        .form-control:focus {
            outline: none;
            border-color: #f5a623;
            box-shadow: 0 0 0 3px rgba(245,166,35,.12);
        }

        .form-control::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
        }

        .error-message {
            color: #f87171;
            font-size: 12px;
            margin-top: 7px;
        }

        .summary-card {
            position: sticky;
            top: 20px;
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

        .service-summary {
            padding: 12px 0;
            border-bottom: 1px solid #303441;
        }

        .service-summary-name {
            font-size: 12px;
            font-weight: 700;
            color: #fff;
        }

        .service-summary-detail {
            display: flex;
            justify-content: space-between;
            color: #a4a8b3;
            font-size: 11px;
            margin-top: 5px;
        }

        .service-summary-detail strong {
            color: #f5a623;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 23px 0;
        }

        .total-row span {
            font-size: 13px;
            color: #fff;
        }

        .total-row strong {
            font-size: 21px;
            color: #f5a623;
        }

        .btn-next {
            display: block;
            width: 100%;
            border: none;
            border-radius: 30px;
            background: #f5a623;
            color: #111;
            padding: 16px;
            font-family: inherit;
            font-weight: 800;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-next:hover {
            background: #ffc15a;
        }

        .btn-back {
            display: block;
            text-align: center;
            color: #a4a8b3;
            text-decoration: none;
            font-size: 12px;
            margin-top: 15px;
        }

        .btn-back:hover {
            color: #f5a623;
        }

        .empty-state {
            color: #a4a8b3;
            padding: 20px 0;
            font-size: 13px;
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
            .barber-list {
                grid-template-columns: 1fr;
            }

            .page-heading h1 {
                font-size: 22px;
            }

            .page-heading {
                padding: 28px 20px;
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

    <!-- HEADER DAN STEPPER -->
    <section class="page-heading">
        <div class="step-label">LANGKAH 2 DARI 3</div>

        <h1>Pilih Barber & Jadwal</h1>

        <p>
            Pilih barber favorit dan tentukan waktu kunjunganmu di
            {{ $barbershop->barbershop_name }}.
        </p>

        <div class="steps">
            <div class="step done">
                <div class="step-circle">✓</div>
                <div class="step-name">Pilih Layanan</div>
            </div>

            <div class="step active">
                <div class="step-circle">2</div>
                <div class="step-name">Barber & Jadwal</div>
            </div>

            <div class="step">
                <div class="step-circle">3</div>
                <div class="step-name">Pembayaran</div>
            </div>
        </div>
    </section>

    <!-- KONTEN -->
    <main class="content">

        <section class="card">

            <div class="section-label">PILIH BARBER</div>
            <h2>Siapa yang akan melayani kamu?</h2>
            <p class="section-description">
                Pilih salah satu barber yang tersedia di barbershop ini.
            </p>

            @if ($errors->any())
                <div style="background:#3b2025;color:#fca5a5;padding:13px;border-radius:9px;margin-bottom:18px;font-size:12px;">
                    <strong>Periksa kembali pilihanmu:</strong>
                    <ul style="padding-left:20px;margin-top:6px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('booking.schedule.store', $barbershop->go_barbershop_id) }}"
                  method="POST">
                @csrf

                <div class="barber-list">

                    @forelse ($barbers as $barber)
                        <label class="barber-option">
                            <input
                                type="radio"
                                name="barber_id"
                                value="{{ $barber->barber_id }}"
                                {{ (string) old('barber_id') === (string) $barber->barber_id ? 'checked' : '' }}
                                required
                            >

                            <div class="barber-box">

                                @if ($barber->photo)
                                    <img
                                        src="{{ $barber->photo }}"
                                        alt="{{ $barber->barber_name }}"
                                        class="barber-photo"
                                    >
                                @else
                                    <div class="barber-initial">
                                        {{ strtoupper(substr($barber->barber_name, 0, 1)) }}
                                    </div>
                                @endif

                                <div>
                                    <div class="barber-name">
                                        {{ $barber->barber_name }}
                                    </div>

                                    <div class="barber-specialty">
                                        {{ $barber->specialty ?: 'Barber profesional' }}
                                    </div>
                                </div>

                                <span class="selected-check">✓</span>
                            </div>
                        </label>
                    @empty
                        <div class="empty-state">
                            Belum ada barber terdaftar di barbershop ini.
                        </div>
                    @endforelse

                </div>

                <!-- PILIH TANGGAL DAN JAM -->
                <div class="schedule-section">

                    <div class="section-label">PILIH JADWAL</div>
                    <h2>Tentukan waktu kunjungan</h2>

                    <p class="section-description">
                        Pilih tanggal dan jam yang kamu inginkan.
                    </p>

                    <div class="form-group">
                        <label for="booking_date">Tanggal Booking</label>

                        <input
                            type="date"
                            id="booking_date"
                            name="booking_date"
                            class="form-control"
                            value="{{ old('booking_date') }}"
                            min="{{ now()->toDateString() }}"
                            required
                        >

                        @error('booking_date')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="booking_time">Jam Booking</label>

                        <input
                            type="time"
                            id="booking_time"
                            name="booking_time"
                            class="form-control"
                            value="{{ old('booking_time') }}"
                            required
                        >

                        @error('booking_time')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <button type="submit" class="btn-next">
                    Lanjut ke Pembayaran →
                </button>

                <a href="{{ route('booking', $barbershop->go_barbershop_id) }}"
                   class="btn-back">
                    ← Kembali Pilih Layanan
                </a>

            </form>
        </section>

        <!-- RINGKASAN -->
        <aside class="card summary-card">

            <div class="section-label">RINGKASAN PESANAN</div>
            <h2>Rincian Reservasi</h2>

            <div class="summary-row">
                <span>Barbershop</span>
                <strong>{{ $barbershop->barbershop_name }}</strong>
            </div>

            <div style="padding-top:15px;">
                <div style="font-size:12px;font-weight:700;margin-bottom:5px;color:#fff;">
                    Layanan Dipilih
                </div>

                @foreach ($services as $service)
                    <div class="service-summary">
                        <div class="service-summary-name">
                            {{ $service->service_name }}
                        </div>

                        <div class="service-summary-detail">
                            <span>{{ $service->duration }} menit</span>
                            <strong>
                                Rp{{ number_format($service->price, 0, ',', '.') }}
                            </strong>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="summary-row">
                <span>Jumlah Layanan</span>
                <strong>{{ $services->count() }} layanan</strong>
            </div>

            <div class="summary-row">
                <span>Total Durasi</span>
                <strong>{{ $services->sum('duration') }} menit</strong>
            </div>

            <div class="total-row">
                <span>Total Pembayaran</span>
                <strong>
                    Rp{{ number_format($services->sum('price'), 0, ',', '.') }}
                </strong>
            </div>

            <p style="font-size:11px;color:#a4a8b3;line-height:1.6;">
                Pastikan barber, tanggal, dan jam yang kamu pilih sudah benar.
            </p>

        </aside>

    </main>

</body>
</html>
