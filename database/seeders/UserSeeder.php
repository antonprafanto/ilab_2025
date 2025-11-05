<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeder ini membuat user berdasarkan SK Rektor No. 2846/UN17/HK.02.03/2025
     * Password: Unique strong password untuk setiap user
     */
    public function run(): void
    {
        // ========================================
        // 1. PIMPINAN UNIT (4 Orang)
        // ========================================

        // 1.1 Pelindung (Rektor) - Super Admin
        User::create([
            'name' => 'Prof. Dr. Ir. H. Abdunnur, M.Si., IPU',
            'email' => 'abdunnur@unmul.ac.id',
            'password' => Hash::make('Unmul@2025#Rektor'),
            'approval_status' => 'approved',
        ])->assignRole('Super Admin');

        // 1.2 Pengarah - Wakil Direktur Pelayanan
        User::create([
            'name' => 'Prof. Dr. Lambang Subagiyo, M.Si',
            'email' => 'lambang@unmul.ac.id',
            'password' => Hash::make('Lambang#Pengarah2025'),
            'approval_status' => 'approved',
        ])->assignRole('Wakil Direktur Pelayanan');

        // 1.3 Penanggung Jawab - Wakil Direktur PM & TI
        User::create([
            'name' => 'apt. Fajar Prasetya, S.Farm., M.Si., Ph.D',
            'email' => 'fajar@unmul.ac.id',
            'password' => Hash::make('Fajar@PJawab2025!'),
            'approval_status' => 'approved',
        ])->assignRole('Wakil Direktur PM & TI');

        // 1.4 Kepala Unit - Super Admin
        User::create([
            'name' => 'Dr. apt. Angga Cipta Narsa, M.Si.',
            'email' => 'angga@unmul.ac.id',
            'password' => Hash::make('Angga#KepalaUnit25'),
            'approval_status' => 'approved',
        ])->assignRole('Super Admin');

        // ========================================
        // 2. KELOMPOK KERJA (3 Orang)
        // ========================================

        // 2.1 Kepala KK Teknis, Inovasi & Kerjasama
        User::create([
            'name' => 'Hamdhani, S.P., M.Sc., Ph.D.',
            'email' => 'hamdhani@unmul.ac.id',
            'password' => Hash::make('Hamdhani@Teknis25'),
            'approval_status' => 'approved',
        ])->assignRole('Kepala Lab');

        // 2.2 Kepala KK Pelayanan, Mutu & TI
        User::create([
            'name' => 'Dr. Chairul Saleh, M.Si.',
            'email' => 'chairul@unmul.ac.id',
            'password' => Hash::make('Chairul!Mutu2025'),
            'approval_status' => 'approved',
        ])->assignRole('Wakil Direktur PM & TI');

        // 2.3 Kepala KK Administrasi & Umum
        User::create([
            'name' => 'Dr. Nurul Puspita Palupi, S.P., M.Si.',
            'email' => 'nurul@unmul.ac.id',
            'password' => Hash::make('Nurul@Admin2025!'),
            'approval_status' => 'approved',
        ])->assignRole('Sub Bagian TU & Keuangan');

        // ========================================
        // 3. KELOMPOK FUNGSIONAL (8 Kelompok - 24 Orang)
        // ========================================

        // 3.1 Kelompok Fungsional Natural Product (3 Orang)
        User::create([
            'name' => 'Sabaniah Indjar Gama, M.Si.',
            'email' => 'sabaniah@unmul.ac.id',
            'password' => Hash::make('Sabaniah#NatProd25'),
            'approval_status' => 'approved',
        ])->assignRole('Kepala Lab');

        User::create([
            'name' => 'Dr. apt. Vina Maulidya, M.Farm.',
            'email' => 'vina@unmul.ac.id',
            'password' => Hash::make('Vina!Farmasi2025'),
            'approval_status' => 'approved',
        ])->assignRole('Anggota Lab');

        User::create([
            'name' => 'Alhawaris, S.Si., M.Kes.',
            'email' => 'alhawaris@unmul.ac.id',
            'password' => Hash::make('Alhawaris@Lab25!'),
            'approval_status' => 'approved',
        ])->assignRole('Anggota Lab');

        // 3.2 Kelompok Fungsional Advanced Instrument (3 Orang)
        User::create([
            'name' => 'Rafitah Hasanah, S.Pi., M.Si., Ph.D.',
            'email' => 'rafitah@unmul.ac.id',
            'password' => Hash::make('Rafitah#AdvInst25'),
            'approval_status' => 'approved',
        ])->assignRole('Kepala Lab');

        User::create([
            'name' => 'Dr. Pintaka Kusumaningtyas, S.Pd., M.Si.',
            'email' => 'pintaka@unmul.ac.id',
            'password' => Hash::make('Pintaka@Instru25!'),
            'approval_status' => 'approved',
        ])->assignRole('Anggota Lab');

        User::create([
            'name' => 'Moh. Syaiful Arif, S.Pd., M.Si.',
            'email' => 'syaiful@unmul.ac.id',
            'password' => Hash::make('Syaiful!Analis25'),
            'approval_status' => 'approved',
        ])->assignRole('Anggota Lab');

        // 3.3 Kelompok Fungsional Environmental (3 Orang)
        User::create([
            'name' => 'Atin Nuryadin, S.Pd., M.Si., Ph.D.',
            'email' => 'atin@unmul.ac.id',
            'password' => Hash::make('Atin#Environ2025'),
            'approval_status' => 'approved',
        ])->assignRole('Kepala Lab');

        User::create([
            'name' => 'Indah Prihatiningtyas D.S., S.T., M.T., Ph.D.',
            'email' => 'indah@unmul.ac.id',
            'password' => Hash::make('Indah@Lingkung25!'),
            'approval_status' => 'approved',
        ])->assignRole('Anggota Lab');

        User::create([
            'name' => 'Dr. Noor Hindryawati, S.Pd., M.Si.',
            'email' => 'noor@unmul.ac.id',
            'password' => Hash::make('Noor!Environ2025'),
            'approval_status' => 'approved',
        ])->assignRole('Anggota Lab');

        // 3.4 Kelompok Fungsional Agriculture & Animal Husbandry (3 Orang)
        User::create([
            'name' => 'Prof. Dr. Ir. Taufan Purwokusumaning Daru, M.P.',
            'email' => 'taufan@unmul.ac.id',
            'password' => Hash::make('Taufan#Agri2025!'),
            'approval_status' => 'approved',
        ])->assignRole('Kepala Lab');

        User::create([
            'name' => 'Kadis Mujiono, SP., MSc., Ph.D.',
            'email' => 'kadis@unmul.ac.id',
            'password' => Hash::make('Kadis@Pertanian25'),
            'approval_status' => 'approved',
        ])->assignRole('Anggota Lab');

        User::create([
            'name' => 'Roro Kesumaningwati, SP., M.Sc.',
            'email' => 'roro@unmul.ac.id',
            'password' => Hash::make('Roro!Agriculture25'),
            'approval_status' => 'approved',
        ])->assignRole('Anggota Lab');

        // 3.5 Kelompok Fungsional Oceanography & Engineering (3 Orang)
        User::create([
            'name' => 'Nanda Khoirunisa, S.Pd., M.Sc.',
            'email' => 'nanda@unmul.ac.id',
            'password' => Hash::make('Nanda#Ocean2025!'),
            'approval_status' => 'approved',
        ])->assignRole('Kepala Lab');

        User::create([
            'name' => 'Anugrah Aditya Budiarsa, S.Pi., M.Si.',
            'email' => 'anugrah@unmul.ac.id',
            'password' => Hash::make('Anugrah@Laut2025'),
            'approval_status' => 'approved',
        ])->assignRole('Anggota Lab');

        User::create([
            'name' => 'Irwan Ramadhan Ritonga, S.Pi., M.Si., Ph.D.',
            'email' => 'irwan@unmul.ac.id',
            'password' => Hash::make('Irwan!Oceano25'),
            'approval_status' => 'approved',
        ])->assignRole('Anggota Lab');

        // 3.6 Kelompok Fungsional Social Innovation (3 Orang)
        User::create([
            'name' => 'Etik Sulistiowati Ningsih, S.P., M.Si., Ph.D.',
            'email' => 'etik@unmul.ac.id',
            'password' => Hash::make('Etik#Social2025!'),
            'approval_status' => 'approved',
        ])->assignRole('Kepala Lab');

        User::create([
            'name' => 'Rahmawati Al Hidayah., SH., LLM.',
            'email' => 'rahmawati@unmul.ac.id',
            'password' => Hash::make('Rahmawati@Innov25'),
            'approval_status' => 'approved',
        ])->assignRole('Anggota Lab');

        User::create([
            'name' => 'Kheyene Molekandella Boer., M.Ilkom',
            'email' => 'kheyene@unmul.ac.id',
            'password' => Hash::make('Kheyene!Sosial25'),
            'approval_status' => 'approved',
        ])->assignRole('Anggota Lab');

        // 3.7 Kelompok Fungsional E-commerce & IT Business (3 Orang)
        User::create([
            'name' => 'Hario Jati Setyadi, S.Kom., M.Kom.',
            'email' => 'hario@unmul.ac.id',
            'password' => Hash::make('Hario#Ecommerce25'),
            'approval_status' => 'approved',
        ])->assignRole('Kepala Lab');

        User::create([
            'name' => 'Anton Prafanto, S.Kom., M.T.',
            'email' => 'antonprafanto@unmul.ac.id',
            'password' => Hash::make('Anton@DevIlab2025!'),
            'approval_status' => 'approved',
        ])->assignRole('Anggota Lab');

        User::create([
            'name' => 'Ellen D. Oktanti Irianto, S.E., M.Sc.',
            'email' => 'ellen@unmul.ac.id',
            'password' => Hash::make('Ellen!Business25'),
            'approval_status' => 'approved',
        ])->assignRole('Anggota Lab');

        // 3.8 Kelompok Fungsional Biotechnology (3 Orang)
        User::create([
            'name' => 'Dr. rer. nat. Bodhi Dharma, M.Si.',
            'email' => 'bodhi@unmul.ac.id',
            'password' => Hash::make('Bodhi#Biotech2025'),
            'approval_status' => 'approved',
        ])->assignRole('Kepala Lab');

        User::create([
            'name' => 'Dr. dr. Dian Rachmawati, M.Kes.',
            'email' => 'dian@unmul.ac.id',
            'password' => Hash::make('Dian@BioMol2025!'),
            'approval_status' => 'approved',
        ])->assignRole('Anggota Lab');

        User::create([
            'name' => 'Muhammad Fauzi Arif, S.Si., M.Sc.',
            'email' => 'fauzi@unmul.ac.id',
            'password' => Hash::make('Fauzi!Biotech25'),
            'approval_status' => 'approved',
        ])->assignRole('Anggota Lab');

        // ========================================
        // 4. STAFF LABORAN (2 Orang - Contoh)
        // ========================================

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@unmul.ac.id',
            'password' => Hash::make('Budi@Teknisi2025!'),
            'approval_status' => 'approved',
        ])->assignRole('Laboran');

        User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@unmul.ac.id',
            'password' => Hash::make('Siti#Laboran2025'),
            'approval_status' => 'approved',
        ])->assignRole('Laboran');

        // ========================================
        // 5. PENGGUNA LAYANAN - CONTOH (8 Orang)
        // ========================================

        // 5.1 Dosen (2 orang)
        User::create([
            'name' => 'Dr. Ahmad Fauzi, M.Si.',
            'email' => 'ahmad.fauzi@unmul.ac.id',
            'password' => Hash::make('Ahmad@Dosen2025!'),
            'approval_status' => 'approved',
        ])->assignRole('Dosen');

        User::create([
            'name' => 'Dr. Siti Nurhaliza, M.Pd.',
            'email' => 'siti.nurhaliza@unmul.ac.id',
            'password' => Hash::make('Siti!Faculty25'),
            'approval_status' => 'approved',
        ])->assignRole('Dosen');

        // 5.2 Mahasiswa (2 orang)
        User::create([
            'name' => 'Andi Wijaya',
            'email' => 'andi.wijaya@student.unmul.ac.id',
            'password' => Hash::make('Andi#Student2025'),
            'approval_status' => 'approved',
        ])->assignRole('Mahasiswa');

        User::create([
            'name' => 'Dewi Lestari',
            'email' => 'dewi.lestari@student.unmul.ac.id',
            'password' => Hash::make('Dewi@Mhs2025!'),
            'approval_status' => 'approved',
        ])->assignRole('Mahasiswa');

        // 5.3 Peneliti Eksternal (2 orang)
        User::create([
            'name' => 'Dr. Bambang Sudarsono',
            'email' => 'bambang@itb.ac.id',
            'password' => Hash::make('Bambang!ITB2025'),
            'approval_status' => 'approved',
        ])->assignRole('Peneliti Eksternal');

        User::create([
            'name' => 'Prof. Dr. Maria Ulfa',
            'email' => 'maria@ugm.ac.id',
            'password' => Hash::make('Maria@UGM2025!'),
            'approval_status' => 'approved',
        ])->assignRole('Peneliti Eksternal');

        // 5.4 Industri/Umum (2 orang)
        User::create([
            'name' => 'PT. Sumber Alam Kalimantan',
            'email' => 'info@sumberalam.co.id',
            'password' => Hash::make('SumberAlam@2025!'),
            'approval_status' => 'approved',
        ])->assignRole('Industri/Umum');

        User::create([
            'name' => 'CV. Agrindo Mandiri',
            'email' => 'contact@agrindo.com',
            'password' => Hash::make('Agrindo#Corp2025'),
            'approval_status' => 'approved',
        ])->assignRole('Industri/Umum');

        $this->command->info('✅ UserSeeder berhasil membuat 41 users dengan unique passwords!');
        $this->command->info('📊 Breakdown:');
        $this->command->info('   - Pimpinan Unit: 4 orang');
        $this->command->info('   - Kelompok Kerja: 3 orang');
        $this->command->info('   - Kelompok Fungsional: 24 orang (8 Kepala Lab + 16 Anggota Lab)');
        $this->command->info('   - Laboran: 2 orang');
        $this->command->info('   - Pengguna Layanan: 8 orang (Dosen, Mahasiswa, Peneliti, Industri)');
        $this->command->info('');
        $this->command->info('🔐 Setiap user memiliki UNIQUE STRONG PASSWORD');
        $this->command->info('📧 Lihat USER_CREDENTIALS.md untuk detail password setiap user');
    }
}
