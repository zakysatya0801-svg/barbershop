<?php

namespace Tests\Feature;

use App\Jobs\CountBarberServices;
use App\Models\Admin;
use App\Models\GoBarberShop;
use App\Models\Owner;
use App\Models\Service;
use App\Models\User;
use App\Support\Tenancy\TenantContext;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

class TenantContextTest extends TestCase
{
    use RefreshDatabase;

    public function test_context_throws_exception_if_barbershop_is_not_set(): void
    {
        $context = app(TenantContext::class);

        $this->assertFalse($context->has());

        $this->expectException(RuntimeException::class);
        $context->goBarberShop();
    }

    public function test_context_is_recreated_after_scoped_instances_are_forgotten(): void
    {
        $context = app(TenantContext::class);
        $context->set(new GoBarberShop);
        $this->assertTrue($context->has());

        $this->app->forgetScopedInstances();

        $this->assertFalse(app(TenantContext::class)->has());
    }

    public function test_queue_job_counts_services_for_its_barbershop_and_clears_context(): void
    {
        $goBarberShopA = $this->createGoBarberShop();
        $goBarberShopB = $this->createGoBarberShop();

        Service::query()->create([
            'go_barbershop_id' => $goBarberShopA->go_barbershop_id,
            'service_name' => 'Haircut A1',
            'price' => 100,
            'duration' => 30,
        ]);
        Service::query()->create([
            'go_barbershop_id' => $goBarberShopA->go_barbershop_id,
            'service_name' => 'Haircut A2',
            'price' => 120,
            'duration' => 40,
        ]);

        foreach (range(1, 3) as $serviceNumber) {
            Service::query()->create([
                'go_barbershop_id' => $goBarberShopB->go_barbershop_id,
                'service_name' => "Haircut B{$serviceNumber}",
                'price' => 150,
                'duration' => 45,
            ]);
        }

        $context = app(TenantContext::class);
        $jobA = new CountBarberServices($goBarberShopA->go_barbershop_id);
        $jobA->handle($context);

        $this->assertSame(2, $jobA->result);
        $this->assertFalse($context->has());

        $jobB = new CountBarberServices($goBarberShopB->go_barbershop_id);
        $jobB->handle($context);

        $this->assertSame(3, $jobB->result);
        $this->assertFalse($context->has());
    }

    private function createGoBarberShop(): GoBarberShop
    {
        $user = User::factory()->create();
        $admin = Admin::query()->create([
            'user_id' => $user->user_id,
            'role' => 'admin',
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
}
