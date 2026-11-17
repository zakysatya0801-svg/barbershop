<?php

namespace App\Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\GoBarberShop;
use App\Modules\Admin\Http\Requests\ScheduleCommissionRequest;
use App\Modules\Admin\Services\ChangeCommissionSchedule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

/**
 * Controller untuk mengelola jadwal perubahan komisi barbershop.
 */
final class AdminCommissionController extends Controller
{
    /**
     * Membuat jadwal perubahan komisi barbershop.
     */
    public function store(
        ScheduleCommissionRequest $request,
        GoBarberShop $barbershop,
        ChangeCommissionSchedule $changeCommissionSchedule
    ): JsonResponse {

        // Mengambil data request yang sudah divalidasi.
        $data = $request->validated();

        // Memproses perubahan komisi melalui service.
        $commissionScheme = $changeCommissionSchedule->handle(
            $barbershop,
            (float) $data['commission_rate'],
            Carbon::parse($data['effective_at'])
        );

        // Mengembalikan hasil perubahan komisi dalam JSON.
        return response()->json([
            'data' => [
                'commission_scheme_id' => $commissionScheme->commission_scheme_id,
                'go_barbershop_id' => $commissionScheme->go_barbershop_id,
                'commission_rate' => $commissionScheme->commission_rate,
                'valid_from' => $commissionScheme->valid_from->toIso8601String(),
                'valid_to' => $commissionScheme->valid_to?->toIso8601String(),
            ],
        ], 201);
    }
}
