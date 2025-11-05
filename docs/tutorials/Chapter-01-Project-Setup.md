# CHAPTER 1: PROJECT SETUP & INSTALLATION

## 📚 Learning Objectives
Setelah menyelesaikan chapter ini, Anda akan mampu:
- Install Laravel 12 dengan dependency lengkap
- Configure MariaDB database connection
- Setup Tailwind CSS + Alpine.js + Vite
- Memahami struktur folder Laravel 12
- Menjalankan development server pertama kali

## 🎯 Prerequisites
- PHP 8.3+ (minimal 8.2)
- Composer 2.x
- Node.js 18+ dan NPM 9+
- MariaDB 10.11+ atau MySQL 8.0+
- Git (optional, untuk version control)
- Text editor (VS Code, PhpStorm, dll)

## ⏱️ Estimated Time
60-90 menit

## 📦 What We'll Build
Pada chapter ini kita akan:
1. Install Laravel 12 fresh installation
2. Configure environment (.env)
3. Setup database MariaDB
4. Install dan configure Tailwind CSS
5. Install dan configure Alpine.js
6. Configure Vite untuk asset building
7. Test first run

---

## 📝 Implementation Steps

### Step 1: Verify System Requirements

**Why we do this**: Memastikan semua tools sudah terinstall dengan versi yang benar sebelum mulai.

**Commands**:
```bash
# Check PHP version (need 8.2+, recommended 8.3+)
php -v

# Check Composer version
composer -V

# Check Node.js and NPM version
node -v
npm -v

# Check MariaDB version (jika sudah install)
mysql --version
```

**Expected Output**:
```
PHP 8.3.x (cli) ...
Composer version 2.x.x
v18.x.x atau lebih tinggi
npm 9.x.x atau lebih tinggi
mysql  Ver 15.1 Distrib 10.11.x-MariaDB
```

**Troubleshooting**:
- Jika PHP < 8.2: Download dan install PHP 8.3 dari php.net atau gunakan XAMPP terbaru
- Jika Composer belum ada: Install dari getcomposer.org
- Jika Node.js < 18: Download dari nodejs.org (gunakan LTS version)

---

### Step 2: Create Project Directory Structure

**Why we do this**: Menyiapkan struktur folder yang terorganisir untuk project.

**Commands**:
```bash
# Navigate to web root (contoh: XAMPP)
cd c:\xampp\htdocs

# Create project directory
mkdir ilab_unmul
cd ilab_unmul

# Create folders untuk documentation
mkdir docs
mkdir docs/tutorials
mkdir tasks
```

**File Structure**:
```
c:\xampp\htdocs\ilab_unmul\
├── docs/              # Dokumentasi project
│   └── tutorials/     # Tutorial chapters
├── tasks/             # Todo dan planning files
└── (Laravel files akan ada di sini)
```

---

### Step 3: Install Laravel 12

**Why we do this**: Laravel 12 adalah versi terbaru dengan fitur dan security updates terkini.

**Commands**:
```bash
# Install Laravel 12 via Composer
composer create-project laravel/laravel . "^12.0"
```

**Penjelasan**:
- `laravel/laravel`: Package name untuk Laravel installer
- `.`: Install di directory saat ini (current directory)
- `"^12.0"`: Install Laravel version 12.x (latest stable di version 12)

**Expected Output**:
```
Creating a "laravel/laravel" project at "./"
Installing laravel/laravel (v12.x.x)
  - Installing laravel/laravel (v12.x.x): Extracting archive
...
Application key set successfully.
```

**Duration**: ~2-5 menit (tergantung koneksi internet)

---

### Step 4: Verify Laravel Installation

**Why we do this**: Memastikan Laravel terinstall dengan benar.

**Commands**:
```bash
# Check Laravel version
php artisan --version

# List semua Artisan commands
php artisan list
```

**Expected Output**:
```
Laravel Framework 12.x.x
```

**File Structure After Installation**:
```
ilab_unmul/
├── app/               # Application logic
├── bootstrap/         # Framework bootstrap
├── config/            # Configuration files
├── database/          # Migrations, seeders, factories
├── public/            # Web root (index.php, assets)
├── resources/         # Views, CSS, JS
│   ├── css/
│   ├── js/
│   └── views/
├── routes/            # Route definitions
├── storage/           # Logs, cache, uploaded files
├── tests/             # Automated tests
├── vendor/            # Composer dependencies
├── .env               # Environment variables
├── .env.example       # Example environment file
├── artisan            # Artisan CLI
├── composer.json      # PHP dependencies
├── package.json       # NPM dependencies
├── vite.config.js     # Vite configuration
└── README.md          # Project readme
```

---

### Step 5: Configure Environment File (.env)

**Why we do this**: Mengatur konfigurasi aplikasi sesuai environment development lokal.

**File**: `.env`

**Changes**:
```env
APP_NAME="iLab UNMUL"
APP_ENV=local
APP_KEY=base64:... (sudah auto-generated)
APP_DEBUG=true
APP_TIMEZONE=Asia/Makassar
APP_URL=http://localhost:8000

APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=id_ID

# Database Configuration - MARIADB
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ilab_unmul
DB_USERNAME=root
DB_PASSWORD=

# Broadcast, Cache, Session, Queue (keep default for now)
BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database
SESSION_DRIVER=database
SESSION_LIFETIME=120

# Mail Configuration (akan diconfig di chapter selanjutnya)
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="noreply@ilab.unmul.ac.id"
MAIL_FROM_NAME="${APP_NAME}"
```

**Important Notes**:
- ⚠️ **DB_CONNECTION=mariadb** (BUKAN mysql!) - Sesuai requirement!
- **APP_TIMEZONE=Asia/Makassar** - Timezone Kalimantan Timur
- **APP_LOCALE=id** - Bahasa Indonesia sebagai default
- **DB_DATABASE=ilab_unmul** - Nama database yang akan kita buat

---

### Step 6: Create Database (MariaDB)

**Why we do this**: Laravel membutuhkan database untuk menyimpan data aplikasi.

**Option 1: Via Command Line**:
```bash
# Login to MariaDB
mysql -u root -p

# Create database
CREATE DATABASE ilab_unmul CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Verify database created
SHOW DATABASES;

# Exit
EXIT;
```

**Option 2: Via phpMyAdmin** (jika menggunakan XAMPP):
1. Buka browser: `http://localhost/phpmyadmin`
2. Click "New" di sidebar kiri
3. Database name: `ilab_unmul`
4. Collation: `utf8mb4_unicode_ci`
5. Click "Create"

**Verify Connection**:
```bash
# Test database connection
php artisan migrate:status
```

**Expected Output**:
```
Migration table created successfully.
No migrations found.
```

Jika berhasil, berarti koneksi ke database sudah OK!

---

### Step 7: Install NPM Dependencies

**Why we do this**: Laravel 12 menggunakan Vite untuk asset bundling, membutuhkan Node packages.

**Commands**:
```bash
# Install NPM packages
npm install
```

**Duration**: ~1-3 menit

**Packages Installed** (check `package.json`):
- `vite`: Modern build tool
- `laravel-vite-plugin`: Laravel integration untuk Vite
- `axios`: HTTP client

---

### Step 8: Install Tailwind CSS v4

**Why we do this**: Tailwind CSS adalah utility-first CSS framework yang mempercepat development UI. Kita menggunakan Tailwind CSS v4 yang memiliki konfigurasi lebih modern.

**Commands**:
```bash
# Install Tailwind CSS v4
npm install tailwindcss@next @tailwindcss/vite@next
```

**Important Notes**:
- ⚠️ **Tailwind CSS v4** tidak menggunakan file `tailwind.config.js` terpisah
- ⚠️ Konfigurasi dilakukan langsung di file CSS menggunakan `@theme`
- ⚠️ Tidak perlu menjalankan `npx tailwindcss init -p`

**Edit**: `resources/css/app.css`
```css
@import 'tailwindcss';

/* Specify source files untuk Tailwind */
@source '../../vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php';
@source '../../storage/framework/views/*.php';
@source '../**/*.blade.php';
@source '../**/*.js';

/* Theme Configuration - UNMUL Brand Colors */
@theme {
    /* Font Configuration */
    --font-sans: 'Inter', 'Segoe UI', 'Roboto', ui-sans-serif, system-ui, sans-serif;

    /* UNMUL Brand Colors */
    --color-unmul-blue: #0066CC;
    --color-innovation-orange: #FF9800;
    --color-tropical-green: #4CAF50;
}

/* Custom CSS untuk iLab UNMUL */
@layer base {
    body {
        @apply bg-gray-50 text-gray-900;
        font-family: var(--font-sans);
    }
}

@layer components {
    /* Button Primary - UNMUL Blue */
    .btn-primary {
        @apply bg-[--color-unmul-blue] text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition;
    }

    /* Button Secondary - Innovation Orange */
    .btn-secondary {
        @apply bg-[--color-innovation-orange] text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition;
    }

    /* Card Component */
    .card {
        @apply bg-white rounded-lg shadow-md p-6;
    }
}
```

**Penjelasan**:
- `@import 'tailwindcss'`: Import Tailwind CSS v4
- `@source`: Specify files yang akan di-scan oleh Tailwind untuk generate CSS
- `@theme`: Konfigurasi custom theme (menggantikan `tailwind.config.js`)
- `--color-*`: CSS custom properties untuk brand colors
- `@layer`: Organize custom CSS ke dalam layers Tailwind
```

---

### Step 9: Install Alpine.js

**Why we do this**: Alpine.js adalah lightweight JavaScript framework untuk interaktivitas UI (alternative ringan untuk Vue/React).

**Commands**:
```bash
# Install Alpine.js
npm install alpinejs
```

**Edit**: `resources/js/app.js`
```javascript
import './bootstrap';
import Alpine from 'alpinejs';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

console.log('iLab UNMUL - Alpine.js initialized!');
```

**Penjelasan**:
- Import Alpine.js
- Expose Alpine ke window object (untuk debugging)
- Start Alpine.js
- Console log untuk verify Alpine loaded

---

### Step 10: Configure Vite for Tailwind CSS v4

**Why we do this**: Vite perlu dikonfigurasi untuk mendukung Tailwind CSS v4.

**File**: `vite.config.js` (edit file yang sudah ada)

```javascript
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        host: '127.0.0.1',
        port: 5173,
        hmr: {
            host: '127.0.0.1',
        },
    },
});
```

**Penjelasan**:
- `import tailwindcss from '@tailwindcss/vite'`: Import Tailwind CSS v4 Vite plugin
- `tailwindcss()`: Tambahkan plugin Tailwind ke Vite
- `input`: Files yang akan di-bundle oleh Vite
- `refresh: true`: Auto-refresh browser saat file berubah
- `server`: Development server configuration

---

### Step 11: Update Base Layout

**Why we do this**: Membuat base layout dengan Tailwind CSS v4 + Alpine.js yang berfungsi.

**File**: `resources/views/welcome.blade.php` (replace isinya)

```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>iLab UNMUL - Pusat Unggulan Studi Tropis</title>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-600 to-green-500">
        <div class="card max-w-2xl text-center" x-data="{ show: false }" x-init="setTimeout(() => show = true, 100)">
            <!-- Logo Placeholder -->
            <div class="mb-6">
                <h1 class="text-4xl font-bold text-[--color-unmul-blue] mb-2">
                    iLab UNMUL
                </h1>
                <p class="text-xl text-gray-600 italic">
                    "Pusat Unggulan Studi Tropis"
                </p>
            </div>

            <!-- Welcome Message with Alpine.js Animation -->
            <div x-show="show"
                 x-transition:enter="transition ease-out duration-500"
                 x-transition:enter-start="opacity-0 transform scale-90"
                 x-transition:enter-end="opacity-100 transform scale-100">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                    Selamat Datang! 🎉
                </h2>
                <p class="text-gray-600 mb-6">
                    <strong>Laravel 12</strong> + <strong>Tailwind CSS v4</strong> + <strong>Alpine.js</strong>
                    + <strong>Vite</strong> berhasil terinstall!
                </p>

                <!-- Tech Stack Info -->
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-sm text-gray-500">Framework</p>
                        <p class="font-semibold text-[--color-unmul-blue]">Laravel 12</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-sm text-gray-500">Database</p>
                        <p class="font-semibold text-[--color-unmul-blue]">MariaDB</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-sm text-gray-500">CSS</p>
                        <p class="font-semibold text-[--color-innovation-orange]">Tailwind CSS v4</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded">
                        <p class="text-sm text-gray-500">JavaScript</p>
                        <p class="font-semibold text-[--color-innovation-orange]">Alpine.js</p>
                    </div>
                </div>

                <!-- CTA Buttons -->
                <div class="flex gap-3 justify-center">
                    <button class="btn-primary" @click="alert('Primary button works!')">
                        Primary Button
                    </button>
                    <button class="btn-secondary" @click="alert('Secondary button works!')">
                        Secondary Button
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
```

**Penjelasan**:
- Tailwind utility classes (`min-h-screen`, `flex`, `items-center`, dll)
- Custom brand colors menggunakan CSS variables (`text-[--color-unmul-blue]`, `bg-[--color-innovation-orange]`)
- Alpine.js directive (`x-data`, `x-show`, `x-transition`, `@click`)
- Vite directive (`@vite()`)
- Responsive grid (`grid grid-cols-2`)

**Important Notes for Tailwind v4**:
- ⚠️ Custom colors diakses dengan syntax `text-[--color-name]` atau `bg-[--color-name]`
- ⚠️ Tidak bisa langsung pakai `text-unmul-blue`, harus `text-[--color-unmul-blue]`

---

### Step 12: Build Assets & Run Development Server

**Why we do this**: Compile CSS/JS dan jalankan development server untuk testing.

**Commands** (buka 2 terminal):

**Terminal 1 - Vite Dev Server**:
```bash
npm run dev
```

**Expected Output**:
```
VITE v5.x.x  ready in xxx ms

  ➜  Local:   http://127.0.0.1:5173/
  ➜  Network: use --host to expose

  LARAVEL v12.x.x  plugin v1.x.x

  ➜  APP_URL: http://localhost:8000
```

**Terminal 2 - Laravel Dev Server**:
```bash
php artisan serve
```

**Expected Output**:
```
Starting Laravel development server: http://127.0.0.1:8000
[Thu Jan 10 2025 10:00:00] PHP 8.3.x Development Server (http://127.0.0.1:8000) started
```

---

### Step 13: Test in Browser

**Why we do this**: Verify semua berfungsi dengan benar.

**Steps**:
1. Buka browser
2. Navigate ke: `http://127.0.0.1:8000` atau `http://localhost:8000`
3. Verify tampilan welcome page dengan:
   - ✅ Background gradient (blue to green)
   - ✅ White card dengan shadow
   - ✅ Title "iLab UNMUL"
   - ✅ Tagline "Pusat Unggulan Studi Tropis"
   - ✅ Tech stack info boxes
   - ✅ Two buttons (Primary blue, Secondary orange)
4. Click kedua buttons → should show alert
5. Open DevTools → Console → should see "iLab UNMUL - Alpine.js initialized!"

**Screenshot**: (akan ada setelah running)

---

## ✅ Testing & Verification

### Manual Testing Checklist

- [ ] PHP version 8.2+ terinstall
- [ ] Composer terinstall
- [ ] Node.js & NPM terinstall
- [ ] Laravel 12 terinstall (`php artisan --version`)
- [ ] Database `ilab_unmul` created
- [ ] Database connection works (`php artisan migrate:status`)
- [ ] NPM packages installed (`node_modules` folder exists)
- [ ] Tailwind CSS v4 configured (`@theme` in `app.css`, NO `tailwind.config.js`)
- [ ] `@tailwindcss/vite` plugin in `vite.config.js`
- [ ] Alpine.js installed (check `package.json`)
- [ ] Vite dev server running (`npm run dev` works)
- [ ] Laravel dev server running (`php artisan serve` works)
- [ ] Welcome page accessible (`http://localhost:8000`)
- [ ] Tailwind classes working (gradient background visible)
- [ ] Alpine.js working (buttons show alert)
- [ ] Custom brand colors working (UNMUL blue, Innovation orange)
- [ ] Console shows Alpine.js initialized message

### Automated Testing

**Why we do this**: Membuat automated test untuk memastikan welcome page berfungsi dengan benar.

**Create Test File**:
```bash
php artisan make:test WelcomePageTest
```

**Expected Output**:
```
INFO  Test [tests/Feature/WelcomePageTest.php] created successfully.
```

**Edit File**: `tests/Feature/WelcomePageTest.php`

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;

class WelcomePageTest extends TestCase
{
    /**
     * Test welcome page loads successfully.
     */
    public function test_welcome_page_loads(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('iLab UNMUL');
        $response->assertSee('Pusat Unggulan Studi Tropis');
    }
}
```

**Penjelasan**:
- `test_welcome_page_loads()`: Test method untuk mengecek welcome page
- `$this->get('/')`: Melakukan GET request ke root URL
- `assertStatus(200)`: Memastikan response code adalah 200 (OK)
- `assertSee()`: Memastikan teks tertentu muncul di halaman

**Run Test**:
```bash
php artisan test --filter WelcomePageTest
```

**Expected Output**:
```
PASS  Tests\Feature\WelcomePageTest
✓ welcome page loads

Tests:    1 passed (3 assertions)
Duration: 0.39s
```

---

## 🐛 Common Issues & Solutions

### Issue 1: Composer SSL Error
**Symptom**: "You are running Composer with SSL/TLS protection disabled"

**Cause**: SSL verification disabled di PHP

**Solution**:
```bash
# Option 1: Enable SSL in php.ini
# Uncomment line:
extension=openssl

# Option 2: Continue with warning (development only)
# Tidak apa-apa untuk development lokal
```

---

### Issue 2: Database Connection Failed
**Symptom**: "SQLSTATE[HY000] [1049] Unknown database 'ilab_unmul'"

**Cause**: Database belum dibuat

**Solution**:
```bash
mysql -u root -p
CREATE DATABASE ilab_unmul CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;
```

---

### Issue 3: NPM Install Gagal
**Symptom**: "npm ERR! code ENOENT"

**Cause**: Node.js/NPM belum terinstall atau versi terlalu lama

**Solution**:
```bash
# Download dan install Node.js LTS dari nodejs.org
# Verify installation
node -v  # should show v18.x or higher
npm -v   # should show 9.x or higher
```

---

### Issue 4: Port 8000 Already in Use
**Symptom**: "Address already in use"

**Cause**: Port 8000 sudah digunakan aplikasi lain

**Solution**:
```bash
# Use different port
php artisan serve --port=8001

# Or kill process using port 8000 (Windows)
netstat -ano | findstr :8000
taskkill /PID <PID_NUMBER> /F
```

---

### Issue 5: Vite Not Loading in Browser
**Symptom**: Styles tidak load, console error "Failed to fetch dynamically imported module"

**Cause**: Vite dev server tidak running

**Solution**:
```bash
# Make sure Vite is running in separate terminal
npm run dev

# Check if http://127.0.0.1:5173 is accessible
```

---

### Issue 6: Tailwind Classes Not Working
**Symptom**: Classes seperti custom colors tidak working

**Cause**:
1. Tailwind CSS v4 menggunakan syntax berbeda untuk custom colors
2. Vite plugin belum dikonfigurasi
3. Browser cache

**Solution**:
```bash
# 1. Pastikan menggunakan syntax yang benar untuk Tailwind v4
# Custom colors: text-[--color-unmul-blue] bukan text-unmul-blue

# 2. Pastikan @tailwindcss/vite plugin sudah ditambahkan di vite.config.js
# import tailwindcss from '@tailwindcss/vite';
# plugins: [..., tailwindcss()]

# 3. Restart Vite dev server
npm run dev

# 4. Hard refresh browser (Ctrl + Shift + R)
# 5. Check browser DevTools → Network → app.css should load
```

---

### Issue 7: "Module not found: @tailwindcss/vite"
**Symptom**: Error saat menjalankan `npm run dev`

**Cause**: Package Tailwind CSS v4 belum terinstall

**Solution**:
```bash
# Install Tailwind CSS v4
npm install tailwindcss@next @tailwindcss/vite@next

# Verify installation
npm list tailwindcss
```

---

## 📚 Chapter Summary

### What We Accomplished ✅

In this chapter, we successfully:
- ✅ Installed Laravel 12 with PHP 8.3+
- ✅ Configured MariaDB database connection
- ✅ Installed and configured Tailwind CSS v4 (latest)
- ✅ Installed and configured Alpine.js
- ✅ Setup Vite 5.0 for modern asset bundling
- ✅ Created custom brand colors using CSS variables (UNMUL Blue, Innovation Orange, Tropical Green)
- ✅ Built a welcome page demonstrating all integrations
- ✅ Created and ran automated tests
- ✅ Verified everything works through manual and automated testing

### Key Takeaways 🎓

1. **Laravel 12** menggunakan Vite (bukan Laravel Mix) untuk asset compilation
2. **MariaDB** digunakan sebagai database (bukan MySQL) untuk better performance
3. **Tailwind CSS v4** menggunakan konfigurasi berbasis CSS dengan `@theme` directive (tidak ada `tailwind.config.js`)
4. **Custom colors** di Tailwind v4 menggunakan CSS variables dengan syntax `text-[--color-name]`
5. **Alpine.js** memberikan reactivity tanpa overhead besar seperti Vue/React
6. **Brand colors** didefinisikan sebagai CSS custom properties di `@theme` untuk consistency
7. **Development workflow**: 2 terminals (Vite + Laravel serve)
8. **Testing**: Automated tests penting untuk memastikan aplikasi berfungsi dengan benar

### Files Created/Modified 📁

**Created**:
- `tests/Feature/WelcomePageTest.php` - Automated test untuk welcome page

**Modified**:
- `.env` - Environment configuration (database, app name, timezone, locale)
- `resources/css/app.css` - Added Tailwind CSS v4 with `@import`, `@source`, and `@theme` directives
- `resources/js/app.js` - Added Alpine.js initialization
- `resources/views/welcome.blade.php` - Custom welcome page dengan brand colors
- `vite.config.js` - Added Tailwind CSS v4 Vite plugin
- `package.json` - Added Tailwind CSS v4 dan Alpine.js dependencies

**NOT Created** (important for Tailwind v4):
- ❌ `tailwind.config.js` - Tidak diperlukan di Tailwind CSS v4
- ❌ `postcss.config.js` - Tidak diperlukan di Tailwind CSS v4

### Project Structure Now 📂

```
ilab_unmul/
├── app/
├── config/
├── database/
├── docs/
│   ├── tutorials/
│   │   └── Chapter-01-Project-Setup.md
│   └── AI_PROMPT_ILAB_WEBAPP.md
├── public/
├── resources/
│   ├── css/
│   │   └── app.css (✨ Tailwind configured)
│   ├── js/
│   │   └── app.js (✨ Alpine.js configured)
│   └── views/
│       └── welcome.blade.php (✨ Custom page)
├── routes/
├── storage/
├── tasks/
│   ├── todo.md
│   └── analysis-summary.md
├── tests/
│   └── Feature/
│       └── WelcomePageTest.php (✨ New test)
├── .env (✨ Configured)
├── vite.config.js (✨ Updated with @tailwindcss/vite)
└── composer.json

**Files NOT Created** (Tailwind v4 doesn't need these):
- ❌ `tailwind.config.js` - Configuration in CSS now
- ❌ `postcss.config.js` - Handled by Vite plugin
```

---

## 🔜 Next Chapter

In **Chapter 2: Authentication System**, we'll build:
- ✅ User registration & login system
- ✅ Role-based access (11 roles for iLab UNMUL)
- ✅ Custom authentication views dengan branding UNMUL
- ✅ Password reset functionality
- ✅ Email verification

**Preview**:
```bash
# Chapter 2 akan install:
composer require laravel/breeze --dev
php artisan breeze:install blade
php artisan migrate
```

---

**🎉 Congratulations!**

Anda telah berhasil menyelesaikan Chapter 1!

Environment development Laravel 12 + Tailwind + Alpine.js + Vite sudah siap untuk development iLab UNMUL System.

---

**Generated with**: iLab UNMUL Tutorial Series
**Author**: AI Assistant
**Date**: 2025-01-10
**Version**: 1.0
