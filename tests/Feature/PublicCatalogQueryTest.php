<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Barber;
use App\Models\GoBarberShop;
use App\Models\Owner;
use App\Models\Product;
use App\Models\Service;
use App\Models\User;
use App\Modules\Catalog\Services\PublicCatalogQuery;
use App\Support\Tenancy\TenantContext;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicCatalogQueryTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_catalog_returns_only_records_for_the_requested_barbershop(): void
    {
        $barbershopA = $this->createGoBarberShop();
        $barbershopB = $this->createGoBarberShop();
        $this->createCatalogRecords($barbershopA, 'A');
        $this->createCatalogRecords($barbershopB, 'B');

        $catalog = app(PublicCatalogQuery::class)->forBarbershop($barbershopA);

        $this->assertSame(['Service A'], $catalog['services']->pluck('service_name')->all());
        $this->assertSame(['Barber A'], $catalog['barbers']->pluck('barber_name')->all());
        $this->assertSame(['Product A'], $catalog['products']->pluck('name_product')->all());
        $this->assertFalse(app(TenantContext::class)->has());
    }

    private function createGoBarberShop(): GoBarberShop
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

        return GoBarberShop::query()->create([
            'owner_id' => $owner->owner_id,
            'barbershop_name' => 'Barbershop '.$user->user_id,
            'open_time' => '09:00:00',
            'close_time' => '18:00:00',
        ]);
    }

    private function createCatalogRecords(GoBarberShop $goBarberShop, string $suffix): void
    {
        $context = app(TenantContext::class);
        $context->set($goBarberShop);

        try {
            Service::query()->create([
                'service_name' => 'Service '.$suffix,
                'price' => 100,
                'duration' => 30,
            ]);
            Barber::query()->create([
                'barber_name' => 'Barber '.$suffix,
                'specialty' => 'Haircut',
            ]);
            Product::query()->create([
                'name_product' => 'Product '.$suffix,
                'price' => 100,
            ]);
        } finally {
            $context->clear();
        }
    }
}
