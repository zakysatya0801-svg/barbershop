<?php

namespace Tests\Feature\Modules\Admin\Http\Controllers;

use App\Models\CommissionScheme;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Modules\Admin\Concerns\CreatesCommissionData;
use Tests\TestCase;

class AdminCommissionControllerTest extends TestCase
{
    use CreatesCommissionData;
    use RefreshDatabase;

    public function test_admin_can_schedule_a_commission_rate_without_a_blade_page(): void
    {
        $this->travelTo('2026-10-25 20:00:00');
        $admin = $this->createUserWithRole('admin');
        $goBarberShop = $this->createBarbershopFor($admin);

        $response = $this->actingAs($admin)->postJson(
            route('admin.barbershops.commission-schemes.store', $goBarberShop),
            [
                'commission_rate' => '12.50',
                'effective_at' => '2026-10-27 10:00:00',
            ]
        );

        $response->assertCreated()
            ->assertJsonPath('data.go_barbershop_id', $goBarberShop->go_barbershop_id)
            ->assertJsonPath('data.commission_rate', '12.50')
            ->assertJsonPath('data.valid_to', null);
        $this->assertDatabaseHas('commission_schemes', [
            'go_barbershop_id' => $goBarberShop->go_barbershop_id,
            'commission_rate' => 12.5,
            'valid_to' => null,
        ]);
    }

    public function test_owner_cannot_schedule_a_commission_rate(): void
    {
        $owner = $this->createUserWithRole('owner');
        $goBarberShop = $this->createBarbershopFor($owner);

        $this->assertFalse($owner->can('scheduleCommission', $goBarberShop));

        $this->actingAs($owner)
            ->postJson(
                route('admin.barbershops.commission-schemes.store', $goBarberShop),
                [
                    'commission_rate' => '12.50',
                    'effective_at' => now()->addDay()->toDateTimeString(),
                ]
            )
            ->assertRedirect(route('client.dashboard'));

        $this->assertDatabaseCount('commission_schemes', 0);
    }

    public function test_invalid_rate_or_past_effective_time_is_rejected(): void
    {
        $this->travelTo('2026-10-25 20:00:00');
        $admin = $this->createUserWithRole('admin');
        $goBarberShop = $this->createBarbershopFor($admin);

        $this->actingAs($admin)
            ->postJson(
                route('admin.barbershops.commission-schemes.store', $goBarberShop),
                [
                    'commission_rate' => '100.01',
                    'effective_at' => '2026-10-24 10:00:00',
                ]
            )
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['commission_rate', 'effective_at']);

        $this->assertSame(0, CommissionScheme::query()->count());
    }
}
