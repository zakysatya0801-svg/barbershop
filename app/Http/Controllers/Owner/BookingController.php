<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Support\Tenancy\TenantContext;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    // Mengambil data Owner berdasarkan akun yang sedang login.
    private function getOwner(Request $request)
    {
        return $request->user()
            ->admin
            ?->owners()
            ->with('goBarberShops')
            ->first();
    }

    // Menampilkan booking dari seluruh barbershop milik Owner.
    public function index(
        Request $request,
        TenantContext $tenantContext
    ): View|RedirectResponse {
        $owner = $this->getOwner($request);

        // Pastikan akun yang login memiliki data Owner.
        if (! $owner) {
            return redirect()
                ->route('client.dashboard')
                ->with('error', 'Data Owner tidak ditemukan.');
        }

        // Menyiapkan koleksi untuk menampung seluruh booking Owner.
        $bookings = collect();

        try {
            // Ambil booking dari setiap barbershop milik Owner.
            foreach ($owner->goBarberShops as $shop) {

                // Aktifkan TenantContext sebelum query Booking.
                $tenantContext->set($shop);

                // Ambil booking beserta relasi yang diperlukan halaman.
                $shopBookings = Booking::with([
                    'customer',
                    'service',
                    'barber',
                    'goBarberShop',
                ])
                    ->latest('booking_date')
                    ->latest('created_at')
                    ->get();

                // Gabungkan hasil booking barbershop ke koleksi utama.
                $bookings = $bookings->concat($shopBookings);
            }
        } finally {
            // Selalu bersihkan TenantContext setelah query selesai,
            // termasuk ketika terjadi kesalahan saat mengambil data.
            $tenantContext->clear();
        }

        // Urutkan booking berdasarkan waktu terbaru.
        $bookings = $bookings
            ->sortByDesc('created_at')
            ->values();

        // Kirim data Owner dan booking ke halaman Blade.
        return view('base-client.booking', compact(
            'owner',
            'bookings'
        ));
    }
}
