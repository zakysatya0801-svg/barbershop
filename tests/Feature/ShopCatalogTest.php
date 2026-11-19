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

    public function test_shop_explore_and_detail_hide_help_and_dashboard_navigation(): void
    {
        $shop = $this->createShopWithCatalog();

        $this->get(route('shops.explore'))
            ->assertOk()
            ->assertDontSee('href="'.route('login').'">Cek Reservasi</a>', false)
            ->assertDontSee('href="'.route('login').'">Bantuan</a>', false)
            ->assertDontSee('href="'.route('login').'">Dashboard</a>', false);

        $this->get(route('shops.show', $shop->go_barbershop_id))
            ->assertOk()
            ->assertDontSee('href="'.route('login').'">Cek Reservasi</a>', false)
            ->assertDontSee('href="'.route('login').'">Bantuan</a>', false)
            ->assertDontSee('href="'.route('login').'">Dashboard</a>', false);
    }

    public function test_shop_detail_includes_services_and_barbers_without_an_active_tenant(): void
    {
        $shop = $this->createShopWithCatalog();

        $this->get(route('shops.show', $shop->go_barbershop_id))
            ->assertOk()
            ->assertSee('Potong Rambut')
            ->assertSee('Barber Test');
    }

    public function test_shop_photo_uses_the_same_url_in_explore_and_detail_pages(): void
    {
        $shop = $this->createShopWithCatalog();
        $shop->update(['photo' => 'barbershops/shop-photo.jpg']);
        $photoUrl = $shop->fresh()->photo_url;

        $this->get(route('shops.explore'))
            ->assertOk()
            ->assertSee($photoUrl, false);

        $this->get(route('shops.show', $shop->go_barbershop_id))
            ->assertOk()
            ->assertSee($photoUrl, false);
    }

    public function test_booking_service_selection_uses_the_selected_shop_catalog(): void
    {
        $shop = $this->createShopWithCatalog();

        $this->get(route('booking', $shop->go_barbershop_id))
            ->assertOk()
            ->assertSee('Potong Rambut');
    }

    public function test_customer_can_reach_payment_after_selecting_a_service_barber_and_schedule(): void
    {
        $shop = $this->createShopWithCatalog();
        $service = Service::withoutGlobalScope('tenant')
            ->where('go_barbershop_id', $shop->go_barbershop_id)
            ->firstOrFail();
        $barber = Barber::withoutGlobalScope('tenant')
            ->where('go_barbershop_id', $shop->go_barbershop_id)
            ->firstOrFail();

        $response = $this->post(
            route('booking.services.store', $shop->go_barbershop_id),
            ['service_ids' => [$service->service_id]]
        );

        $response->assertRedirectToRoute(
            'booking.schedule',
            $shop->go_barbershop_id
        )
            ->assertSessionHas('booking.shop_id', $shop->go_barbershop_id)
            ->assertSessionHas('booking.service_ids', [$service->service_id]);

        $this->get(route('booking.schedule', $shop->go_barbershop_id))
            ->assertOk()
            ->assertSee('Pilih Barber & Jadwal', false);

        $this->post(
            route('booking.schedule.store', $shop->go_barbershop_id),
            [
                'barber_id' => $barber->barber_id,
                'booking_date' => now()->addDay()->toDateString(),
                'booking_time' => '10:00',
            ]
        )->assertRedirectToRoute(
            'booking.payment',
            $shop->go_barbershop_id
        );

        $this->get(route('booking.payment', $shop->go_barbershop_id))
            ->assertOk()
            ->assertSee('Pembayaran Reservasi')
            ->assertSee('Potong Rambut');
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
