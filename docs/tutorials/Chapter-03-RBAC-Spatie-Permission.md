# Chapter 03: Role-Based Access Control (RBAC) dengan Spatie Laravel Permission

**Durasi:** 60-90 menit
**Level:** Intermediate

> ⚠️ **PENTING:** Jika Anda menemukan error saat mengikuti chapter ini, lihat **[Dokumen Revisi Chapter 3](../REVISI-CHAPTER-03.md)** untuk solusi lengkap dari semua error yang umum terjadi.

## 🎯 Tujuan Pembelajaran

Setelah menyelesaikan chapter ini, Anda akan mampu:
- Menginstall dan mengkonfigurasi Spatie Laravel Permission
- Membuat comprehensive permissions system (50 permissions)
- Mengassign permissions ke 11 roles iLab UNMUL
- Menggunakan middleware untuk route protection
- Implementasi permission checking di Blade views

## 📋 Prasyarat

- Chapter 2 sudah selesai (Authentication System)
- Spatie Laravel Permission package installed
- Memahami konsep Roles & Permissions

## 🚀 Step-by-Step Tutorial

### Step 1: Install Spatie Laravel Permission

```bash
composer require spatie/laravel-permission
```

**Output yang diharapkan:**
```
Package operations: 1 install, 0 updates, 0 removals
- Installing spatie/laravel-permission (6.21.0)
```

---

### Step 2: Publish Config & Migrations

```bash
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

**Files yang dipublish:**
- `config/permission.php` - Konfigurasi package
- `database/migrations/xxxx_create_permission_tables.php` - Migration untuk roles, permissions, dll

---

### Step 3: Hapus Old Role System (Chapter 2)

Karena Spatie menyediakan sistem roles sendiri, hapus role system dari Chapter 2:

```bash
# Hapus migrations lama
rm database/migrations/*create_roles_table.php
rm database/migrations/*add_role_id_to_users_table.php

# Hapus seeders & models lama
rm database/seeders/RoleSeeder.php
rm app/Models/Role.php
```

---

### Step 4: Update User Model dengan HasRoles Trait

Edit `app/Models/User.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;  // ← Import

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;  // ← Add HasRoles trait

    protected $fillable = [
        'name',
        'email',
        'password',
        // role_id sudah tidak diperlukan, Spatie uses pivot table
        'phone',
        'address',
        'institution',
        'nip_nim',
    ];

    // Old role methods sudah tidak diperlukan
    // Spatie provides: hasRole(), can(), hasPermissionTo()
}
```

**Trait HasRoles menyediakan methods:**
- `assignRole($role)` - Assign role ke user
- `removeRole($role)` - Remove role dari user
- `hasRole($role)` - Check if user has role
- `getRoleNames()` - Get all role names
- `givePermissionTo($permission)` - Give direct permission
- `hasPermissionTo($permission)` - Check permission
- `getAllPermissions()` - Get all permissions (via roles + direct)

---

### Step 5: Create Comprehensive PermissionSeeder

Buat seeder dengan 50 permissions untuk iLab UNMUL:

```bash
php artisan make:seeder PermissionSeeder
```

Edit `database/seeders/PermissionSeeder.php`:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions untuk iLab UNMUL (50 permissions)
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

        // Create 11 Roles dan assign permissions

        // 1. Super Admin - Full Access
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // 2. Wakil Direktur Pelayanan
        $wakilDirPelayanan = Role::create(['name' => 'Wakil Direktur Pelayanan']);
        $wakilDirPelayanan->givePermissionTo([
            'view-dashboard', 'view-own-profile', 'edit-own-profile',
            'view-all-requests', 'approve-requests',
            'view-test-results', 'view-activity-reports',
            'view-usage-reports', 'view-revenue-reports', 'export-reports',
        ]);

        // 3. Wakil Direktur PM & TI
        $wakilDirPMTI = Role::create(['name' => 'Wakil Direktur PM & TI']);
        $wakilDirPMTI->givePermissionTo([
            'view-dashboard', 'view-own-profile', 'edit-own-profile',
            'view-equipment', 'manage-equipment-maintenance',
            'view-calibrations', 'create-calibrations', 'edit-calibrations', 'approve-calibrations',
            'manage-settings', 'view-audit-logs',
        ]);

        // 4. Kepala Lab/Unit
        $kepalaLab = Role::create(['name' => 'Kepala Lab']);
        $kepalaLab->givePermissionTo([
            'view-dashboard', 'view-own-profile', 'edit-own-profile',
            'view-all-requests', 'approve-requests', 'assign-analyst',
            'view-equipment', 'view-test-results', 'approve-test-results',
            'view-activity-reports', 'view-usage-reports', 'export-reports',
        ]);

        // 5. Anggota Lab/Unit (Analyst/Researcher)
        $anggotaLab = Role::create(['name' => 'Anggota Lab']);
        $anggotaLab->givePermissionTo([
            'view-dashboard', 'view-own-profile', 'edit-own-profile',
            'view-all-requests', 'update-request-status',
            'input-test-results', 'view-test-results', 'export-test-results',
        ]);

        // 6. Laboran (Technician)
        $laboran = Role::create(['name' => 'Laboran']);
        $laboran->givePermissionTo([
            'view-dashboard', 'view-own-profile', 'edit-own-profile',
            'view-equipment', 'edit-equipment', 'manage-equipment-maintenance',
            'view-all-requests',
        ]);

        // 7. Sub Bagian TU & Keuangan
        $subBagianTUKeuangan = Role::create(['name' => 'Sub Bagian TU & Keuangan']);
        $subBagianTUKeuangan->givePermissionTo([
            'view-dashboard', 'view-own-profile', 'edit-own-profile',
            'view-invoices', 'create-invoices', 'edit-invoices',
            'manage-payments', 'view-financial-reports', 'export-reports',
        ]);

        // 8. Dosen (Faculty)
        $dosen = Role::create(['name' => 'Dosen']);
        $dosen->givePermissionTo([
            'view-dashboard', 'view-own-profile', 'edit-own-profile',
            'view-own-requests', 'create-requests',
            'view-test-results', 'export-test-results', 'view-invoices',
        ]);

        // 9. Mahasiswa (Student)
        $mahasiswa = Role::create(['name' => 'Mahasiswa']);
        $mahasiswa->givePermissionTo([
            'view-dashboard', 'view-own-profile', 'edit-own-profile',
            'view-own-requests', 'create-requests', 'view-test-results',
        ]);

        // 10. Peneliti Eksternal
        $penelitiEksternal = Role::create(['name' => 'Peneliti Eksternal']);
        $penelitiEksternal->givePermissionTo([
            'view-dashboard', 'view-own-profile', 'edit-own-profile',
            'view-own-requests', 'create-requests',
            'view-test-results', 'export-test-results', 'view-invoices',
        ]);

        // 11. Industri/Masyarakat Umum
        $industriUmum = Role::create(['name' => 'Industri/Umum']);
        $industriUmum->givePermissionTo([
            'view-dashboard', 'view-own-profile', 'edit-own-profile',
            'view-own-requests', 'create-requests',
            'view-test-results', 'view-invoices',
        ]);

        $this->command->info('✅ Permissions & Roles dengan Spatie created successfully!');
        $this->command->info('📊 Total Permissions: ' . Permission::count());
        $this->command->info('👥 Total Roles: ' . Role::count());
    }
}
```

---

### Step 6: Update DatabaseSeeder

Edit `database/seeders/DatabaseSeeder.php`:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed permissions & roles dengan Spatie
        $this->call(PermissionSeeder::class);
    }
}
```

---

### Step 7: Update RegisteredUserController

Update untuk menggunakan Spatie's `assignRole()`:

Edit `app/Http/Controllers/Auth/RegisteredUserController.php`:

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;  // ← Spatie Role
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $roles = Role::orderBy('name')->get();
        return view('auth.register', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'institution' => ['nullable', 'string', 'max:255'],
            'nip_nim' => ['nullable', 'string', 'max:50'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'institution' => $request->institution,
            'nip_nim' => $request->nip_nim,
        ]);

        // Assign role menggunakan Spatie
        // IMPORTANT: assignRole() accepts role name or object, NOT ID
        // Find role by ID first, then assign
        $role = Role::findById($request->role_id);
        $user->assignRole($role);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
```

---

### Step 8: Run Migrations & Seeders

```bash
php artisan migrate:fresh --seed
```

**Output yang diharapkan:**
```
Dropped all tables successfully.
Migration table created successfully.

Running migrations:
  0001_01_01_000000_create_users_table ............... DONE
  0001_01_01_000001_create_cache_table ............... DONE
  0001_01_01_000002_create_jobs_table ................ DONE
  2025_10_02_014940_create_permission_tables ......... DONE

Seeding database:
  Database\Seeders\PermissionSeeder .................. RUNNING
  ✅ Permissions & Roles dengan Spatie created successfully!
  📊 Total Permissions: 50
  👥 Total Roles: 11
  Database\Seeders\PermissionSeeder .................. DONE
```

---

### Step 9: Setup Middleware

Register Spatie middleware di `bootstrap/app.php`:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
```

**Middleware yang tersedia:**
- `role:Super Admin` - Hanya Super Admin
- `permission:view-equipment` - Hanya yang punya permission view-equipment
- `role_or_permission:Super Admin|view-equipment` - Super Admin ATAU punya permission

---

### Step 10: Protect Routes dengan Middleware

Edit `routes/web.php`:

```php
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Example: Admin-only routes
Route::middleware(['auth', 'role:Super Admin'])->prefix('admin')->group(function () {
    Route::get('/users', function () {
        return 'User Management - Super Admin Only';
    })->name('admin.users');
});

// Example: Permission-based routes
Route::middleware(['auth', 'permission:view-equipment'])->group(function () {
    Route::get('/equipment', function () {
        return 'Equipment List - Requires view-equipment permission';
    })->name('equipment.index');
});

require __DIR__.'/auth.php';
```

**Testing:**
- User dengan role "Dosen" tidak bisa akses `/admin/users` (403 Forbidden)
- User dengan role "Super Admin" bisa akses semua routes
- User dengan permission "view-equipment" bisa akses `/equipment`

---

### Step 11: Update Dashboard dengan Permission Display

Edit `resources/views/dashboard.blade.php`:

```blade
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-2">Selamat Datang, {{ auth()->user()->name }}!</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Role Anda: <span class="font-semibold text-[--color-unmul-blue]">{{ auth()->user()->getRoleNames()->first() }}</span>
                    </p>
                </div>
            </div>

            <!-- Permissions Info Card -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h4 class="font-semibold mb-4">Your Permissions</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                        @forelse(auth()->user()->getAllPermissions() as $permission)
                            <div class="bg-gray-100 dark:bg-gray-700 px-3 py-2 rounded text-sm">
                                {{ $permission->name }}
                            </div>
                        @empty
                            <p class="text-gray-500">No permissions assigned</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Quick Links based on permissions -->
            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @can('view-equipment')
                <a href="{{ route('equipment.index') }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-md transition">
                    <h5 class="font-semibold text-lg mb-2">Equipment Management</h5>
                    <p class="text-sm text-gray-600 dark:text-gray-400">View and manage laboratory equipment</p>
                </a>
                @endcan

                @role('Super Admin')
                <a href="{{ route('admin.users') }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-md transition">
                    <h5 class="font-semibold text-lg mb-2">User Management</h5>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Manage system users (Admin only)</p>
                </a>
                @endrole

                @can('create-requests')
                <a href="#" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-md transition">
                    <h5 class="font-semibold text-lg mb-2">Create Service Request</h5>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Submit new testing/analysis request</p>
                </a>
                @endcan
            </div>
        </div>
    </div>
</x-app-layout>
```

**Blade Directives dari Spatie:**
- `@role('Super Admin')` - Show if user has role
- `@hasrole('Super Admin')` - Alias untuk @role
- `@can('view-equipment')` - Show if user has permission
- `@canany(['view-equipment', 'create-equipment'])` - Show if has any permission

---

### Step 12: Testing RBAC System

```bash
php artisan serve
```

**Test Checklist:**

1. ✅ **Register New User** (http://127.0.0.1:8000/register)
   - Pilih role "Dosen"
   - Submit registrasi
   - Login dengan user baru

2. ✅ **Test Dashboard Permissions Display**
   - Dashboard menampilkan role name
   - Dashboard menampilkan semua permissions untuk role tersebut
   - Quick links hanya muncul sesuai permissions

3. ✅ **Test Route Protection**
   - Akses `/admin/users` sebagai "Dosen" → 403 Forbidden
   - Akses `/equipment` dengan role yang punya permission → Success
   - Logout dan login sebagai "Super Admin" → Akses semua routes berhasil

4. ✅ **Test Permission in Blade**
   - User "Dosen" melihat: Create Service Request card
   - User "Dosen" TIDAK melihat: User Management card (Super Admin only)
   - User "Super Admin" melihat: Semua cards

---

## 📊 Database Structure (Spatie)

Spatie membuat 5 tabel utama:

**permissions**
```
id | name                  | guard_name
---|----------------------|------------
1  | view-dashboard       | web
2  | view-own-profile     | web
...
50 | manage-announcements | web
```

**roles**
```
id | name                     | guard_name
---|-------------------------|------------
1  | Super Admin             | web
2  | Wakil Direktur Pelayanan| web
...
11 | Industri/Umum           | web
```

**model_has_roles** (Pivot: User ↔ Role)
```
role_id | model_type    | model_id
--------|---------------|----------
1       | App\Models\User | 1
2       | App\Models\User | 2
```

**role_has_permissions** (Pivot: Role ↔ Permission)
```
permission_id | role_id
--------------|--------
1             | 1
2             | 1
...
```

**model_has_permissions** (Direct Permissions)
```
permission_id | model_type      | model_id
--------------|-----------------|----------
5             | App\Models\User | 3
```

---

## 🔐 Using Permissions in Code

### Di Controller:
```php
// Check permission
if ($user->can('view-equipment')) {
    // Show equipment list
}

// Check role
if ($user->hasRole('Super Admin')) {
    // Admin actions
}

// Check multiple permissions (OR)
if ($user->hasAnyPermission(['view-equipment', 'create-equipment'])) {
    // Has at least one permission
}

// Check multiple permissions (AND)
if ($user->hasAllPermissions(['view-equipment', 'create-equipment'])) {
    // Has all permissions
}

// Assign role
$user->assignRole('Dosen');

// Give direct permission (bypass role)
$user->givePermissionTo('view-special-reports');

// Remove permission
$user->revokePermissionTo('view-special-reports');
```

### Di Blade:
```blade
{{-- Role checking --}}
@role('Super Admin')
    <p>Super Admin content</p>
@endrole

{{-- Permission checking --}}
@can('view-equipment')
    <a href="/equipment">Equipment</a>
@endcan

{{-- Multiple roles (OR) --}}
@hasanyrole('Super Admin|Kepala Lab')
    <p>Leadership content</p>
@endhasanyrole

{{-- Multiple permissions (OR) --}}
@canany(['view-equipment', 'create-equipment'])
    <p>Equipment actions</p>
@endcanany

{{-- Else conditions --}}
@can('edit-equipment')
    <button>Edit</button>
@else
    <p>No permission to edit</p>
@endcan
```

### Di Routes:
```php
// Single role
Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    // Admin routes
});

// Multiple roles (OR)
Route::middleware(['auth', 'role:Super Admin|Kepala Lab'])->group(function () {
    // Leadership routes
});

// Single permission
Route::middleware(['auth', 'permission:view-equipment'])->group(function () {
    // Equipment routes
});

// Multiple permissions (AND)
Route::middleware(['auth', 'permission:view-equipment,create-equipment'])->group(function () {
    // Requires BOTH permissions
});

// Role OR Permission
Route::middleware(['auth', 'role_or_permission:Super Admin|view-equipment'])->group(function () {
    // Super Admin OR has view-equipment permission
});
```

---

## 🐛 Troubleshooting

### Error 1: "Class 'Role' not found"
**Solusi:** Pastikan import `use Spatie\Permission\Models\Role;`

### Error 2: "Table 'roles' already exists"

**Error Message:**
```
SQLSTATE[42S01]: Base table or view already exists: 1050 Table 'roles' already exists
```

**Penyebab:** Migration `create_roles_table` dari Chapter 2 masih ada dan conflict dengan Spatie migrations.

**Solusi Lengkap:**
```bash
# 1. Hapus migrations lama dari Chapter 2
rm database/migrations/*create_roles_table.php
rm database/migrations/*add_role_id_to_users_table.php

# 2. Hapus model & seeder lama
rm app/Models/Role.php
rm database/seeders/RoleSeeder.php

# 3. Run migrations ulang
php artisan migrate:fresh --seed
```

### Error 3: "Column not found: 'phone', 'address', etc."

**Error Message:**
```
SQLSTATE[42S22]: Column not found: 1054 Unknown column 'phone' in 'field list'
```

**Penyebab:** Migration yang menambahkan kolom extra user fields terhapus bersama `add_role_id_to_users_table`.

**Solusi:** Buat migration baru untuk extra fields:

```bash
php artisan make:migration add_extra_fields_to_users_table
```

Edit migration:
```php
public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('phone', 20)->nullable()->after('email');
        $table->text('address')->nullable()->after('phone');
        $table->string('institution', 255)->nullable()->after('address');
        $table->string('nip_nim', 50)->nullable()->after('institution');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['phone', 'address', 'institution', 'nip_nim']);
    });
}
```

Run migration:
```bash
php artisan migrate
```

### Error 4: "Role Does Not Exist - Role Named '8'"

**Error Message:**
```
Spatie\Permission\Exceptions\RoleDoesNotExist
There is no role named `8` for guard `web`.
```

**Penyebab:** `assignRole()` method menerima **role name** atau **role object**, bukan **role ID**.

**Code yang Salah:**
```php
// ❌ SALAH - assignRole tidak menerima ID langsung
$user->assignRole($request->role_id);
```

**Solusi:**
```php
// ✅ BENAR - Find role by ID dulu, baru assign
$role = Role::findById($request->role_id);
$user->assignRole($role);

// Alternative: assign by name
$roleName = Role::findById($request->role_id)->name;
$user->assignRole($roleName);
```

**NOTE:** Tutorial sudah diperbaiki di Step 7 dengan code yang benar!

### Error 5: "Call to undefined method assignRole()"
**Solusi:** Pastikan `HasRoles` trait sudah di-add di User model:
```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles; // ← HasRoles trait
}
```

### Error 6: Permissions tidak update setelah seeder
**Solusi:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan permission:cache-reset
```

### Error 7: Route middleware tidak bekerja
**Solusi:**
1. Pastikan middleware alias sudah registered di `bootstrap/app.php`
2. Clear route cache: `php artisan route:clear`

---

## ✅ Chapter 3 Checklist

- [x] Spatie Laravel Permission installed
- [x] Config & migrations published
- [x] Old role system removed (migrations, models, seeders)
- [x] User model updated dengan HasRoles trait
- [x] PermissionSeeder created dengan 50 permissions
- [x] 11 Roles created dengan permissions assigned
- [x] DatabaseSeeder updated
- [x] Migrations & seeders berhasil dijalankan
- [x] Middleware registered di bootstrap/app.php
- [x] RegisteredUserController updated untuk Spatie
- [x] Example routes dengan protection created
- [x] Dashboard updated dengan permission display
- [x] Testing: Role-based route protection works
- [x] Testing: Permission-based route protection works
- [x] Testing: Blade directives work (@role, @can)

---

## 🎯 Key Takeaways

### General:
1. **Spatie Permission** menyediakan RBAC system yang production-ready
2. **50 Permissions** di-group berdasarkan module (User, Equipment, Request, dll)
3. **11 Roles** sesuai struktur organisasi iLab UNMUL
4. **Middleware** melindungi routes berdasarkan role/permission
5. **Blade Directives** memudahkan conditional rendering
6. **HasRoles Trait** menyediakan methods untuk permission checking

### Best Practices (Lessons from Revisions):
1. **assignRole() Syntax:**
   - ✅ `assignRole()` accepts role **name** or **object**
   - ❌ Does NOT accept role **ID** directly
   - ✅ Use `Role::findById($id)` first, then assign

2. **Migration Management:**
   - ✅ Remove old role system before installing Spatie
   - ✅ Don't have duplicate table names
   - ✅ Create separate migration for extra user fields

3. **User Model:**
   - ✅ Use `HasRoles` trait from Spatie (don't create custom methods)
   - ✅ Remove old `hasRole()`, `hasAnyRole()`, `role()` methods
   - ✅ Spatie provides all methods needed

4. **Testing Strategy:**
   - ✅ Test registration with different roles
   - ✅ Verify permissions display correctly
   - ✅ Test route protection with middleware
   - ✅ Test blade directives (@role, @can)

---

## 📚 Permission Matrix iLab UNMUL

| Permission | Super Admin | Wadir Pelayanan | Wadir PMTI | Kepala Lab | Anggota Lab | Laboran | TU & Keuangan | Dosen | Mahasiswa | Peneliti Eksternal | Industri/Umum |
|------------|-------------|-----------------|------------|------------|-------------|---------|---------------|-------|-----------|-------------------|---------------|
| view-dashboard | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| create-users | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| approve-requests | ✅ | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| input-test-results | ✅ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |
| manage-payments | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ |
| create-requests | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ✅ | ✅ | ✅ | ✅ |

*(Full matrix ada di PermissionSeeder)*

---

## ⏭️ Next Chapter

**Chapter 4: User Profile & Dashboard Enhancement**

Di chapter selanjutnya kita akan:
- Customize user profile page
- Upload avatar/photo
- Update user information
- Role-specific dashboard widgets
- Activity timeline

---

**💡 Tips Pro:**
- Gunakan `@can` untuk permission checking di Blade
- Gunakan `@role` untuk role checking di Blade
- Cache permissions dengan `php artisan permission:cache-reset`
- Gunakan Policy classes untuk complex authorization logic

**🎉 Selamat!** Anda telah menyelesaikan Chapter 3: RBAC dengan Spatie Laravel Permission!
