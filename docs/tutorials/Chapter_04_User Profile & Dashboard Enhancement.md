# iLab UNMUL - Tutorial Chapter 4: User Profile & Dashboard Enhancement

## Daftar Isi
1. [Pendahuluan](#pendahuluan)
2. [Fitur yang Dibangun](#fitur-yang-dibangun)
3. [Struktur Database](#struktur-database)
4. [Model & Relationships](#model--relationships)
5. [Controller & Routes](#controller--routes)
6. [Views & UI](#views--ui)
7. [Enhanced Notifications](#enhanced-notifications)
8. [Password Validation](#password-validation)
9. [Testing](#testing)
10. [Troubleshooting](#troubleshooting)

---

## Pendahuluan

**Chapter 4** melengkapi sistem iLab UNMUL dengan fitur **User Profile yang Lengkap** dan **Dashboard yang Enhanced**. Pada chapter ini, kita menambahkan:

- Extended profile dengan 30+ fields untuk data akademik
- Sistem gelar depan & belakang (title & academic degree)
- Upload avatar dengan storage system
- Fallback avatar menggunakan UI Avatars API
- Dashboard dengan gradient UNMUL branding
- Statistics cards berdasarkan role
- Quick links dengan icon
- **Enhanced toast notifications** dengan gradient UNMUL
- **Real-time password validation** dengan visual feedback

---

## Fitur yang Dibangun

### 1. Extended User Profile
- **Avatar Upload** (max 2MB, JPG/PNG/GIF)
- **Academic Information**:
  - **Gelar Depan** (Title): Dr., Prof., H., Hj. - ditulis di depan nama
  - **Gelar Belakang** (Academic Degree): S.Kom., M.T., Ph.D. - ditulis di belakang nama
  - **Bio & Expertise**: Deskripsi singkat dan bidang keahlian
- **Contact Information**: Office phone, mobile, alternate email, website
- **Professional Information**: Department, Faculty, Position, Employment Status
- **Identity Information**: ID Card Number, Tax ID (NPWP)
- **Address Information**: Office address, city, province, postal code
- **Social Media Links**: LinkedIn, Google Scholar, ResearchGate, ORCID
- **Preferences**: Language, Timezone, Email/SMS Notifications

### 2. Enhanced Dashboard
- **Gradient Welcome Card** dengan avatar user & full name (termasuk gelar)
- **Role-specific Statistics Cards** (Total Requests, My Requests, Equipment, Tasks)
- **Permissions Display** dengan styling UNMUL
- **Quick Links** dengan icon dan border warna UNMUL

### 3. Enhanced Notifications
- **Toast Notification** di kanan atas dengan gradient hijau-biru UNMUL
- **Auto-dismiss** setelah 5 detik
- **Smooth animations** (slide + fade)
- **Success icon** + close button
- Muncul saat profile berhasil disimpan

### 4. Password Validation with Real-time Feedback
- **Persyaratan Password Indicator**:
  - Checklist dinamis "Minimal 8 karakter"
  - Warna abu-abu (✓) jika belum memenuhi
  - Warna hijau (✓) jika sudah memenuhi
- **Password Match Indicator**:
  - ❌ Merah "Password tidak sama" jika konfirmasi tidak cocok
  - ✓ Hijau "Password cocok" jika sudah sama
  - Real-time validation saat mengetik
- Menggunakan Alpine.js untuk interaktivitas

---

## Struktur Database

### Migration: `create_user_profiles_table`

```bash
php artisan make:migration create_user_profiles_table
```

**Fields:**
- `user_id` (foreignId) - Relationship ke users table
- `avatar` (string, nullable) - Path ke file avatar
- Profile Information: `title` (gelar depan), `academic_degree` (gelar belakang), `bio`, `expertise`
- Contact Information: `phone_office`, `phone_mobile`, `email_alternate`, `website`
- Professional: `department`, `faculty`, `position`, `employment_status`
- Identity: `id_card_number`, `tax_id`
- Address: `address_office`, `city`, `province`, `postal_code`, `country`
- Social Media: `linkedin`, `google_scholar`, `researchgate`, `orcid`
- Preferences: `language`, `timezone`, `email_notifications`, `sms_notifications`
- Metadata: `last_profile_update`, `timestamps`

**Relationship:**
```php
$table->foreignId('user_id')->constrained()->cascadeOnDelete();
```
Artinya: Jika user dihapus, profile ikut terhapus (cascade delete).

**Run Migration:**
```bash
php artisan migrate
```

---

## Model & Relationships

### UserProfile Model

**File:** `app/Models/UserProfile.php`

**Key Features:**
1. **Fillable Fields** - Semua field bisa mass assignment (termasuk `title` dan `academic_degree`)
2. **Casts** - Automatic type casting untuk boolean dan datetime
3. **Relationship** - `belongsTo(User::class)`
4. **Accessors:**
   - `getFullNameAttribute()` - Format: [Title] Name[, Academic Degree] (contoh: Dr. Anton Prafanto, S.Kom., M.T.)
   - `getAvatarUrlAttribute()` - Return URL avatar atau fallback ke UI Avatars

```php
public function getFullNameAttribute(): string
{
    $name = $this->user->name;

    // Add title prefix (Dr., Prof., H., Hj., etc.)
    if ($this->title) {
        $name = $this->title . ' ' . $name;
    }

    // Add academic degree suffix (S.Kom., M.T., Ph.D., etc.)
    if ($this->academic_degree) {
        $name = $name . ', ' . $this->academic_degree;
    }

    return $name;
}

public function getAvatarUrlAttribute(): string
{
    if ($this->avatar) {
        return asset('storage/' . $this->avatar);
    }
    return 'https://ui-avatars.com/api/?name=' . urlencode($this->user->name)
           . '&size=200&background=0066CC&color=ffffff';
}
```

### User Model Update

**File:** `app/Models/User.php`

**Tambahan:**
```php
use Illuminate\Database\Eloquent\Relations\HasOne;

public function profile(): HasOne
{
    return $this->hasOne(UserProfile::class);
}

public function getAvatarUrlAttribute(): string
{
    if ($this->profile && $this->profile->avatar) {
        return $this->profile->avatar_url;
    }
    return 'https://ui-avatars.com/api/?name=' . urlencode($this->name)
           . '&size=200&background=0066CC&color=ffffff';
}

public function getFullNameAttribute(): string
{
    if ($this->profile) {
        return $this->profile->full_name;
    }
    return $this->name;
}
```

**Penjelasan:**
- `hasOne(UserProfile::class)` - Setiap user punya 1 profile
- Accessor `avatar_url` dan `full_name` bisa dipanggil seperti: `$user->avatar_url`
- Format nama lengkap menggunakan logic dari UserProfile model (gelar depan + nama + gelar belakang)

---

## Controller & Routes

### ProfileController Update

**File:** `app/Http/Controllers/ProfileController.php`

**Method `edit()` - Tambah auto-create profile:**
```php
public function edit(Request $request): View
{
    $user = $request->user()->load('profile');

    // Create profile if not exists
    if (!$user->profile) {
        $user->profile()->create([]);
    }

    return view('profile.edit', [
        'user' => $user,
    ]);
}
```

**Method `updateProfile()` - Handle extended profile:**
```php
public function updateProfile(Request $request): RedirectResponse
{
    $validated = $request->validate([
        'avatar' => ['nullable', 'image', 'max:2048'], // 2MB max
        'title' => ['nullable', 'string', 'max:100'],
        'academic_degree' => ['nullable', 'string', 'max:255'],
        'bio' => ['nullable', 'string', 'max:1000'],
        'phone_office' => ['nullable', 'string', 'max:20'],
        // ... semua field lainnya
        'email_notifications' => ['boolean'],
        'sms_notifications' => ['boolean'],
    ]);

    $user = $request->user();
    $profile = $user->profile ?? $user->profile()->create([]);

    // Handle avatar upload
    if ($request->hasFile('avatar')) {
        // Delete old avatar
        if ($profile->avatar) {
            Storage::disk('public')->delete($profile->avatar);
        }

        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        $validated['avatar'] = $path;
    }

    $validated['last_profile_update'] = now();
    $profile->update($validated);

    return Redirect::route('profile.edit')->with('status', 'profile-updated');
}
```

**Penjelasan Avatar Upload:**
1. Check jika ada file avatar yang di-upload
2. Hapus avatar lama (jika ada)
3. Simpan avatar baru ke `storage/app/public/avatars/`
4. Update database dengan path file

### Routes

**File:** `routes/web.php`

```php
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/extended', [ProfileController::class, 'updateProfile'])
         ->name('profile.update.extended');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
```

### Storage Symlink

**PENTING:** Agar file avatar bisa diakses public, jalankan:
```bash
php artisan storage:link
```

Command ini membuat symbolic link dari `storage/app/public` ke `public/storage`.

---

## Views & UI

### 1. Profile Edit Page

**File:** `resources/views/profile/edit.blade.php`

**Header dengan Avatar:**
```blade
<x-slot name="header">
    <div class="flex items-center justify-between">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
        <div class="flex items-center space-x-3">
            <img src="{{ auth()->user()->avatar_url }}" alt="Avatar"
                 class="h-10 w-10 rounded-full ring-2 ring-[--color-unmul-blue]">
            <div>
                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                    {{ auth()->user()->full_name }}
                </p>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ auth()->user()->getRoleNames()->first() }}
                </p>
            </div>
        </div>
    </div>
</x-slot>
```

**Form Sections:**
1. Update Profile Information (default Breeze)
2. **Extended Profile Form** (BARU)
3. Update Password (default Breeze)
4. Delete Account (default Breeze)

### 2. Extended Profile Form

**File:** `resources/views/profile/partials/update-extended-profile-form.blade.php`

**Fitur:**
- **Avatar Upload dengan Preview**
- **8 Section**: Avatar, Academic Info, Contact, Professional, Identity, Address, Social Media, Preferences
- **UNMUL Branding**: Input dengan border dan focus warna UNMUL
- **Responsive Design**: Grid yang adapt untuk mobile/tablet/desktop
- **JavaScript Preview**: Avatar langsung preview sebelum upload

**JavaScript Avatar Preview:**
```javascript
function previewAvatar(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatar-preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
```

**Input Styling UNMUL:**
```blade
<input type="text"
       class="mt-1 block w-full border-gray-300 dark:border-gray-700
              dark:bg-gray-900 dark:text-gray-300
              focus:border-[--color-unmul-blue] focus:ring-[--color-unmul-blue]
              rounded-md shadow-sm" />
```

### 3. Enhanced Dashboard

**File:** `resources/views/dashboard.blade.php`

**Welcome Card dengan Gradient:**
```blade
<div class="bg-gradient-to-r from-[--color-unmul-blue] to-[--color-tropical-green]
            overflow-hidden shadow-lg sm:rounded-lg mb-6">
    <div class="p-8 text-white">
        <div class="flex items-center space-x-4">
            <img src="{{ auth()->user()->avatar_url }}"
                 alt="Avatar"
                 class="h-20 w-20 rounded-full ring-4 ring-white shadow-lg">
            <div>
                <h3 class="text-2xl font-bold mb-1">
                    Selamat Datang, {{ auth()->user()->full_name }}!
                </h3>
                <p class="text-sm text-white/90">
                    Role: <span class="font-semibold bg-white/20 px-3 py-1 rounded-full">
                        {{ auth()->user()->getRoleNames()->first() }}
                    </span>
                </p>
                <p class="text-xs text-white/80 mt-1">
                    {{ now()->isoFormat('dddd, D MMMM YYYY') }}
                </p>
            </div>
        </div>
    </div>
</div>
```

**Statistics Cards (Role-specific):**
```blade
@can('view-all-requests')
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                    Total Requests
                </p>
                <p class="text-3xl font-bold text-[--color-unmul-blue] mt-1">0</p>
            </div>
            <div class="bg-[--color-unmul-blue]/10 p-3 rounded-full">
                <!-- SVG Icon -->
            </div>
        </div>
    </div>
</div>
@endcan
```

**Quick Links dengan Icon:**
```blade
@can('view-equipment')
<a href="{{ route('equipment.index') }}"
   class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow-sm
          hover:shadow-lg transition border-l-4 border-[--color-unmul-blue]">
    <div class="flex items-center space-x-3">
        <div class="bg-[--color-unmul-blue]/10 p-3 rounded-lg">
            <!-- SVG Icon -->
        </div>
        <div>
            <h5 class="font-semibold text-lg">Equipment Management</h5>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                View and manage laboratory equipment
            </p>
        </div>
    </div>
</a>
@endcan
```

---

## Enhanced Notifications

### Toast Notification Component

Chapter 4 dilengkapi dengan **enhanced notification system** yang menampilkan feedback visual yang eye-catching saat user berhasil menyimpan profile.

**File:** `resources/views/components/notification.blade.php`

**Key Features:**
- Toast notification di kanan atas (fixed position)
- Gradient background: Hijau (#4CAF50) ke Biru UNMUL (#0066CC)
- Auto-dismiss setelah 5 detik
- Smooth animations menggunakan Alpine.js transitions
- Success icon + close button manual

**Code:**
```blade
@props(['status'])

@if (session('status'))
    <div x-data="{ show: true }"
         x-show="show"
         x-transition:enter="transform ease-out duration-300 transition"
         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-init="setTimeout(() => show = false, 5000)"
         class="fixed top-4 right-4 z-50 max-w-md">

        <div class="rounded-lg shadow-2xl p-4 border-l-4 border-white"
             style="background: linear-gradient(to right, #4CAF50, #0066CC);">
            <div class="flex items-center space-x-3">
                <!-- Success Icon -->
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <div class="flex-1">
                    <p class="text-sm font-bold text-white">Berhasil!</p>
                    <p class="text-xs text-white/90 mt-1">
                        {{ session('status') === 'profile-updated'
                           ? 'Profile Anda telah berhasil diperbarui!'
                           : 'Perubahan telah disimpan.' }}
                    </p>
                </div>

                <!-- Close Button -->
                <button @click="show = false" class="flex-shrink-0 text-white hover:text-gray-200 transition">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>
@endif
```

### Menggunakan Notification Component

Tambahkan di `resources/views/profile/edit.blade.php`:

```blade
<x-app-layout>
    <!-- Enhanced Notification -->
    <x-notification />

    <x-slot name="header">
        <!-- ... header content ... -->
    </x-slot>

    <!-- ... rest of content ... -->
</x-app-layout>
```

**Penjelasan:**
- Component menerima `session('status')` dari controller redirect
- `x-init="setTimeout(() => show = false, 5000)"` - Auto-hide setelah 5 detik
- `@click="show = false"` - Manual close dengan tombol X
- Inline `style` digunakan karena CSS variables Tailwind tidak bekerja untuk gradient

---

## Password Validation

### Real-time Password Validation with Alpine.js

Chapter 4 dilengkapi dengan **real-time password validation** yang memberikan visual feedback langsung saat user mengetik password.

**File:** `resources/views/profile/partials/update-password-form.blade.php`

**Key Features:**
- Persyaratan password indicator (minimal 8 karakter)
- Password match indicator (cocok/tidak cocok)
- Checklist dengan perubahan warna dinamis
- Real-time validation tanpa submit form
- Menggunakan Alpine.js `x-data` dan `x-model`

**Code:**
```blade
<section x-data="{ password: '', confirmation: '' }">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password"
                          name="current_password"
                          type="password"
                          class="mt-1 block w-full"
                          autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password with Requirements Indicator -->
        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <input id="update_password_password"
                   name="password"
                   type="password"
                   class="mt-1 block w-full border-gray-300 dark:border-gray-700
                          dark:bg-gray-900 dark:text-gray-300
                          focus:border-indigo-500 dark:focus:border-indigo-600
                          focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                   autocomplete="new-password"
                   x-model="password" />

            <!-- Password Requirements Indicator -->
            <div class="mt-2 space-y-1">
                <p class="text-xs font-semibold text-gray-700 dark:text-gray-300">
                    Persyaratan Password:
                </p>
                <div class="flex items-center space-x-2">
                    <svg class="h-4 w-4 transition-colors"
                         :class="password.length >= 8 ? 'text-green-600' : 'text-gray-400'"
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-xs transition-colors"
                          :class="password.length >= 8 ? 'text-green-600 font-semibold' : 'text-gray-500'">
                        Minimal 8 karakter
                    </span>
                </div>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password with Match Indicator -->
        <div>
            <x-input-label for="update_password_password_confirmation"
                           :value="__('Confirm Password')" />
            <input id="update_password_password_confirmation"
                   name="password_confirmation"
                   type="password"
                   class="mt-1 block w-full border-gray-300 dark:border-gray-700
                          dark:bg-gray-900 dark:text-gray-300
                          focus:border-indigo-500 dark:focus:border-indigo-600
                          focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                   autocomplete="new-password"
                   x-model="confirmation" />

            <!-- Password Match Indicator -->
            <div class="mt-2">
                <p x-show="confirmation.length > 0 && password.length > 0 && confirmation !== password"
                   x-cloak
                   class="text-xs font-semibold flex items-center space-x-1"
                   style="color: #E53935;">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span>Password tidak sama</span>
                </p>
                <p x-show="confirmation.length > 0 && password.length >= 8 && confirmation === password"
                   x-cloak
                   class="text-xs font-semibold flex items-center space-x-1"
                   style="color: #4CAF50;">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Password cocok</span>
                </p>
            </div>

            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>
</section>

<style>
    [x-cloak] { display: none !important; }
</style>
```

### Penjelasan Alpine.js Implementation

**1. Single Alpine Component Wrapper:**
```blade
<section x-data="{ password: '', confirmation: '' }">
```
- `x-data` di root section agar `password` dan `confirmation` accessible di semua child elements
- Hindari nested `x-data` yang bisa menyebabkan conflict

**2. Two-way Data Binding:**
```blade
<input x-model="password" />
<input x-model="confirmation" />
```
- `x-model` bind input value ke Alpine variable
- Setiap perubahan input langsung update variable

**3. Conditional Classes:**
```blade
:class="password.length >= 8 ? 'text-green-600' : 'text-gray-400'"
```
- Dynamic class berdasarkan kondisi
- Checklist berubah hijau saat password ≥ 8 karakter

**4. Conditional Display:**
```blade
x-show="confirmation.length > 0 && confirmation !== password"
x-show="confirmation.length > 0 && password.length >= 8 && confirmation === password"
```
- Tampilkan pesan "Password tidak sama" saat berbeda
- Tampilkan pesan "Password cocok" saat sama DAN password ≥ 8 karakter

**5. Hide Before Alpine Loads:**
```css
[x-cloak] { display: none !important; }
```
- Mencegah flash of unstyled content (FOUC)
- Element dengan `x-cloak` hidden sampai Alpine.js loaded

**6. Inline Styles untuk Warna:**
```blade
style="color: #E53935;"  <!-- Red -->
style="color: #4CAF50;"  <!-- Green -->
```
- Gunakan inline style karena CSS variables Tailwind tidak reliable untuk dynamic content

---

## Testing

### 1. Test Profile Creation

```bash
# Login sebagai user yang sudah ada
# Akses: http://localhost:8000/profile
```

**Expected:**
- Profile otomatis dibuat jika belum ada
- Form extended profile muncul
- Avatar fallback menggunakan UI Avatars (initial name)

### 2. Test Avatar Upload

1. Klik "Choose Avatar"
2. Pilih image (JPG/PNG/GIF, max 2MB)
3. Preview langsung muncul
4. Klik "Save Extended Profile"
5. Avatar tersimpan di `storage/app/public/avatars/`
6. Avatar muncul di header dan dashboard

### 3. Test Profile Update with Degrees

**Fill form dengan data:**
- **Gelar Depan**: "Dr." (optional)
- **Gelar Belakang**: "S.Kom., M.T."
- Bio: "Dosen Fakultas MIPA"
- Department: "Informatika"
- Faculty: "MIPA"
- Phone: "0541-123456"
- dll.

**Submit dan verify:**
- Data tersimpan
- `last_profile_update` terupdate
- Full name format benar:
  - Jika hanya gelar belakang: "Anton Prafanto, S.Kom., M.T."
  - Jika ada gelar depan & belakang: "Dr. Anton Prafanto, S.Kom., M.T."
- **Toast notification muncul** di kanan atas dengan gradient hijau-biru
- Notification auto-dismiss setelah 5 detik

### 4. Test Enhanced Notification

1. Buka halaman Profile
2. Ubah data apapun (bio, phone, dll)
3. Klik "SIMPAN PROFILE"

**Expected:**
- ✅ Toast notification muncul di **kanan atas**
- ✅ Background **gradient hijau (#4CAF50) ke biru (#0066CC)**
- ✅ Icon success (✓) berwarna putih
- ✅ Text "Berhasil!" dan "Profile Anda telah berhasil diperbarui!"
- ✅ Auto-dismiss setelah **5 detik**
- ✅ Bisa di-close manual dengan tombol X
- ✅ Smooth slide + fade animation

### 5. Test Password Validation (Real-time)

**Test A: Persyaratan 8 Karakter**
1. Scroll ke section "Update Password"
2. Isi "New Password" dengan `123` (< 8 karakter)
   - **Expected**: Checklist ✓ berwarna **abu-abu**, text abu-abu "Minimal 8 karakter"
3. Tambahkan jadi `12345678` (≥ 8 karakter)
   - **Expected**: Checklist ✓ dan text berubah **hijau** (#4CAF50)

**Test B: Password Match Indicator**
1. Isi "New Password": `12345678`
2. Isi "Confirm Password": `different`
   - **Expected**: Muncul pesan **merah** (#E53935) ❌ "Password tidak sama"
3. Ubah "Confirm Password": `12345678`
   - **Expected**: Pesan merah hilang, muncul pesan **hijau** ✓ "Password cocok"

**Test C: Kombinasi (Password < 8 karakter)**
1. Isi "New Password": `abc` (< 8)
2. Isi "Confirm Password": `abc`
   - **Expected**:
     - Checklist 8 karakter: abu-abu (belum memenuhi)
     - Password match: **TIDAK muncul** karena password < 8 karakter

**Test D: Submit & Verify**
1. Isi Current Password dengan password lama
2. Isi New Password: `newpassword123`
3. Isi Confirm Password: `newpassword123`
4. Klik "Save"
   - **Expected**: Password berhasil diupdate (cek dengan logout & login ulang)

### 6. Test Dashboard Enhancement

**Login dengan berbagai role:**
- **Super Admin**: Lihat semua cards (Total Requests, Equipment, User Management)
- **Lab Manager**: Lihat Equipment dan My Requests
- **Researcher**: Lihat My Requests dan Create Request

**Verify:**
- Welcome card menampilkan avatar + full name
- Statistics cards sesuai permission
- Quick links sesuai role
- Permissions display lengkap

---

## Troubleshooting

### 1. Avatar Tidak Muncul (404)

**Problem:** Image 404 atau tidak muncul

**Solution:**
```bash
php artisan storage:link
```

Pastikan symbolic link sudah dibuat. Check folder `public/storage/` ada atau tidak.

### 2. Profile Null Error

**Problem:** `Attempt to read property on null` saat akses `$user->profile`

**Solution:**
Profile controller sudah handle auto-create:
```php
if (!$user->profile) {
    $user->profile()->create([]);
}
```

Tapi jika masih error, manual create:
```bash
php artisan tinker
>>> $user = User::find(1);
>>> $user->profile()->create([]);
```

### 3. Avatar Upload Gagal

**Problem:** Upload error atau file terlalu besar

**Check:**
1. **php.ini** settings:
   ```ini
   upload_max_filesize = 2M
   post_max_size = 8M
   ```

2. **Validation** di controller:
   ```php
   'avatar' => ['nullable', 'image', 'max:2048'], // 2MB
   ```

3. **Storage permissions:**
   ```bash
   # Linux/Mac
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

### 4. UI Avatars Tidak Load

**Problem:** Fallback avatar tidak muncul (CORS atau internet issue)

**Alternative:** Gunakan avatar placeholder lokal atau library lain seperti:
- DiceBear API: `https://api.dicebear.com/7.x/initials/svg?seed=`
- Boring Avatars: `https://source.boringavatars.com/`

### 5. Dashboard Statistics Kosong

**Problem:** Statistics cards selalu 0

**Reason:** Data memang belum ada (ini normal untuk tahap sekarang)

**Next Chapter:** Nanti akan diisi dengan real data dari:
- Service Requests (Chapter 5)
- Equipment Management (Chapter 6)
- Laboratory Tests (Chapter 7)

### 6. Permission Card Tidak Muncul

**Problem:** `@can('permission-name')` tidak bekerja

**Check:**
1. Permission sudah di-seed?
   ```bash
   php artisan db:seed --class=RolePermissionSeeder
   ```

2. User sudah punya role?
   ```bash
   php artisan tinker
   >>> User::find(1)->roles;
   ```

3. Role sudah punya permission?
   ```bash
   >>> Role::find(1)->permissions;
   ```

### 7. Toast Notification Tidak Muncul atau Background Hitam

**Problem:** Notification tidak muncul sama sekali ATAU muncul tapi background hitam (bukan gradient hijau-biru)

**Solution A: Check Alpine.js Loaded**
1. Buka browser console (F12 → Console tab)
2. Ketik: `Alpine.version`
3. Jika error `Alpine is not defined`, berarti Alpine.js tidak ter-load

**Fix:**
Pastikan layout app.blade.php punya Alpine.js:
```blade
<!-- resources/views/layouts/app.blade.php -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
```

**Solution B: Fix Background Gradient**
Jika notification muncul tapi background hitam:

**Причина:** CSS variables `--color-tropical-green` dan `--color-unmul-blue` tidak ter-load atau tidak accessible di component.

**Fix:** Gunakan inline style dengan warna langsung:
```blade
<!-- JANGAN PAKAI INI (tidak bekerja): -->
<div class="bg-gradient-to-r from-[--color-tropical-green] to-[--color-unmul-blue]">

<!-- PAKAI INI (bekerja): -->
<div style="background: linear-gradient(to right, #4CAF50, #0066CC);">
```

**Solution C: Hard Refresh Browser**
```
Ctrl + F5  (Windows/Linux)
Cmd + Shift + R  (Mac)
```

### 8. Password Validation Tidak Bekerja

**Problem:** Checklist tidak berubah warna, password match indicator tidak muncul

**Причина:** Alpine.js `x-data` nested conflict atau tidak ter-load

**Solution A: Check Alpine.js**
1. Buka browser console (F12)
2. Cari error JavaScript
3. Pastikan Alpine.js loaded (lihat Troubleshooting #7)

**Solution B: Check x-data Structure**
Pastikan struktur Alpine component benar:

```blade
<!-- BENAR: Single x-data wrapper -->
<section x-data="{ password: '', confirmation: '' }">
    <input x-model="password" />
    <input x-model="confirmation" />
    <span :class="password.length >= 8 ? 'text-green-600' : 'text-gray-400'">
</section>

<!-- SALAH: Nested x-data (conflict) -->
<section x-data="{ password: '' }">
    <div x-data="{ confirmation: '' }">  <!-- ❌ Nested -->
        ...
    </div>
</section>
```

**Solution C: Check x-cloak Style**
Pastikan ada style untuk hide element sebelum Alpine loads:
```blade
<style>
    [x-cloak] { display: none !important; }
</style>
```

**Solution D: Use Inline Colors**
Jika `:class` dengan CSS variables tidak bekerja, gunakan inline style:
```blade
<!-- JANGAN: -->
:class="password.length >= 8 ? 'text-[--color-tropical-green]' : 'text-gray-400'"

<!-- PAKAI: -->
:class="password.length >= 8 ? 'text-green-600' : 'text-gray-400'"
```

### 9. Gelar Tidak Muncul di Dashboard

**Problem:** Nama di welcome card atau dropdown tidak menampilkan gelar (hanya nama dasar)

**Check:**
1. **Data gelar sudah tersimpan?**
   ```bash
   php artisan tinker
   >>> $user = User::find(1);
   >>> $user->profile->title;  // Gelar depan
   >>> $user->profile->academic_degree;  // Gelar belakang
   ```

2. **User model menggunakan full_name accessor?**
   ```blade
   <!-- BENAR: -->
   {{ auth()->user()->full_name }}

   <!-- SALAH: -->
   {{ auth()->user()->name }}
   ```

3. **Profile relationship di-load?**
   ```php
   // Di controller atau view:
   $user = auth()->user()->load('profile');
   ```

**Fix Manual:**
```bash
php artisan tinker
>>> $user = User::find(1);
>>> $user->name = 'Anton Prafanto';
>>> $user->save();
>>> $user->profile()->updateOrCreate(
...     ['user_id' => $user->id],
...     ['academic_degree' => 'S.Kom., M.T.', 'title' => 'Dr.']
... );
```

Refresh browser dan gelar seharusnya muncul sebagai: "Dr. Anton Prafanto, S.Kom., M.T."

---

## Summary Chapter 4

**Yang Sudah Dibuat:**
✅ User Profiles table dengan 30+ fields
✅ Sistem gelar depan & belakang (title & academic degree)
✅ UserProfile model dengan relationships & accessors
✅ Avatar upload system dengan storage symlink
✅ UI Avatars API sebagai fallback
✅ Extended profile form dengan 8 sections
✅ Enhanced dashboard dengan gradient & statistics
✅ Role-specific widgets menggunakan `@can`
✅ **Enhanced toast notifications dengan gradient UNMUL**
✅ **Real-time password validation dengan Alpine.js**
✅ UNMUL branding di semua UI elements

**Files Created:**
- `database/migrations/2025_10_02_033838_create_user_profiles_table.php`
- `database/migrations/2025_10_02_040452_add_academic_degree_to_user_profiles_table.php`
- `app/Models/UserProfile.php`
- `resources/views/profile/partials/update-extended-profile-form.blade.php`
- `resources/views/components/notification.blade.php`

**Files Modified:**
- `app/Models/User.php` - added profile relationship & full_name accessor
- `app/Http/Controllers/ProfileController.php` - added updateProfile() method
- `routes/web.php` - added profile.update.extended route
- `resources/views/profile/edit.blade.php` - added notification component
- `resources/views/profile/partials/update-password-form.blade.php` - added real-time validation
- `resources/views/dashboard.blade.php` - enhanced with gradient & statistics
- `resources/views/layouts/navigation.blade.php` - show full_name instead of name

**Key Features:**
1. **Gelar System**: Pisah gelar depan (Dr., Prof.) dan gelar belakang (S.Kom., M.T.)
2. **Full Name Format**: "Dr. Anton Prafanto, S.Kom., M.T."
3. **Toast Notifications**: Gradient hijau-biru (#4CAF50 → #0066CC), auto-dismiss 5 detik
4. **Password Validation**: Real-time checklist minimal 8 karakter + password match indicator
5. **Alpine.js Integration**: Interactive UI tanpa page reload

**Next Chapter (Chapter 5): Service Request Management**
- Create service_requests table
- Build request form
- Implement approval workflow
- Email notifications
- Request tracking & history

---

**iLab UNMUL - Innovation Laboratory Management System**
*Universitas Mulawarman, Samarinda, Kalimantan Timur*
