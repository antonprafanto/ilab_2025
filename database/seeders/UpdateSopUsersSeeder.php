<?php

namespace Database\Seeders;

use App\Models\Sop;
use App\Models\User;
use Illuminate\Database\Seeder;

class UpdateSopUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users for approval workflow
        $anggotaLab = User::whereHas('roles', function($q) {
            $q->where('name', 'Anggota Lab');
        })->first();

        $kepalaLab = User::whereHas('roles', function($q) {
            $q->where('name', 'Kepala Lab');
        })->first();

        $wakilDirektur = User::whereHas('roles', function($q) {
            $q->where('name', 'Wakil Direktur PM & TI');
        })->first();

        if (!$anggotaLab || !$kepalaLab || !$wakilDirektur) {
            $this->command->error('❌ Required users not found! Please run SampleUserSeeder first.');
            return;
        }

        // Update approved SOPs - full workflow
        $approvedCount = Sop::where('status', 'approved')->update([
            'prepared_by' => $anggotaLab->id,
            'reviewed_by' => $kepalaLab->id,
            'approved_by' => $wakilDirektur->id,
        ]);

        // Update review SOPs - prepared and reviewed only
        $reviewCount = Sop::where('status', 'review')->update([
            'prepared_by' => $anggotaLab->id,
            'reviewed_by' => $kepalaLab->id,
            'approved_by' => null,
        ]);

        // Update draft SOPs - prepared only
        $draftCount = Sop::where('status', 'draft')->update([
            'prepared_by' => $anggotaLab->id,
            'reviewed_by' => null,
            'approved_by' => null,
        ]);

        $this->command->info('✅ SOP users updated successfully!');
        $this->command->info("   - Approved SOPs: {$approvedCount}");
        $this->command->info("   - Review SOPs: {$reviewCount}");
        $this->command->info("   - Draft SOPs: {$draftCount}");
    }
}
