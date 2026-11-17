
<section class="services-section">
    <h2>Layanan Barbershop</h2>
    <p>Pilih layanan yang ingin kamu nikmati.</p>

    <div class="services-list">
        @forelse ($barbershop->services->where('is_available', true) as $service)
            <div class="service-item">
                <h3>{{ $service->service_name }}</h3>

                <p>
                    {{ $service->description ?? 'Layanan barbershop profesional.' }}
                </p>

                <strong>
                    Rp{{ number_format($service->price, 0, ',', '.') }}
                </strong>

                <span>{{ $service->duration }} menit</span>
            </div>
        @empty
            <p>Belum ada layanan yang tersedia di barbershop ini.</p>
        @endforelse
    </div>
</section>
