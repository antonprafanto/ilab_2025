<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed permissions & roles first
        $this->call(PermissionSeeder::class);

        // 2. Create users (required by other modules)
        $this->call(CreateAntonUserSeeder::class);
        $this->call(SampleUserSeeder::class);

        // 3. Seed laboratories
        $this->call(LaboratorySeeder::class);

        // 4. Seed rooms (depends on laboratories)
        $this->call(RoomSeeder::class);

        // 5. Seed equipment (depends on laboratories)
        $this->call(EquipmentSeeder::class);

        // 6. Seed SOPs
        $this->call(SopSeeder::class);

        // 7. Seed maintenance records (depends on equipment & users)
        $this->call(MaintenanceRecordSeeder::class);

        // 8. Seed calibration records (depends on equipment & users)
        $this->call(CalibrationRecordSeeder::class);

        // 9. Seed samples (depends on laboratories & users)
        $this->call(SampleSeeder::class);

        // 10. Seed reagents (depends on laboratories)
        $this->call(ReagentSeeder::class);

        // 11. Seed services (depends on laboratories)
        $this->call(ServiceSeeder::class);
    }
}
