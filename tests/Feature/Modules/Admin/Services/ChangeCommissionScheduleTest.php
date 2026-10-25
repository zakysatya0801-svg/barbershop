<?php

namespace Tests\Feature\Modules\Admin\Services;

use App\Models\CommissionScheme;
use App\Modules\Admin\Services\ChangeCommissionSchedule;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\Feature\Modules\Admin\Concerns\CreatesCommissionData;
use Tests\TestCase;

class ChangeCommissionScheduleTest extends TestCase
{
    use CreatesCommissionData;
    use RefreshDatabase;

    public function test_scheduling_a_new_rate_closes_the_previous_rate_at_the_exact_boundary(): void
    {
        $this->travelTo('2026-10-25 20:00:00');
        $admin = $this->createUserWithRole('admin');
        $goBarberShop = $this->createBarbershopFor($admin);
        $service = new ChangeCommissionSchedule;
        $firstEffectiveAt = CarbonImmutable::parse('2026-10-27 10:00:00');
        $nextEffectiveAt = CarbonImmutable::parse('2026-11-03 10:00:00');

        $firstScheme = $service->handle($goBarberShop, 10.5, $firstEffectiveAt);
        $nextScheme = $service->handle($goBarberShop, 12, $nextEffectiveAt);

        $this->assertTrue($firstScheme->fresh()->valid_to->equalTo($nextEffectiveAt));
        $this->assertSame(
            $firstScheme->commission_scheme_id,
            CommissionScheme::query()
                ->where('go_barbershop_id', $goBarberShop->go_barbershop_id)
                ->effectiveAt($nextEffectiveAt->subSecond())
                ->value('commission_scheme_id')
        );
        $this->assertSame(
            $nextScheme->commission_scheme_id,
            CommissionScheme::query()
                ->where('go_barbershop_id', $goBarberShop->go_barbershop_id)
                ->effectiveAt($nextEffectiveAt)
                ->value('commission_scheme_id')
        );
    }

    public function test_schedule_rejects_a_start_time_that_is_not_after_the_existing_rate(): void
    {
        $this->travelTo('2026-10-25 20:00:00');
        $admin = $this->createUserWithRole('admin');
        $goBarberShop = $this->createBarbershopFor($admin);
        $service = new ChangeCommissionSchedule;
        $existingEffectiveAt = CarbonImmutable::parse('2026-10-28 10:00:00');
        $service->handle($goBarberShop, 10, $existingEffectiveAt);

        try {
            $service->handle(
                $goBarberShop,
                15,
                CarbonImmutable::parse('2026-10-27 10:00:00')
            );
            $this->fail('Expected the overlapping schedule to be rejected.');
        } catch (ValidationException $exception) {
            $this->assertArrayHasKey('effective_at', $exception->errors());
        }

        $this->assertDatabaseCount('commission_schemes', 1);
    }
}
