<?php

namespace App\Modules\Admin\Services;

use App\Models\GoBarberShop;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Linkxtr\QrCode\Facades\QrCode;
use RuntimeException;

class GenerateBarbershopQr
{
    /**
     * Membuat QR Code baru untuk barbershop.
     */
    public function handle(
        GoBarberShop $barbershop,
        array $data = []
    ): array {
        return DB::transaction(function () use ($barbershop, $data) {

            // Cabut token aktif sebelumnya.
            $barbershop->qrTokens()
                ->where('status', 'active')
                ->whereNull('revoked_at')
                ->update([
                    'status' => 'revoked',
                    'revoked_at' => now(),
                ]);

            // Buat token acak yang sulit ditebak.
            $plainToken = Str::random(64);

            // Simpan hash token, bukan token aslinya.
            $record = $barbershop->qrTokens()->create([
                'token_hash' => hash('sha256', $plainToken),
                'status' => 'active',
                'issued_at' => now(),
                'expires_at' => $data['expires_at'] ?? null,
                'revoked_at' => null,
            ]);

            $scanUrl = route('barbershops.qr.scan', ['token' => $plainToken]);
            $qrImage = (string) QrCode::size(300)
                ->format('svg')
                ->generate($scanUrl);
            $qrImagePath = $record->qrImagePath();

            if (! Storage::disk('public')->put($qrImagePath, $qrImage)) {
                throw new RuntimeException('Gagal menyimpan gambar QR barbershop.');
            }

            return [
                'record' => $record,
                'plain_token' => $plainToken,
                'scan_url' => $scanUrl,
                'qr_image_url' => Storage::disk('public')->url($qrImagePath),
            ];
        });
    }
}
