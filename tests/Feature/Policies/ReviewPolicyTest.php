<?php

namespace Tests\Feature\Policies;

use App\Models\Review;
use App\Models\User;
use App\Policies\ReviewPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\Policies\Concerns\CreatesBarbershopPolicyData;
use Tests\TestCase;

class ReviewPolicyTest extends TestCase
{
    use CreatesBarbershopPolicyData;
    use RefreshDatabase;

    public function test_owner_can_moderate_reviews_for_their_barbershop_only(): void
    {
        $owner = $this->createUserWithRole('owner');
        $ownedShop = $this->createOwnedBarbershop($owner);
        $otherOwner = $this->createUserWithRole('owner');
        $otherShop = $this->createOwnedBarbershop($otherOwner);
        $ownedReview = new Review;
        $ownedReview->setAttribute('go_barbershop_id', $ownedShop->go_barbershop_id);
        $otherReview = new Review;
        $otherReview->setAttribute('go_barbershop_id', $otherShop->go_barbershop_id);
        $policy = new ReviewPolicy;

        $this->assertTrue($policy->delete($owner, $ownedReview));
        $this->assertFalse($policy->delete($owner, $otherReview));
    }

    public function test_user_without_an_administrative_role_cannot_manage_reviews(): void
    {
        $user = User::factory()->create();
        $review = new Review;
        $review->setAttribute('go_barbershop_id', 999);

        $this->assertFalse((new ReviewPolicy)->view($user, $review));
    }
}
