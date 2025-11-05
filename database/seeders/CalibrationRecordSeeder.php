<?php

namespace Database\Seeders;

use App\Models\CalibrationRecord;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CalibrationRecordSeeder extends Seeder
{
    public function run(): void
    {
        $equipment = Equipment::first();
        if (!$equipment) {
            $this->command->warn('No equipment found!');
            return;
        }

        $calibrator = User::whereHas('roles', fn($q) => $q->where('name', 'Anggota Lab'))->first();
        $verifier = User::whereHas('roles', fn($q) => $q->where('name', 'Kepala Lab'))->first();

        $calibrations = [
            [
                'equipment_id' => $equipment->id,
                'calibration_code' => 'CAL-' . $equipment->code . '-2025-001',
                'type' => 'internal',
                'method' => 'comparison',
                'calibration_date' => Carbon::now()->subMonths(3),
                'due_date' => Carbon::now()->addMonths(9),
                'interval_months' => 12,
                'status' => 'passed',
                'result' => 'pass',
                'measurement_results' => 'Semua titik uji dalam batas toleransi',
                'accuracy' => '±0.01g',
                'uncertainty' => '±0.005g',
                'range_calibrated' => '0-1000g',
                'standards_used' => 'Anak timbang standar kelas E2',
                'calibrated_by' => $calibrator?->id,
                'verified_by' => $verifier?->id,
                'calibration_cost' => 0,
                'next_calibration_date' => Carbon::now()->addMonths(9),
            ],
            [
                'equipment_id' => $equipment->id,
                'calibration_code' => 'CAL-' . $equipment->code . '-2025-002',
                'type' => 'external',
                'method' => 'comparison',
                'calibration_date' => Carbon::now()->subMonths(6),
                'due_date' => Carbon::now()->addMonths(6),
                'interval_months' => 12,
                'status' => 'passed',
                'result' => 'pass',
                'external_lab' => 'PT Kalibrasi Indonesia',
                'certificate_number' => 'CERT-2025-001',
                'certificate_issue_date' => Carbon::now()->subMonths(6),
                'certificate_expiry_date' => Carbon::now()->addMonths(6),
                'calibration_cost' => 2500000,
                'next_calibration_date' => Carbon::now()->addMonths(6),
            ],
            [
                'equipment_id' => $equipment->id,
                'calibration_code' => 'CAL-' . $equipment->code . '-2025-003',
                'type' => 'internal',
                'calibration_date' => Carbon::now()->addMonth(),
                'interval_months' => 12,
                'status' => 'scheduled',
                'calibrated_by' => $calibrator?->id,
            ],
        ];

        foreach ($calibrations as $calibration) {
            CalibrationRecord::create($calibration);
        }

        $this->command->info('✅ Calibration records seeded!');
    }
}
