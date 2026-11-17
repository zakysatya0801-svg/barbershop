<?php

namespace App\Modules\Admin\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validasi request untuk pembuatan QR Code barbershop.
 */
class GenerateBarbershopQrRequest extends FormRequest
{
    /**
     * Menentukan apakah request diizinkan.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi input pembuatan QR Code.
     */
    public function rules(): array
    {
        return [
            'expires_at' => [
                'nullable',
                'date',
                'after:now',
            ],
        ];
    }
}
