<?php

namespace Database\Seeders;

use App\Models\MaintenanceRecord;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MaintenanceRecordSeeder extends Seeder
{
    public function run(): void
    {
        $equipment = Equipment::first();
        if (!$equipment) {
            $this->command->warn('No equipment found!');
            return;
        }

        $technician = User::whereHas('roles', fn($q) => $q->where('name', 'Anggota Lab'))->first();
        $verifier = User::whereHas('roles', fn($q) => $q->where('name', 'Kepala Lab'))->first();

        $maintenances = [
            [
                'equipment_id' => $equipment->id,
                'maintenance_code' => 'MAINT-' . $equipment->code . '-2025-001',
                'type' => 'preventive',
                'priority' => 'medium',
                'scheduled_date' => Carbon::now()->subMonths(2),
                'completed_date' => Carbon::now()->subMonths(2)->addDays(1),
                'status' => 'completed',
                'description' => 'Pemeliharaan preventif rutin bulanan',
                'work_performed' => "1. Pembersihan komponen utama\n2. Pengecekan kondisi fisik\n3. Pelumasan bagian bergerak",
                'findings' => 'Kondisi equipment baik',
                'performed_by' => $technician?->id,
                'verified_by' => $verifier?->id,
                'labor_cost' => 500000,
                'parts_cost' => 0,
                'total_cost' => 500000,
                'next_maintenance_date' => Carbon::now()->addMonth(),
            ],
            [
                'equipment_id' => $equipment->id,
                'maintenance_code' => 'MAINT-' . $equipment->code . '-2025-002',
                'type' => 'inspection',
                'priority' => 'low',
                'scheduled_date' => Carbon::now()->addWeek(),
                'status' => 'scheduled',
                'description' => 'Inspeksi rutin triwulanan',
                'performed_by' => $technician?->id,
                'next_maintenance_date' => Carbon::now()->addMonths(3),
            ],
        ];

        foreach ($maintenances as $maintenance) {
            MaintenanceRecord::create($maintenance);
        }

        $this->command->info('✅ Maintenance records seeded!');
    }
}
