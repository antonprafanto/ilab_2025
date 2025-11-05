<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ServiceRequest;
use App\Models\User;
use App\Models\Service;
use Carbon\Carbon;

class ServiceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users and services
        $users = User::all();
        $services = Service::all();

        if ($users->isEmpty() || $services->isEmpty()) {
            $this->command->warn('No users or services found. Please seed users and services first.');
            return;
        }

        // Get admin/lab staff for assignments (fallback to any users if roles not found)
        $adminUser = User::whereHas('roles', function ($query) {
            $query->where('name', 'Sub Bagian TU & Keuangan');
        })->first() ?? $users->random();

        $directorUser = User::whereHas('roles', function ($query) {
            $query->whereIn('name', ['Wakil Direktur Pelayanan', 'Wakil Direktur PM & TI']);
        })->first() ?? $users->random();

        $kepalaLab = User::whereHas('roles', function ($query) {
            $query->where('name', 'Kepala Lab');
        })->first() ?? $users->random();

        // Sample requests in various statuses
        $requests = [
            // 1. Pending Request (just submitted)
            [
                'user_id' => $users->random()->id,
                'service_id' => $services->random()->id,
                'title' => 'Analisis Kandungan Protein dalam Susu Sapi Lokal',
                'description' => 'Pengujian kadar protein untuk penelitian tugas akhir tentang kualitas susu sapi lokal Kalimantan Timur.',
                'priority' => 'standard',
                'is_urgent' => false,
                'sample_count' => 5,
                'sample_type' => 'Cair',
                'sample_description' => 'Sampel susu sapi segar dari 5 peternakan berbeda di daerah Samarinda',
                'sample_preparation' => 'Sudah disimpan dalam suhu 4°C',
                'research_title' => 'Analisis Kualitas Susu Sapi Lokal Kalimantan Timur',
                'research_objective' => 'Membandingkan kandungan protein susu sapi lokal dengan standar SNI',
                'institution' => 'Universitas Mulawarman',
                'department' => 'Teknologi Hasil Pertanian',
                'supervisor_name' => 'Dr. Budi Santoso, M.T.',
                'supervisor_contact' => 'budi.santoso@unmul.ac.id',
                'preferred_date' => Carbon::now()->addDays(7),
                'status' => 'pending',
                'submitted_at' => Carbon::now()->subHours(2),
            ],

            // 2. Verified Request
            [
                'user_id' => $users->random()->id,
                'service_id' => $services->random()->id,
                'title' => 'Uji Kadar Logam Berat pada Air Sungai Mahakam',
                'description' => 'Pengujian pencemaran logam berat untuk penelitian lingkungan',
                'priority' => 'urgent',
                'is_urgent' => true,
                'urgency_reason' => 'Deadline penelitian akhir bulan ini dan data dibutuhkan untuk publikasi jurnal internasional',
                'sample_count' => 10,
                'sample_type' => 'Cair',
                'sample_description' => 'Sampel air dari 10 titik berbeda di sepanjang Sungai Mahakam',
                'research_title' => 'Monitoring Pencemaran Logam Berat di Sungai Mahakam',
                'institution' => 'Universitas Mulawarman',
                'department' => 'Teknik Lingkungan',
                'status' => 'verified',
                'verified_by' => $adminUser?->id,
                'verified_at' => Carbon::now()->subHours(1),
                'submitted_at' => Carbon::now()->subHours(5),
            ],

            // 3. Approved Request
            [
                'user_id' => $users->random()->id,
                'service_id' => $services->random()->id,
                'title' => 'Analisis Mikrobiologi Produk Pangan Lokal',
                'description' => 'Uji cemaran mikroba pada produk makanan tradisional',
                'priority' => 'standard',
                'is_urgent' => false,
                'sample_count' => 3,
                'sample_type' => 'Padat',
                'sample_description' => 'Amplang, kue cucur, dan dodol khas Kalimantan Timur',
                'research_title' => 'Studi Keamanan Pangan Produk Tradisional Kaltim',
                'institution' => 'Universitas Mulawarman',
                'department' => 'Ilmu dan Teknologi Pangan',
                'status' => 'approved',
                'verified_by' => $adminUser?->id,
                'verified_at' => Carbon::now()->subDays(1),
                'approved_by' => $directorUser?->id,
                'approved_at' => Carbon::now()->subHours(12),
                'submitted_at' => Carbon::now()->subDays(2),
            ],

            // 4. Assigned Request
            [
                'user_id' => $users->random()->id,
                'service_id' => $services->random()->id,
                'title' => 'Karakterisasi Material Komposit Berbasis Serat Alam',
                'description' => 'Pengujian sifat mekanik dan termal material komposit',
                'priority' => 'standard',
                'sample_count' => 15,
                'sample_type' => 'Padat',
                'sample_description' => 'Sampel komposit dengan berbagai variasi komposisi serat alam',
                'sample_preparation' => 'Sudah dibentuk menjadi spesimen uji sesuai standar',
                'research_title' => 'Pengembangan Material Komposit Ramah Lingkungan',
                'institution' => 'Universitas Mulawarman',
                'department' => 'Teknik Mesin',
                'status' => 'assigned',
                'verified_by' => $adminUser?->id,
                'verified_at' => Carbon::now()->subDays(2),
                'approved_by' => $directorUser?->id,
                'approved_at' => Carbon::now()->subDays(1),
                'assigned_to' => $kepalaLab?->id,
                'assigned_at' => Carbon::now()->subHours(8),
                'submitted_at' => Carbon::now()->subDays(3),
            ],

            // 5. In Progress Request
            [
                'user_id' => $users->random()->id,
                'service_id' => $services->random()->id,
                'title' => 'Analisis Kandungan Fitokimia Tanaman Obat Tradisional',
                'description' => 'Identifikasi senyawa aktif dalam tanaman obat khas Kalimantan',
                'priority' => 'standard',
                'sample_count' => 8,
                'sample_type' => 'Bubuk',
                'sample_description' => 'Ekstrak kering dari 8 jenis tanaman obat tradisional',
                'sample_preparation' => 'Sudah diekstraksi dan dikeringkan',
                'research_title' => 'Eksplorasi Potensi Fitofarmaka Tanaman Kalimantan',
                'institution' => 'Universitas Mulawarman',
                'department' => 'Farmasi',
                'status' => 'in_progress',
                'verified_by' => $adminUser?->id,
                'verified_at' => Carbon::now()->subDays(5),
                'approved_by' => $directorUser?->id,
                'approved_at' => Carbon::now()->subDays(4),
                'assigned_to' => $kepalaLab?->id,
                'assigned_at' => Carbon::now()->subDays(3),
                'submitted_at' => Carbon::now()->subDays(6),
            ],

            // 6. Testing Request
            [
                'user_id' => $users->random()->id,
                'service_id' => $services->random()->id,
                'title' => 'Uji Aktivitas Antioksidan Ekstrak Buah Lokal',
                'description' => 'Pengujian aktivitas antioksidan buah-buahan khas Kalimantan',
                'priority' => 'standard',
                'sample_count' => 6,
                'sample_type' => 'Cair',
                'sample_description' => 'Ekstrak dari 6 jenis buah lokal (lahung, rambai, mentawa, dll)',
                'research_title' => 'Potensi Antioksidan Buah Lokal Kalimantan Timur',
                'institution' => 'Universitas Mulawarman',
                'department' => 'Kimia',
                'status' => 'testing',
                'verified_by' => $adminUser?->id,
                'verified_at' => Carbon::now()->subDays(8),
                'approved_by' => $directorUser?->id,
                'approved_at' => Carbon::now()->subDays(7),
                'assigned_to' => $kepalaLab?->id,
                'assigned_at' => Carbon::now()->subDays(6),
                'submitted_at' => Carbon::now()->subDays(9),
            ],

            // 7. Completed Request
            [
                'user_id' => $users->random()->id,
                'service_id' => $services->random()->id,
                'title' => 'Analisis Kualitas Air Bersih PDAM',
                'description' => 'Pengujian parameter fisika, kimia, dan mikrobiologi air PDAM',
                'priority' => 'standard',
                'sample_count' => 12,
                'sample_type' => 'Cair',
                'sample_description' => 'Sampel air dari 12 titik distribusi PDAM Samarinda',
                'research_title' => 'Evaluasi Kualitas Air Bersih di Kota Samarinda',
                'institution' => 'Universitas Mulawarman',
                'department' => 'Kesehatan Masyarakat',
                'status' => 'completed',
                'verified_by' => $adminUser?->id,
                'verified_at' => Carbon::now()->subDays(15),
                'approved_by' => $directorUser?->id,
                'approved_at' => Carbon::now()->subDays(14),
                'assigned_to' => $kepalaLab?->id,
                'assigned_at' => Carbon::now()->subDays(13),
                'completed_at' => Carbon::now()->subDays(1),
                'actual_completion_date' => Carbon::now()->subDays(1),
                'submitted_at' => Carbon::now()->subDays(16),
            ],

            // 8. Urgent Pending Request
            [
                'user_id' => $users->random()->id,
                'service_id' => $services->random()->id,
                'title' => 'Analisis Urgent: Uji Kualitas Produk Untuk Sertifikasi',
                'description' => 'Pengujian mendesak untuk keperluan sertifikasi produk ekspor',
                'priority' => 'urgent',
                'is_urgent' => true,
                'urgency_reason' => 'Deadline sertifikasi dari BPOM 5 hari lagi, diperlukan untuk ekspor ke luar negeri',
                'sample_count' => 2,
                'sample_type' => 'Padat',
                'sample_description' => 'Produk olahan ikan kering siap ekspor',
                'institution' => 'PT Samudera Kaltim Jaya',
                'status' => 'pending',
                'submitted_at' => Carbon::now()->subMinutes(30),
            ],

            // 9. Simple External Request
            [
                'user_id' => $users->random()->id,
                'service_id' => $services->random()->id,
                'title' => 'Uji Kualitas Tanah Perkebunan',
                'description' => 'Analisis pH, nitrogen, fosfor, kalium untuk optimasi pemupukan',
                'priority' => 'standard',
                'sample_count' => 20,
                'sample_type' => 'Padat',
                'sample_description' => 'Sampel tanah dari 20 titik di area perkebunan kelapa sawit',
                'preferred_date' => Carbon::now()->addDays(10),
                'status' => 'pending',
                'submitted_at' => Carbon::now()->subDays(1),
            ],

            // 10. Complex Research Request
            [
                'user_id' => $users->random()->id,
                'service_id' => $services->random()->id,
                'title' => 'Karakterisasi Lengkap Batubara Kalimantan',
                'description' => 'Analisis proksimat, ultimat, dan nilai kalor batubara',
                'priority' => 'standard',
                'sample_count' => 25,
                'sample_type' => 'Padat',
                'sample_description' => 'Sampel batubara dari berbagai lapisan dan lokasi tambang',
                'sample_preparation' => 'Sudah dihaluskan hingga 200 mesh',
                'research_title' => 'Studi Karakteristik Batubara untuk Gasifikasi',
                'research_objective' => 'Menentukan kesesuaian batubara lokal untuk teknologi gasifikasi',
                'institution' => 'Universitas Mulawarman',
                'department' => 'Teknik Pertambangan',
                'supervisor_name' => 'Prof. Dr. Ir. Suharto, M.Eng.',
                'supervisor_contact' => 'suharto.unmul@gmail.com',
                'preferred_date' => Carbon::now()->addDays(14),
                'status' => 'verified',
                'verified_by' => $adminUser?->id,
                'verified_at' => Carbon::now()->subHours(3),
                'submitted_at' => Carbon::now()->subDays(1),
            ],
        ];

        foreach ($requests as $requestData) {
            $request = ServiceRequest::create($requestData);

            // Calculate estimated completion
            if ($request->service) {
                $estimatedDate = $request->calculateEstimatedCompletion();
                $request->update(['estimated_completion_date' => $estimatedDate]);
            }
        }

        $this->command->info('Created ' . count($requests) . ' service requests with various statuses.');
    }
}
