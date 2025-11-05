# iLab UNMUL - Tutorial Chapter 7: Equipment Management

## Daftar Isi
1. [Pendahuluan](#pendahuluan)
2. [Database Migration](#database-migration)
3. [Equipment Model](#equipment-model)
4. [Equipment Controller](#equipment-controller)
5. [Routes](#routes)
6. [Views](#views)
   - [Index View](#index-view)
   - [Create & Edit Views](#create--edit-views)
   - [Show View](#show-view)
7. [Equipment Seeder](#equipment-seeder)
8. [Testing](#testing)
9. [Troubleshooting](#troubleshooting)
10. [Summary](#summary)

---

## Pendahuluan

**Chapter 7** membangun fitur manajemen equipment/alat laboratorium yang merupakan aset penting dalam operasional laboratorium. Equipment akan terhubung dengan laboratorium (Chapter 6) dan menjadi basis untuk maintenance, calibration, dan booking di chapter selanjutnya.

**Fitur yang Dibangun:**
- ✅ CRUD Equipment (Create, Read, Update, Delete)
- ✅ Photo upload dengan preview
- ✅ Search & multi-filter (laboratory, category, status, condition)
- ✅ Equipment categorization (analytical, measurement, preparation, safety, computer, general)
- ✅ Purchase information & warranty tracking
- ✅ Maintenance & calibration scheduling
- ✅ Assignment to user
- ✅ Status management (available, in_use, maintenance, calibration, broken, retired)
- ✅ Condition tracking (excellent, good, fair, poor, broken)
- ✅ Soft delete untuk history

**Tech Stack:**
- Laravel 12 (Eloquent ORM, File Storage)
- Blade Components (dari Chapter 5)
- Alpine.js (untuk interactivity)
- Tailwind CSS v4 (styling)
- Font Awesome (icons)

---

## Database Migration

### Langkah 1: Buat Migration

```bash
php artisan make:migration create_equipment_table
```

### Langkah 2: Edit Migration File

**File**: `database/migrations/YYYY_MM_DD_HHMMSS_create_equipment_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('name'); // Nama alat
            $table->string('code', 50)->unique(); // Kode alat (EQ-LAB-001)
            $table->foreignId('laboratory_id')->constrained('laboratories')->cascadeOnDelete();
            $table->enum('category', [
                'analytical',
                'measurement',
                'preparation',
                'safety',
                'computer',
                'general'
            ]); // Kategori alat

            // Specifications
            $table->string('brand')->nullable(); // Merk
            $table->string('model')->nullable(); // Model
            $table->string('serial_number')->nullable()->unique(); // Serial Number
            $table->text('description')->nullable(); // Deskripsi
            $table->json('specifications')->nullable(); // Spesifikasi teknis (JSON)
            $table->string('photo')->nullable(); // Foto alat

            // Purchase Information
            $table->date('purchase_date')->nullable(); // Tanggal pembelian
            $table->decimal('purchase_price', 15, 2)->nullable(); // Harga beli
            $table->string('supplier')->nullable(); // Supplier
            $table->string('warranty_period')->nullable(); // Periode garansi (e.g., "2 tahun")
            $table->date('warranty_until')->nullable(); // Garansi sampai

            // Condition & Status
            $table->enum('condition', [
                'excellent',
                'good',
                'fair',
                'poor',
                'broken'
            ])->default('good'); // Kondisi fisik

            $table->enum('status', [
                'available',
                'in_use',
                'maintenance',
                'calibration',
                'broken',
                'retired'
            ])->default('available'); // Status operasional

            $table->text('status_notes')->nullable(); // Catatan status

            // Maintenance & Calibration
            $table->date('last_maintenance')->nullable(); // Maintenance terakhir
            $table->date('next_maintenance')->nullable(); // Maintenance berikutnya
            $table->integer('maintenance_interval_days')->nullable(); // Interval maintenance (hari)

            $table->date('last_calibration')->nullable(); // Kalibrasi terakhir
            $table->date('next_calibration')->nullable(); // Kalibrasi berikutnya
            $table->integer('calibration_interval_days')->nullable(); // Interval kalibrasi (hari)

            // Location & Assignment
            $table->string('location_detail')->nullable(); // Detail lokasi (Rak A2, Lemari 3, dll)
            $table->foreignId('assigned_to')->nullable()->constrained('users')->nullOnDelete(); // PIC/User

            // Usage Tracking
            $table->integer('usage_count')->default(0); // Jumlah pemakaian
            $table->decimal('usage_hours', 10, 2)->default(0); // Total jam pemakaian

            // Documents
            $table->string('manual_file')->nullable(); // File manual (PDF)
            $table->json('documents')->nullable(); // Dokumen lain (array of files)

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('laboratory_id');
            $table->index('category');
            $table->index('status');
            $table->index('condition');
            $table->index('assigned_to');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
```

### Langkah 3: Jalankan Migration

```bash
php artisan migrate
```

**Expected Output:**
```
2025_10_09_HHMMSS_create_equipment_table ...................... DONE
```

---

## Equipment Model

### Langkah 1: Buat Model

```bash
php artisan make:model Equipment
```

### Langkah 2: Edit Equipment Model

**File**: `app/Models/Equipment.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Equipment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'laboratory_id',
        'category',
        'brand',
        'model',
        'serial_number',
        'description',
        'specifications',
        'photo',
        'purchase_date',
        'purchase_price',
        'supplier',
        'warranty_period',
        'warranty_until',
        'condition',
        'status',
        'status_notes',
        'last_maintenance',
        'next_maintenance',
        'maintenance_interval_days',
        'last_calibration',
        'next_calibration',
        'calibration_interval_days',
        'location_detail',
        'assigned_to',
        'usage_count',
        'usage_hours',
        'manual_file',
        'documents',
    ];

    protected $casts = [
        'specifications' => 'array',
        'documents' => 'array',
        'purchase_date' => 'date',
        'warranty_until' => 'date',
        'last_maintenance' => 'date',
        'next_maintenance' => 'date',
        'last_calibration' => 'date',
        'next_calibration' => 'date',
        'purchase_price' => 'decimal:2',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the laboratory that owns the equipment
     */
    public function laboratory(): BelongsTo
    {
        return $this->belongsTo(Laboratory::class);
    }

    /**
     * Get the user assigned to this equipment
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get maintenance records (Chapter 7B)
     */
    public function maintenanceRecords(): HasMany
    {
        return $this->hasMany(EquipmentMaintenance::class);
    }

    /**
     * Get calibration records (Chapter 7B)
     */
    public function calibrationRecords(): HasMany
    {
        return $this->hasMany(EquipmentCalibration::class);
    }

    /**
     * Scope: Available equipment
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope: Filter by laboratory
     */
    public function scopeInLaboratory($query, $laboratoryId)
    {
        return $query->where('laboratory_id', $laboratoryId);
    }

    /**
     * Scope: Filter by category
     */
    public function scopeOfCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: Needs maintenance (overdue or due soon)
     */
    public function scopeNeedsMaintenance($query, $daysAhead = 7)
    {
        return $query->whereNotNull('next_maintenance')
            ->where('next_maintenance', '<=', Carbon::now()->addDays($daysAhead));
    }

    /**
     * Scope: Needs calibration (overdue or due soon)
     */
    public function scopeNeedsCalibration($query, $daysAhead = 7)
    {
        return $query->whereNotNull('next_calibration')
            ->where('next_calibration', '<=', Carbon::now()->addDays($daysAhead));
    }

    /**
     * Get category label
     */
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'analytical' => 'Analitik',
            'measurement' => 'Pengukuran',
            'preparation' => 'Preparasi',
            'safety' => 'Safety',
            'computer' => 'Komputer',
            'general' => 'Umum',
            default => $this->category,
        };
    }

    /**
     * Get condition label
     */
    public function getConditionLabelAttribute(): string
    {
        return match($this->condition) {
            'excellent' => 'Sangat Baik',
            'good' => 'Baik',
            'fair' => 'Cukup',
            'poor' => 'Buruk',
            'broken' => 'Rusak',
            default => $this->condition,
        };
    }

    /**
     * Get condition badge variant
     */
    public function getConditionBadgeAttribute(): string
    {
        return match($this->condition) {
            'excellent' => 'success',
            'good' => 'primary',
            'fair' => 'warning',
            'poor' => 'danger',
            'broken' => 'danger',
            default => 'default',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'available' => 'Tersedia',
            'in_use' => 'Sedang Digunakan',
            'maintenance' => 'Maintenance',
            'calibration' => 'Kalibrasi',
            'broken' => 'Rusak',
            'retired' => 'Retired',
            default => $this->status,
        };
    }

    /**
     * Get status badge variant
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'available' => 'success',
            'in_use' => 'info',
            'maintenance' => 'warning',
            'calibration' => 'warning',
            'broken' => 'danger',
            'retired' => 'default',
            default => 'default',
        };
    }

    /**
     * Get photo URL with SVG placeholder
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }

        // Return inline SVG data URI sebagai placeholder
        return 'data:image/svg+xml;base64,' . base64_encode('
            <svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
                <rect width="400" height="300" fill="#FF9800"/>
                <text x="50%" y="50%" text-anchor="middle" dy=".3em" fill="white" font-family="Arial, sans-serif" font-size="24" font-weight="bold">
                    Equipment Photo
                </text>
            </svg>
        ');
    }

    /**
     * Check if warranty is still valid
     */
    public function getIsUnderWarrantyAttribute(): bool
    {
        return $this->warranty_until && $this->warranty_until >= Carbon::now();
    }

    /**
     * Check if maintenance is overdue
     */
    public function getIsMaintenanceOverdueAttribute(): bool
    {
        return $this->next_maintenance && $this->next_maintenance < Carbon::now();
    }

    /**
     * Check if calibration is overdue
     */
    public function getIsCalibrationOverdueAttribute(): bool
    {
        return $this->next_calibration && $this->next_calibration < Carbon::now();
    }

    /**
     * Get days until next maintenance
     */
    public function getDaysUntilMaintenanceAttribute(): ?int
    {
        if (!$this->next_maintenance) {
            return null;
        }
        return Carbon::now()->diffInDays($this->next_maintenance, false);
    }

    /**
     * Get days until next calibration
     */
    public function getDaysUntilCalibrationAttribute(): ?int
    {
        if (!$this->next_calibration) {
            return null;
        }
        return Carbon::now()->diffInDays($this->next_calibration, false);
    }
}
```

**Penjelasan Fitur Model:**

1. **Relationships:**
   - `laboratory()` - Equipment belongs to Laboratory
   - `assignedUser()` - Equipment assigned to User
   - `maintenanceRecords()` & `calibrationRecords()` - Untuk Chapter 7B

2. **Query Scopes:**
   - `available()` - Filter alat yang tersedia
   - `inLaboratory($id)` - Filter by lab
   - `ofCategory($cat)` - Filter by kategori
   - `needsMaintenance($days)` - Alat yang perlu maintenance
   - `needsCalibration($days)` - Alat yang perlu kalibrasi

3. **Accessors:**
   - Label terjemahan (category, condition, status)
   - Badge variant untuk UI
   - Photo URL dengan placeholder SVG
   - Boolean helpers (is_under_warranty, is_maintenance_overdue, dll)
   - Days until maintenance/calibration

---

## Equipment Controller

### Langkah 1: Buat Controller

```bash
php artisan make:controller EquipmentController --resource
```

### Langkah 2: Edit Equipment Controller

**File**: `app/Http/Controllers/EquipmentController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Equipment::with(['laboratory', 'assignedUser']);

        // Filter by laboratory
        if ($request->filled('laboratory_id')) {
            $query->where('laboratory_id', $request->laboratory_id);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by condition
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('brand', 'like', "%{$search}%")
                  ->orWhere('model', 'like', "%{$search}%")
                  ->orWhere('serial_number', 'like', "%{$search}%");
            });
        }

        $equipment = $query->latest()->paginate(12);
        $laboratories = Laboratory::active()->get();

        return view('equipment.index', compact('equipment', 'laboratories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $laboratories = Laboratory::active()->get();
        $users = User::all(); // For assigned_to
        return view('equipment.create', compact('laboratories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:equipment,code',
            'laboratory_id' => 'required|exists:laboratories,id',
            'category' => 'required|in:analytical,measurement,preparation,safety,computer,general',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:equipment,serial_number',
            'description' => 'nullable|string',
            'specifications' => 'nullable|array',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'warranty_period' => 'nullable|string|max:255',
            'warranty_until' => 'nullable|date',
            'condition' => 'required|in:excellent,good,fair,poor,broken',
            'status' => 'required|in:available,in_use,maintenance,calibration,broken,retired',
            'status_notes' => 'nullable|string',
            'location_detail' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'maintenance_interval_days' => 'nullable|integer|min:1',
            'calibration_interval_days' => 'nullable|integer|min:1',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('equipment', 'public');
        }

        $equipment = Equipment::create($validated);

        return redirect()->route('equipment.show', $equipment)
            ->with('success', 'Equipment berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Equipment $equipment)
    {
        // Load only relationships that exist (maintenance & calibration will be added in Chapter 7B)
        $equipment->load(['laboratory', 'assignedUser']);
        return view('equipment.show', compact('equipment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Equipment $equipment)
    {
        $laboratories = Laboratory::active()->get();
        $users = User::all();
        return view('equipment.edit', compact('equipment', 'laboratories', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:equipment,code,' . $equipment->id,
            'laboratory_id' => 'required|exists:laboratories,id',
            'category' => 'required|in:analytical,measurement,preparation,safety,computer,general',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255|unique:equipment,serial_number,' . $equipment->id,
            'description' => 'nullable|string',
            'specifications' => 'nullable|array',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'supplier' => 'nullable|string|max:255',
            'warranty_period' => 'nullable|string|max:255',
            'warranty_until' => 'nullable|date',
            'condition' => 'required|in:excellent,good,fair,poor,broken',
            'status' => 'required|in:available,in_use,maintenance,calibration,broken,retired',
            'status_notes' => 'nullable|string',
            'location_detail' => 'nullable|string|max:255',
            'assigned_to' => 'nullable|exists:users,id',
            'maintenance_interval_days' => 'nullable|integer|min:1',
            'calibration_interval_days' => 'nullable|integer|min:1',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($equipment->photo) {
                Storage::disk('public')->delete($equipment->photo);
            }
            $validated['photo'] = $request->file('photo')->store('equipment', 'public');
        }

        $equipment->update($validated);

        return redirect()->route('equipment.show', $equipment)
            ->with('success', 'Equipment berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Equipment $equipment)
    {
        // Delete photo
        if ($equipment->photo) {
            Storage::disk('public')->delete($equipment->photo);
        }

        $equipment->delete();

        return redirect()->route('equipment.index')
            ->with('success', 'Equipment berhasil dihapus!');
    }
}
```

**Penjelasan Fitur Controller:**

1. **Index Method:**
   - Multi-filter: laboratory, category, status, condition
   - Search: name, code, brand, model, serial_number
   - Pagination: 12 items per page
   - Eager loading: laboratory & assignedUser

2. **Store & Update:**
   - Comprehensive validation (required, unique, file upload)
   - Photo upload ke `storage/equipment/`
   - Auto-delete old photo saat update

3. **Delete:**
   - Soft delete dengan `SoftDeletes` trait
   - Auto-delete photo file

---

## Routes

### Edit Routes File

**File**: `routes/web.php`

Tambahkan route resource untuk equipment:

```php
use App\Http\Controllers\EquipmentController;

// Equipment Management Routes (Laboran, Kepala Lab, Wakil Direktur PM & TI, Super Admin)
Route::middleware(['auth', 'verified'])
    ->prefix('equipment')
    ->name('equipment.')
    ->group(function () {
        Route::get('/', [EquipmentController::class, 'index'])->name('index')
            ->middleware('permission:view-equipment');
        Route::get('/create', [EquipmentController::class, 'create'])->name('create')
            ->middleware('permission:create-equipment');
        Route::post('/', [EquipmentController::class, 'store'])->name('store')
            ->middleware('permission:create-equipment');
        Route::get('/{equipment}', [EquipmentController::class, 'show'])->name('show')
            ->middleware('permission:view-equipment');
        Route::get('/{equipment}/edit', [EquipmentController::class, 'edit'])->name('edit')
            ->middleware('permission:edit-equipment');
        Route::put('/{equipment}', [EquipmentController::class, 'update'])->name('update')
            ->middleware('permission:edit-equipment');
        Route::delete('/{equipment}', [EquipmentController::class, 'destroy'])->name('destroy')
            ->middleware('permission:delete-equipment');
    });
```

**Permission Required:**
- `view-equipment` - Lihat daftar equipment
- `create-equipment` - Tambah equipment baru
- `edit-equipment` - Edit equipment
- `delete-equipment` - Hapus equipment

Permissions ini sudah ada di Chapter 3 (PermissionSeeder).

---

## Views

### Struktur Folder Views

Buat folder dan file berikut:

```
resources/views/equipment/
├── index.blade.php
├── create.blade.php
├── edit.blade.php
├── show.blade.php
└── partials/
    └── form.blade.php
```

---

### Index View

**File**: `resources/views/equipment/index.blade.php`

```blade
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manajemen Alat Laboratorium') }}
            </h2>
            @can('create-equipment')
                <x-button variant="primary" size="sm" onclick="window.location.href='{{ route('equipment.create') }}'">
                    <i class="fa fa-plus mr-1"></i> Tambah Alat
                </x-button>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Filter Section --}}
            <x-card class="mb-6">
                <form method="GET" action="{{ route('equipment.index') }}">
                    <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                        {{-- Search Box --}}
                        <div class="md:col-span-2">
                            <x-input
                                name="search"
                                placeholder="Cari nama, kode, merk, model, SN..."
                                value="{{ request('search') }}"
                                icon="fa fa-search"
                                iconPosition="left"
                            />
                        </div>

                        {{-- Laboratory Filter --}}
                        <div>
                            <x-select
                                name="laboratory_id"
                                placeholder="Semua Lab"
                                :options="$laboratories->pluck('name', 'id')->toArray()"
                                value="{{ request('laboratory_id') }}"
                            />
                        </div>

                        {{-- Category Filter --}}
                        <div>
                            <x-select
                                name="category"
                                placeholder="Kategori"
                                :options="[
                                    'analytical' => 'Analitik',
                                    'measurement' => 'Pengukuran',
                                    'preparation' => 'Preparasi',
                                    'safety' => 'Safety',
                                    'computer' => 'Komputer',
                                    'general' => 'Umum'
                                ]"
                                value="{{ request('category') }}"
                            />
                        </div>

                        {{-- Status Filter --}}
                        <div>
                            <x-select
                                name="status"
                                placeholder="Status"
                                :options="[
                                    'available' => 'Tersedia',
                                    'in_use' => 'Sedang Digunakan',
                                    'maintenance' => 'Maintenance',
                                    'calibration' => 'Kalibrasi',
                                    'broken' => 'Rusak',
                                    'retired' => 'Retired'
                                ]"
                                value="{{ request('status') }}"
                            />
                        </div>

                        {{-- Condition Filter --}}
                        <div>
                            <x-select
                                name="condition"
                                placeholder="Kondisi"
                                :options="[
                                    'excellent' => 'Sangat Baik',
                                    'good' => 'Baik',
                                    'fair' => 'Cukup',
                                    'poor' => 'Buruk',
                                    'broken' => 'Rusak'
                                ]"
                                value="{{ request('condition') }}"
                            />
                        </div>
                    </div>

                    <div class="flex gap-2 mt-4">
                        <x-button type="submit" variant="primary">
                            <i class="fa fa-filter mr-2"></i> Filter
                        </x-button>
                        <x-button
                            type="button"
                            variant="ghost"
                            onclick="window.location.href='{{ route('equipment.index') }}'"
                        >
                            Reset
                        </x-button>
                    </div>
                </form>
            </x-card>

            {{-- Equipment Grid --}}
            @if($equipment->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($equipment as $item)
                        <x-card class="hover:shadow-lg transition-shadow duration-200">
                            {{-- Photo with Status Badge --}}
                            <div class="mb-4 -mx-6 -mt-6">
                                <div class="relative">
                                    <img
                                        src="{{ $item->photo_url }}"
                                        alt="{{ $item->name }}"
                                        class="w-full h-48 object-cover rounded-t-lg"
                                    >
                                    <div class="absolute top-2 right-2">
                                        <x-badge :variant="$item->status_badge" dot="true">
                                            {{ $item->status_label }}
                                        </x-badge>
                                    </div>
                                </div>
                            </div>

                            {{-- Equipment Info --}}
                            <div class="space-y-3">
                                <div>
                                    <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">
                                        {{ $item->name }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $item->code }}
                                    </p>
                                </div>

                                <div class="flex items-center gap-2">
                                    <x-badge variant="primary" size="sm">
                                        <i class="fa fa-flask mr-1"></i> {{ $item->category_label }}
                                    </x-badge>
                                    <x-badge :variant="$item->condition_badge" size="sm">
                                        {{ $item->condition_label }}
                                    </x-badge>
                                </div>

                                <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                    <p><i class="fa fa-building w-4 mr-2"></i> {{ $item->laboratory->name }}</p>
                                    @if($item->brand)
                                        <p><i class="fa fa-tag w-4 mr-2"></i> {{ $item->brand }} {{ $item->model }}</p>
                                    @endif
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex items-center gap-2 pt-3 border-t border-gray-200 dark:border-gray-700">
                                    @can('view-equipment')
                                        <x-button
                                            variant="primary"
                                            size="sm"
                                            onclick="window.location.href='{{ route('equipment.show', $item) }}'"
                                        >
                                            Detail
                                        </x-button>
                                    @endcan

                                    @can('edit-equipment')
                                        <x-button
                                            variant="warning"
                                            size="sm"
                                            onclick="window.location.href='{{ route('equipment.edit', $item) }}'"
                                        >
                                            Edit
                                        </x-button>
                                    @endcan

                                    @can('delete-equipment')
                                        <form action="{{ route('equipment.destroy', $item) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus alat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <x-button type="submit" variant="danger" size="sm">
                                                <i class="fa fa-trash"></i>
                                            </x-button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                        </x-card>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $equipment->links() }}
                </div>
            @else
                <x-card>
                    <div class="text-center py-12">
                        <i class="fa fa-box-open text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            Tidak ada alat ditemukan
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-4">
                            @if(request()->hasAny(['search', 'laboratory_id', 'category', 'status', 'condition']))
                                Coba ubah filter pencarian Anda
                            @else
                                Belum ada alat laboratorium yang terdaftar
                            @endif
                        </p>
                        @can('create-equipment')
                            <x-button variant="primary" onclick="window.location.href='{{ route('equipment.create') }}'">
                                <i class="fa fa-plus mr-2"></i> Tambah Alat Pertama
                            </x-button>
                        @endcan
                    </div>
                </x-card>
            @endif
        </div>
    </div>
</x-app-layout>
```

---

### Create & Edit Views

**File**: `resources/views/equipment/create.blade.php`

```blade
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <x-button
                variant="ghost"
                size="sm"
                onclick="window.location.href='{{ route('equipment.index') }}'"
                class="mr-4"
            >
                <i class="fa fa-arrow-left"></i>
            </x-button>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Tambah Alat Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form action="{{ route('equipment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @include('equipment.partials.form', ['equipment' => null, 'laboratories' => $laboratories, 'users' => $users])
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
```

**File**: `resources/views/equipment/edit.blade.php`

```blade
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <x-button
                variant="ghost"
                size="sm"
                onclick="window.location.href='{{ route('equipment.show', $equipment) }}'"
                class="mr-4"
            >
                <i class="fa fa-arrow-left"></i>
            </x-button>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Alat: ') }} {{ $equipment->name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-card>
                <form action="{{ route('equipment.update', $equipment) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('equipment.partials.form', ['equipment' => $equipment, 'laboratories' => $laboratories, 'users' => $users])
                </form>
            </x-card>
        </div>
    </div>
</x-app-layout>
```

**File**: `resources/views/equipment/partials/form.blade.php`

```blade
<div class="space-y-6">
    {{-- Informasi Dasar --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            Informasi Dasar
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input
                label="Nama Alat"
                name="name"
                :value="old('name', $equipment->name ?? '')"
                placeholder="FTIR Spectrometer"
                required="true"
                :error="$errors->first('name')"
            />

            <x-input
                label="Kode Alat"
                name="code"
                :value="old('code', $equipment->code ?? '')"
                placeholder="EQ-LAB-001"
                required="true"
                hint="Format: EQ-XXX-001"
                :error="$errors->first('code')"
            />

            <x-select
                label="Laboratorium"
                name="laboratory_id"
                :options="$laboratories->pluck('name', 'id')->toArray()"
                :value="old('laboratory_id', $equipment->laboratory_id ?? '')"
                placeholder="Pilih laboratorium"
                required="true"
                :error="$errors->first('laboratory_id')"
            />

            <x-select
                label="Kategori"
                name="category"
                :options="[
                    'analytical' => 'Analitik',
                    'measurement' => 'Pengukuran',
                    'preparation' => 'Preparasi',
                    'safety' => 'Safety',
                    'computer' => 'Komputer',
                    'general' => 'Umum'
                ]"
                :value="old('category', $equipment->category ?? '')"
                placeholder="Pilih kategori"
                required="true"
                :error="$errors->first('category')"
            />

            <x-input
                label="Merk"
                name="brand"
                :value="old('brand', $equipment->brand ?? '')"
                placeholder="Shimadzu"
                :error="$errors->first('brand')"
            />

            <x-input
                label="Model"
                name="model"
                :value="old('model', $equipment->model ?? '')"
                placeholder="IRPrestige-21"
                :error="$errors->first('model')"
            />

            <x-input
                label="Serial Number"
                name="serial_number"
                :value="old('serial_number', $equipment->serial_number ?? '')"
                placeholder="SN123456789"
                :error="$errors->first('serial_number')"
            />

            <x-input
                label="Detail Lokasi"
                name="location_detail"
                :value="old('location_detail', $equipment->location_detail ?? '')"
                placeholder="Rak A2, Lemari 3"
                :error="$errors->first('location_detail')"
            />
        </div>

        <div class="mt-4">
            <x-textarea
                label="Deskripsi"
                name="description"
                :value="old('description', $equipment->description ?? '')"
                placeholder="Deskripsi alat dan fungsinya..."
                rows="3"
                :error="$errors->first('description')"
            />
        </div>
    </div>

    {{-- Foto Upload --}}
    <div>
        <x-file-upload
            label="Foto Alat"
            name="photo"
            accept="image/*"
            hint="Format: JPG, PNG. Max: 2MB"
            :error="$errors->first('photo')"
        />

        @if(isset($equipment) && $equipment->photo)
            <div class="mt-4">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Foto Saat Ini:</p>
                <img src="{{ $equipment->photo_url }}" alt="{{ $equipment->name }}" class="w-48 h-32 object-cover rounded-lg">
            </div>
        @endif
    </div>

    {{-- Informasi Pembelian --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            Informasi Pembelian
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input
                type="date"
                label="Tanggal Pembelian"
                name="purchase_date"
                :value="old('purchase_date', isset($equipment) && $equipment->purchase_date ? $equipment->purchase_date->format('Y-m-d') : '')"
                :error="$errors->first('purchase_date')"
            />

            <x-input
                type="number"
                label="Harga Pembelian (Rp)"
                name="purchase_price"
                :value="old('purchase_price', $equipment->purchase_price ?? '')"
                placeholder="10000000"
                step="0.01"
                :error="$errors->first('purchase_price')"
            />

            <x-input
                label="Supplier"
                name="supplier"
                :value="old('supplier', $equipment->supplier ?? '')"
                placeholder="PT. Supplier Indonesia"
                :error="$errors->first('supplier')"
            />

            <x-input
                label="Periode Garansi"
                name="warranty_period"
                :value="old('warranty_period', $equipment->warranty_period ?? '')"
                placeholder="2 tahun"
                :error="$errors->first('warranty_period')"
            />

            <x-input
                type="date"
                label="Garansi Sampai"
                name="warranty_until"
                :value="old('warranty_until', isset($equipment) && $equipment->warranty_until ? $equipment->warranty_until->format('Y-m-d') : '')"
                :error="$errors->first('warranty_until')"
            />
        </div>
    </div>

    {{-- Status & Kondisi --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            Status & Kondisi
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-select
                label="Status"
                name="status"
                :options="[
                    'available' => 'Tersedia',
                    'in_use' => 'Sedang Digunakan',
                    'maintenance' => 'Maintenance',
                    'calibration' => 'Kalibrasi',
                    'broken' => 'Rusak',
                    'retired' => 'Retired'
                ]"
                :value="old('status', $equipment->status ?? 'available')"
                required="true"
                :error="$errors->first('status')"
            />

            <x-select
                label="Kondisi"
                name="condition"
                :options="[
                    'excellent' => 'Sangat Baik',
                    'good' => 'Baik',
                    'fair' => 'Cukup',
                    'poor' => 'Buruk',
                    'broken' => 'Rusak'
                ]"
                :value="old('condition', $equipment->condition ?? 'good')"
                required="true"
                :error="$errors->first('condition')"
            />

            <x-select
                label="Ditugaskan Kepada"
                name="assigned_to"
                :options="$users->pluck('name', 'id')->toArray()"
                :value="old('assigned_to', $equipment->assigned_to ?? '')"
                placeholder="Pilih PIC (opsional)"
                :error="$errors->first('assigned_to')"
            />
        </div>

        <div class="mt-4">
            <x-textarea
                label="Catatan Status"
                name="status_notes"
                :value="old('status_notes', $equipment->status_notes ?? '')"
                placeholder="Catatan tambahan tentang status atau kondisi alat..."
                rows="3"
                :error="$errors->first('status_notes')"
            />
        </div>
    </div>

    {{-- Maintenance & Kalibrasi --}}
    <div>
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
            Jadwal Maintenance & Kalibrasi
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <x-input
                type="number"
                label="Interval Maintenance (hari)"
                name="maintenance_interval_days"
                :value="old('maintenance_interval_days', $equipment->maintenance_interval_days ?? '')"
                placeholder="90"
                hint="Contoh: 90 hari (3 bulan)"
                :error="$errors->first('maintenance_interval_days')"
            />

            <x-input
                type="number"
                label="Interval Kalibrasi (hari)"
                name="calibration_interval_days"
                :value="old('calibration_interval_days', $equipment->calibration_interval_days ?? '')"
                placeholder="180"
                hint="Contoh: 180 hari (6 bulan)"
                :error="$errors->first('calibration_interval_days')"
            />
        </div>
    </div>

    {{-- Action Buttons --}}
    <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200 dark:border-gray-700">
        <x-button type="button" variant="ghost" onclick="window.history.back()">
            Batal
        </x-button>
        <x-button type="submit" variant="primary">
            <i class="fa fa-save mr-2"></i>
            {{ isset($equipment) && $equipment->id ? 'Update Alat' : 'Simpan Alat' }}
        </x-button>
    </div>
</div>
```

---

### Show View

**File**: `resources/views/equipment/show.blade.php`

```blade
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <x-button
                    variant="ghost"
                    size="sm"
                    onclick="window.location.href='{{ route('equipment.index') }}'"
                    class="mr-4"
                >
                    <i class="fa fa-arrow-left"></i>
                </x-button>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Detail Alat') }}
                </h2>
            </div>
            @can('edit-equipment')
                <x-button
                    variant="primary"
                    size="sm"
                    onclick="window.location.href='{{ route('equipment.edit', $equipment) }}'"
                >
                    <i class="fa fa-edit mr-1"></i> Edit
                </x-button>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Header Card with Photo --}}
            <x-card>
                <div class="flex flex-col md:flex-row gap-6">
                    {{-- Photo --}}
                    <div class="flex-shrink-0">
                        <img
                            src="{{ $equipment->photo_url }}"
                            alt="{{ $equipment->name }}"
                            class="w-full md:w-64 h-48 object-cover rounded-lg"
                        >
                    </div>

                    {{-- Basic Info --}}
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                            {{ $equipment->name }}
                        </h1>
                        <p class="text-lg text-gray-600 dark:text-gray-400 mb-4">
                            {{ $equipment->code }}
                        </p>

                        <div class="flex flex-wrap gap-2 mb-4">
                            <x-badge :variant="$equipment->status_badge" dot="true">
                                {{ $equipment->status_label }}
                            </x-badge>
                            <x-badge :variant="$equipment->condition_badge">
                                {{ $equipment->condition_label }}
                            </x-badge>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Laboratorium</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $equipment->laboratory->name }}
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-500 dark:text-gray-400">Kategori</span>
                                <p class="font-medium text-gray-900 dark:text-gray-100">
                                    {{ $equipment->category_label }}
                                </p>
                            </div>
                            @if($equipment->brand)
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Merk & Model</span>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $equipment->brand }} {{ $equipment->model }}
                                    </p>
                                </div>
                            @endif
                            @if($equipment->serial_number)
                                <div>
                                    <span class="text-gray-500 dark:text-gray-400">Serial Number</span>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">
                                        {{ $equipment->serial_number }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- Details Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Informasi Detail --}}
                <x-card title="Informasi Detail">
                    <div class="space-y-4 text-sm">
                        @if($equipment->description)
                            <div>
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-1">Deskripsi</h4>
                                <p class="text-gray-600 dark:text-gray-400">{{ $equipment->description }}</p>
                            </div>
                        @endif

                        @if($equipment->location_detail)
                            <div>
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-1">Detail Lokasi</h4>
                                <p class="text-gray-600 dark:text-gray-400">{{ $equipment->location_detail }}</p>
                            </div>
                        @endif

                        @if($equipment->assignedUser)
                            <div>
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-1">Ditugaskan Kepada</h4>
                                <p class="text-gray-600 dark:text-gray-400">{{ $equipment->assignedUser->name }}</p>
                            </div>
                        @endif

                        @if($equipment->status_notes)
                            <div>
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-1">Catatan Status</h4>
                                <p class="text-gray-600 dark:text-gray-400">{{ $equipment->status_notes }}</p>
                            </div>
                        @endif
                    </div>
                </x-card>

                {{-- Informasi Pembelian --}}
                <x-card title="Informasi Pembelian">
                    <div class="space-y-4 text-sm">
                        @if($equipment->purchase_price)
                            <div>
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-1">Harga Pembelian</h4>
                                <p class="text-gray-600 dark:text-gray-400">
                                    Rp {{ number_format($equipment->purchase_price, 0, ',', '.') }}
                                </p>
                            </div>
                        @endif

                        @if($equipment->supplier)
                            <div>
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-1">Supplier</h4>
                                <p class="text-gray-600 dark:text-gray-400">{{ $equipment->supplier }}</p>
                            </div>
                        @endif

                        @if($equipment->warranty_period)
                            <div>
                                <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-1">Garansi</h4>
                                <p class="text-gray-600 dark:text-gray-400">
                                    {{ $equipment->warranty_period }}
                                    @if($equipment->warranty_until)
                                        <x-badge :variant="$equipment->is_under_warranty ? 'success' : 'danger'" size="sm" class="ml-2">
                                            {{ $equipment->is_under_warranty ? 'Berakhir' : 'Expired' }}
                                        </x-badge>
                                    @endif
                                </p>
                            </div>
                        @endif
                    </div>
                </x-card>
            </div>

            {{-- Maintenance & Calibration Schedule --}}
            <x-card title="Jadwal Maintenance & Kalibrasi">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Maintenance --}}
                    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                        <h4 class="font-semibold text-blue-900 dark:text-blue-100 mb-3">
                            <i class="fa fa-tools mr-2"></i> Maintenance
                        </h4>
                        <div class="space-y-2 text-sm">
                            @if($equipment->maintenance_interval_days)
                                <p class="text-blue-700 dark:text-blue-300">
                                    <span class="font-medium">Interval:</span> {{ $equipment->maintenance_interval_days }} hari
                                </p>
                            @endif
                            @if($equipment->last_maintenance)
                                <p class="text-blue-700 dark:text-blue-300">
                                    <span class="font-medium">Terakhir:</span> {{ $equipment->last_maintenance->format('d M Y') }}
                                </p>
                            @endif
                            @if($equipment->next_maintenance)
                                <p class="text-blue-700 dark:text-blue-300">
                                    <span class="font-medium">Berikutnya:</span> {{ $equipment->next_maintenance->format('d M Y') }}
                                    @if($equipment->is_maintenance_overdue)
                                        <x-badge variant="danger" size="sm" class="ml-2">Terlambat</x-badge>
                                    @elseif($equipment->days_until_maintenance !== null && $equipment->days_until_maintenance <= 7)
                                        <x-badge variant="warning" size="sm" class="ml-2">Segera</x-badge>
                                    @endif
                                </p>
                            @endif
                        </div>
                        <p class="text-xs text-blue-600 dark:text-blue-400 mt-3">
                            <i class="fa fa-info-circle mr-1"></i>
                            Fitur riwayat maintenance akan tersedia di Chapter 7B
                        </p>
                    </div>

                    {{-- Calibration --}}
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                        <h4 class="font-semibold text-green-900 dark:text-green-100 mb-3">
                            <i class="fa fa-check-circle mr-2"></i> Kalibrasi
                        </h4>
                        <div class="space-y-2 text-sm">
                            @if($equipment->calibration_interval_days)
                                <p class="text-green-700 dark:text-green-300">
                                    <span class="font-medium">Interval:</span> {{ $equipment->calibration_interval_days }} hari
                                </p>
                            @endif
                            @if($equipment->last_calibration)
                                <p class="text-green-700 dark:text-green-300">
                                    <span class="font-medium">Terakhir:</span> {{ $equipment->last_calibration->format('d M Y') }}
                                </p>
                            @endif
                            @if($equipment->next_calibration)
                                <p class="text-green-700 dark:text-green-300">
                                    <span class="font-medium">Berikutnya:</span> {{ $equipment->next_calibration->format('d M Y') }}
                                    @if($equipment->is_calibration_overdue)
                                        <x-badge variant="danger" size="sm" class="ml-2">Terlambat</x-badge>
                                    @elseif($equipment->days_until_calibration !== null && $equipment->days_until_calibration <= 7)
                                        <x-badge variant="warning" size="sm" class="ml-2">Segera</x-badge>
                                    @endif
                                </p>
                            @endif
                        </div>
                        <p class="text-xs text-green-600 dark:text-green-400 mt-3">
                            <i class="fa fa-info-circle mr-1"></i>
                            Fitur riwayat kalibrasi akan tersedia di Chapter 7B
                        </p>
                    </div>
                </div>
            </x-card>

            {{-- Usage Information --}}
            <x-card title="Informasi Penggunaan">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div>
                        <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-1">Jumlah Penggunaan</h4>
                        <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                            {{ $equipment->usage_count }} <span class="text-sm font-normal">kali</span>
                        </p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-700 dark:text-gray-300 mb-1">Jam Penggunaan</h4>
                        <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                            {{ $equipment->usage_hours }} <span class="text-sm font-normal">jam</span>
                        </p>
                    </div>
                </div>
            </x-card>

        </div>
    </div>
</x-app-layout>
```

---

## Equipment Seeder

### Langkah 1: Buat Seeder

```bash
php artisan make:seeder EquipmentSeeder
```

### Langkah 2: Edit Seeder File

**File**: `database/seeders/EquipmentSeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $labKimia = Laboratory::where('code', 'LAB-KIM-001')->first();
        $labBio = Laboratory::where('code', 'LAB-BIO-001')->first();
        $labFisika = Laboratory::where('code', 'LAB-FIS-001')->first();

        // Get sample users untuk assignment
        $laboran = User::whereHas('roles', function($q) {
            $q->where('name', 'Laboran');
        })->first();

        $equipment = [
            // Analytical Equipment
            [
                'name' => 'GC-MS',
                'code' => 'EQ-KIM-002',
                'laboratory_id' => $labKimia->id,
                'category' => 'analytical',
                'brand' => 'Agilent',
                'model' => '7890B-5977B',
                'serial_number' => 'HAAS-VF2-2022-345',
                'description' => 'Gas Chromatography-Mass Spectrometry untuk analisis senyawa organik volatil dan semi-volatil.',
                'photo' => null,
                'purchase_date' => Carbon::parse('2022-03-15'),
                'purchase_price' => 650000000,
                'supplier' => 'Haas Automation Anton Corp',
                'warranty_period' => '1 tahun',
                'warranty_until' => Carbon::parse('2023-03-15'),
                'condition' => 'good',
                'status' => 'in_use',
                'status_notes' => null,
                'last_maintenance' => Carbon::parse('2025-09-01'),
                'next_maintenance' => Carbon::parse('2025-12-01'),
                'maintenance_interval_days' => 90,
                'last_calibration' => Carbon::parse('2025-07-01'),
                'next_calibration' => Carbon::parse('2026-01-01'),
                'calibration_interval_days' => 180,
                'location_detail' => 'Area Machining CNC, Zona A',
                'assigned_to' => $laboran?->id,
                'usage_count' => 0,
                'usage_hours' => 0,
            ],
            [
                'name' => 'HPLC',
                'code' => 'EQ-KIM-003',
                'laboratory_id' => $labKimia->id,
                'category' => 'analytical',
                'brand' => 'Waters',
                'model' => 'Alliance e2695',
                'serial_number' => 'HAAS-VF2-2022-34312',
                'description' => 'High Performance Liquid Chromatography untuk pemisahan, identifikasi, dan kuantifikasi komponen dalam campuran.',
                'photo' => null,
                'purchase_date' => Carbon::parse('2023-05-20'),
                'purchase_price' => 550000000,
                'supplier' => 'Waters Indonesia',
                'warranty_period' => '2 tahun',
                'warranty_until' => Carbon::parse('2025-05-20'),
                'condition' => 'excellent',
                'status' => 'available',
                'status_notes' => null,
                'last_maintenance' => Carbon::parse('2025-08-15'),
                'next_maintenance' => Carbon::parse('2025-11-15'),
                'maintenance_interval_days' => 90,
                'last_calibration' => Carbon::parse('2025-06-01'),
                'next_calibration' => Carbon::parse('2025-12-01'),
                'calibration_interval_days' => 180,
                'location_detail' => 'Ruang Instrumentasi, Meja 2',
                'assigned_to' => null,
                'usage_count' => 0,
                'usage_hours' => 0,
            ],
            [
                'name' => 'Analytical Balance',
                'code' => 'EQ-KIM-004',
                'laboratory_id' => $labKimia->id,
                'category' => 'measurement',
                'brand' => 'Mettler Toledo',
                'model' => 'XPE205',
                'serial_number' => 'MT-XPE-2024-001',
                'description' => 'Neraca analitik presisi tinggi (0.01 mg) untuk penimbangan sampel analitis.',
                'photo' => null,
                'purchase_date' => Carbon::parse('2024-01-10'),
                'purchase_price' => 85000000,
                'supplier' => 'Mettler Toledo Indonesia',
                'warranty_period' => '3 tahun',
                'warranty_until' => Carbon::parse('2027-01-10'),
                'condition' => 'excellent',
                'status' => 'available',
                'status_notes' => null,
                'last_maintenance' => Carbon::parse('2025-09-20'),
                'next_maintenance' => Carbon::parse('2025-10-20'),
                'maintenance_interval_days' => 30,
                'last_calibration' => Carbon::parse('2025-09-20'),
                'next_calibration' => Carbon::parse('2025-10-20'),
                'calibration_interval_days' => 30,
                'location_detail' => 'Ruang Preparasi, Meja Anti-Vibrasi',
                'assigned_to' => null,
                'usage_count' => 0,
                'usage_hours' => 0,
            ],

            // Measurement Equipment
            [
                'name' => 'pH Meter',
                'code' => 'EQ-KIM-005',
                'laboratory_id' => $labKimia->id,
                'category' => 'measurement',
                'brand' => 'Hanna Instruments',
                'model' => 'HI5221',
                'serial_number' => 'HI-5221-2023-789',
                'description' => 'pH meter benchtop untuk pengukuran pH, mV, dan suhu dengan akurasi tinggi.',
                'photo' => null,
                'purchase_date' => Carbon::parse('2023-08-10'),
                'purchase_price' => 12000000,
                'supplier' => 'PT. Hanna Indonesia',
                'warranty_period' => '2 tahun',
                'warranty_until' => Carbon::parse('2025-08-10'),
                'condition' => 'good',
                'status' => 'available',
                'status_notes' => null,
                'last_maintenance' => Carbon::parse('2025-09-15'),
                'next_maintenance' => Carbon::parse('2025-10-15'),
                'maintenance_interval_days' => 30,
                'last_calibration' => Carbon::parse('2025-10-01'),
                'next_calibration' => Carbon::parse('2025-10-08'),
                'calibration_interval_days' => 7,
                'location_detail' => 'Ruang Analisis Umum, Rak 3',
                'assigned_to' => null,
                'usage_count' => 0,
                'usage_hours' => 0,
            ],

            // Preparation Equipment
            [
                'name' => 'Rotary Evaporator',
                'code' => 'EQ-KIM-006',
                'laboratory_id' => $labKimia->id,
                'category' => 'preparation',
                'brand' => 'Heidolph',
                'model' => 'Hei-VAP Value',
                'serial_number' => 'HD-VAP-2023-456',
                'description' => 'Rotary evaporator untuk pemekatan dan pengeringan sampel dengan metode evaporasi vakum.',
                'photo' => null,
                'purchase_date' => Carbon::parse('2023-11-20'),
                'purchase_price' => 45000000,
                'supplier' => 'PT. Scientific Indonesia',
                'warranty_period' => '1 tahun',
                'warranty_until' => Carbon::parse('2024-11-20'),
                'condition' => 'good',
                'status' => 'available',
                'status_notes' => null,
                'last_maintenance' => Carbon::parse('2025-07-01'),
                'next_maintenance' => Carbon::parse('2025-10-01'),
                'maintenance_interval_days' => 90,
                'last_calibration' => null,
                'next_calibration' => null,
                'calibration_interval_days' => null,
                'location_detail' => 'Ruang Preparasi, Fume Hood 2',
                'assigned_to' => null,
                'usage_count' => 0,
                'usage_hours' => 0,
            ],

            // Biology Lab Equipment
            [
                'name' => 'Autoclave',
                'code' => 'EQ-BIO-001',
                'laboratory_id' => $labBio->id,
                'category' => 'safety',
                'brand' => 'Hirayama',
                'model' => 'HV-110',
                'serial_number' => 'HRY-HV110-2022-123',
                'description' => 'Autoclave vertical 110 liter untuk sterilisasi alat dan media laboratorium.',
                'photo' => null,
                'purchase_date' => Carbon::parse('2022-09-15'),
                'purchase_price' => 35000000,
                'supplier' => 'PT. Lab Equipment Indonesia',
                'warranty_period' => '2 tahun',
                'warranty_until' => Carbon::parse('2024-09-15'),
                'condition' => 'good',
                'status' => 'maintenance',
                'status_notes' => 'Maintenance rutin: cek pressure gauge dan seal pintu',
                'last_maintenance' => Carbon::parse('2025-09-01'),
                'next_maintenance' => Carbon::parse('2025-10-01'),
                'maintenance_interval_days' => 30,
                'last_calibration' => Carbon::parse('2025-07-01'),
                'next_calibration' => Carbon::parse('2026-01-01'),
                'calibration_interval_days' => 180,
                'location_detail' => 'Ruang Sterilisasi',
                'assigned_to' => null,
                'usage_count' => 0,
                'usage_hours' => 0,
            ],
            [
                'name' => 'Microscope Olympus',
                'code' => 'EQ-BIO-002',
                'laboratory_id' => $labBio->id,
                'category' => 'analytical',
                'brand' => 'Olympus',
                'model' => 'CX23',
                'serial_number' => 'OLY-CX23-2024-567',
                'description' => 'Mikroskop binokuler untuk observasi sampel biologis dengan perbesaran hingga 1000x.',
                'photo' => null,
                'purchase_date' => Carbon::parse('2024-02-20'),
                'purchase_price' => 18000000,
                'supplier' => 'PT. Olympus Indonesia',
                'warranty_period' => '2 tahun',
                'warranty_until' => Carbon::parse('2026-02-20'),
                'condition' => 'excellent',
                'status' => 'available',
                'status_notes' => null,
                'last_maintenance' => Carbon::parse('2025-08-01'),
                'next_maintenance' => Carbon::parse('2025-11-01'),
                'maintenance_interval_days' => 90,
                'last_calibration' => null,
                'next_calibration' => null,
                'calibration_interval_days' => null,
                'location_detail' => 'Ruang Mikroskopi, Meja 1',
                'assigned_to' => null,
                'usage_count' => 0,
                'usage_hours' => 0,
            ],

            // Computer Equipment
            [
                'name' => 'Workstation PC',
                'code' => 'EQ-COMP-001',
                'laboratory_id' => $labKimia->id,
                'category' => 'computer',
                'brand' => 'Dell',
                'model' => 'Precision 3660',
                'serial_number' => 'DELL-3660-2024-789',
                'description' => 'Workstation untuk analisis data instrumentasi (GC-MS, HPLC) dengan software ChemStation.',
                'photo' => null,
                'purchase_date' => Carbon::parse('2024-03-10'),
                'purchase_price' => 25000000,
                'supplier' => 'PT. Dell Indonesia',
                'warranty_period' => '3 tahun',
                'warranty_until' => Carbon::parse('2027-03-10'),
                'condition' => 'excellent',
                'status' => 'available',
                'status_notes' => null,
                'last_maintenance' => Carbon::parse('2025-09-01'),
                'next_maintenance' => Carbon::parse('2025-12-01'),
                'maintenance_interval_days' => 90,
                'last_calibration' => null,
                'next_calibration' => null,
                'calibration_interval_days' => null,
                'location_detail' => 'Ruang Instrumentasi, Meja Operator GC-MS',
                'assigned_to' => $laboran?->id,
                'usage_count' => 0,
                'usage_hours' => 0,
            ],
        ];

        foreach ($equipment as $item) {
            Equipment::create($item);
        }

        $this->command->info('✅ Equipment seeded successfully!');
    }
}
```

### Langkah 3: Jalankan Seeder

```bash
php artisan db:seed --class=EquipmentSeeder
```

**Expected Output:**
```
✅ Equipment seeded successfully!
```

---

## Testing

### Manual Testing Checklist

#### 1. Index Page
- [ ] Akses `/equipment` - Lihat daftar equipment
- [ ] Test search box - Cari "GC-MS"
- [ ] Test filter laboratorium - Pilih Lab Kimia
- [ ] Test filter kategori - Pilih "Analitik"
- [ ] Test filter status - Pilih "Tersedia"
- [ ] Test filter kondisi - Pilih "Baik"
- [ ] Kombinasi filter - Multiple filters active
- [ ] Klik "Reset" - Filter cleared
- [ ] Test pagination - Next/Previous

#### 2. Create Equipment
- [ ] Akses `/equipment/create`
- [ ] Test form validation:
  - Submit form kosong → Error "Please fill out this field"
  - Input kode duplikat → Error "The code has already been taken"
  - Input serial number duplikat → Error "The serial number has already been taken"
- [ ] Test photo upload:
  - Upload file > 2MB → Error "The photo failed to upload"
  - Upload file non-image → Error
  - Upload JPG/PNG valid → Success
- [ ] Fill all fields dan submit
- [ ] Verify redirect ke show page
- [ ] Verify success message

#### 3. Edit Equipment
- [ ] Pilih equipment dan klik "Edit"
- [ ] Form pre-filled dengan data existing
- [ ] Ubah beberapa field
- [ ] Upload foto baru (optional)
- [ ] Submit dan verify update
- [ ] Verify old photo deleted (jika upload baru)

#### 4. Show Equipment
- [ ] Klik "Detail" pada salah satu equipment
- [ ] Verify semua informasi tampil:
  - Photo (atau placeholder)
  - Basic info (name, code, category, etc.)
  - Status & condition badges
  - Laboratory name
  - Purchase information
  - Maintenance schedule
  - Calibration schedule
  - Usage statistics
- [ ] Test "Edit" button → Navigate to edit page

#### 5. Delete Equipment
- [ ] Klik tombol delete (trash icon)
- [ ] Verify konfirmasi dialog muncul
- [ ] Klik "OK" → Equipment deleted
- [ ] Verify success message
- [ ] Verify photo file deleted dari storage

#### 6. Permissions
- [ ] Login sebagai role tanpa `view-equipment` → 403 Forbidden
- [ ] Login sebagai Laboran → Full access (view, create, edit, delete)
- [ ] Login sebagai Dosen → View only (no create/edit/delete buttons)

#### 7. Relationships
- [ ] Verify equipment terhubung dengan laboratory
- [ ] Verify assigned user tampil di detail page
- [ ] Delete laboratory → Equipment ikut terhapus (cascade)

---

## Troubleshooting

### Error: "Table 'equipment_maintenances' doesn't exist"

**Penyebab:** Controller eager loading relationship yang belum ada (Chapter 7B).

**Fix:**
```php
// EquipmentController@show
public function show(Equipment $equipment)
{
    // JANGAN load maintenanceRecords & calibrationRecords (belum ada)
    $equipment->load(['laboratory', 'assignedUser']);
    return view('equipment.show', compact('equipment'));
}
```

---

### Error: "Unable to locate a class or view for component [tab-button]"

**Penyebab:** View menggunakan component yang tidak ada.

**Fix:** Gunakan simple card layout, jangan pakai tabs. Lihat `show.blade.php` di tutorial ini.

---

### Error: Photo tidak muncul (orange placeholder terus)

**Penyebab:**
1. Foto tidak diupload saat create/edit
2. Storage symbolic link belum dibuat

**Fix:**
```bash
# Buat symbolic link
php artisan storage:link

# Test upload foto lagi saat create/edit
```

---

### Error: "The code has already been taken" saat create

**Penyebab:** Kode equipment sudah digunakan (unique constraint).

**Fix:** Gunakan kode yang berbeda (e.g., EQ-LAB-999).

---

### Filter tidak berfungsi

**Penyebab:** Form method atau route salah.

**Checklist:**
- Form method = `GET` (bukan POST)
- Form action = `{{ route('equipment.index') }}`
- Input name sesuai dengan request parameter di controller

---

## Summary

### Apa yang Sudah Dibangun?

✅ **Database:**
- Migration `create_equipment_table` dengan 30+ columns
- Soft deletes untuk history
- Relationships: Laboratory, User
- Indexes untuk performa query

✅ **Model:**
- Equipment model dengan fillable, casts, relationships
- 6 query scopes (available, inLaboratory, ofCategory, dll)
- 11 accessors untuk labels, badges, URL, dan boolean helpers

✅ **Controller:**
- CRUD lengkap dengan validation
- Multi-filter & search
- Photo upload/delete
- Pagination (12 items)

✅ **Views:**
- Index dengan filter form & equipment grid
- Create/Edit dengan form partials
- Show dengan card-based layout
- Semua menggunakan Chapter 5 components

✅ **Seeder:**
- 8 sample equipment dari 3 lab berbeda
- Kategori: analytical, measurement, preparation, safety, computer

✅ **Testing:**
- ✅ Index page dengan multi-filter
- ✅ Create equipment dengan upload foto
- ✅ Edit equipment
- ✅ Show equipment
- ✅ Delete equipment dengan konfirmasi
- ✅ Form validation (required, unique, file upload)

### Key Learnings

1. **Component Consistency:** Gunakan Chapter 5 components untuk UI consistency
2. **Accessor Pattern:** Laravel accessors sangat powerful untuk transformasi data
3. **Scope Pattern:** Query scopes membuat filtering lebih clean dan reusable
4. **SVG Placeholder:** Inline SVG data URI untuk placeholder yang tidak perlu file
5. **Soft Deletes:** Preserve equipment history dengan soft deletes

### Next Steps (Chapter 7B - Optional)

Chapter 7B akan menambahkan:
- Equipment Maintenance records (table + CRUD)
- Equipment Calibration records (table + CRUD)
- Maintenance history tracking
- Calibration history tracking
- Automated maintenance/calibration reminders
- Equipment usage logging

**Note:** Chapter 7B adalah opsional. Untuk saat ini, Equipment Management sudah bisa digunakan untuk operasional dasar.

---

**Tutorial Created:** 9 Oktober 2025
**Laravel Version:** 12.32.5
**Chapter Status:** ✅ COMPLETED & TESTED
