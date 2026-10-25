<?php

namespace App\Policies;

use App\Models\GoBarberShop;
use App\Models\User;

class GoBarberShopPolicy
{
    /** Hanya Admin yang boleh menjadwalkan komisi platform untuk barbershop. */
    public function scheduleCommission(User $user, GoBarberShop $goBarberShop): bool
    {
        return $user->hasRole('admin');
    }
}
