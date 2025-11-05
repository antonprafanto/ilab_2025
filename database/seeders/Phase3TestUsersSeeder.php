<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class Phase3TestUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Creates test users needed for Phase 3 manual testing
     */
    public function run(): void
    {
        $this->command->info('Creating Phase 3 test users...');

        // 1. Admin User (for testing approval workflows)
        $admin = User::firstOrCreate(
            ['email' => 'admin@ilab.unmul.ac.id'],
            [
                'name' => 'Admin Testing',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assign Super Admin role if exists, otherwise Admin
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        if ($superAdminRole && !$admin->hasRole('Super Admin')) {
            $admin->assignRole('Super Admin');
            $this->command->info('✅ Admin user created/updated: admin@ilab.unmul.ac.id');
        }

        // 2. Dosen User (for submitting service requests)
        $dosen = User::firstOrCreate(
            ['email' => 'dosen@ilab.unmul.ac.id'],
            [
                'name' => 'Dr. Dosen Testing, M.Si.',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assign Dosen role if exists, otherwise create user without specific role
        $dosenRole = Role::where('name', 'Dosen')->first();
        if (!$dosenRole) {
            // Try alternative role names
            $dosenRole = Role::where('name', 'LIKE', '%Dosen%')->first()
                      ?? Role::where('name', 'Anggota Lab')->first();
        }

        if ($dosenRole && !$dosen->hasAnyRole(['Dosen', 'Anggota Lab'])) {
            $dosen->assignRole($dosenRole);
        }
        $this->command->info('✅ Dosen user created/updated: dosen@ilab.unmul.ac.id');

        // 3. Mahasiswa User (for creating bookings)
        $mahasiswa = User::firstOrCreate(
            ['email' => 'mahasiswa@ilab.unmul.ac.id'],
            [
                'name' => 'Mahasiswa Testing',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // Mahasiswa might not have specific role - that's OK for testing
        $mahasiswaRole = Role::where('name', 'Mahasiswa')->first();
        if ($mahasiswaRole && !$mahasiswa->hasRole('Mahasiswa')) {
            $mahasiswa->assignRole('Mahasiswa');
        }
        $this->command->info('✅ Mahasiswa user created/updated: mahasiswa@ilab.unmul.ac.id');

        $this->command->info('');
        $this->command->info('=== Phase 3 Test Users Ready ===');
        $this->command->info('All passwords: password');
        $this->command->info('');
        $this->command->info('You can now login with:');
        $this->command->info('  - admin@ilab.unmul.ac.id (Super Admin)');
        $this->command->info('  - dosen@ilab.unmul.ac.id (Dosen/Anggota Lab)');
        $this->command->info('  - mahasiswa@ilab.unmul.ac.id (Mahasiswa)');
    }
}
