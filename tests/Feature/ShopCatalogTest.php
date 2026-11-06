<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Barber;
use App\Models\GoBarberShop;
use App\Models\Owner;
use App\Models\Service;
use App\Models\User;
use App\Support\Tenancy\TenantContext;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopCatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_explore_includes_services_without_an_active_tenant(): void
    {
        $shop = $this->createShopWithCatalog();

        $this->get(route('shops.explore'))
            ->assertOk()
            ->assertSee($shop->barbershop_name)
            ->assertSee('Rp100.000');
    }

    public function test_shop_detail_includes_services_and_barbers_without_an_active_tenant(): void
    {
        $shop = $this->createShopWithCatalog();

        $this->get(route('shops.show', $shop->go_barbershop_id))
            ->assertOk()
            ->assertSee('Potong Rambut')
            ->assertSee('Barber Test');
    }

    private function createShopWithCatalog(): GoBarberShop
    {
        $user = User::factory()->create();
        $admin = Admin::query()->create([
            'user_id' => $user->user_id,
            'role' => 'owner',
        ]);
        $owner = Owner::query()->create([
            'admin_id' => $admin->admin_id,
            'nama_owners' => 'Owner '.$user->user_id,
            'email' => $user->email,
            'phone' => '081234567890',
        ]);
        $shop = GoBarberShop::query()->create([
            'owner_id' => $owner->owner_id,
            'barbershop_name' => 'Barbershop '.$user->user_id,
            'open_time' => '09:00:00',
            'close_time' => '18:00:00',
        ]);

        app(TenantContext::class)->set($shop);

        try {
            Service::query()->create([
                'service_name' => 'Potong Rambut',
                'price' => 100000,
                'duration' => 30,
            ]);
            Barber::query()->create([
                'barber_name' => 'Barber Test',
                'specialty' => 'Haircut',
            ]);
        } finally {
            app(TenantContext::class)->clear();
        }

        return $shop;
    }
}
