<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\GoBarberShop;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_home_page_with_login_link(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Dashboard')
            ->assertSee('href="'.route('login').'"', false)
            ->assertDontSee('href="'.route('admin.dashboard').'"', false)
            ->assertDontSee('href="'.route('client.dashboard').'"', false);
    }

    public function test_admin_sees_admin_dashboard_link_on_home_page(): void
    {
        $admin = $this->createUserWithRole('admin');

        $response = $this->actingAs($admin)->get('/');

        $response->assertOk()
            ->assertSee('href="'.route('admin.dashboard').'"', false)
            ->assertDontSee('href="'.route('client.dashboard').'"', false);
    }

    public function test_owner_sees_owner_dashboard_link_on_home_page(): void
    {
        $owner = $this->createUserWithRole('owner');

        $response = $this->actingAs($owner)->get('/');

        $response->assertOk()
            ->assertSee('href="'.route('client.dashboard').'"', false)
            ->assertDontSee('href="'.route('admin.dashboard').'"', false);
    }

    public function test_login_page_does_not_ask_for_a_role_selection(): void
    {
        $response = $this->get('/login');

        $response->assertOk()
            ->assertDontSee('name="role"', false)
            ->assertDontSee('Masuk sebagai');
    }

    public function test_guest_can_open_login_page(): void
    {
        $response = $this->get('/login');

        $response->assertOk()->assertSee('Masuk ke akun GoBarberShop');
        $response->assertSee('name="email"', false)
            ->assertSee('name="password"', false)
            ->assertSee('method="POST"', false)
            ->assertSee('action="'.route('login.process').'"', false)
            ->assertSee('name="_token"', false);
        $this->assertGuest();
    }

    public function test_authenticated_admin_is_redirected_to_admin_dashboard_from_login(): void
    {
        $admin = $this->createUserWithRole('admin');

        $response = $this->actingAs($admin)->get('/login');

        $response->assertRedirectToRoute('admin.dashboard');
    }

    public function test_admin_can_login_and_is_redirected_to_admin_dashboard(): void
    {
        $admin = $this->createUserWithRole('admin', verified: false);

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirectToRoute('admin.dashboard');
        $this->assertAuthenticated();
    }

    public function test_owner_can_login_and_is_redirected_to_client_dashboard(): void
    {
        $owner = $this->createUserWithRole('owner', verified: false);

        $response = $this->post('/login', [
            'email' => $owner->email,
            'password' => 'password',
        ]);

        $response->assertRedirectToRoute('client.dashboard');
        $this->assertAuthenticated();
    }

    public function test_login_uses_the_account_role_instead_of_a_submitted_role(): void
    {
        $owner = $this->createUserWithRole('owner');

        $response = $this->post('/login', [
            'email' => $owner->email,
            'password' => 'password',
            'role' => 'admin',
        ]);

        $response->assertRedirectToRoute('client.dashboard');
        $this->assertAuthenticated();
    }

    public function test_invalid_credentials_show_an_error_and_keep_user_guest(): void
    {
        $user = User::factory()->create();
        $this->get('/login');

        $response = $this->followingRedirects()->post('/login', [
            'email' => $user->email,
            'password' => 'sensitive-wrong-password',
        ]);

        $response->assertOk()
            ->assertSee('Email atau password tidak sesuai.')
            ->assertSee('value="'.$user->email.'"', false)
            ->assertDontSee('sensitive-wrong-password');
        $this->assertGuest();
    }

    public function test_login_rejects_a_user_without_an_allowed_role(): void
    {
        $user = $this->createUserWithRole('staff');

        $response = $this->followingRedirects()->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertOk()
            ->assertSee('Akun tidak memiliki akses Admin atau Owner.');
        $this->assertGuest();
    }

    public function test_guest_is_redirected_to_login_from_both_dashboards(): void
    {
        $this->get('/admin/dashboard')->assertRedirectToRoute('login');
        $this->get('/client/dashboard')->assertRedirectToRoute('login');
    }

    public function test_guest_is_redirected_to_login_from_legacy_shop_dashboard(): void
    {
        $this->get('/dashboard/example-shop')->assertRedirectToRoute('login');
    }

    public function test_guest_is_redirected_to_login_from_a_barbershop_dashboard(): void
    {
        $ownerUser = $this->createUserWithRole('owner');
        $owner = $this->createOwnerProfile($ownerUser);
        $shop = $this->createBarbershop($owner, 'Barbershop Private');

        $this->get("/client/barbershops/{$shop->go_barbershop_id}/dashboard")
            ->assertRedirectToRoute('login');
    }

    public function test_admin_and_owner_are_redirected_from_the_other_role_dashboard(): void
    {
        $admin = $this->createUserWithRole('admin');
        $owner = $this->createUserWithRole('owner');

        $this->actingAs($admin)->get('/client/dashboard')
            ->assertRedirectToRoute('admin.dashboard');
        $this->actingAs($owner)->get('/admin/dashboard')
            ->assertRedirectToRoute('client.dashboard');
    }

    public function test_owner_dashboard_only_lists_shops_belonging_to_the_logged_in_owner(): void
    {
        $ownerUser = $this->createUserWithRole('owner');
        $owner = $this->createOwnerProfile($ownerUser);
        $this->createBarbershop($owner, 'Barbershop Saya');

        $otherOwnerUser = $this->createUserWithRole('owner');
        $otherOwner = $this->createOwnerProfile($otherOwnerUser);
        $this->createBarbershop($otherOwner, 'Barbershop Orang Lain');

        $response = $this->actingAs($ownerUser)->get('/client/dashboard');

        $response->assertOk()
            ->assertSee('Barbershop Saya')
            ->assertDontSee('Barbershop Orang Lain');
    }

    public function test_owner_is_redirected_to_their_dashboard_from_another_owners_shop_dashboard(): void
    {
        $ownerUser = $this->createUserWithRole('owner');
        $owner = $this->createOwnerProfile($ownerUser);
        $this->createBarbershop($owner, 'Barbershop Saya');

        $otherOwnerUser = $this->createUserWithRole('owner');
        $otherOwner = $this->createOwnerProfile($otherOwnerUser);
        $otherShop = $this->createBarbershop($otherOwner, 'Barbershop Orang Lain');

        $this->actingAs($ownerUser)
            ->get("/client/barbershops/{$otherShop->go_barbershop_id}/dashboard")
            ->assertRedirectToRoute('client.dashboard');
    }

    public function test_admin_is_redirected_to_admin_dashboard_from_owner_shop_dashboard(): void
    {
        $admin = $this->createUserWithRole('admin');
        $ownerUser = $this->createUserWithRole('owner');
        $owner = $this->createOwnerProfile($ownerUser);
        $shop = $this->createBarbershop($owner, 'Barbershop Owner');

        $this->actingAs($admin)
            ->get("/client/barbershops/{$shop->go_barbershop_id}/dashboard")
            ->assertRedirectToRoute('admin.dashboard');
    }

    public function test_user_with_an_unsupported_role_cannot_access_either_dashboard(): void
    {
        $user = $this->createUserWithRole('staff');

        $this->actingAs($user)->get('/admin/dashboard')->assertForbidden();
        $this->actingAs($user)->get('/client/dashboard')->assertForbidden();
    }

    public function test_logout_clears_authentication_and_allows_login_page(): void
    {
        $admin = $this->createUserWithRole('admin');
        $this->actingAs($admin);

        $response = $this->post('/logout');

        $response->assertRedirectToRoute('login');
        $this->assertGuest();
        $this->get('/login')->assertOk();

        $home = $this->get('/');

        $home->assertOk()
            ->assertSee('href="'.route('login').'"', false)
            ->assertDontSee('href="'.route('admin.dashboard').'"', false)
            ->assertDontSee('href="'.route('client.dashboard').'"', false);

        $this->get('/admin/dashboard')->assertRedirectToRoute('login');
        $this->get('/client/dashboard')->assertRedirectToRoute('login');
    }

    public function test_guest_cannot_post_to_the_logout_route(): void
    {
        $this->post('/logout')->assertRedirectToRoute('login');

        $this->assertGuest();
    }

    public function test_admin_dashboard_displays_a_csrf_protected_post_logout_form(): void
    {
        $admin = $this->createUserWithRole('admin');

        $response = $this->actingAs($admin)->get('/admin/dashboard');

        $response->assertOk()
            ->assertSee('<form action="'.route('logout').'" method="POST">', false)
            ->assertSee('name="_token"', false)
            ->assertSee('class="btn btn-outline-danger btn-sm"', false)
            ->assertSee('class="nav-link text-start w-100 border-0 bg-transparent text-danger"', false)
            ->assertSee('Logout');
    }

    public function test_client_dashboard_displays_a_csrf_protected_post_logout_form(): void
    {
        $user = $this->createUserWithRole('owner');
        $this->createOwnerProfile($user);

        $response = $this->actingAs($user)->get('/client/dashboard');

        $response->assertOk()
            ->assertSee('<form action="'.route('logout').'" method="POST">', false)
            ->assertSee('name="_token"', false)
            ->assertSee('class="app-logout">Logout</button>', false);
    }

    private function createUserWithRole(string $role, bool $verified = true): User
    {
        $user = $verified
            ? User::factory()->create()
            : User::factory()->unverified()->create();

        Admin::create([
            'user_id' => $user->user_id,
            'role' => $role,
        ]);

        return $user;
    }

    private function createOwnerProfile(User $user): Owner
    {
        return Owner::create([
            'admin_id' => $user->admin->admin_id,
            'nama_owners' => 'Owner Test '.$user->user_id,
            'email' => $user->email,
            'phone' => '081234567890',
        ]);
    }

    private function createBarbershop(Owner $owner, string $name): GoBarberShop
    {
        return GoBarberShop::create([
            'owner_id' => $owner->owner_id,
            'barbershop_name' => $name,
            'open_time' => '09:00:00',
            'close_time' => '18:00:00',
        ]);
    }
}
