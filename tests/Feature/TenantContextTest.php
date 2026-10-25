<?php

namespace Tests\Feature;

use App\Jobs\CountBarberServices;
use App\Models\Admin;
use App\Models\Barber;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\CustomerRequest;
use App\Models\GoBarberShop;
use App\Models\Owner;
use App\Models\Payment;
use App\Models\Service;
use App\Models\User;
use App\Support\Tenancy\TenantContext;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use LogicException;
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

        $this->createService($goBarberShopA, 'Haircut A1');
        $this->createService($goBarberShopA, 'Haircut A2');

        foreach (range(1, 3) as $serviceNumber) {
            $this->createService($goBarberShopB, "Haircut B{$serviceNumber}");
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

    public function test_tenant_queries_are_scoped_and_writes_require_the_active_barbershop(): void
    {
        $goBarberShopA = $this->createGoBarberShop();
        $goBarberShopB = $this->createGoBarberShop();
        $serviceA = $this->createService($goBarberShopA, 'Service A');
        $this->createService($goBarberShopB, 'Service B');
        $context = app(TenantContext::class);

        $context->set($goBarberShopA);
        $this->assertSame(
            ['Service A'],
            Service::query()->pluck('service_name')->all()
        );

        $context->set($goBarberShopB);
        $this->assertSame(
            ['Service B'],
            Service::query()->pluck('service_name')->all()
        );

        $context->clear();
        $this->assertSame([], Service::query()->pluck('service_name')->all());

        $this->expectException(LogicException::class);
        $serviceA->service_name = 'Changed without tenant';
        $serviceA->save();
    }

    public function test_tenant_write_cannot_move_a_service_to_another_barbershop(): void
    {
        $goBarberShopA = $this->createGoBarberShop();
        $goBarberShopB = $this->createGoBarberShop();
        $service = $this->createService($goBarberShopA, 'Service A');

        $context = app(TenantContext::class);
        $context->set($goBarberShopB);
        $service->go_barbershop_id = $goBarberShopB->go_barbershop_id;

        $this->expectException(LogicException::class);
        $service->save();
    }

    public function test_tenant_id_from_mass_assignment_cannot_override_the_active_barbershop(): void
    {
        $goBarberShopA = $this->createGoBarberShop();
        $goBarberShopB = $this->createGoBarberShop();
        app(TenantContext::class)->set($goBarberShopA);

        $service = Service::query()->create([
            'go_barbershop_id' => $goBarberShopB->go_barbershop_id,
            'service_name' => 'Service A',
            'price' => 100,
            'duration' => 30,
        ]);

        $this->assertSame(
            $goBarberShopA->go_barbershop_id,
            $service->go_barbershop_id
        );
    }

    public function test_booking_cannot_combine_a_service_and_barber_from_different_barbershops(): void
    {
        $goBarberShopA = $this->createGoBarberShop();
        $goBarberShopB = $this->createGoBarberShop();
        $serviceA = $this->createService($goBarberShopA, 'Service A');
        $barberB = $this->createBarber($goBarberShopB, 'Barber B');
        $customer = Customer::query()->create([
            'name' => 'Customer',
            'phone' => '081234567890',
        ]);

        app(TenantContext::class)->set($goBarberShopA);

        $this->expectException(LogicException::class);
        Booking::query()->create([
            'customer_id' => $customer->customer_id,
            'service_id' => $serviceA->service_id,
            'barber_id' => $barberB->barber_id,
            'booking_date' => '2026-10-24',
            'time_slot' => '10:00:00',
            'status' => 'pending',
        ]);
    }

    public function test_booking_children_are_scoped_to_the_active_barbershop(): void
    {
        $goBarberShopA = $this->createGoBarberShop();
        $goBarberShopB = $this->createGoBarberShop();
        $customer = Customer::query()->create([
            'name' => 'Customer',
            'phone' => '081234567890',
        ]);
        $bookingIds = [];

        foreach ([$goBarberShopA, $goBarberShopB] as $index => $barbershop) {
            app(TenantContext::class)->set($barbershop);
            $service = $this->createService($barbershop, 'Service '.$index);
            $barber = $this->createBarber($barbershop, 'Barber '.$index);
            app(TenantContext::class)->set($barbershop);
            $booking = Booking::query()->create([
                'customer_id' => $customer->customer_id,
                'service_id' => $service->service_id,
                'barber_id' => $barber->barber_id,
                'booking_date' => '2026-10-24',
                'time_slot' => '10:00:00',
                'status' => 'pending',
            ]);
            $bookingIds[] = $booking->booking_id;

            DB::table('payments')->insert([
                'booking_id' => $booking->booking_id,
                'amount' => 100,
                'payment_method' => 'cash',
                'payment_status' => 'pending',
            ]);
            DB::table('requests')->insert([
                'booking_id' => $booking->booking_id,
                'customer_id' => $customer->customer_id,
                'massage' => 'Request '.$index,
                'status' => 'pending',
            ]);
        }

        app(TenantContext::class)->set($goBarberShopB);

        $this->assertSame([$bookingIds[1]], Payment::query()->pluck('booking_id')->all());
        $this->assertSame(
            [$bookingIds[1]],
            CustomerRequest::query()->pluck('booking_id')->all()
        );

        app(TenantContext::class)->set($goBarberShopA);

        $this->expectException(LogicException::class);
        CustomerRequest::query()->create([
            'booking_id' => $bookingIds[1],
            'customer_id' => $customer->customer_id,
            'massage' => 'Cross-tenant request',
            'status' => 'pending',
        ]);
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

    private function createService(GoBarberShop $goBarberShop, string $name): Service
    {
        $context = app(TenantContext::class);
        $context->set($goBarberShop);

        try {
            return Service::query()->create([
                'service_name' => $name,
                'price' => 100,
                'duration' => 30,
            ]);
        } finally {
            $context->clear();
        }
    }

    private function createBarber(GoBarberShop $goBarberShop, string $name): Barber
    {
        $context = app(TenantContext::class);
        $context->set($goBarberShop);

        try {
            return Barber::query()->create([
                'barber_name' => $name,
                'specialty' => 'Haircut',
            ]);
        } finally {
            $context->clear();
        }
    }
}
