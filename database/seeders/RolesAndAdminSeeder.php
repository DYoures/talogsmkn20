<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles (Admin, Guru, Siswa)
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $guruRole = Role::firstOrCreate(['name' => 'Guru']);
        $siswaRole = Role::firstOrCreate(['name' => 'Siswa']);

        // Create the Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@talogsmkn20.local'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
            ]
        );

        $admin->syncRoles([$adminRole]);
    }
}
