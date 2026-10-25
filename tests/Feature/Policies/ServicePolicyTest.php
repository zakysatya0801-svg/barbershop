<?php

namespace Tests\Feature\Policies;

use App\Models\Service;
use App\Policies\ServicePolicy;
use App\Support\Tenancy\TenantContext;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Policies\Concerns\CreatesBarbershopPolicyData;
use Tests\TestCase;

class ServicePolicyTest extends TestCase
{
    use CreatesBarbershopPolicyData;
    use RefreshDatabase;

    public function test_owner_can_create_services_only_in_their_active_barbershop(): void
    {
        $owner = $this->createUserWithRole('owner');
        $ownedShop = $this->createOwnedBarbershop($owner);
        $otherOwner = $this->createUserWithRole('owner');
        $otherShop = $this->createOwnedBarbershop($otherOwner);
        $policy = new ServicePolicy;
        $context = app(TenantContext::class);

        $this->assertFalse($policy->create($owner));

        try {
            $context->set($ownedShop);
            $this->assertTrue($policy->create($owner));

            $context->set($otherShop);
            $this->assertFalse($policy->create($owner));
        } finally {
            $context->clear();
        }
    }

    public function test_owner_cannot_update_another_owners_service(): void
    {
        $owner = $this->createUserWithRole('owner');
        $ownedShop = $this->createOwnedBarbershop($owner);
        $otherOwner = $this->createUserWithRole('owner');
        $otherShop = $this->createOwnedBarbershop($otherOwner);
        $ownedService = new Service;
        $ownedService->setAttribute('go_barbershop_id', $ownedShop->go_barbershop_id);
        $otherService = new Service;
        $otherService->setAttribute('go_barbershop_id', $otherShop->go_barbershop_id);
        $policy = new ServicePolicy;

        $this->assertTrue($policy->update($owner, $ownedService));
        $this->assertFalse($policy->update($owner, $otherService));
    }
}
