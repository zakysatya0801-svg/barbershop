<?php

namespace App\Modules\Admin\Services;

use App\Models\CommissionScheme;
use App\Models\GoBarberShop;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use InvalidArgumentException;
use LogicException;

/**
 * Menjadwalkan tarif komisi tanpa mengubah riwayat yang sudah lewat.
 *
 * Seluruh jadwal memakai interval [valid_from, valid_to); tarif lama berakhir
 * tepat ketika tarif penggantinya mulai berlaku.
 */
final class ChangeCommissionSchedule
{
    public function handle(
        GoBarberShop $goBarberShop,
        float $commissionRatePercent,
        CarbonInterface $effectiveAt
    ): CommissionScheme {
        if (! is_finite($commissionRatePercent) || $commissionRatePercent < 0 || $commissionRatePercent > 100) {
            throw new InvalidArgumentException('Tarif komisi harus berada di antara 0 dan 100 persen.');
        }

        if ($effectiveAt->lessThanOrEqualTo(now())) {
            throw ValidationException::withMessages([
                'effective_at' => 'Waktu mulai harus berada di masa depan.',
            ]);
        }

        return DB::transaction(function () use (
            $goBarberShop,
            $commissionRatePercent,
            $effectiveAt
        ): CommissionScheme {
            // Mengunci toko juga ketika belum ada skema, sehingga dua jadwal awal
            // untuk toko yang sama tidak dapat disimpan bersamaan.
            $lockedShop = GoBarberShop::query()
                ->whereKey($goBarberShop->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            $activeSchemes = CommissionScheme::query()
                ->where('go_barbershop_id', $lockedShop->go_barbershop_id)
                ->whereNull('valid_to')
                ->lockForUpdate()
                ->get();

            if ($activeSchemes->count() > 1) {
                throw new LogicException(
                    'Barbershop memiliki lebih dari satu jadwal komisi aktif.'
                );
            }

            $activeScheme = $activeSchemes->first();

            if (
                $activeScheme !== null
                && $effectiveAt->lessThanOrEqualTo($activeScheme->valid_from)
            ) {
                throw ValidationException::withMessages([
                    'effective_at' => 'Waktu mulai harus setelah jadwal komisi terakhir.',
                ]);
            }

            $overlappingSchemes = CommissionScheme::query()
                ->where('go_barbershop_id', $lockedShop->go_barbershop_id)
                ->where(function (Builder $query) use ($effectiveAt): void {
                    $query->whereNull('valid_to')
                        ->orWhere('valid_to', '>', $effectiveAt);
                })
                ->when(
                    $activeScheme !== null,
                    fn (Builder $query): Builder => $query->where(
                        'commission_scheme_id',
                        '!=',
                        $activeScheme->commission_scheme_id
                    )
                )
                ->lockForUpdate()
                ->exists();

            if ($overlappingSchemes) {
                throw ValidationException::withMessages([
                    'effective_at' => 'Waktu mulai bertabrakan dengan jadwal komisi yang sudah ada.',
                ]);
            }

            $activeScheme?->forceFill([
                'valid_to' => $effectiveAt,
            ])->save();

            return $lockedShop->commissionSchemes()->create([
                'commission_rate' => $commissionRatePercent,
                'valid_from' => $effectiveAt,
                'valid_to' => null,
            ]);
        });
    }
}
