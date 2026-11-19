<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Admin;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BarbershopControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_create_a_barbershop_from_the_barbershop_form(): void
    {
        $owner = $this->createOwner();
        $otherOwner = $this->createOwner();

        $response = $this->actingAs($owner->admin->user)->post(
            route('owner.barbershop.store'),
            [
                'barbershop_name' => 'Nopal Barber',
                'description' => 'Potong rambut profesional',
                'open_time' => '09:00',
                'close_time' => '18:00',
                'owner_id' => $otherOwner->owner_id,
            ]
        );

        $response->assertRedirectToRoute('owner.barbershop')
            ->assertSessionHas('success', 'Barbershop berhasil ditambahkan.');

        $this->assertDatabaseHas('go_barbershops', [
            'owner_id' => $owner->owner_id,
            'barbershop_name' => 'Nopal Barber',
            'description' => 'Potong rambut profesional',
            'open_time' => '09:00',
            'close_time' => '18:00',
        ]);
        $this->assertDatabaseMissing('go_barbershops', [
            'owner_id' => $otherOwner->owner_id,
            'barbershop_name' => 'Nopal Barber',
        ]);
    }

    public function test_owner_dashboard_displays_the_saved_barbershop_photo_url(): void
    {
        $owner = $this->createOwner();
        $barbershop = $owner->goBarberShops()->create([
            'barbershop_name' => 'Devi BER',
            'description' => 'Barbershop test',
            'photo' => 'images/barbershops/devi-ber.jpg',
            'open_time' => '09:00',
            'close_time' => '18:00',
        ]);

        $this->actingAs($owner->admin->user)
            ->get(route('owner.barbershop.edit', $barbershop->go_barbershop_id))
            ->assertOk()
            ->assertSee(asset('images/barbershops/devi-ber.jpg'), false);
    }

    private function createOwner(): Owner
    {
        $user = User::factory()->create();
        $admin = Admin::query()->create([
            'user_id' => $user->user_id,
            'role' => 'owner',
        ]);

        return Owner::query()->create([
            'admin_id' => $admin->admin_id,
            'nama_owners' => 'Owner '.$user->user_id,
            'email' => $user->email,
            'phone' => '081234567890',
        ]);
    }
}
