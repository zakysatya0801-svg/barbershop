<?php

namespace App\Modules\Admin\Http\Requests;

use App\Models\GoBarberShop;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Memastikan hanya Admin boleh menjadwalkan tarif komisi dengan nilai dan waktu valid.
 */
final class ScheduleCommissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        $goBarberShop = $this->route('barbershop');

        return $goBarberShop instanceof GoBarberShop
            && ($this->user()?->can('scheduleCommission', $goBarberShop) ?? false);
    }

    /**
     * Persentase disimpan sebagai angka 0-100; valid_to ditentukan service.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'commission_rate' => [
                'required',
                'numeric',
                'between:0,100',
                'decimal:0,2',
            ],
            'effective_at' => ['required', 'date', 'after:now'],
        ];
    }
}
