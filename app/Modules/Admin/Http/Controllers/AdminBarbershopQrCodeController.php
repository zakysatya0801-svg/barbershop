<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GoBarberShop;
use App\Modules\Admin\Http\Requests\GenerateBarbershopQrRequest;
use App\Modules\Admin\Services\GenerateBarbershopQr;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

/**
 * Controller untuk mengelola QR Code barbershop.
 */
final class AdminBarbershopQrCodeController extends Controller
{
    /**
     * Membuat QR Code baru untuk barbershop.
     *
     * Jika token aktif sebelumnya tersedia,
     * token lama akan dicabut sebelum token baru dibuat.
     */
    public function store(
        GenerateBarbershopQrRequest $request,
        GoBarberShop $barbershop,
        GenerateBarbershopQr $generateBarbershopQr
    ): JsonResponse|RedirectResponse {

        // Mengambil data request yang sudah divalidasi.
        $data = $request->validated();

        // Menjalankan proses pembuatan token melalui service.
        $result = $generateBarbershopQr->handle(
            $barbershop,
            $data
        );

        if (! $request->expectsJson()) {
            return redirect()
                ->route('admin.dashboard')
                ->with('status', 'QR Code untuk '.$barbershop->barbershop_name.' berhasil diperbarui.');
        }

        // Mengembalikan informasi QR Code yang berhasil dibuat.
        return response()->json([
            'message' => 'QR Code barbershop berhasil dibuat.',
            'data' => [
                'qr_token_id' => $result['record']->id,
                'go_barbershop_id' => $barbershop->go_barbershop_id,
                'barbershop_name' => $barbershop->barbershop_name,
                'token' => $result['plain_token'],
                'status' => $result['record']->status,
                'issued_at' => $result['record']->issued_at?->toIso8601String(),
                'expires_at' => $result['record']->expires_at?->toIso8601String(),
                'scan_url' => $result['scan_url'],
                'qr_image_url' => $result['qr_image_url'],
            ],
        ], 201);
    }
}
