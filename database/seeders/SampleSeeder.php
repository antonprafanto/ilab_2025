<?php

namespace Database\Seeders;

use App\Models\Sample;
use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lab = Laboratory::first();
        $submitter = User::first();
        $analyzer = User::skip(1)->first() ?? $submitter;

        if (!$lab || !$submitter) {
            $this->command->warn('No laboratory or user found. Please seed laboratories and users first.');
            return;
        }

        $samples = [
            [
                'laboratory_id' => $lab->id,
                'code' => 'SMP-2025-001',
                'name' => 'Air Sungai Mahakam',
                'type' => 'environmental',
                'source' => 'Sungai Mahakam, Samarinda',
                'storage_location' => 'Refrigerator B-02, Shelf 3',
                'storage_condition' => 'refrigerated',
                'status' => 'completed',
                'received_date' => Carbon::now()->subDays(45),
                'expiry_date' => Carbon::now()->addDays(15),
                'quantity' => 1000.00,
                'unit' => 'mL',
                'submitted_by' => $submitter->id,
                'analyzed_by' => $analyzer->id,
                'description' => 'Sampel air untuk analisis parameter kualitas air sungai sesuai PP 22/2021',
                'test_parameters' => "- pH\n- TSS (Total Suspended Solids)\n- BOD (Biological Oxygen Demand)\n- COD (Chemical Oxygen Demand)\n- DO (Dissolved Oxygen)\n- Logam Berat (Pb, Cd, Hg)",
                'analysis_results' => "pH: 7.2\nTSS: 45 mg/L\nBOD: 12 mg/L\nCOD: 28 mg/L\nDO: 6.5 mg/L\nPb: <0.01 mg/L\nCd: <0.001 mg/L\nHg: <0.001 mg/L\n\nKesimpulan: Memenuhi baku mutu kelas II PP 22/2021",
                'analysis_date' => Carbon::now()->subDays(30),
                'result_date' => Carbon::now()->subDays(28),
                'priority' => 'normal',
                'special_requirements' => 'Analisis harus dilakukan dalam 7 hari sejak pengambilan sampel',
                'notes' => 'Sampel diambil pada jam 08:00 WIB, kondisi cerah',
            ],
            [
                'laboratory_id' => $lab->id,
                'code' => 'SMP-2025-002',
                'name' => 'Ekstrak Daun Beluntas',
                'type' => 'biological',
                'source' => 'Kebun Tanaman Obat UNMUL',
                'storage_location' => 'Freezer A-01, Box 12',
                'storage_condition' => 'frozen',
                'status' => 'in_analysis',
                'received_date' => Carbon::now()->subDays(7),
                'expiry_date' => Carbon::now()->addMonths(6),
                'quantity' => 50.00,
                'unit' => 'g',
                'submitted_by' => $submitter->id,
                'analyzed_by' => $analyzer->id,
                'description' => 'Ekstrak etanol daun Beluntas (Pluchea indica) untuk uji aktivitas antioksidan',
                'test_parameters' => "- Kadar Total Fenol\n- Kadar Flavonoid\n- Aktivitas Antioksidan (DPPH)\n- Aktivitas Antioksidan (FRAP)\n- Profil Fitokimia FTIR",
                'analysis_results' => null,
                'analysis_date' => Carbon::now()->subDays(2),
                'result_date' => null,
                'priority' => 'high',
                'special_requirements' => 'Hindari paparan cahaya langsung, simpan dalam kondisi beku',
                'notes' => 'Ekstraksi dilakukan dengan metode maserasi selama 3x24 jam',
            ],
            [
                'laboratory_id' => $lab->id,
                'code' => 'SMP-2025-003',
                'name' => 'Tablet Paracetamol Generic',
                'type' => 'pharmaceutical',
                'source' => 'Apotek Kimia Farma Samarinda',
                'storage_location' => 'Cabinet C-05, Drawer 2',
                'storage_condition' => 'room_temperature',
                'status' => 'received',
                'received_date' => Carbon::now()->subDays(2),
                'expiry_date' => Carbon::now()->addYear(),
                'quantity' => 100.00,
                'unit' => 'tablet',
                'submitted_by' => $submitter->id,
                'analyzed_by' => null,
                'description' => 'Tablet paracetamol 500mg untuk uji disolusi dan penetapan kadar',
                'test_parameters' => "- Penetapan Kadar Paracetamol (HPLC)\n- Uji Disolusi\n- Kekerasan Tablet\n- Waktu Hancur\n- Keseragaman Bobot",
                'analysis_results' => null,
                'analysis_date' => null,
                'result_date' => null,
                'priority' => 'urgent',
                'special_requirements' => 'Analisis mengikuti Farmakope Indonesia Edisi VI',
                'notes' => 'Batch No: 2024120501, Exp: Dec 2025',
            ],
            [
                'laboratory_id' => $lab->id,
                'code' => 'SMP-2025-004',
                'name' => 'Sampel Tanah Pertambangan',
                'type' => 'environmental',
                'source' => 'Site Tambang Batubara, Kutai Kartanegara',
                'storage_location' => 'Storage Room D-01, Shelf 5',
                'storage_condition' => 'room_temperature',
                'status' => 'completed',
                'received_date' => Carbon::now()->subDays(60),
                'expiry_date' => null,
                'quantity' => 2000.00,
                'unit' => 'g',
                'submitted_by' => $submitter->id,
                'analyzed_by' => $analyzer->id,
                'description' => 'Sampel tanah untuk analisis kontaminasi logam berat di area pertambangan',
                'test_parameters' => "- Logam Berat (Hg, Pb, Cd, As, Cr) - AAS\n- pH Tanah\n- Tekstur Tanah\n- Kadar Organik\n- KTK (Kapasitas Tukar Kation)",
                'analysis_results' => "Hg: 0.45 mg/kg\nPb: 125 mg/kg\nCd: 2.1 mg/kg\nAs: 8.5 mg/kg\nCr: 45 mg/kg\npH: 5.8\nKadar Organik: 2.3%\n\nKesimpulan: Konsentrasi Cd dan As melebihi baku mutu PP 101/2014",
                'analysis_date' => Carbon::now()->subDays(50),
                'result_date' => Carbon::now()->subDays(48),
                'priority' => 'high',
                'special_requirements' => 'Sampel harus dikeringkan dan diayak 100 mesh sebelum analisis',
                'notes' => 'Titik sampling: Koordinat GPS -0.5234, 116.8765, Kedalaman 0-20 cm',
            ],
            [
                'laboratory_id' => $lab->id,
                'code' => 'SMP-2025-005',
                'name' => 'Madu Hutan Kalimantan',
                'type' => 'food',
                'source' => 'Pengepul Madu, Berau',
                'storage_location' => 'Cabinet B-03, Shelf 1',
                'storage_condition' => 'room_temperature',
                'status' => 'in_analysis',
                'received_date' => Carbon::now()->subDays(5),
                'expiry_date' => Carbon::now()->addMonths(18),
                'quantity' => 500.00,
                'unit' => 'g',
                'submitted_by' => $submitter->id,
                'analyzed_by' => $analyzer->id,
                'description' => 'Madu hutan asli Kalimantan untuk uji keaslian dan parameter kualitas',
                'test_parameters' => "- Kadar Air\n- Kadar Gula Pereduksi\n- Kadar Sukrosa\n- Kadar HMF (Hidroksimetilfurfural)\n- Aktivitas Diastase\n- Cemaran Mikroba\n- Uji Keaslian (FTIR)",
                'analysis_results' => null,
                'analysis_date' => Carbon::now()->subDays(3),
                'result_date' => null,
                'priority' => 'normal',
                'special_requirements' => 'Simpan pada suhu ruang, hindari kontaminasi silang',
                'notes' => 'Madu diklaim dari hutan Berau, untuk keperluan sertifikasi produk',
            ],
            [
                'laboratory_id' => $lab->id,
                'code' => 'SMP-2025-006',
                'name' => 'Kultur Bakteri E. coli',
                'type' => 'biological',
                'source' => 'Laboratorium Mikrobiologi UNMUL',
                'storage_location' => 'Incubator Bio-01',
                'storage_condition' => 'special',
                'status' => 'archived',
                'received_date' => Carbon::now()->subDays(90),
                'expiry_date' => Carbon::now()->subDays(60),
                'quantity' => 10.00,
                'unit' => 'plate',
                'submitted_by' => $submitter->id,
                'analyzed_by' => $analyzer->id,
                'description' => 'Kultur murni E. coli ATCC 25922 untuk kontrol positif uji antimikroba',
                'test_parameters' => "- Konfirmasi Spesies (16S rRNA)\n- Uji Kemurnian\n- Viabilitas Sel\n- Profil Resistensi Antibiotik",
                'analysis_results' => "Spesies: E. coli ATCC 25922 (confirmed)\nKemurnian: 100%\nViabilitas: 8.5 x 10^8 CFU/mL\nResistensi: Sensitif terhadap semua antibiotik standar\n\nKesimpulan: Kultur sesuai standar ATCC",
                'analysis_date' => Carbon::now()->subDays(85),
                'result_date' => Carbon::now()->subDays(82),
                'priority' => 'low',
                'special_requirements' => 'Inkubasi pada 37°C, subkultur setiap 2 minggu',
                'notes' => 'Kultur telah diarsipkan setelah masa pakai habis',
            ],
        ];

        foreach ($samples as $sampleData) {
            Sample::create($sampleData);
        }

        $this->command->info('Sample seeder completed successfully. Created 6 samples.');
    }
}
