<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class SampleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Wakil Direktur PM & TI
        $wakilDirektur = User::create([
            'name' => 'Dr. Budi Santoso, M.T.',
            'email' => 'budi.santoso@unmul.ac.id',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $wakilDirektur->assignRole('Wakil Direktur PM & TI');

        // 2. Kepala Lab Kimia Analitik
        $kepalaLabKimia = User::create([
            'name' => 'Dr. Siti Nurhaliza, M.Si.',
            'email' => 'siti.nurhaliza@unmul.ac.id',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $kepalaLabKimia->assignRole('Kepala Lab');

        // 3. Kepala Lab Biologi Molekuler
        $kepalaLabBio = User::create([
            'name' => 'Dr. Ahmad Fauzi, M.Sc.',
            'email' => 'ahmad.fauzi@unmul.ac.id',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $kepalaLabBio->assignRole('Kepala Lab');

        // 4. Anggota Lab (Analyst)
        $anggotaLab1 = User::create([
            'name' => 'Rina Wijaya, S.Si.',
            'email' => 'rina.wijaya@unmul.ac.id',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $anggotaLab1->assignRole('Anggota Lab');

        $anggotaLab2 = User::create([
            'name' => 'Dedi Kurniawan, S.Si.',
            'email' => 'dedi.kurniawan@unmul.ac.id',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $anggotaLab2->assignRole('Anggota Lab');

        // 5. Laboran
        $laboran = User::create([
            'name' => 'Sari Indah, A.Md.',
            'email' => 'sari.indah@unmul.ac.id',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);
        $laboran->assignRole('Laboran');

        $this->command->info('✅ Sample users created successfully!');
        $this->command->info('   - Wakil Direktur: budi.santoso@unmul.ac.id');
        $this->command->info('   - Kepala Lab Kimia: siti.nurhaliza@unmul.ac.id');
        $this->command->info('   - Kepala Lab Bio: ahmad.fauzi@unmul.ac.id');
        $this->command->info('   - Anggota Lab: rina.wijaya@unmul.ac.id, dedi.kurniawan@unmul.ac.id');
        $this->command->info('   - Laboran: sari.indah@unmul.ac.id');
        $this->command->info('   - Password semua: password123');
    }
}
