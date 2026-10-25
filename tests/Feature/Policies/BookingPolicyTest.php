<?php

namespace Tests\Feature\Policies;

use App\Models\Booking;
use App\Policies\BookingPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Policies\Concerns\CreatesBarbershopPolicyData;
use Tests\TestCase;

class BookingPolicyTest extends TestCase
{
    use CreatesBarbershopPolicyData;
    use RefreshDatabase;

    public function test_owner_can_view_bookings_for_their_barbershop_only(): void
    {
        $owner = $this->createUserWithRole('owner');
        $ownedShop = $this->createOwnedBarbershop($owner);
        $otherOwner = $this->createUserWithRole('owner');
        $otherShop = $this->createOwnedBarbershop($otherOwner);
        $policy = new BookingPolicy;
        $ownedBooking = new Booking;
        $ownedBooking->setAttribute('go_barbershop_id', $ownedShop->go_barbershop_id);
        $otherBooking = new Booking;
        $otherBooking->setAttribute('go_barbershop_id', $otherShop->go_barbershop_id);

        $this->assertTrue($owner->can('view', $ownedBooking));
        $this->assertFalse($policy->view($owner, $otherBooking));
    }

    public function test_admin_can_view_bookings_across_barbershops(): void
    {
        $admin = $this->createUserWithRole('admin');
        $booking = new Booking;
        $booking->setAttribute('go_barbershop_id', 999);

        $this->assertTrue((new BookingPolicy)->view($admin, $booking));
    }
}
