<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\BarbershopQrToken;
use App\Models\GoBarberShop;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Modules\Admin\Concerns\CreatesCommissionData;
use Tests\TestCase;

class BarbershopQrScanControllerTest extends TestCase
{
    use CreatesCommissionData;
    use RefreshDatabase;

    public function test_guest_with_an_active_token_is_redirected_to_the_barbershop(): void
    {
        $admin = $this->createUserWithRole('admin');
        $barbershop = $this->createBarbershopFor($admin);
        $plainToken = str_repeat('a', 64);

        $this->createToken($barbershop, $plainToken, 'active', null, null);

        $this->get(route('barbershops.qr.scan', $plainToken))
            ->assertRedirectToRoute('shops.show', $barbershop);
    }

    public function test_unknown_token_returns_404(): void
    {
        $this->get(route('barbershops.qr.scan', str_repeat('b', 64)))
            ->assertNotFound();
    }

    public function test_revoked_token_returns_404(): void
    {
        $admin = $this->createUserWithRole('admin');
        $barbershop = $this->createBarbershopFor($admin);
        $plainToken = str_repeat('c', 64);

        $this->createToken($barbershop, $plainToken, 'revoked', null, now()->subHour()->toDateTimeString());

        $this->get(route('barbershops.qr.scan', $plainToken))
            ->assertNotFound();
    }

    public function test_expired_token_returns_404(): void
    {
        $this->travelTo('2026-11-15 12:00:00');

        $admin = $this->createUserWithRole('admin');
        $barbershop = $this->createBarbershopFor($admin);
        $plainToken = str_repeat('d', 64);

        $this->createToken(
            $barbershop,
            $plainToken,
            'active',
            now()->subMinute()->toDateTimeString(),
            null
        );

        $this->get(route('barbershops.qr.scan', $plainToken))
            ->assertNotFound();
    }

    private function createToken(
        GoBarberShop $barbershop,
        string $plainToken,
        string $status,
        ?string $expiresAt,
        ?string $revokedAt
    ): BarbershopQrToken {
        return $barbershop->qrTokens()->create([
            'token_hash' => hash('sha256', $plainToken),
            'status' => $status,
            'issued_at' => now(),
            'expires_at' => $expiresAt,
            'revoked_at' => $revokedAt,
        ]);
    }
}
