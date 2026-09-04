<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

use Database\Seeders\RolesAndAdminSeeder;
use Database\Seeders\JurusanSeeder;

class AdminRoleUnifiedTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndAdminSeeder::class);
        $this->seed(JurusanSeeder::class);
    }
    public function test_super_admin_role_does_not_exist_in_database(): void
    {
        $this->assertNull(Role::where('name', 'Super Admin')->first());
    }

    public function test_admin_user_can_login_and_redirect_to_dashboard(): void
    {
        $response = $this->post('/login', [
            'email' => 'admin@talogsmkn20.local',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard', absolute: false));
        $this->assertAuthenticated();
    }

    public function test_admin_can_access_dashboard_and_users_management(): void
    {
        $admin = User::where('email', 'admin@talogsmkn20.local')->first();
        $this->assertTrue($admin->hasRole('Admin'));

        $this->actingAs($admin)
            ->get('/admin/dashboard')
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get('/admin/users')
            ->assertStatus(200);

        $this->actingAs($admin)
            ->get('/admin/jurusan')
            ->assertStatus(200);
    }

    public function test_guru_and_siswa_cannot_access_admin_routes(): void
    {
        $guru = User::where('email', 'guru.rpl@talogsmkn20.local')->first();
        $siswa = User::where('email', 'siswa.rpl1@talogsmkn20.local')->first();

        $this->actingAs($guru)
            ->get('/admin/users')
            ->assertStatus(403);

        $this->actingAs($siswa)
            ->get('/admin/users')
            ->assertStatus(403);
    }
}
