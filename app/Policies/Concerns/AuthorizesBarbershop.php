<?php

namespace App\Policies\Concerns;

use App\Models\User;
use App\Support\Tenancy\TenantContext;
use Illuminate\Database\Eloquent\Builder;

trait AuthorizesBarbershop
{
    /** Admin dapat mengelola semua barbershop; owner harus memiliki minimal satu. */
    protected function canManageAnyBarbershop(User $user): bool
    {
        $admin = $user->admin;

        if ($admin?->role === 'admin') {
            return true;
        }

        return $admin?->role === 'owner'
            && $admin->owners()->whereHas('goBarberShops')->exists();
    }

    /** Memastikan user berwenang atas barbershop spesifik, bukan hanya punya role. */
    protected function canManageBarbershop(User $user, ?int $barbershopId): bool
    {
        if ($barbershopId === null) {
            return false;
        }

        $admin = $user->admin;

        if ($admin?->role === 'admin') {
            return true;
        }

        if ($admin?->role !== 'owner') {
            return false;
        }

        return $admin->owners()
            ->whereHas(
                'goBarberShops',
                fn (Builder $query): Builder => $query->where(
                    'go_barbershops.go_barbershop_id',
                    $barbershopId
                )
            )
            ->exists();
    }

    /** Operasi create menggunakan barbershop yang sudah divalidasi middleware tenant. */
    protected function canManageActiveBarbershop(User $user): bool
    {
        return $this->canManageBarbershop(
            $user,
            app(TenantContext::class)->idOrNull()
        );
    }
}
