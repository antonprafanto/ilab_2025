# iLab UNMUL - Tutorial Chapter 6: Laboratory Management

## Daftar Isi
1. [Pendahuluan](#pendahuluan)
2. [Database Migration](#database-migration)
3. [Laboratory Model](#laboratory-model)
4. [Laboratory Controller](#laboratory-controller)
5. [Routes](#routes)
6. [Views](#views)
   - [Index View](#index-view)
   - [Create & Edit Views](#create--edit-views)
   - [Show View](#show-view)
7. [Laboratory Seeder](#laboratory-seeder)
8. [Testing](#testing)
9. [Troubleshooting](#troubleshooting)
10. [Summary](#summary)

---

## Pendahuluan

**Chapter 6** membangun fitur manajemen laboratorium yang merupakan core module dari iLab UNMUL. Laboratorium adalah entitas utama yang akan menjadi basis untuk equipment, services, dan bookings di chapter-chapter selanjutnya.

**Fitur yang Dibangun:**
- ✅ CRUD Laboratorium (Create, Read, Update, Delete)
- ✅ Photo upload dengan preview
- ✅ Search & filter (type, status, keyword)
- ✅ Operating hours & days management
- ✅ Kepala Lab assignment
- ✅ Facilities & certifications tracking
- ✅ Status management (active, maintenance, closed)
- ✅ Soft delete untuk history

**Tech Stack:**
- Laravel 12 (Eloquent ORM, File Storage)
- Blade Components (dari Chapter 5)
- Alpine.js (untuk interactivity)
- Tailwind CSS v4 (styling)

---

## Database Migration

### Langkah 1: Buat Migration

```bash
php artisan make:migration create_laboratories_table
```

### Langkah 2: Edit Migration File

**File**: `database/migrations/YYYY_MM_DD_HHMMSS_create_laboratories_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laboratories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama laboratorium
            $table->string('code', 50)->unique(); // Kode lab (LAB-KIM-001)
            $table->enum('type', [
                'chemistry',
                'biology',
                'physics',
                'geology',
                'engineering',
                'computer',
                'other'
            ]); // 7 types sesuai spec
            $table->text('description')->nullable(); // Deskripsi lab
            $table->string('location')->nullable(); // Lokasi fisik
            $table->decimal('area_sqm', 8, 2)->nullable(); // Luas ruangan (m²)
            $table->integer('capacity')->nullable(); // Kapasitas orang
            $table->string('photo')->nullable(); // Foto lab

            // Kepala Lab (FK ke users table)
            $table->foreignId('head_user_id')->nullable()->constrained('users')->nullOnDelete();

            // Contact info
            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();

            // Operating hours
            $table->time('operating_hours_start')->nullable();
            $table->time('operating_hours_end')->nullable();
            $table->json('operating_days')->nullable(); // ["Monday", "Tuesday", ...]

            // Status
            $table->enum('status', ['active', 'maintenance', 'closed'])->default('active');
            $table->text('status_notes')->nullable();

            // Metadata
            $table->json('facilities')->nullable(); // Fasilitas lab
            $table->json('certifications')->nullable(); // Sertifikasi lab

            $table->timestamps();
            $table->softDeletes(); // Soft delete untuk history

            // Indexes
            $table->index('type');
            $table->index('status');
            $table->index('head_user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laboratories');
    }
};
```

### Langkah 3: Run Migration

```bash
php artisan migrate
```

**Expected Output:**
```
INFO  Running migrations.

2025_10_02_070034_create_laboratories_table ................... 69.47ms DONE
```

---

## Laboratory Model

### Langkah 1: Buat Model

```bash
php artisan make:model Laboratory
```

### Langkah 2: Edit Model

**File**: `app/Models/Laboratory.php`

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laboratory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'type',
        'description',
        'location',
        'area_sqm',
        'capacity',
        'photo',
        'head_user_id',
        'phone',
        'email',
        'operating_hours_start',
        'operating_hours_end',
        'operating_days',
        'status',
        'status_notes',
        'facilities',
        'certifications',
    ];

    protected $casts = [
        'operating_days' => 'array',
        'facilities' => 'array',
        'certifications' => 'array',
        'operating_hours_start' => 'datetime',
        'operating_hours_end' => 'datetime',
        'area_sqm' => 'decimal:2',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the head/kepala lab user
     */
    public function headUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'head_user_id');
    }

    /**
     * Get equipment in this laboratory (Chapter 7)
     */
    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }

    /**
     * Get services provided by this laboratory (Chapter 9)
     */
    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Scope for active laboratories
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope filter by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get lab type label
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'chemistry' => 'Kimia',
            'biology' => 'Biologi',
            'physics' => 'Fisika',
            'geology' => 'Geologi',
            'engineering' => 'Teknik',
            'computer' => 'Komputer',
            'other' => 'Lainnya',
            default => $this->type,
        };
    }

    /**
     * Get status badge variant
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'active' => 'success',
            'maintenance' => 'warning',
            'closed' => 'danger',
            default => 'default',
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active' => 'Aktif',
            'maintenance' => 'Maintenance',
            'closed' => 'Tutup',
            default => $this->status,
        };
    }

    /**
     * Get photo URL with SVG placeholder
     *
     * IMPORTANT: Menggunakan inline SVG data URI untuk placeholder
     * karena external service (via.placeholder.com) sering tidak bisa diakses
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }

        // Return inline SVG data URI sebagai placeholder
        return 'data:image/svg+xml;base64,' . base64_encode('
            <svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
                <rect width="400" height="300" fill="#0066CC"/>
                <text x="50%" y="50%" text-anchor="middle" dy=".3em" fill="white" font-family="Arial, sans-serif" font-size="24" font-weight="bold">
                    Lab Photo
                </text>
            </svg>
        ');
    }
}
```

**Key Features Model:**
- ✅ **Soft Deletes**: History tetap tersimpan
- ✅ **Relationships**: headUser, equipment, services
- ✅ **Scopes**: active(), ofType()
- ✅ **Accessors**: type_label, status_badge, status_label, photo_url
- ✅ **JSON Casts**: operating_days, facilities, certifications

---

## Laboratory Controller

### Langkah 1: Buat Controller

```bash
php artisan make:controller LaboratoryController --resource
```

### Langkah 2: Edit Controller

**File**: `app/Http/Controllers/LaboratoryController.php`

```php
<?php

namespace App\Http\Controllers;

use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaboratoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Laboratory::with('headUser');

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $laboratories = $query->latest()->paginate(12);

        return view('laboratories.index', compact('laboratories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::role('Kepala Lab')->get();
        return view('laboratories.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:laboratories,code',
            'type' => 'required|in:chemistry,biology,physics,geology,engineering,computer,other',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'area_sqm' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'head_user_id' => 'nullable|exists:users,id',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'operating_hours_start' => 'nullable|date_format:H:i',
            'operating_hours_end' => 'nullable|date_format:H:i',
            'operating_days' => 'nullable|array',
            'status' => 'required|in:active,maintenance,closed',
            'status_notes' => 'nullable|string',
            'facilities' => 'nullable|array',
            'certifications' => 'nullable|array',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('laboratories', 'public');
        }

        $laboratory = Laboratory::create($validated);

        return redirect()->route('laboratories.show', $laboratory)
            ->with('success', 'Laboratorium berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Laboratory $laboratory)
    {
        $laboratory->load('headUser');
        return view('laboratories.show', compact('laboratory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laboratory $laboratory)
    {
        $users = User::role('Kepala Lab')->get();
        return view('laboratories.edit', compact('laboratory', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laboratory $laboratory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:laboratories,code,' . $laboratory->id,
            'type' => 'required|in:chemistry,biology,physics,geology,engineering,computer,other',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'area_sqm' => 'nullable|numeric|min:0',
            'capacity' => 'nullable|integer|min:0',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'head_user_id' => 'nullable|exists:users,id',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'operating_hours_start' => 'nullable|date_format:H:i',
            'operating_hours_end' => 'nullable|date_format:H:i',
            'operating_days' => 'nullable|array',
            'status' => 'required|in:active,maintenance,closed',
            'status_notes' => 'nullable|string',
            'facilities' => 'nullable|array',
            'certifications' => 'nullable|array',
        ]);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($laboratory->photo) {
                Storage::disk('public')->delete($laboratory->photo);
            }
            $validated['photo'] = $request->file('photo')->store('laboratories', 'public');
        }

        $laboratory->update($validated);

        return redirect()->route('laboratories.show', $laboratory)
            ->with('success', 'Laboratorium berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Laboratory $laboratory)
    {
        // Delete photo
        if ($laboratory->photo) {
            Storage::disk('public')->delete($laboratory->photo);
        }

        $laboratory->delete();

        return redirect()->route('laboratories.index')
            ->with('success', 'Laboratorium berhasil dihapus!');
    }
}
```

---

## Routes

**File**: `routes/web.php`

```php
use App\Http\Controllers\LaboratoryController;

// Laboratory Management
Route::middleware('auth')->group(function () {
    Route::resource('laboratories', LaboratoryController::class);
});
```

**Routes yang dibuat:**
```
GET    /laboratories              - index (list)
GET    /laboratories/create       - create form
POST   /laboratories              - store
GET    /laboratories/{id}         - show (detail)
GET    /laboratories/{id}/edit    - edit form
PUT    /laboratories/{id}         - update
DELETE /laboratories/{id}         - destroy
```

---

## Views

### Index View

**File**: `resources/views/laboratories/index.blade.php`

Fitur utama:
- Grid layout (3 kolom di desktop, 2 di tablet, 1 di mobile)
- Search & filter form
- Card dengan photo, info, badges
- Pagination
- Empty state

**Komponen yang digunakan (Chapter 5):**
- `<x-card>` - Container
- `<x-button>` - Action buttons
- `<x-badge>` - Status & type badges
- `<x-alert>` - Success notifications
- `<x-input>` - Search field
- `<x-select>` - Filter dropdowns

### Create & Edit Views

**Files**:
- `resources/views/laboratories/create.blade.php`
- `resources/views/laboratories/edit.blade.php`
- `resources/views/laboratories/partials/form.blade.php` (shared)

Form fields:
- Basic info (nama, kode, tipe, status)
- Description (textarea dengan counter)
- Location & capacity
- Photo upload (dengan preview)
- Kepala lab (select dari users)
- Contact (telepon, email)
- Operating hours & days
- Status notes (conditional)

**Komponen yang digunakan:**
- `<x-input>` - Text inputs
- `<x-textarea>` - Description dengan character counter
- `<x-select>` - Dropdowns
- `<x-checkbox>` - Operating days
- `<x-file-upload>` - Photo upload dengan preview
- `<x-button>` - Submit & cancel

### Show View

**File**: `resources/views/laboratories/show.blade.php`

Fitur:
- Photo display
- All lab information
- Contact info (clickable)
- Operating hours & days
- Tabs (Info, Equipment, Services)
- Edit & delete buttons

**Komponen yang digunakan:**
- `<x-card>` - Info containers
- `<x-badge>` - Status & type
- `<x-tabs>` & `<x-tab-content>` - Tab navigation
- `<x-alert>` - Status notes
- `<x-button>` - Actions

---

## Laboratory Seeder

### Langkah 1: Buat Seeder

```bash
php artisan make:seeder LaboratorySeeder
```

### Langkah 2: Edit Seeder

**File**: `database/seeders/LaboratorySeeder.php`

```php
<?php

namespace Database\Seeders;

use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Database\Seeder;

class LaboratorySeeder extends Seeder
{
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
            // ... 6 more labs (see full code in LaboratorySeeder.php)
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
```

### Langkah 3: Run Seeder

```bash
php artisan db:seed --class=LaboratorySeeder
```

**Expected Output:**
```
INFO  Seeding database.
```

**Seeder akan membuat 7 laboratorium:**
1. Lab. Kimia Analitik (Active)
2. Lab. Biologi Molekuler (Active)
3. Lab. Fisika Komputasi (Active)
4. Lab. Geologi Batuan & Mineral (Active)
5. Lab. Teknik Mesin (Active)
6. Lab. Jaringan Komputer (Active)
7. Lab. Freeze Dryer (Maintenance) ⭐

---

## Testing

### Testing Checklist

**1. Index Page** (`/laboratories`)
- [ ] List tampil dengan grid layout
- [ ] Filter type berfungsi
- [ ] Filter status berfungsi
- [ ] Search berfungsi
- [ ] Reset filter berfungsi
- [ ] Photo placeholder SVG tampil
- [ ] Badges warna sesuai status
- [ ] Pagination berfungsi

**2. Create Page** (`/laboratories/create`)
- [ ] Form lengkap tampil
- [ ] Validation berfungsi (required, unique, max size)
- [ ] Photo upload dengan preview
- [ ] Kepala lab dropdown populated
- [ ] Operating days checkboxes
- [ ] Status notes muncul conditional
- [ ] Submit berhasil create

**3. Show Page** (`/laboratories/{id}`)
- [ ] Detail lengkap tampil
- [ ] Photo display (atau placeholder)
- [ ] Badges status & type
- [ ] Tabs berfungsi
- [ ] Alert status notes (jika maintenance/closed)
- [ ] Edit & delete buttons

**4. Edit Page** (`/laboratories/{id}/edit`)
- [ ] Form ter-populate dengan data existing
- [ ] Photo existing tampil
- [ ] Update berhasil
- [ ] Validation unique code (kecuali lab sendiri)

**5. Delete**
- [ ] Konfirmasi muncul
- [ ] Delete berhasil (soft delete)
- [ ] Photo terhapus dari storage
- [ ] Redirect ke index

**6. Photo Upload**
- [ ] Upload berfungsi
- [ ] Preview tampil
- [ ] Tersimpan di `storage/app/public/laboratories/`
- [ ] Photo lama terhapus saat upload baru

---

## Troubleshooting

### Error 1: "Undefined constant activeTab" di Tabs Component

**Problem:** Alpine.js variable `activeTab` tidak bisa diakses di child component.

**Solution:** Gunakan `$parent.activeTab` di `tab-content.blade.php`:

```blade
<div x-show="$parent.activeTab === '{{ $id }}'" ...>
```

### Error 2: Photo Placeholder Loading Terus

**Problem:** External service `via.placeholder.com` tidak bisa diakses (DNS error).

**Solution:** Gunakan inline SVG data URI di model accessor:

```php
public function getPhotoUrlAttribute(): string
{
    if ($this->photo) {
        return asset('storage/' . $this->photo);
    }

    // Inline SVG placeholder
    return 'data:image/svg+xml;base64,' . base64_encode('
        <svg width="400" height="300" xmlns="http://www.w3.org/2000/svg">
            <rect width="400" height="300" fill="#0066CC"/>
            <text x="50%" y="50%" text-anchor="middle" dy=".3em" fill="white" font-family="Arial, sans-serif" font-size="24" font-weight="bold">
                Lab Photo
            </text>
        </svg>
    ');
}
```

Remove `onerror` attribute dari `<img>` tag di views.

### Error 3: Storage Link Not Found

**Problem:** Photo upload error "The file could not be found".

**Solution:** Buat symbolic link:

```bash
php artisan storage:link
```

### Error 4: Validation Error "The code has already been taken" saat Edit

**Problem:** Unique validation tidak mengecualikan record sendiri.

**Solution:** Gunakan unique dengan ignore:

```php
'code' => 'required|string|max:50|unique:laboratories,code,' . $laboratory->id,
```

---

## Summary Chapter 6

**Yang Sudah Dibuat:**
✅ **Database**: Migration laboratories table (20+ fields, soft deletes)
✅ **Model**: Laboratory dengan relationships, scopes, accessors
✅ **Controller**: Full CRUD + photo upload/delete + search/filter
✅ **Routes**: Resource routes (`/laboratories/*`)
✅ **Views**: Index, Create, Edit, Show, Form partial (menggunakan komponen Chapter 5)
✅ **Seeder**: 7 laboratorium sample data
✅ **Testing**: All features tested & working

**Files Created:**
```
database/migrations/..._create_laboratories_table.php
app/Models/Laboratory.php
app/Http/Controllers/LaboratoryController.php
resources/views/laboratories/index.blade.php
resources/views/laboratories/create.blade.php
resources/views/laboratories/edit.blade.php
resources/views/laboratories/show.blade.php
resources/views/laboratories/partials/form.blade.php
database/seeders/LaboratorySeeder.php
routes/web.php (updated)
```

**Key Features:**
1. ✅ Photo upload dengan preview & validation
2. ✅ Search & filter (type, status, keyword)
3. ✅ Operating hours & days management
4. ✅ Kepala Lab assignment
5. ✅ Status management (active, maintenance, closed)
6. ✅ Facilities & certifications tracking
7. ✅ Soft delete untuk history
8. ✅ Beautiful UI dengan UNMUL branding
9. ✅ Responsive design (mobile, tablet, desktop)
10. ✅ Dark mode support

**Database Schema:**
- **laboratories** table: 20+ columns
- **Relationships**: belongsTo User (head_user_id)
- **Future relationships**: hasMany Equipment, hasMany Services

**Next Chapter (Chapter 7): Equipment Management**
- Create equipment table & model
- Equipment CRUD operations
- Maintenance tracking
- Calibration tracking
- Equipment calendar
- Photo upload
- Relationship dengan Laboratory

---

**iLab UNMUL - Innovation Laboratory Management System**
*Universitas Mulawarman, Samarinda, Kalimantan Timur*
