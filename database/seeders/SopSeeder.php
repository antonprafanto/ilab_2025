<?php

namespace Database\Seeders;

use App\Models\Sop;
use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $labKimia = Laboratory::where('code', 'LAB-KIM-001')->first();
        $labBio = Laboratory::where('code', 'LAB-BIO-001')->first();

        // Get users for approval workflow
        $kepalaLab = User::whereHas('roles', function($q) {
            $q->where('name', 'Kepala Lab');
        })->first();

        $anggotaLab = User::whereHas('roles', function($q) {
            $q->where('name', 'Anggota Lab');
        })->first();

        $wakilDirektur = User::whereHas('roles', function($q) {
            $q->where('name', 'Wakil Direktur PM & TI');
        })->first();

        $sops = [
            // Equipment SOPs
            [
                'code' => 'SOP-EQ-001',
                'title' => 'Prosedur Penggunaan GC-MS (Gas Chromatography-Mass Spectrometry)',
                'category' => 'equipment',
                'laboratory_id' => $labKimia->id,
                'version' => '1.0',
                'revision_number' => 0,
                'purpose' => 'SOP ini bertujuan untuk memberikan panduan standar dalam penggunaan GC-MS untuk analisis senyawa organik volatil dan semi-volatil, sehingga menghasilkan data yang akurat, presisi, dan konsisten.',
                'scope' => 'SOP ini berlaku untuk semua analis yang menggunakan GC-MS di Laboratorium Kimia Analitik untuk keperluan penelitian, pengujian, dan layanan analisis.',
                'description' => 'Prosedur penggunaan GC-MS meliputi persiapan instrumen, persiapan sampel, running analisis, analisis data, dan shutdown instrumen. Pastikan semua langkah dilakukan sesuai urutan untuk hasil optimal.',
                'requirements' => "1. Pelatihan penggunaan GC-MS\n2. Pemahaman tentang senyawa yang akan dianalisis\n3. Sampel yang telah dipreparasi dengan benar\n4. Gas carrier (Helium) tersedia dengan tekanan yang cukup",
                'safety_precautions' => "1. Gunakan APD lengkap (jas lab, sarung tangan, safety glasses)\n2. Pastikan ventilasi ruangan baik\n3. Hindari kontak langsung dengan pelarut organik\n4. Jangan menyalakan instrumen jika ada kebocoran gas\n5. Pastikan suhu oven sudah turun sebelum membuka",
                'references' => "1. Manual GC-MS Agilent 7890B-5977B\n2. EPA Method 8270D\n3. ASTM D3328",
                'document_file' => null,
                'status' => 'approved',
                'prepared_by' => $anggotaLab?->id,
                'reviewed_by' => $kepalaLab?->id,
                'approved_by' => $wakilDirektur?->id,
                'review_date' => Carbon::now()->subMonths(2),
                'approval_date' => Carbon::now()->subMonth(),
                'effective_date' => Carbon::now()->subMonth(),
                'next_review_date' => Carbon::now()->addMonths(11),
                'review_interval_months' => 12,
                'revision_notes' => 'Versi awal - approved',
            ],
            [
                'code' => 'SOP-EQ-002',
                'title' => 'Prosedur Penggunaan HPLC (High Performance Liquid Chromatography)',
                'category' => 'equipment',
                'laboratory_id' => $labKimia->id,
                'version' => '1.0',
                'revision_number' => 0,
                'purpose' => 'Memberikan panduan standar dalam penggunaan HPLC untuk pemisahan, identifikasi, dan kuantifikasi komponen dalam campuran.',
                'scope' => 'Berlaku untuk semua analis di Laboratorium Kimia yang menggunakan HPLC.',
                'description' => 'Prosedur meliputi persiapan fase gerak, equilibrasi sistem, injeksi sampel, running, dan analisis data.',
                'requirements' => "1. Pelatihan penggunaan HPLC\n2. Fase gerak yang telah disiapkan dan difilter\n3. Kolom HPLC sesuai aplikasi\n4. Sampel yang telah difilter",
                'safety_precautions' => "1. Gunakan APD lengkap\n2. Hindari kontak dengan pelarut organik\n3. Pastikan tidak ada kebocoran sistem\n4. Buang waste secara proper",
                'references' => "1. Waters Alliance e2695 Manual\n2. USP <621> Chromatography",
                'document_file' => null,
                'status' => 'approved',
                'prepared_by' => $anggotaLab?->id,
                'reviewed_by' => $kepalaLab?->id,
                'approved_by' => $wakilDirektur?->id,
                'review_date' => Carbon::now()->subMonths(2),
                'approval_date' => Carbon::now()->subMonth(),
                'effective_date' => Carbon::now()->subMonth(),
                'next_review_date' => Carbon::now()->addMonths(11),
                'review_interval_months' => 12,
                'revision_notes' => null,
            ],

            // Testing SOPs
            [
                'code' => 'SOP-TEST-001',
                'title' => 'Prosedur Pengujian Kadar Air Metode Gravimetri',
                'category' => 'testing',
                'laboratory_id' => $labKimia->id,
                'version' => '2.0',
                'revision_number' => 1,
                'purpose' => 'Menetapkan prosedur standar untuk pengujian kadar air dalam sampel menggunakan metode gravimetri dengan pemanasan oven.',
                'scope' => 'Berlaku untuk pengujian kadar air pada sampel padat dan semi-padat di Laboratorium Kimia.',
                'description' => 'Sampel ditimbang, dipanaskan dalam oven pada suhu tertentu, kemudian ditimbang kembali. Kadar air dihitung dari selisih berat sebelum dan sesudah pemanasan.',
                'requirements' => "1. Neraca analitik\n2. Oven pengering (105°C)\n3. Desikator\n4. Cawan porselen atau aluminium",
                'safety_precautions' => "1. Gunakan sarung tangan tahan panas saat mengeluarkan sampel dari oven\n2. Biarkan sampel dingin dalam desikator sebelum ditimbang\n3. Hindari tumpahan sampel panas",
                'references' => "1. SNI 01-2891-1992\n2. AOAC Official Method 925.10",
                'document_file' => null,
                'status' => 'approved',
                'prepared_by' => $anggotaLab?->id,
                'reviewed_by' => $kepalaLab?->id,
                'approved_by' => $wakilDirektur?->id,
                'review_date' => Carbon::now()->subWeeks(3),
                'approval_date' => Carbon::now()->subWeeks(2),
                'effective_date' => Carbon::now()->subWeeks(2),
                'next_review_date' => Carbon::now()->addMonths(10),
                'review_interval_months' => 12,
                'revision_notes' => 'Revisi 1: Penambahan detail tentang waktu pemanasan dan prosedur desikasi',
            ],

            // Safety SOPs
            [
                'code' => 'SOP-SAFE-001',
                'title' => 'Prosedur Keselamatan Kerja di Laboratorium Kimia',
                'category' => 'safety',
                'laboratory_id' => $labKimia->id,
                'version' => '1.0',
                'revision_number' => 0,
                'purpose' => 'Menetapkan prosedur keselamatan kerja untuk mencegah kecelakaan dan memastikan lingkungan kerja yang aman di laboratorium.',
                'scope' => 'Berlaku untuk semua personel yang bekerja di Laboratorium Kimia Analitik.',
                'description' => 'Prosedur mencakup penggunaan APD, penanganan bahan kimia berbahaya, prosedur darurat, dan protokol kebersihan laboratorium.',
                'requirements' => "1. APD lengkap (jas lab, safety glasses, sarung tangan)\n2. MSDS bahan kimia\n3. Pelatihan K3 laboratorium\n4. Emergency contact numbers",
                'safety_precautions' => "1. WAJIB menggunakan APD setiap saat di lab\n2. Tidak makan/minum di laboratorium\n3. Cuci tangan setelah keluar lab\n4. Laporkan segera jika ada tumpahan/kecelakaan\n5. Ketahui lokasi safety shower, eye wash, dan APAR",
                'references' => "1. OSHA Laboratory Safety Guidance\n2. WHO Laboratory Biosafety Manual\n3. Permenaker No. 5 Tahun 2018",
                'document_file' => null,
                'status' => 'approved',
                'prepared_by' => $kepalaLab?->id,
                'reviewed_by' => $wakilDirektur?->id,
                'approved_by' => $wakilDirektur?->id,
                'review_date' => Carbon::now()->subMonths(3),
                'approval_date' => Carbon::now()->subMonths(3),
                'effective_date' => Carbon::now()->subMonths(3),
                'next_review_date' => Carbon::now()->addMonths(9),
                'review_interval_months' => 12,
                'revision_notes' => null,
            ],

            // Calibration SOP
            [
                'code' => 'SOP-CAL-001',
                'title' => 'Prosedur Kalibrasi Neraca Analitik',
                'category' => 'calibration',
                'laboratory_id' => $labKimia->id,
                'version' => '1.0',
                'revision_number' => 0,
                'purpose' => 'Menetapkan prosedur kalibrasi neraca analitik untuk memastikan akurasi dan presisi penimbangan.',
                'scope' => 'Berlaku untuk semua neraca analitik di Laboratorium Kimia.',
                'description' => 'Kalibrasi dilakukan menggunakan anak timbang standar tertelusur. Prosedur mencakup kalibrasi internal dan eksternal.',
                'requirements' => "1. Anak timbang standar kelas E2 atau lebih baik\n2. Sertifikat kalibrasi anak timbang yang masih valid\n3. Form kalibrasi\n4. Lingkungan ruangan stabil (suhu, getaran, kelembaban)",
                'safety_precautions' => "1. Pastikan neraca dalam kondisi level\n2. Hindari sentuhan langsung pada anak timbang\n3. Gunakan pinset untuk menangani anak timbang",
                'references' => "1. OIML R 76-1\n2. ISO/IEC 17025:2017",
                'document_file' => null,
                'status' => 'review',
                'prepared_by' => $anggotaLab?->id,
                'reviewed_by' => $kepalaLab?->id,
                'approved_by' => null,
                'review_date' => Carbon::now()->subWeek(),
                'approval_date' => null,
                'effective_date' => null,
                'next_review_date' => null,
                'review_interval_months' => 6,
                'revision_notes' => 'Sedang dalam review untuk approval',
            ],

            // Maintenance SOP
            [
                'code' => 'SOP-MAINT-001',
                'title' => 'Prosedur Pemeliharaan Rutin Fume Hood',
                'category' => 'maintenance',
                'laboratory_id' => $labKimia->id,
                'version' => '1.0',
                'revision_number' => 0,
                'purpose' => 'Menetapkan prosedur pemeliharaan rutin fume hood untuk memastikan fungsi optimal dan keselamatan pengguna.',
                'scope' => 'Berlaku untuk semua fume hood di Laboratorium Kimia.',
                'description' => 'Pemeliharaan meliputi pembersihan permukaan, pengecekan airflow, penggantian filter, dan verifikasi alarm.',
                'requirements' => "1. Pembersih permukaan lab-grade\n2. Anemometer untuk cek airflow\n3. Filter HEPA replacement (jika diperlukan)\n4. Form checklist pemeliharaan",
                'safety_precautions' => "1. Matikan fume hood sebelum pembersihan\n2. Gunakan APD saat pembersihan\n3. Pastikan tidak ada bahan kimia di dalam fume hood\n4. Jangan blokir ventilasi",
                'references' => "1. ANSI/ASHRAE 110\n2. OSHA 29 CFR 1910.1450",
                'document_file' => null,
                'status' => 'draft',
                'prepared_by' => $anggotaLab?->id,
                'reviewed_by' => null,
                'approved_by' => null,
                'review_date' => null,
                'approval_date' => null,
                'effective_date' => null,
                'next_review_date' => null,
                'review_interval_months' => 12,
                'revision_notes' => 'Draft - belum direview',
            ],

            // Biology Lab SOP
            [
                'code' => 'SOP-BIO-001',
                'title' => 'Prosedur Sterilisasi Alat dan Media Menggunakan Autoclave',
                'category' => 'equipment',
                'laboratory_id' => $labBio->id,
                'version' => '1.0',
                'revision_number' => 0,
                'purpose' => 'Menetapkan prosedur sterilisasi menggunakan autoclave untuk memastikan alat dan media bebas dari mikroorganisme.',
                'scope' => 'Berlaku untuk sterilisasi semua alat dan media kultur di Laboratorium Biologi Molekuler.',
                'description' => 'Sterilisasi dilakukan pada suhu 121°C, tekanan 15 psi, selama 15-30 menit tergantung volume dan jenis barang.',
                'requirements' => "1. Autoclave yang terkalibrasi\n2. Indikator sterilisasi (tape, strip)\n3. Wrapping material (aluminium foil, kertas sterilisasi)\n4. Form log autoclave",
                'safety_precautions' => "1. Gunakan sarung tangan tahan panas\n2. Jangan membuka autoclave sebelum tekanan turun ke 0\n3. Biarkan barang dingin sebelum dikeluarkan\n4. Periksa pintu seal secara berkala\n5. Jangan overload chamber",
                'references' => "1. CDC Guidelines for Disinfection and Sterilization\n2. WHO Decontamination and Reprocessing Manual",
                'document_file' => null,
                'status' => 'approved',
                'prepared_by' => $anggotaLab?->id,
                'reviewed_by' => $kepalaLab?->id,
                'approved_by' => $wakilDirektur?->id,
                'review_date' => Carbon::now()->subMonths(4),
                'approval_date' => Carbon::now()->subMonths(4),
                'effective_date' => Carbon::now()->subMonths(4),
                'next_review_date' => Carbon::now()->addMonths(8),
                'review_interval_months' => 12,
                'revision_notes' => null,
            ],
        ];

        foreach ($sops as $sop) {
            Sop::create($sop);
        }

        $this->command->info('✅ SOP seeded successfully!');
    }
}
