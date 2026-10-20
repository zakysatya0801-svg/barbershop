<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_login_page(): void
    {
        $response = $this->get('/login');

        $response->assertOk()->assertSee('Login Admin dan Owner');
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
        $admin = $this->createUserWithRole('admin');

        $response = $this->post('/login', [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirectToRoute('admin.dashboard');
        $this->assertAuthenticated();
    }

    public function test_owner_can_login_and_is_redirected_to_client_dashboard(): void
    {
        $owner = $this->createUserWithRole('owner');

        $response = $this->post('/login', [
            'email' => $owner->email,
            'password' => 'password',
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

    public function test_admin_and_owner_cannot_access_the_other_role_dashboard(): void
    {
        $admin = $this->createUserWithRole('admin');
        $owner = $this->createUserWithRole('owner');

        $this->actingAs($admin)->get('/client/dashboard')->assertForbidden();
        $this->actingAs($owner)->get('/admin/dashboard')->assertForbidden();
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
    }


public function test_admin_dashboard_displays_a_csrf_protected_post_logout_form(): void
{
    $admin = $this->createUserWithRole('admin');

    $response = $this->actingAs($admin)->get('/admin/dashboard');

    $response->assertOk()
        ->assertSee('<form action="'.route('logout').'" method="POST">', false)
        ->assertSee('name="_token"', false)
        ->assertSee('class="btn btn-outline-danger btn-sm"', false)
        ->assertSee('Logout');
}


    public function test_client_dashboard_displays_a_csrf_protected_post_logout_form(): void
    {
        $user = $this->createUserWithRole('owner');
        $admin = $user->admin;
        Owner::create([
            'admin_id' => $admin->admin_id,
            'nama_owners' => 'Owner Test',
            'email' => $user->email,
            'phone' => '081234567890',
        ]);

        $response = $this->actingAs($user)->get('/client/dashboard');

        $response->assertOk()
            ->assertSee('<form action="'.route('logout').'" method="POST">', false)
            ->assertSee('name="_token"', false)
            ->assertSee('class="app-logout">Logout</button>', false);
    }

    private function createUserWithRole(string $role): User
    {
        $user = User::factory()->create();

        Admin::create([
            'user_id' => $user->user_id,
            'role' => $role,
        ]);

        return $user;
    }
}
