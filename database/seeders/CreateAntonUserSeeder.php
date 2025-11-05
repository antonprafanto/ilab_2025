<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateAntonUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Super Admin user
        $user = User::create([
            'name' => 'Prof. Dr. Anton Prafanto, S.Kom., M.T.',
            'email' => 'antonprafanto@unmul.ac.id',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        // Assign Super Admin role
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $user->assignRole($superAdminRole);

        $this->command->info('✅ User Anton created successfully!');
        $this->command->info('Email: antonprafanto@unmul.ac.id');
        $this->command->info('Password: password123');
        $this->command->info('Role: Super Admin');
    }
}
