<?php

namespace Tests\Feature;

use Linkxtr\QrCode\Facades\QrCode;
use Tests\TestCase;

class BookingSuccessPageTest extends TestCase
{
    public function test_booking_success_page_hides_booking_reference_but_renders_its_qr_code(): void
    {
        $bookingCode = 'GB-TEST1234';
        $html = view('booking-barber.success', [
            'booking' => [
                'booking_code' => $bookingCode,
                'barber_name' => 'Andi',
                'booking_date' => '2026-11-20',
                'booking_time' => '21:39',
            ],
            'barbershop' => (object) ['barbershop_name' => 'GoBarber Banyuwangi'],
            'services' => collect(),
            'total' => 0,
        ])->render();

        $this->assertStringNotContainsString($bookingCode, $html);
        $this->assertStringContainsString('alt="QR code bukti reservasi"', $html);
        $this->assertSame(
            1,
            preg_match(
                '/<img\s+src="data:image\/svg\+xml;base64,([^"]+)"/',
                $html,
                $matches
            )
        );

        $this->assertSame(
            (string) QrCode::size(180)->format('svg')->generate($bookingCode),
            base64_decode($matches[1], true)
        );
    }
}
