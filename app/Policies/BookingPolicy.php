<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use App\Policies\Concerns\AuthorizesBarbershop;

class BookingPolicy
{
    use AuthorizesBarbershop;

    /** Daftar booking hanya tersedia untuk admin atau owner yang punya barbershop. */
    public function viewAny(User $user): bool
    {
        return $this->canManageAnyBarbershop($user);
    }

    /** Booking hanya boleh dilihat oleh admin atau owner barbershop terkait. */
    public function view(User $user, Booking $booking): bool
    {
        return $this->canManageBarbershop($user, $booking->go_barbershop_id);
    }

    /** Booking baru hanya boleh dibuat dalam konteks barbershop yang dikelola user. */
    public function create(User $user): bool
    {
        return $this->canManageActiveBarbershop($user);
    }

    /** Perubahan dan penghapusan booking dibatasi ke barbershop milik owner. */
    public function update(User $user, Booking $booking): bool
    {
        return $this->canManageBarbershop($user, $booking->go_barbershop_id);
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $this->canManageBarbershop($user, $booking->go_barbershop_id);
    }
}
