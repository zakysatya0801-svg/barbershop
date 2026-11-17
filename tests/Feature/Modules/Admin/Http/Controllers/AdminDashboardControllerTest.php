<?php

namespace Tests\Feature\Modules\Admin\Http\Controllers;

use App\Models\BarbershopQrToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Modules\Admin\Concerns\CreatesCommissionData;
use Tests\TestCase;

class AdminDashboardControllerTest extends TestCase
{
    use CreatesCommissionData;
    use RefreshDatabase;

    public function test_admin_can_create_and_view_a_barbershop_qr_from_the_dashboard(): void
    {
        Storage::fake('public');

        $admin = $this->createUserWithRole('admin');
        $barbershop = $this->createBarbershopFor($admin);

        $this->actingAs($admin)
            ->post(route('admin.barbershops.qr-code.store', $barbershop))
            ->assertRedirectToRoute('admin.dashboard')
            ->assertSessionHas('status');

        $qrToken = BarbershopQrToken::query()->sole();

        Storage::disk('public')->assertExists($qrToken->qrImagePath());

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee($barbershop->barbershop_name)
            ->assertSee(Storage::disk('public')->url($qrToken->qrImagePath()), false)
            ->assertSee('Unduh SVG');
    }
}
