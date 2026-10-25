<?php

namespace App\Policies;

use App\Models\Service;
use App\Models\User;
use App\Policies\Concerns\AuthorizesBarbershop;

class ServicePolicy
{
    use AuthorizesBarbershop;

    /** Daftar layanan hanya tersedia untuk admin atau owner yang punya barbershop. */
    public function viewAny(User $user): bool
    {
        return $this->canManageAnyBarbershop($user);
    }

    /** Layanan hanya boleh dilihat oleh admin atau owner barbershop terkait. */
    public function view(User $user, Service $service): bool
    {
        return $this->canManageBarbershop($user, $service->go_barbershop_id);
    }

    /** Layanan baru hanya boleh dibuat dalam konteks barbershop yang dikelola user. */
    public function create(User $user): bool
    {
        return $this->canManageActiveBarbershop($user);
    }

    /** Perubahan dan penghapusan layanan dibatasi ke barbershop milik owner. */
    public function update(User $user, Service $service): bool
    {
        return $this->canManageBarbershop($user, $service->go_barbershop_id);
    }

    public function delete(User $user, Service $service): bool
    {
        return $this->canManageBarbershop($user, $service->go_barbershop_id);
    }
}
