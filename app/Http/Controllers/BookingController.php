<?php

namespace App\Http\Controllers;

use App\Models\GoBarberShop;
use App\Modules\Catalog\Services\PublicCatalogQuery;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    // LANGKAH 1: PILIH LAYANAN
    public function services($shop)
    {
        $barbershop = GoBarberShop::with('location')
            ->findOrFail($shop);

        $services = app(PublicCatalogQuery::class)
            ->forBarbershop($barbershop)['services'];

        return view('booking-barber.services', compact(
            'barbershop',
            'services'
        ));
    }

    // SIMPAN LAYANAN YANG DIPILIH
    public function storeServices(Request $request, $shop)
    {
        $barbershop = GoBarberShop::findOrFail($shop);

        $validated = $request->validate([
            'service_ids' => ['required', 'array', 'min:1'],
            'service_ids.*' => ['required', 'integer'],
        ]);

        $serviceIds = app(PublicCatalogQuery::class)
            ->forBarbershop($barbershop)['services']
            ->whereIn('service_id', $validated['service_ids'])
            ->pluck('service_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        if (count($serviceIds) !== count($validated['service_ids'])) {
            throw ValidationException::withMessages([
                'service_ids' => 'Layanan yang dipilih tidak valid.',
            ]);
        }

        session([
            'booking' => [
                'shop_id' => $barbershop->go_barbershop_id,
                'service_ids' => $serviceIds,
            ],
        ]);

        return redirect()->route('booking.schedule', $shop);
    }

    // LANGKAH 2: PILIH BARBER DAN JADWAL
    public function schedule($shop)
    {
        $barbershop = GoBarberShop::with('location')
            ->findOrFail($shop);

        $booking = session('booking');

        if (
            ! $booking ||
            $booking['shop_id'] != $barbershop->go_barbershop_id ||
            empty($booking['service_ids'])
        ) {
            return redirect()->route('booking', $shop)
                ->with('error', 'Silakan pilih layanan terlebih dahulu.');
        }

        $catalog = app(PublicCatalogQuery::class)
            ->forBarbershop($barbershop);
        $services = $catalog['services']
            ->whereIn('service_id', $booking['service_ids'])
            ->values();
        $barbers = $catalog['barbers'];

        return view('booking-barber.schedule', compact(
            'barbershop',
            'services',
            'barbers'
        ));
    }

    // SIMPAN BARBER DAN JADWAL
    public function storeSchedule(Request $request, $shop)
    {
        $barbershop = GoBarberShop::findOrFail($shop);

        $booking = session('booking');

        if (
            ! $booking ||
            $booking['shop_id'] != $barbershop->go_barbershop_id ||
            empty($booking['service_ids'])
        ) {
            return redirect()->route('booking', $shop);
        }

        $validated = $request->validate([
            'barber_id' => ['required', 'integer'],
            'booking_date' => ['required', 'date', 'after_or_equal:today'],
            'booking_time' => ['required', 'date_format:H:i'],
        ]);

        $barber = app(PublicCatalogQuery::class)
            ->forBarbershop($barbershop)['barbers']
            ->firstWhere('barber_id', $validated['barber_id']);

        if (! $barber) {
            throw ValidationException::withMessages([
                'barber_id' => 'Barber tidak ditemukan pada barbershop ini.',
            ]);
        }

        session([
            'booking.barber_id' => $barber->barber_id,
            'booking.barber_name' => $barber->barber_name,
            'booking.booking_date' => $validated['booking_date'],
            'booking.booking_time' => $validated['booking_time'],
        ]);

        return redirect()->route('booking.payment', $shop);
    }

    // LANGKAH 3: PEMBAYARAN
    public function payment($shop)
    {
        $barbershop = GoBarberShop::findOrFail($shop);

        $booking = session('booking');

        if (
            ! $booking ||
            $booking['shop_id'] != $barbershop->go_barbershop_id ||
            empty($booking['barber_id'])
        ) {
            return redirect()->route('booking', $shop);
        }

        $services = app(PublicCatalogQuery::class)
            ->forBarbershop($barbershop)['services']
            ->whereIn('service_id', $booking['service_ids'])
            ->values();

        $total = $services->sum('price');
        $duration = $services->sum('duration');

        return view('booking-barber.payment', compact(
            'barbershop',
            'booking',
            'services',
            'total',
            'duration'
        ));
    }

    // KONFIRMASI PEMBAYARAN SEMENTARA
    public function confirmPayment(Request $request, $shop)
    {
        $barbershop = GoBarberShop::findOrFail($shop);

        $booking = session('booking');

        if (
            ! $booking ||
            $booking['shop_id'] != $barbershop->go_barbershop_id ||
            empty($booking['barber_id'])
        ) {
            return redirect()->route('booking', $shop);
        }

        /*
         * SEMENTARA:
         * Ini hanya simulasi konfirmasi.
         * Belum memverifikasi pembayaran melalui payment gateway.
         */

        $booking['booking_code'] = 'GB-'.strtoupper(
            bin2hex(random_bytes(4))
        );

        $booking['payment_status'] = 'simulasi';
        $booking['reservation_status'] = 'menunggu_verifikasi';

        session(['booking' => $booking]);

        return redirect()->route('booking.success', $shop);
    }

    // BOOKING SELESAI
    public function success($shop)
    {
        $barbershop = GoBarberShop::findOrFail($shop);

        $booking = session('booking');

        if (
            ! $booking ||
            $booking['shop_id'] != $barbershop->go_barbershop_id ||
            empty($booking['booking_code'])
        ) {
            return redirect()->route('booking', $shop);
        }

        $services = app(PublicCatalogQuery::class)
            ->forBarbershop($barbershop)['services']
            ->whereIn('service_id', $booking['service_ids'])
            ->values();

        $total = $services->sum('price');

        return view('booking-barber.success', compact(
            'barbershop',
            'booking',
            'services',
            'total'
        ));
    }
}
