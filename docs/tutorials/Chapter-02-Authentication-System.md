# Chapter 02: Authentication System dengan Role-Based Access

**Durasi:** 45-60 menit
**Level:** Beginner-Intermediate

## 🎯 Tujuan Pembelajaran

Setelah menyelesaikan chapter ini, Anda akan mampu:
- Menginstall dan mengkonfigurasi Laravel Breeze
- Membuat sistem role dengan 11 jenis pengguna iLab UNMUL
- Menambahkan field tambahan pada user registration
- Mengustomisasi tampilan authentication dengan branding UNMUL
- Memahami relationship antara User dan Role

## 📋 Prasyarat

- Chapter 1 sudah selesai (Laravel 12 + Tailwind CSS v4 terinstall)
- MariaDB server berjalan
- Composer dan NPM terinstall

## 🚀 Step-by-Step Tutorial

### Step 1: Install Laravel Breeze

Laravel Breeze adalah starter kit authentication yang ringan dan sederhana.

```bash
# Install Laravel Breeze
composer require laravel/breeze:^2.3

# Install Breeze dengan Blade stack dan dark mode
php artisan breeze:install blade --dark

# Install dependencies dan build assets
npm install && npm run build
```

**Penjelasan:**
- `laravel/breeze` - Package authentication starter kit
- `blade` - Menggunakan Blade template engine
- `--dark` - Mendukung dark mode

**Output yang diharapkan:**
```
Breeze scaffolding installed successfully.
```

---

### Step 2: Membuat Migration untuk Roles Table

Kita akan membuat tabel `roles` untuk menyimpan 11 jenis pengguna iLab UNMUL.

```bash
php artisan make:migration create_roles_table
```

Edit file migration yang dibuat di `database/migrations/xxxx_create_roles_table.php`:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);        // Nama role (Super Admin / Direktur)
            $table->string('slug', 100)->unique(); // Slug untuk checking (super-admin)
            $table->text('description')->nullable(); // Deskripsi role
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
```

**Penjelasan struktur tabel:**
- `id` - Primary key
- `name` - Nama role yang user-friendly
- `slug` - Unique identifier untuk role checking
- `description` - Penjelasan tentang role

---

### Step 3: Menambahkan role_id ke Users Table

Kita perlu menghubungkan users dengan roles menggunakan foreign key.

```bash
php artisan make:migration add_role_id_to_users_table
```

Edit migration file:

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menambahkan role_id setelah email
            $table->foreignId('role_id')
                  ->nullable()
                  ->after('email')
                  ->constrained('roles')
                  ->nullOnDelete();

            // Field tambahan untuk user profile
            $table->string('phone', 20)->nullable()->after('email');
            $table->text('address')->nullable()->after('phone');
            $table->string('institution', 255)->nullable()->after('address');
            $table->string('nip_nim', 50)->nullable()->after('institution');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn(['role_id', 'phone', 'address', 'institution', 'nip_nim']);
        });
    }
};
```

**Penjelasan:**
- `role_id` - Foreign key ke tabel roles
- `nullOnDelete()` - Jika role dihapus, user tidak ikut terhapus (role_id = NULL)
- `phone`, `address`, `institution`, `nip_nim` - Data tambahan user

---

### Step 4: Membuat Role Model

```bash
php artisan make:model Role
```

Edit `app/Models/Role.php`:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    /**
     * Relasi: Satu role memiliki banyak users
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
```

---

### Step 5: Update User Model

Edit `app/Models/User.php` untuk menambahkan relationship dan helper methods:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',      // ← Tambahkan
        'phone',        // ← Tambahkan
        'address',      // ← Tambahkan
        'institution',  // ← Tambahkan
        'nip_nim',      // ← Tambahkan
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi: User belongs to Role
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Helper: Cek apakah user memiliki role tertentu
     */
    public function hasRole(string $roleSlug): bool
    {
        return $this->role?->slug === $roleSlug;
    }

    /**
     * Helper: Cek apakah user memiliki salah satu dari roles
     */
    public function hasAnyRole(array $roleSlugs): bool
    {
        return in_array($this->role?->slug, $roleSlugs);
    }
}
```

**Helper Methods Explanation:**
- `hasRole('super-admin')` - Cek apakah user adalah Super Admin
- `hasAnyRole(['dosen', 'mahasiswa'])` - Cek apakah user adalah Dosen ATAU Mahasiswa

---

### Step 6: Membuat Role Seeder

Kita akan seed 11 roles sesuai struktur iLab UNMUL.

```bash
php artisan make:seeder RoleSeeder
```

Edit `database/seeders/RoleSeeder.php`:

```php
<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin / Direktur',
                'slug' => 'super-admin',
                'description' => 'Akses penuh ke seluruh sistem, mengelola semua aspek operasional iLab'
            ],
            [
                'name' => 'Wakil Direktur Pelayanan',
                'slug' => 'wakil-direktur-pelayanan',
                'description' => 'Mengelola operasional pelayanan, approval request, monitoring SLA'
            ],
            [
                'name' => 'Wakil Direktur Penjaminan Mutu & TI',
                'slug' => 'wakil-direktur-pmti',
                'description' => 'Mengelola kualitas layanan, kalibrasi, IT infrastructure'
            ],
            [
                'name' => 'Kepala Lab/Unit',
                'slug' => 'kepala-lab',
                'description' => 'Mengelola operasional lab/unit, approval internal, monitoring usage'
            ],
            [
                'name' => 'Anggota Lab/Unit (Analyst/Researcher)',
                'slug' => 'anggota-lab',
                'description' => 'Melakukan testing, input hasil, update status request'
            ],
            [
                'name' => 'Laboran (Technician)',
                'slug' => 'laboran',
                'description' => 'Maintenance alat, input usage log, teknisi lapangan'
            ],
            [
                'name' => 'Sub Bagian TU & Keuangan',
                'slug' => 'sub-bagian-tu-keuangan',
                'description' => 'Mengelola invoicing, payment tracking, reporting keuangan'
            ],
            [
                'name' => 'Dosen (Faculty)',
                'slug' => 'dosen',
                'description' => 'Request layanan untuk penelitian, lihat history & invoice'
            ],
            [
                'name' => 'Mahasiswa (Student)',
                'slug' => 'mahasiswa',
                'description' => 'Request layanan untuk tugas akhir/penelitian dengan approval dosen'
            ],
            [
                'name' => 'Peneliti Eksternal',
                'slug' => 'peneliti-eksternal',
                'description' => 'Peneliti dari luar UNMUL yang menggunakan fasilitas iLab'
            ],
            [
                'name' => 'Industri/Masyarakat Umum',
                'slug' => 'industri-umum',
                'description' => 'Partner industri atau masyarakat umum yang request layanan'
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $this->command->info('✅ 11 roles created successfully for iLab UNMUL!');
    }
}
```

---

### Step 7: Update DatabaseSeeder

Edit `database/seeders/DatabaseSeeder.php`:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,  // ← Tambahkan ini
        ]);
    }
}
```

---

### Step 8: Jalankan Migrations dan Seeders

```bash
php artisan migrate:fresh --seed
```

**Output yang diharapkan:**
```
Dropped all tables successfully.
Migration table created successfully.
Migrating: 2014_10_12_000000_create_users_table
Migrated:  2014_10_12_000000_create_users_table
...
Migrating: xxxx_create_roles_table
Migrated:  xxxx_create_roles_table
Migrating: xxxx_add_role_id_to_users_table
Migrated:  xxxx_add_role_id_to_users_table

Seeding: Database\Seeders\RoleSeeder
✅ 11 roles created successfully for iLab UNMUL!
Seeded:  Database\Seeders\RoleSeeder
```

---

### Step 9: Update Registration Controller

Edit `app/Http/Controllers/Auth/RegisteredUserController.php`:

```php
<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;  // ← Tambahkan
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $roles = Role::orderBy('name')->get();  // ← Tambahkan
        return view('auth.register', compact('roles'));  // ← Update
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],  // ← Tambahkan
            'phone' => ['nullable', 'string', 'max:20'],    // ← Tambahkan
            'address' => ['nullable', 'string'],            // ← Tambahkan
            'institution' => ['nullable', 'string', 'max:255'], // ← Tambahkan
            'nip_nim' => ['nullable', 'string', 'max:50'],  // ← Tambahkan
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,        // ← Tambahkan
            'phone' => $request->phone,            // ← Tambahkan
            'address' => $request->address,        // ← Tambahkan
            'institution' => $request->institution, // ← Tambahkan
            'nip_nim' => $request->nip_nim,        // ← Tambahkan
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
```

---

### Step 10: Update Registration View

Edit `resources/views/auth/register.blade.php`:

```blade
<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role_id" :value="__('Jenis Pengguna')" />
            <select id="role_id" name="role_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required>
                <option value="">Pilih Jenis Pengguna</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Nomor Telepon')" />
            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Institution -->
        <div class="mt-4">
            <x-input-label for="institution" :value="__('Institusi/Organisasi')" />
            <x-text-input id="institution" class="block mt-1 w-full" type="text" name="institution" :value="old('institution')" autocomplete="organization" />
            <x-input-error :messages="$errors->get('institution')" class="mt-2" />
        </div>

        <!-- NIP/NIM -->
        <div class="mt-4">
            <x-input-label for="nip_nim" :value="__('NIP/NIM (jika ada)')" />
            <x-text-input id="nip_nim" class="block mt-1 w-full" type="text" name="nip_nim" :value="old('nip_nim')" />
            <x-input-error :messages="$errors->get('nip_nim')" class="mt-2" />
        </div>

        <!-- Address -->
        <div class="mt-4">
            <x-input-label for="address" :value="__('Alamat')" />
            <textarea id="address" name="address" rows="3" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('address') }}</textarea>
            <x-input-error :messages="$errors->get('address')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Sudah punya akun?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Daftar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
```

---

### Step 11: Apply UNMUL Branding

**a) Update Guest Layout**

Edit `resources/views/layouts/guest.blade.php`:

```blade
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="text-center mb-6">
                <a href="/" class="inline-block">
                    <x-application-logo class="w-20 h-20 fill-current text-[--color-unmul-blue]" />
                </a>
                <h1 class="mt-4 text-2xl font-bold text-[--color-unmul-blue] dark:text-white">iLab UNMUL</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Pusat Unggulan Studi Tropis</p>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-500">Universitas Mulawarman</p>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
```

**b) Update Login View**

Edit `resources/views/auth/login.blade.php` - tambahkan link register di bagian bawah form:

```blade
<!-- Tambahkan sebelum closing </form> -->
<div class="mt-4 text-center">
    <p class="text-sm text-gray-600 dark:text-gray-400">
        Belum punya akun?
        <a href="{{ route('register') }}" class="underline text-[--color-unmul-blue] hover:text-[--color-innovation-orange] dark:text-[--color-unmul-blue] dark:hover:text-[--color-innovation-orange]">
            Daftar sekarang
        </a>
    </p>
</div>
```

Juga update text ke Bahasa Indonesia:
- "Remember me" → "Ingat saya"
- "Forgot your password?" → "Lupa password?"
- "Log in" → "Masuk"

**c) Update Primary Button dengan UNMUL Colors**

Edit `resources/views/components/primary-button.blade.php`:

```blade
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[--color-unmul-blue] dark:bg-[--color-unmul-blue] border border-transparent rounded-md font-semibold text-xs text-white dark:text-white uppercase tracking-widest hover:bg-[--color-tropical-green] dark:hover:bg-[--color-tropical-green] focus:bg-[--color-tropical-green] dark:focus:bg-[--color-tropical-green] active:bg-[--color-innovation-orange] dark:active:bg-[--color-innovation-orange] focus:outline-none focus:ring-2 focus:ring-[--color-unmul-blue] focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
```

**UNMUL Color States:**
- Normal: UNMUL Blue (#0066CC)
- Hover: Tropical Green (#4CAF50)
- Active: Innovation Orange (#FF9800)

---

### Step 12: Testing Authentication Flow

```bash
# Start development server
php artisan serve
```

**Test Checklist:**

1. ✅ **Test Registration** (http://127.0.0.1:8000/register)
   - Buka form registrasi
   - Klik dropdown "Jenis Pengguna" → pastikan 11 roles muncul
   - Isi semua field (nama, email, role, phone, institution, nip_nim, alamat, password)
   - Submit → harus redirect ke dashboard

2. ✅ **Test Login** (http://127.0.0.1:8000/login)
   - Login dengan kredensial yang baru dibuat
   - Test checkbox "Ingat saya"
   - Test link "Lupa password?"
   - Pastikan redirect ke dashboard berhasil

3. ✅ **Test Dashboard** (http://127.0.0.1:8000/dashboard)
   - Pastikan nama user tampil di header
   - Pastikan dropdown Profile & Log Out berfungsi
   - Test logout

4. ✅ **Test Branding**
   - Pastikan logo dan tagline "Pusat Unggulan Studi Tropis" tampil
   - Pastikan button menggunakan UNMUL colors (blue → green → orange)
   - Test dark mode compatibility

---

## 🎨 UNMUL Branding Colors

Pastikan menggunakan CSS variables dari Chapter 1:

```css
/* resources/css/app.css */
@theme {
  --color-unmul-blue: #0066cc;
  --color-innovation-orange: #ff9800;
  --color-tropical-green: #4caf50;
}
```

**Penggunaan di Tailwind:**
- Background: `bg-[--color-unmul-blue]`
- Text: `text-[--color-unmul-blue]`
- Border: `border-[--color-unmul-blue]`

---

## 📊 Database Structure

**Tabel: roles**
```
id | name                          | slug                      | description
---|-------------------------------|---------------------------|-------------
1  | Super Admin / Direktur        | super-admin               | Akses penuh...
2  | Wakil Direktur Pelayanan      | wakil-direktur-pelayanan  | Mengelola...
...
```

**Tabel: users**
```
id | name | email | role_id | phone | institution | nip_nim | address
---|------|-------|---------|-------|-------------|---------|--------
1  | ...  | ...   | 1       | ...   | ...         | ...     | ...
```

**Relationship:**
- `users.role_id` → `roles.id` (Foreign Key)
- 1 Role has Many Users
- 1 User belongs to 1 Role

---

## 🔐 Menggunakan Role Checking

**Di Controller:**
```php
// Cek single role
if ($user->hasRole('super-admin')) {
    // Logic untuk Super Admin
}

// Cek multiple roles
if ($user->hasAnyRole(['dosen', 'mahasiswa'])) {
    // Logic untuk Dosen atau Mahasiswa
}
```

**Di Blade:**
```blade
@if(auth()->user()->hasRole('super-admin'))
    <p>Welcome, Super Admin!</p>
@endif

@if(auth()->user()->hasAnyRole(['kepala-lab', 'anggota-lab']))
    <p>Welcome, Lab Staff!</p>
@endif
```

---

## 🐛 Troubleshooting

### Error: "Class 'Role' not found"
**Solusi:** Pastikan import `use App\Models\Role;` di controller

### Error: "SQLSTATE[23000]: Integrity constraint violation"
**Solusi:** Pastikan role_id yang disubmit ada di tabel roles

### Error: "Undefined variable $roles"
**Solusi:** Pastikan `compact('roles')` sudah ditambahkan di RegisteredUserController::create()

### Dropdown roles tidak muncul
**Solusi:**
1. Cek apakah seeder sudah dijalankan: `SELECT * FROM roles;`
2. Pastikan `$roles` di-pass ke view
3. Clear view cache: `php artisan view:clear`

### Button tidak menggunakan UNMUL colors
**Solusi:**
1. Pastikan CSS variables sudah defined di `resources/css/app.css`
2. Rebuild assets: `npm run build`
3. Hard refresh browser (Ctrl+Shift+R)

---

## ✅ Chapter 2 Checklist

Pastikan semua langkah berikut sudah selesai:

- [x] Laravel Breeze terinstall
- [x] Migration `roles` table created
- [x] Migration `add_role_id_to_users_table` created
- [x] Role model dengan relationship created
- [x] User model updated dengan role relationship
- [x] RoleSeeder dengan 11 roles created
- [x] DatabaseSeeder updated
- [x] Migrations & seeders berhasil dijalankan
- [x] RegisteredUserController updated (create & store methods)
- [x] Registration view dengan role dropdown & extra fields
- [x] Guest layout dengan UNMUL branding
- [x] Login view updated ke Bahasa Indonesia
- [x] Primary button dengan UNMUL colors
- [x] Testing: Registration berhasil
- [x] Testing: Login berhasil
- [x] Testing: Dashboard accessible
- [x] Testing: Logout berhasil

---

## 🎯 Key Takeaways

1. **Laravel Breeze** menyediakan authentication scaffolding yang siap pakai
2. **Role-Based System** memisahkan user berdasarkan level akses
3. **Eloquent Relationships** memudahkan query data terkait (User → Role)
4. **Helper Methods** (`hasRole`, `hasAnyRole`) membuat role checking lebih clean
5. **Blade Components** memudahkan reusability dan branding consistency

---

## 📚 Referensi

- [Laravel Breeze Documentation](https://laravel.com/docs/12.x/starter-kits#laravel-breeze)
- [Laravel Eloquent Relationships](https://laravel.com/docs/12.x/eloquent-relationships)
- [Laravel Authentication](https://laravel.com/docs/12.x/authentication)
- [Tailwind CSS v4 Documentation](https://tailwindcss.com/docs)

---

## ⏭️ Next Chapter

**Chapter 3: Role-Based Access Control (RBAC) dengan Spatie Laravel Permission**

Di chapter selanjutnya kita akan:
- Install Spatie Laravel Permission package
- Membuat permissions system (create, read, update, delete)
- Assign permissions ke roles
- Implementasi middleware untuk route protection
- Membuat permission checking di Blade views

---

**💡 Tips Pro:**
- Gunakan `hasRole()` untuk single role checking
- Gunakan `hasAnyRole()` untuk multiple role checking
- Selalu validate `role_id` dengan `exists:roles,id` di form request
- Gunakan nullable foreign key untuk mencegah cascade delete

**🎉 Selamat!** Anda telah menyelesaikan Chapter 2: Authentication System dengan Role-Based Access!
