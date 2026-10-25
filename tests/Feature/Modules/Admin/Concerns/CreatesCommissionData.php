<?php

namespace Tests\Feature\Modules\Admin\Concerns;

use App\Models\Admin;
use App\Models\GoBarberShop;
use App\Models\Owner;
use App\Models\User;

trait CreatesCommissionData
{
    protected function createUserWithRole(string $role): User
    {
        $user = User::factory()->create();

        Admin::query()->create([
            'user_id' => $user->user_id,
            'role' => $role,
        ]);

        return $user->load('admin');
    }

    protected function createBarbershopFor(User $user): GoBarberShop
    {
        $owner = Owner::query()->create([
            'admin_id' => $user->admin->admin_id,
            'nama_owners' => 'Owner '.$user->user_id,
            'email' => $user->email,
            'phone' => '081234567890',
        ]);

        return GoBarberShop::query()->create([
            'owner_id' => $owner->owner_id,
            'barbershop_name' => 'Barbershop '.$user->user_id,
            'open_time' => '09:00:00',
            'close_time' => '18:00:00',
        ]);
    }
}
