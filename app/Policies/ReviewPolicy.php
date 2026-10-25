<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use App\Policies\Concerns\AuthorizesBarbershop;

/**
 * Mengatur akses staff terhadap ulasan.
 *
 * Customer belum terhubung ke User, jadi policy ini belum memberi izin untuk
 * membuat atau mengubah ulasan atas nama customer.
 */
class ReviewPolicy
{
    use AuthorizesBarbershop;

    /** Daftar ulasan hanya tersedia untuk admin atau owner yang punya barbershop. */
    public function viewAny(User $user): bool
    {
        return $this->canManageAnyBarbershop($user);
    }

    /** Ulasan hanya boleh dilihat oleh admin atau owner barbershop terkait. */
    public function view(User $user, Review $review): bool
    {
        return $this->canManageBarbershop($user, $review->go_barbershop_id);
    }

    /** Hanya admin atau owner barbershop terkait yang boleh menghapus ulasan. */
    public function delete(User $user, Review $review): bool
    {
        return $this->canManageBarbershop($user, $review->go_barbershop_id);
    }
}
