<?php

namespace App\Modules\Admin\Http\Requests;

use App\Models\User;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Memvalidasi data saat Owner mendaftarkan barbershop baru.
 *
 * Identitas Owner diambil dari akun login, bukan dari nilai yang dikirim form.
 */
final class StoreGoBarberShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Hanya akun ber-role Owner yang memiliki profil Owner boleh membuat toko.
        return $this->ownerId() !== null;
    }

    /**
     * Mengambil ID profil Owner dari relasi akun, bukan dari input pengguna.
     */
    public function ownerId(): ?int
    {
        $user = $this->user();

        if (! $user instanceof User || ! $user->hasRole('owner')) {
            return null;
        }

        $ownerId = $user->admin?->owners()->value('owner_id');

        return $ownerId === null ? null : (int) $ownerId;
    }

    /**
     * Nama toko unik per Owner agar pemilik berbeda boleh memakai nama yang sama.
     *
     * @return array<string, array<mixed>|string>
     */
    public function rules(): array
    {
        $ownerId = $this->ownerId();

        return [
            'barbershop_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('go_barbershops', 'barbershop_name')
                    ->where(
                        fn (QueryBuilder $query): QueryBuilder => $query
                            ->where('owner_id', $ownerId)
                    ),
            ],
            'location_id' => ['nullable', 'integer', 'exists:locations,location_id'],
            'description' => ['nullable', 'string'],
            'photo' => ['nullable', 'string'],
            'open_time' => ['required', 'date_format:H:i'],
            'close_time' => ['required', 'date_format:H:i'],
        ];
    }
}
