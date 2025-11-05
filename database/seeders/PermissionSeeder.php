<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions untuk iLab UNMUL
        $permissions = [
            // Dashboard & Profile
            'view-dashboard',
            'view-own-profile',
            'edit-own-profile',

            // User Management
            'view-users',
            'create-users',
            'edit-users',
            'delete-users',

            // Role & Permission Management
            'view-roles',
            'create-roles',
            'edit-roles',
            'delete-roles',
            'assign-roles',

            // Lab/Unit Management
            'view-labs',
            'create-labs',
            'edit-labs',
            'delete-labs',

            // Equipment/Instrument Management
            'view-equipment',
            'create-equipment',
            'edit-equipment',
            'delete-equipment',
            'manage-equipment-maintenance',

            // SOP Management
            'view-sop',
            'create-sop',
            'edit-sop',
            'delete-sop',
            'approve-sop',

            // Service Request Management
            'view-all-requests',
            'view-own-requests',
            'create-requests',
            'edit-requests',
            'delete-requests',
            'approve-requests',
            'assign-analyst',
            'update-request-status',

            // Testing & Results
            'input-test-results',
            'approve-test-results',
            'view-test-results',
            'export-test-results',

            // Calibration Management
            'view-calibrations',
            'create-calibrations',
            'edit-calibrations',
            'approve-calibrations',

            // Financial Management
            'view-invoices',
            'create-invoices',
            'edit-invoices',
            'approve-invoices',
            'manage-payments',
            'view-financial-reports',

            // Reporting
            'view-activity-reports',
            'view-usage-reports',
            'view-revenue-reports',
            'export-reports',

            // System Settings
            'manage-settings',
            'view-audit-logs',
            'manage-announcements',
        ];

        // Create all permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles dengan Spatie dan assign permissions

        // 1. Super Admin - Full Access
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // 2. Wakil Direktur Pelayanan
        $wakilDirPelayanan = Role::create(['name' => 'Wakil Direktur Pelayanan']);
        $wakilDirPelayanan->givePermissionTo([
            'view-dashboard',
            'view-own-profile',
            'edit-own-profile',
            'view-all-requests',
            'approve-requests',
            'view-test-results',
            'view-activity-reports',
            'view-usage-reports',
            'view-revenue-reports',
            'export-reports',
        ]);

        // 3. Wakil Direktur PM & TI
        $wakilDirPMTI = Role::create(['name' => 'Wakil Direktur PM & TI']);
        $wakilDirPMTI->givePermissionTo([
            'view-dashboard',
            'view-own-profile',
            'edit-own-profile',
            'view-equipment',
            'manage-equipment-maintenance',
            'view-sop',
            'create-sop',
            'edit-sop',
            'delete-sop',
            'approve-sop',
            'view-calibrations',
            'create-calibrations',
            'edit-calibrations',
            'approve-calibrations',
            'manage-settings',
            'view-audit-logs',
        ]);

        // 4. Kepala Lab/Unit
        $kepalaLab = Role::create(['name' => 'Kepala Lab']);
        $kepalaLab->givePermissionTo([
            'view-dashboard',
            'view-own-profile',
            'edit-own-profile',
            'view-all-requests',
            'approve-requests',
            'assign-analyst',
            'view-equipment',
            'view-sop',
            'create-sop',
            'edit-sop',
            'view-test-results',
            'approve-test-results',
            'view-activity-reports',
            'view-usage-reports',
            'export-reports',
        ]);

        // 5. Anggota Lab/Unit (Analyst/Researcher)
        $anggotaLab = Role::create(['name' => 'Anggota Lab']);
        $anggotaLab->givePermissionTo([
            'view-dashboard',
            'view-own-profile',
            'edit-own-profile',
            'view-all-requests',
            'update-request-status',
            'input-test-results',
            'view-test-results',
            'export-test-results',
            'view-sop',
        ]);

        // 6. Laboran (Technician)
        $laboran = Role::create(['name' => 'Laboran']);
        $laboran->givePermissionTo([
            'view-dashboard',
            'view-own-profile',
            'edit-own-profile',
            'view-equipment',
            'edit-equipment',
            'manage-equipment-maintenance',
            'view-all-requests',
            'view-sop',
        ]);

        // 7. Sub Bagian TU & Keuangan
        $subBagianTUKeuangan = Role::create(['name' => 'Sub Bagian TU & Keuangan']);
        $subBagianTUKeuangan->givePermissionTo([
            'view-dashboard',
            'view-own-profile',
            'edit-own-profile',
            'view-invoices',
            'create-invoices',
            'edit-invoices',
            'manage-payments',
            'view-financial-reports',
            'export-reports',
        ]);

        // 8. Dosen (Faculty)
        $dosen = Role::create(['name' => 'Dosen']);
        $dosen->givePermissionTo([
            'view-dashboard',
            'view-own-profile',
            'edit-own-profile',
            'view-own-requests',
            'create-requests',
            'view-test-results',
            'export-test-results',
            'view-invoices',
        ]);

        // 9. Mahasiswa (Student)
        $mahasiswa = Role::create(['name' => 'Mahasiswa']);
        $mahasiswa->givePermissionTo([
            'view-dashboard',
            'view-own-profile',
            'edit-own-profile',
            'view-own-requests',
            'create-requests',
            'view-test-results',
        ]);

        // 10. Peneliti Eksternal
        $penelitiEksternal = Role::create(['name' => 'Peneliti Eksternal']);
        $penelitiEksternal->givePermissionTo([
            'view-dashboard',
            'view-own-profile',
            'edit-own-profile',
            'view-own-requests',
            'create-requests',
            'view-test-results',
            'export-test-results',
            'view-invoices',
        ]);

        // 11. Industri/Masyarakat Umum
        $industriUmum = Role::create(['name' => 'Industri/Umum']);
        $industriUmum->givePermissionTo([
            'view-dashboard',
            'view-own-profile',
            'edit-own-profile',
            'view-own-requests',
            'create-requests',
            'view-test-results',
            'view-invoices',
        ]);

        $this->command->info('✅ Permissions & Roles dengan Spatie created successfully!');
        $this->command->info('📊 Total Permissions: ' . Permission::count());
        $this->command->info('👥 Total Roles: ' . Role::count());
    }
}
