<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ensure Admin role exists
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Find Super Admin role if exists
        $superAdminRole = Role::where('name', 'Super Admin')->first();

        if ($superAdminRole) {
            // Reassign all Super Admin users to Admin
            $users = User::role('Super Admin')->get();
            foreach ($users as $user) {
                $user->removeRole('Super Admin');
                $user->assignRole($adminRole);
            }

            // Delete Super Admin role
            $superAdminRole->delete();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No reverse needed as Super Admin is permanently merged into Admin
    }
};
