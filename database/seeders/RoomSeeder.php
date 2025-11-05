<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lab = Laboratory::first();
        $user = User::first();

        if (!$lab || !$user) {
            $this->command->warn('No laboratory or user found. Please seed laboratories and users first.');
            return;
        }

        $rooms = [
            [
                'laboratory_id' => $lab->id,
                'code' => 'R-LAB-001',
                'name' => 'Ruang Analisis Kimia',
                'type' => 'research',
                'area' => 48.50,
                'capacity' => 15,
                'status' => 'active',
                'description' => 'Ruang untuk analisis kimia kualitatif dan kuantitatif',
                'facilities' => "- Fume Hood 2 unit\n- Meja Lab 6 unit\n- Kursi Lab 15 unit\n- AC 2 unit\n- Lampu Emergency\n- Wastafel 3 titik",
                'floor' => '2',
                'building' => 'Gedung A',
                'responsible_person' => $user->id,
                'safety_equipment' => "- APAR 2 unit\n- Emergency Shower\n- Eye Wash Station\n- First Aid Kit\n- Spill Kit",
                'notes' => 'Ruang dilengkapi sistem ventilasi khusus',
            ],
            [
                'laboratory_id' => $lab->id,
                'code' => 'R-LAB-002',
                'name' => 'Ruang Instrumentasi',
                'type' => 'research',
                'area' => 36.00,
                'capacity' => 10,
                'status' => 'active',
                'description' => 'Ruang khusus untuk peralatan instrumentasi',
                'facilities' => "- FTIR Spectrometer\n- UV-Vis Spectrophotometer\n- pH Meter\n- Timbangan Analitik\n- AC 1 unit\n- Stabilizer",
                'floor' => '2',
                'building' => 'Gedung A',
                'responsible_person' => $user->id,
                'safety_equipment' => "- APAR 1 unit\n- First Aid Kit",
                'notes' => 'Akses terbatas, hanya untuk personel terlatih',
            ],
            [
                'laboratory_id' => $lab->id,
                'code' => 'R-PREP-001',
                'name' => 'Ruang Persiapan',
                'type' => 'preparation',
                'area' => 24.00,
                'capacity' => 5,
                'status' => 'active',
                'description' => 'Ruang persiapan sampel dan reagen',
                'facilities' => "- Meja Persiapan 2 unit\n- Lemari Asam\n- Lemari Penyimpanan\n- Wastafel",
                'floor' => '2',
                'building' => 'Gedung A',
                'responsible_person' => $user->id,
                'safety_equipment' => "- APAR 1 unit\n- Eye Wash Station\n- First Aid Kit",
            ],
            [
                'laboratory_id' => $lab->id,
                'code' => 'R-STORE-001',
                'name' => 'Ruang Penyimpanan Bahan Kimia',
                'type' => 'storage',
                'area' => 16.00,
                'capacity' => 3,
                'status' => 'active',
                'description' => 'Ruang penyimpanan bahan kimia dengan sistem keamanan khusus',
                'facilities' => "- Lemari Asam Basa\n- Lemari Penyimpanan Flammable\n- Exhaust Fan\n- Alarm System",
                'floor' => '1',
                'building' => 'Gedung A',
                'responsible_person' => $user->id,
                'safety_equipment' => "- APAR 2 unit\n- Spill Kit\n- Emergency Shower\n- Eye Wash Station",
                'notes' => 'Akses sangat terbatas, wajib log book',
            ],
            [
                'laboratory_id' => $lab->id,
                'code' => 'R-MEET-001',
                'name' => 'Ruang Diskusi',
                'type' => 'meeting',
                'area' => 30.00,
                'capacity' => 20,
                'status' => 'active',
                'description' => 'Ruang untuk diskusi dan presentasi hasil penelitian',
                'facilities' => "- Meja Meeting\n- Kursi 20 unit\n- Proyektor\n- Whiteboard\n- AC 1 unit\n- WiFi",
                'floor' => '2',
                'building' => 'Gedung A',
                'responsible_person' => $user->id,
                'safety_equipment' => "- APAR 1 unit",
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }

        $this->command->info('Room seeder completed successfully.');
    }
}
