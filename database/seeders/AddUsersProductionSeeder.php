<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * PRODUCTION-SAFE SEEDER
 * Seeder ini AMAN dijalankan di production karena:
 * - Menggunakan firstOrCreate (tidak error jika user sudah ada)
 * - Hanya menambah user baru, tidak mengubah user existing
 * - Tidak menghapus data apapun
 */
class AddUsersProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeder ini membuat 41 user berdasarkan SK Rektor No. 2846/UN17/HK.02.03/2025
     * Password: Unique strong password untuk setiap user
     */
    public function run(): void
    {
        $created = 0;
        $skipped = 0;

        // ========================================
        // 1. PIMPINAN UNIT (4 Orang)
        // ========================================

        // 1.1 Pelindung (Rektor) - Super Admin
        $user = User::firstOrCreate(
            ['email' => 'abdunnur@unmul.ac.id'],
            [
                'name' => 'Prof. Dr. Ir. H. Abdunnur, M.Si., IPU',
                'password' => Hash::make('Unmul@2025#Rektor'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Super Admin');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // 1.2 Pengarah - Wakil Direktur Pelayanan
        $user = User::firstOrCreate(
            ['email' => 'lambang@unmul.ac.id'],
            [
                'name' => 'Prof. Dr. Lambang Subagiyo, M.Si',
                'password' => Hash::make('Lambang#Pengarah2025'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Wakil Direktur Pelayanan');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // 1.3 Penanggung Jawab - Wakil Direktur PM & TI
        $user = User::firstOrCreate(
            ['email' => 'fajar@unmul.ac.id'],
            [
                'name' => 'apt. Fajar Prasetya, S.Farm., M.Si., Ph.D',
                'password' => Hash::make('Fajar@PJawab2025!'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Wakil Direktur PM & TI');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // 1.4 Kepala Unit - Super Admin
        $user = User::firstOrCreate(
            ['email' => 'angga@unmul.ac.id'],
            [
                'name' => 'Dr. apt. Angga Cipta Narsa, M.Si.',
                'password' => Hash::make('Angga#KepalaUnit25'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Super Admin');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // ========================================
        // 2. KELOMPOK KERJA (3 Orang)
        // ========================================

        // 2.1 Kepala KK Teknis, Inovasi & Kerjasama
        $user = User::firstOrCreate(
            ['email' => 'hamdhani@unmul.ac.id'],
            [
                'name' => 'Hamdhani, S.P., M.Sc., Ph.D.',
                'password' => Hash::make('Hamdhani@Teknis25'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Kepala Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // 2.2 Kepala KK Pelayanan, Mutu & TI
        $user = User::firstOrCreate(
            ['email' => 'chairul@unmul.ac.id'],
            [
                'name' => 'Dr. Chairul Saleh, M.Si.',
                'password' => Hash::make('Chairul!Mutu2025'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Wakil Direktur PM & TI');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // 2.3 Kepala KK Administrasi & Umum
        $user = User::firstOrCreate(
            ['email' => 'nurul@unmul.ac.id'],
            [
                'name' => 'Dr. Nurul Puspita Palupi, S.P., M.Si.',
                'password' => Hash::make('Nurul@Admin2025!'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Sub Bagian TU & Keuangan');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // ========================================
        // 3. KELOMPOK FUNGSIONAL (8 Kelompok - 24 Orang)
        // ========================================

        // 3.1 Kelompok Fungsional Natural Product (3 Orang)
        $user = User::firstOrCreate(
            ['email' => 'sabaniah@unmul.ac.id'],
            [
                'name' => 'Sabaniah Indjar Gama, M.Si.',
                'password' => Hash::make('Sabaniah#NatProd25'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Kepala Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'vina@unmul.ac.id'],
            [
                'name' => 'Dr. apt. Vina Maulidya, M.Farm.',
                'password' => Hash::make('Vina!Farmasi2025'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Anggota Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'alhawaris@unmul.ac.id'],
            [
                'name' => 'Alhawaris, S.Si., M.Kes.',
                'password' => Hash::make('Alhawaris@Lab25!'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Anggota Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // 3.2 Kelompok Fungsional Advanced Instrument (3 Orang)
        $user = User::firstOrCreate(
            ['email' => 'rafitah@unmul.ac.id'],
            [
                'name' => 'Rafitah Hasanah, S.Pi., M.Si., Ph.D.',
                'password' => Hash::make('Rafitah#AdvInst25'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Kepala Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'pintaka@unmul.ac.id'],
            [
                'name' => 'Dr. Pintaka Kusumaningtyas, S.Pd., M.Si.',
                'password' => Hash::make('Pintaka@Instru25!'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Anggota Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'syaiful@unmul.ac.id'],
            [
                'name' => 'Moh. Syaiful Arif, S.Pd., M.Si.',
                'password' => Hash::make('Syaiful!Analis25'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Anggota Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // 3.3 Kelompok Fungsional Environmental (3 Orang)
        $user = User::firstOrCreate(
            ['email' => 'atin@unmul.ac.id'],
            [
                'name' => 'Atin Nuryadin, S.Pd., M.Si., Ph.D.',
                'password' => Hash::make('Atin#Environ2025'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Kepala Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'indah@unmul.ac.id'],
            [
                'name' => 'Indah Prihatiningtyas D.S., S.T., M.T., Ph.D.',
                'password' => Hash::make('Indah@Lingkung25!'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Anggota Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'noor@unmul.ac.id'],
            [
                'name' => 'Dr. Noor Hindryawati, S.Pd., M.Si.',
                'password' => Hash::make('Noor!Environ2025'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Anggota Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // 3.4 Kelompok Fungsional Agriculture & Animal Husbandry (3 Orang)
        $user = User::firstOrCreate(
            ['email' => 'taufan@unmul.ac.id'],
            [
                'name' => 'Prof. Dr. Ir. Taufan Purwokusumaning Daru, M.P.',
                'password' => Hash::make('Taufan#Agri2025!'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Kepala Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'kadis@unmul.ac.id'],
            [
                'name' => 'Kadis Mujiono, SP., MSc., Ph.D.',
                'password' => Hash::make('Kadis@Pertanian25'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Anggota Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'roro@unmul.ac.id'],
            [
                'name' => 'Roro Kesumaningwati, SP., M.Sc.',
                'password' => Hash::make('Roro!Agriculture25'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Anggota Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // 3.5 Kelompok Fungsional Oceanography & Engineering (3 Orang)
        $user = User::firstOrCreate(
            ['email' => 'nanda@unmul.ac.id'],
            [
                'name' => 'Nanda Khoirunisa, S.Pd., M.Sc.',
                'password' => Hash::make('Nanda#Ocean2025!'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Kepala Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'anugrah@unmul.ac.id'],
            [
                'name' => 'Anugrah Aditya Budiarsa, S.Pi., M.Si.',
                'password' => Hash::make('Anugrah@Laut2025'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Anggota Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'irwan@unmul.ac.id'],
            [
                'name' => 'Irwan Ramadhan Ritonga, S.Pi., M.Si., Ph.D.',
                'password' => Hash::make('Irwan!Oceano25'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Anggota Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // 3.6 Kelompok Fungsional Social Innovation (3 Orang)
        $user = User::firstOrCreate(
            ['email' => 'etik@unmul.ac.id'],
            [
                'name' => 'Etik Sulistiowati Ningsih, S.P., M.Si., Ph.D.',
                'password' => Hash::make('Etik#Social2025!'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Kepala Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'rahmawati@unmul.ac.id'],
            [
                'name' => 'Rahmawati Al Hidayah., SH., LLM.',
                'password' => Hash::make('Rahmawati@Innov25'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Anggota Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'kheyene@unmul.ac.id'],
            [
                'name' => 'Kheyene Molekandella Boer., M.Ilkom',
                'password' => Hash::make('Kheyene!Sosial25'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Anggota Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // 3.7 Kelompok Fungsional E-commerce & IT Business (3 Orang)
        $user = User::firstOrCreate(
            ['email' => 'hario@unmul.ac.id'],
            [
                'name' => 'Hario Jati Setyadi, S.Kom., M.Kom.',
                'password' => Hash::make('Hario#Ecommerce25'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Kepala Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'antonprafanto@unmul.ac.id'],
            [
                'name' => 'Anton Prafanto, S.Kom., M.T.',
                'password' => Hash::make('Anton@DevIlab2025!'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Anggota Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'ellen@unmul.ac.id'],
            [
                'name' => 'Ellen D. Oktanti Irianto, S.E., M.Sc.',
                'password' => Hash::make('Ellen!Business25'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Anggota Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // 3.8 Kelompok Fungsional Biotechnology (3 Orang)
        $user = User::firstOrCreate(
            ['email' => 'bodhi@unmul.ac.id'],
            [
                'name' => 'Dr. rer. nat. Bodhi Dharma, M.Si.',
                'password' => Hash::make('Bodhi#Biotech2025'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Kepala Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'dian@unmul.ac.id'],
            [
                'name' => 'Dr. dr. Dian Rachmawati, M.Kes.',
                'password' => Hash::make('Dian@BioMol2025!'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Anggota Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'fauzi@unmul.ac.id'],
            [
                'name' => 'Muhammad Fauzi Arif, S.Si., M.Sc.',
                'password' => Hash::make('Fauzi!Biotech25'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Anggota Lab');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // ========================================
        // 4. STAFF LABORAN (2 Orang - Contoh)
        // ========================================

        $user = User::firstOrCreate(
            ['email' => 'budi@unmul.ac.id'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('Budi@Teknisi2025!'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Laboran');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'siti@unmul.ac.id'],
            [
                'name' => 'Siti Aminah',
                'password' => Hash::make('Siti#Laboran2025'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Laboran');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // ========================================
        // 5. PENGGUNA LAYANAN - CONTOH (8 Orang)
        // ========================================

        // 5.1 Dosen (2 orang)
        $user = User::firstOrCreate(
            ['email' => 'ahmad.fauzi@unmul.ac.id'],
            [
                'name' => 'Dr. Ahmad Fauzi, M.Si.',
                'password' => Hash::make('Ahmad@Dosen2025!'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Dosen');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'siti.nurhaliza@unmul.ac.id'],
            [
                'name' => 'Dr. Siti Nurhaliza, M.Pd.',
                'password' => Hash::make('Siti!Faculty25'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Dosen');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // 5.2 Mahasiswa (2 orang)
        $user = User::firstOrCreate(
            ['email' => 'andi.wijaya@student.unmul.ac.id'],
            [
                'name' => 'Andi Wijaya',
                'password' => Hash::make('Andi#Student2025'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Mahasiswa');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'dewi.lestari@student.unmul.ac.id'],
            [
                'name' => 'Dewi Lestari',
                'password' => Hash::make('Dewi@Mhs2025!'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Mahasiswa');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // 5.3 Peneliti Eksternal (2 orang)
        $user = User::firstOrCreate(
            ['email' => 'bambang@itb.ac.id'],
            [
                'name' => 'Dr. Bambang Sudarsono',
                'password' => Hash::make('Bambang!ITB2025'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Peneliti Eksternal');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'maria@ugm.ac.id'],
            [
                'name' => 'Prof. Dr. Maria Ulfa',
                'password' => Hash::make('Maria@UGM2025!'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Peneliti Eksternal');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // 5.4 Industri/Umum (2 orang)
        $user = User::firstOrCreate(
            ['email' => 'info@sumberalam.co.id'],
            [
                'name' => 'PT. Sumber Alam Kalimantan',
                'password' => Hash::make('SumberAlam@2025!'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Industri/Umum');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        $user = User::firstOrCreate(
            ['email' => 'contact@agrindo.com'],
            [
                'name' => 'CV. Agrindo Mandiri',
                'password' => Hash::make('Agrindo#Corp2025'),
                'approval_status' => 'approved',
            ]
        );
        if ($user->wasRecentlyCreated) {
            $user->assignRole('Industri/Umum');
            $created++;
            $this->command->info("✅ Created: {$user->name}");
        } else {
            $skipped++;
            $this->command->warn("⏭️  Skipped (already exists): {$user->email}");
        }

        // ========================================
        // SUMMARY
        // ========================================

        $this->command->newLine();
        $this->command->info('========================================');
        $this->command->info('📊 SUMMARY:');
        $this->command->info('========================================');
        $this->command->info("✅ Users created: {$created}");
        $this->command->info("⏭️  Users skipped (already exist): {$skipped}");
        $this->command->info("📝 Total users processed: " . ($created + $skipped));
        $this->command->newLine();

        if ($created > 0) {
            $this->command->info('🔐 Password untuk user baru ada di USER_CREDENTIALS.md');
        }

        if ($skipped > 0) {
            $this->command->warn('⚠️  Beberapa user sudah ada di database dan di-skip.');
        }

        $this->command->info('========================================');
    }
}
