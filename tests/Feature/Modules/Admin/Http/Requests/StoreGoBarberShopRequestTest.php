<?php

namespace Tests\Feature\Modules\Admin\Http\Requests;

use App\Models\Admin;
use App\Models\GoBarberShop;
use App\Models\Owner;
use App\Models\User;
use App\Modules\Admin\Http\Requests\StoreGoBarberShopRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class StoreGoBarberShopRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_only_use_a_barbershop_name_once_per_owner(): void
    {
        $owner = $this->createUserWithRole('owner');
        $this->createOwnedBarbershop($owner, 'Klip Barbershop');
        $otherOwner = $this->createUserWithRole('owner');
        $request = new StoreGoBarberShopRequest;
        $request->setUserResolver(fn (): User => $owner);
        $otherRequest = new StoreGoBarberShopRequest;
        $otherRequest->setUserResolver(fn (): User => $otherOwner);

        $duplicateForSameOwner = Validator::make(
            $this->validInput('Klip Barbershop'),
            $request->rules()
        );
        $sameNameForDifferentOwner = Validator::make(
            $this->validInput('Klip Barbershop'),
            $otherRequest->rules()
        );

        $this->assertFalse($duplicateForSameOwner->passes());
        $this->assertTrue($sameNameForDifferentOwner->passes());
    }

    public function test_owner_id_from_input_is_not_returned_as_validated_data(): void
    {
        $owner = $this->createUserWithRole('owner');
        $this->createOwnerProfile($owner);
        $request = new StoreGoBarberShopRequest;
        $request->setUserResolver(fn (): User => $owner);
        $input = $this->validInput('Klip Barbershop');
        $input['owner_id'] = '999';
        $validator = Validator::make($input, $request->rules());

        $this->assertTrue($validator->passes());
        $this->assertArrayNotHasKey('owner_id', $validator->validated());
    }

    public function test_only_an_owner_with_an_owner_profile_can_authorize_shop_creation(): void
    {
        $ownerWithoutProfile = $this->createUserWithRole('owner');
        $owner = $this->createUserWithRole('owner');
        $this->createOwnerProfile($owner);
        $admin = $this->createUserWithRole('admin');
        $request = new StoreGoBarberShopRequest;

        $request->setUserResolver(fn (): User => $ownerWithoutProfile);
        $this->assertFalse($request->authorize());

        $request->setUserResolver(fn (): User => $owner);
        $this->assertTrue($request->authorize());

        $request->setUserResolver(fn (): User => $admin);
        $this->assertFalse($request->authorize());
    }

    /**
     * @return array<string, string>
     */
    private function validInput(string $barbershopName): array
    {
        return [
            'barbershop_name' => $barbershopName,
            'open_time' => '09:00',
            'close_time' => '18:00',
        ];
    }

    private function createUserWithRole(string $role): User
    {
        $user = User::factory()->create();

        Admin::query()->create([
            'user_id' => $user->user_id,
            'role' => $role,
        ]);

        return $user->load('admin');
    }

    private function createOwnedBarbershop(User $user, string $name): GoBarberShop
    {
        $owner = $this->createOwnerProfile($user);

        return GoBarberShop::query()->create([
            'owner_id' => $owner->owner_id,
            'barbershop_name' => $name,
            'open_time' => '09:00:00',
            'close_time' => '18:00:00',
        ]);
    }

    private function createOwnerProfile(User $user): Owner
    {
        return Owner::query()->create([
            'admin_id' => $user->admin->admin_id,
            'nama_owners' => 'Owner '.$user->user_id,
            'email' => $user->email,
            'phone' => '081234567890',
        ]);
    }
}
