<?php

namespace Tests\Feature\Modules\Admin\Http\Controllers;

use App\Models\BarbershopQrToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Modules\Admin\Concerns\CreatesCommissionData;
use Tests\TestCase;

class AdminBarbershopQrCodeControllerTest extends TestCase
{
    use CreatesCommissionData;
    use RefreshDatabase;

    public function test_admin_can_create_an_expiring_qr_and_store_its_svg(): void
    {
        $this->travelTo('2026-11-15 12:00:00');
        Storage::fake('public');

        $admin = $this->createUserWithRole('admin');
        $barbershop = $this->createBarbershopFor($admin);

        $response = $this->actingAs($admin)->postJson(
            route('admin.barbershops.qr-code.store', $barbershop),
            ['expires_at' => '2026-11-17 12:00:00']
        );

        $response->assertCreated()
            ->assertJsonPath('data.go_barbershop_id', $barbershop->go_barbershop_id)
            ->assertJsonPath('data.status', 'active')
            ->assertJsonPath('data.expires_at', '2026-11-17T12:00:00+00:00');

        $qrToken = BarbershopQrToken::query()->sole();
        $plainToken = $response->json('data.token');
        $qrImagePath = 'barbershop-qr/'.$barbershop->go_barbershop_id.'/'.$qrToken->id.'.svg';

        $this->assertSame(hash('sha256', $plainToken), $qrToken->token_hash);
        $this->assertSame('2026-11-17 12:00:00', $qrToken->expires_at->format('Y-m-d H:i:s'));
        $response->assertJsonPath('data.scan_url', route('barbershops.qr.scan', $plainToken))
            ->assertJsonPath('data.qr_image_url', Storage::disk('public')->url($qrImagePath));

        Storage::disk('public')->assertExists($qrImagePath);
        $this->assertStringContainsString('<svg', Storage::disk('public')->get($qrImagePath));
    }

    public function test_creating_a_new_qr_revokes_the_previous_token(): void
    {
        $this->travelTo('2026-11-15 12:00:00');
        Storage::fake('public');

        $admin = $this->createUserWithRole('admin');
        $barbershop = $this->createBarbershopFor($admin);
        $oldToken = $barbershop->qrTokens()->create([
            'token_hash' => hash('sha256', 'previous-qr-token'),
            'status' => 'active',
            'issued_at' => now()->subDay(),
            'expires_at' => null,
            'revoked_at' => null,
        ]);

        $response = $this->actingAs($admin)->postJson(
            route('admin.barbershops.qr-code.store', $barbershop)
        );

        $response->assertCreated()
            ->assertJsonPath('data.status', 'active')
            ->assertJsonPath('data.expires_at', null);

        $this->assertSame('revoked', $oldToken->refresh()->status);
        $this->assertNotNull($oldToken->revoked_at);
        $this->assertDatabaseCount('barbershop_qr_tokens', 2);
    }

    public function test_guest_receives_401_when_creating_a_qr(): void
    {
        $admin = $this->createUserWithRole('admin');
        $barbershop = $this->createBarbershopFor($admin);

        $this->postJson(route('admin.barbershops.qr-code.store', $barbershop))
            ->assertUnauthorized();
    }

    public function test_owner_cannot_create_an_admin_qr(): void
    {
        $owner = $this->createUserWithRole('owner');
        $barbershop = $this->createBarbershopFor($owner);

        $this->actingAs($owner)
            ->postJson(route('admin.barbershops.qr-code.store', $barbershop))
            ->assertRedirect(route('client.dashboard'));

        $this->assertDatabaseCount('barbershop_qr_tokens', 0);
    }

    public function test_past_expiration_is_rejected_without_creating_a_token(): void
    {
        $this->travelTo('2026-11-15 12:00:00');
        Storage::fake('public');

        $admin = $this->createUserWithRole('admin');
        $barbershop = $this->createBarbershopFor($admin);

        $this->actingAs($admin)
            ->postJson(
                route('admin.barbershops.qr-code.store', $barbershop),
                ['expires_at' => '2026-11-14 12:00:00']
            )
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['expires_at']);

        $this->assertDatabaseCount('barbershop_qr_tokens', 0);
        $this->assertSame([], Storage::disk('public')->allFiles());
    }

    public function test_qr_generation_is_not_available_without_the_admin_prefix(): void
    {
        $admin = $this->createUserWithRole('admin');
        $barbershop = $this->createBarbershopFor($admin);

        $this->postJson('/barbershops/'.$barbershop->go_barbershop_id.'/qr-code')
            ->assertNotFound();
    }
}
