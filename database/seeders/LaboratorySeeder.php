<?php

namespace Database\Seeders;

use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LaboratorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get Kepala Lab user
        $kepalaLab = User::role('Kepala Lab')->first();

        $laboratories = [
            [
                'name' => 'Laboratorium Kimia Analitik',
                'code' => 'LAB-KIM-001',
                'type' => 'chemistry',
                'description' => 'Laboratorium untuk analisis kimia kualitatif dan kuantitatif, dilengkapi dengan instrumen analitik modern seperti FTIR, GC-MS, dan HPLC.',
                'location' => 'Gedung Fakultas MIPA, Lantai 2, Ruang 201',
                'area_sqm' => 120.50,
                'capacity' => 30,
                'head_user_id' => $kepalaLab?->id,
                'phone' => '0541-7771234',
                'email' => 'labkimia@unmul.ac.id',
                'operating_hours_start' => '08:00',
                'operating_hours_end' => '16:00',
                'operating_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'status' => 'active',
                'facilities' => ['AC', 'Internet WiFi', 'Fume Hood', 'Emergency Shower', 'Fire Extinguisher'],
                'certifications' => ['ISO 17025:2017', 'Good Laboratory Practice'],
            ],
            [
                'name' => 'Laboratorium Biologi Molekuler',
                'code' => 'LAB-BIO-001',
                'type' => 'biology',
                'description' => 'Laboratorium untuk penelitian biologi molekuler, genetika, dan bioteknologi dengan peralatan PCR, elektroforesis, dan mikroskop fluoresen.',
                'location' => 'Gedung Fakultas MIPA, Lantai 3, Ruang 301',
                'area_sqm' => 100.00,
                'capacity' => 25,
                'head_user_id' => $kepalaLab?->id,
                'phone' => '0541-7771235',
                'email' => 'labbio@unmul.ac.id',
                'operating_hours_start' => '08:00',
                'operating_hours_end' => '17:00',
                'operating_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                'status' => 'active',
                'facilities' => ['AC', 'Internet WiFi', 'Laminar Flow', 'Refrigerator -80°C', 'Autoclave'],
                'certifications' => ['Biosafety Level 2'],
            ],
            [
                'name' => 'Laboratorium Fisika Komputasi',
                'code' => 'LAB-FIS-001',
                'type' => 'physics',
                'description' => 'Laboratorium untuk simulasi dan komputasi fisika menggunakan software seperti MATLAB, COMSOL, dan Python.',
                'location' => 'Gedung Fakultas MIPA, Lantai 1, Ruang 105',
                'area_sqm' => 80.00,
                'capacity' => 40,
                'head_user_id' => $kepalaLab?->id,
                'phone' => '0541-7771236',
                'email' => 'labfisika@unmul.ac.id',
                'operating_hours_start' => '07:30',
                'operating_hours_end' => '18:00',
                'operating_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'status' => 'active',
                'facilities' => ['AC', 'Internet 100 Mbps', 'Komputer Workstation 40 unit', 'Proyektor', 'UPS'],
                'certifications' => [],
            ],
            [
                'name' => 'Laboratorium Geologi Batuan dan Mineral',
                'code' => 'LAB-GEO-001',
                'type' => 'geology',
                'description' => 'Laboratorium untuk analisis batuan, mineral, dan fosil dengan peralatan mikroskop petrografi, XRD, dan XRF.',
                'location' => 'Gedung Fakultas Teknik, Lantai 2, Ruang 205',
                'area_sqm' => 90.00,
                'capacity' => 20,
                'head_user_id' => $kepalaLab?->id,
                'phone' => '0541-7771237',
                'email' => 'labgeo@unmul.ac.id',
                'operating_hours_start' => '08:00',
                'operating_hours_end' => '16:00',
                'operating_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'status' => 'active',
                'facilities' => ['AC', 'Internet WiFi', 'Sample Storage', 'Grinding Machine'],
                'certifications' => [],
            ],
            [
                'name' => 'Laboratorium Teknik Mesin',
                'code' => 'LAB-TEK-001',
                'type' => 'engineering',
                'description' => 'Laboratorium untuk praktikum teknik mesin, manufaktur, dan material dengan mesin CNC, lathe, dan milling.',
                'location' => 'Gedung Fakultas Teknik, Lantai 1, Ruang Workshop',
                'area_sqm' => 200.00,
                'capacity' => 35,
                'head_user_id' => $kepalaLab?->id,
                'phone' => '0541-7771238',
                'email' => 'labmesin@unmul.ac.id',
                'operating_hours_start' => '07:00',
                'operating_hours_end' => '17:00',
                'operating_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                'status' => 'active',
                'facilities' => ['Ventilasi', 'Safety Equipment', 'Tool Storage', 'First Aid Kit'],
                'certifications' => ['K3 Certified'],
            ],
            [
                'name' => 'Laboratorium Jaringan Komputer',
                'code' => 'LAB-KOM-001',
                'type' => 'computer',
                'description' => 'Laboratorium untuk praktikum jaringan komputer, keamanan siber, dan administrasi sistem.',
                'location' => 'Gedung Fakultas Teknik, Lantai 3, Ruang 310',
                'area_sqm' => 100.00,
                'capacity' => 50,
                'head_user_id' => $kepalaLab?->id,
                'phone' => '0541-7771239',
                'email' => 'labkom@unmul.ac.id',
                'operating_hours_start' => '08:00',
                'operating_hours_end' => '20:00',
                'operating_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                'status' => 'active',
                'facilities' => ['AC', 'Internet 1 Gbps', 'Komputer 50 unit', 'Network Rack', 'Server Room'],
                'certifications' => ['Cisco NetAcad', 'Microsoft IT Academy'],
            ],
            [
                'name' => 'Laboratorium Freeze Dryer',
                'code' => 'LAB-KIM-002',
                'type' => 'chemistry',
                'description' => 'Laboratorium khusus untuk proses freeze drying (liofilisasi) sampel biologis, farmasi, dan makanan.',
                'location' => 'Gedung Fakultas MIPA, Lantai 1, Ruang 110',
                'area_sqm' => 50.00,
                'capacity' => 10,
                'head_user_id' => $kepalaLab?->id,
                'phone' => '0541-7771240',
                'email' => 'freezedryer@unmul.ac.id',
                'operating_hours_start' => '08:00',
                'operating_hours_end' => '16:00',
                'operating_days' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'status' => 'maintenance',
                'status_notes' => 'Sedang dilakukan kalibrasi dan maintenance rutin bulanan. Diperkirakan selesai dalam 3 hari.',
                'facilities' => ['AC', 'Cold Storage', 'Vacuum Pump', 'Temperature Monitoring'],
                'certifications' => ['GMP Certified'],
            ],
        ];

        foreach ($laboratories as $lab) {
            Laboratory::create($lab);
        }
    }
}
