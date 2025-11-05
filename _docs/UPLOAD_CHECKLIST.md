# Checklist File & Folder untuk Upload ke ilab.unmul.ac.id

## ✅ **WAJIB DIUPLOAD** (Total ~50-100 MB)

### 1. **Folder Aplikasi Laravel**

```
📁 app/                          ✅ UPLOAD (semua file)
   ├── Console/
   ├── Exceptions/
   ├── Http/
   │   ├── Controllers/
   │   ├── Middleware/
   │   └── Requests/
   ├── Models/
   └── Providers/
```

```
📁 bootstrap/                    ✅ UPLOAD (semua file)
   ├── cache/                    ✅ UPLOAD (kosongkan isinya, hanya .gitignore)
   │   └── .gitignore
   ├── app.php
   └── providers.php
```

```
📁 config/                       ✅ UPLOAD (semua file)
   ├── app.php
   ├── auth.php
   ├── cache.php
   ├── database.php
   ├── filesystems.php
   ├── logging.php
   ├── mail.php
   ├── permission.php
   ├── queue.php
   ├── services.php
   ├── session.php
   └── ... (semua file .php)
```

```
📁 database/                     ✅ UPLOAD (semua file)
   ├── factories/
   ├── migrations/               ✅ PENTING! (semua migration files)
   ├── seeders/                  ✅ PENTING! (terutama RolePermissionSeeder)
   └── .gitignore
```

```
📁 public/                       ✅ UPLOAD (semua file)
   ├── build/                    ✅ PENTING! (hasil npm run build)
   │   ├── assets/
   │   │   ├── app-*.css
   │   │   └── app-*.js
   │   └── manifest.json
   ├── images/                   ✅ UPLOAD (kosong dulu, nanti upload logo manual)
   │   └── README.md
   ├── .htaccess                 ✅ PENTING! (untuk rewrite rules)
   ├── favicon.ico
   ├── index.php                 ✅ PENTING! (entry point Laravel)
   └── robots.txt
```

```
📁 resources/                    ✅ UPLOAD (semua file)
   ├── css/
   │   └── app.css
   ├── js/
   │   ├── app.js
   │   └── bootstrap.js
   └── views/                    ✅ PENTING! (semua blade templates)
       ├── admin/
       ├── auth/
       ├── components/
       ├── equipment/
       ├── laboratories/
       ├── layouts/
       ├── profile/
       ├── services/
       ├── dashboard.blade.php
       └── welcome.blade.php     ✅ PENTING! (landing page)
```

```
📁 routes/                       ✅ UPLOAD (semua file)
   ├── auth.php
   ├── console.php
   └── web.php                   ✅ PENTING! (semua routes)
```

```
📁 storage/                      ✅ UPLOAD (struktur saja, bukan isinya)
   ├── app/
   │   ├── private/
   │   │   └── .gitignore
   │   ├── public/
   │   │   └── .gitignore
   │   └── .gitignore
   ├── framework/
   │   ├── cache/
   │   │   ├── data/
   │   │   │   └── .gitignore
   │   │   └── .gitignore
   │   ├── sessions/
   │   │   └── .gitignore
   │   ├── testing/
   │   │   └── .gitignore
   │   └── views/
   │       └── .gitignore
   └── logs/
       └── .gitignore

⚠️ PENTING: Upload STRUKTUR folder storage, tapi KOSONGKAN isinya!
   Hanya upload file .gitignore di setiap subfolder.
```

### 2. **File Root (di root project)**

```
📄 .htaccess                     ✅ UPLOAD (security untuk root)
📄 artisan                       ✅ UPLOAD (Laravel CLI)
📄 composer.json                 ✅ UPLOAD (dependency list)
📄 composer.lock                 ✅ UPLOAD (dependency versions)
📄 package.json                  ✅ UPLOAD (untuk dokumentasi)
📄 package-lock.json             ✅ UPLOAD (untuk dokumentasi)
📄 postcss.config.js             ✅ UPLOAD
📄 tailwind.config.js            ✅ UPLOAD
📄 vite.config.js                ✅ UPLOAD
📄 README.md                     ✅ UPLOAD (dokumentasi)
📄 CHANGELOG.md                  ✅ UPLOAD (dokumentasi)
📄 BETA_NOTES.md                 ✅ UPLOAD (dokumentasi)
📄 DEPLOYMENT_GUIDE.md           ✅ UPLOAD (dokumentasi)
📄 DEPLOYMENT_UNMUL.md           ✅ UPLOAD (dokumentasi)
📄 PRODUCTION_CHECKLIST.md       ✅ UPLOAD (dokumentasi)
📄 UPLOAD_CHECKLIST.md           ✅ UPLOAD (dokumentasi ini)
```

### 3. **File Environment (BUAT BARU DI SERVER)**

```
📄 .env                          ❌ JANGAN UPLOAD dari lokal!
                                 ✅ BUAT BARU di server setelah upload

Copy dari .env.production.example dan edit dengan kredensial UNMUL
```

---

## ❌ **JANGAN DIUPLOAD** (Exclude)

### 1. **Dependencies (akan diinstall di server)**

```
📁 node_modules/                 ❌ JANGAN! (~200-500 MB, akan lama)
📁 vendor/                       ❌ JANGAN! (~50-100 MB)
                                    Install via composer di server:
                                    composer install --no-dev
```

### 2. **Environment & Config**

```
📄 .env                          ❌ JANGAN! (kredensial lokal, buat baru di server)
📄 .env.backup                   ❌ JANGAN!
📄 .env.production               ❌ JANGAN!
```

### 3. **Development Files**

```
📄 .phpunit.result.cache         ❌ JANGAN!
📄 phpunit.xml                   ⚠️  Optional (hanya untuk testing)
📁 tests/                        ⚠️  Optional (hanya untuk testing)
📁 .vscode/                      ❌ JANGAN!
📁 .idea/                        ❌ JANGAN!
```

### 4. **Debug & Temporary Files**

```
📄 debug_fullcalendar.html       ❌ JANGAN!
📄 simple_calendar_test.html     ❌ JANGAN!
📄 test_calendar.html            ❌ JANGAN!
📄 CALENDAR_DEBUG_REPORT.md      ❌ JANGAN!
📄 nul                           ❌ JANGAN!
```

### 5. **Storage Content (hanya struktur yang diupload)**

```
📁 storage/logs/*.log            ❌ JANGAN! (log files lama)
📁 storage/framework/cache/*     ❌ JANGAN! (cache files)
📁 storage/framework/sessions/*  ❌ JANGAN! (session files)
📁 storage/framework/views/*     ❌ JANGAN! (compiled views)

✅ Yang diupload: hanya file .gitignore di setiap subfolder
```

### 6. **Git Files**

```
📁 .git/                         ❌ JANGAN! (git history, besar)
📄 .gitignore                    ⚠️  Optional (untuk dokumentasi)
📄 .gitattributes                ⚠️  Optional
```

### 7. **Build Source (sudah dikompile ke public/build)**

```
📁 resources/css/ (file source)  ⚠️  UPLOAD tapi tidak wajib
📁 resources/js/ (file source)   ⚠️  UPLOAD tapi tidak wajib

Yang penting: public/build/ sudah ada (hasil npm run build)
```

---

## 📊 **Estimasi Size**

| Kategori | Size | Status |
|----------|------|--------|
| Laravel Core (app, config, routes, etc) | ~5 MB | ✅ Upload |
| Database (migrations, seeders) | ~1 MB | ✅ Upload |
| Resources (views, css, js source) | ~2 MB | ✅ Upload |
| Public (build assets) | ~1-2 MB | ✅ Upload |
| Storage (struktur kosong) | ~100 KB | ✅ Upload |
| Documentation | ~500 KB | ✅ Upload |
| **Total Upload** | **~10-15 MB** | ✅ |
| | | |
| node_modules (exclude) | ~300 MB | ❌ Jangan |
| vendor (exclude) | ~80 MB | ❌ Jangan |
| .git (exclude) | ~50 MB | ❌ Jangan |

**Upload time estimate:** 5-10 menit (tergantung koneksi internet)

---

## 🚀 **Step-by-Step Upload Process**

### Persiapan Sebelum Upload

#### 1. Build Production Assets
```bash
cd C:\xampp\htdocs\ilab_v1
npm run build
```

Pastikan folder `public/build/` sudah terisi:
```
public/build/
├── assets/
│   ├── app-B1qvAq4B.css
│   └── app-DrMxDsOA.js
└── manifest.json
```

#### 2. Clear Cache Lokal
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

#### 3. Kosongkan Storage Content (Optional)
Jika ingin upload storage yang bersih:
```bash
# Hapus isi storage (bukan foldernya)
del /s /q storage\logs\*.log
del /s /q storage\framework\cache\data\*
del /s /q storage\framework\sessions\*
del /s /q storage\framework\views\*
```

### Upload via WinSCP

#### 1. Connect ke Server
- Host: `ilab.unmul.ac.id`
- Port: `22`
- Username: `ilab`
- Password: `yG2cSqEwGWIKumX`

#### 2. Create Folder Structure
```
/home/ilab/
├── laravel/              ← Create folder ini
└── public_html/          ← Sudah ada
```

#### 3. Upload Files

**Cara Manual (Drag & Drop):**
1. Buka WinSCP
2. Kiri = Lokal (C:\xampp\htdocs\ilab_v1)
3. Kanan = Server (/home/ilab/laravel)
4. Select folders & drag dari kiri ke kanan:
   - ✅ app/
   - ✅ bootstrap/
   - ✅ config/
   - ✅ database/
   - ✅ public/
   - ✅ resources/
   - ✅ routes/
   - ✅ storage/ (struktur saja)
   - ✅ All files (.htaccess, artisan, composer.json, dll)

**Exclude saat upload:**
- ❌ node_modules/
- ❌ vendor/
- ❌ .env
- ❌ .git/
- ❌ storage/logs/*.log
- ❌ storage/framework/cache/*
- ❌ storage/framework/sessions/*
- ❌ storage/framework/views/*

#### 4. Verify Upload
Check di server bahwa struktur folder benar:
```
/home/ilab/laravel/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
│   ├── build/          ← Pastikan ada!
│   ├── .htaccess       ← Pastikan ada!
│   └── index.php       ← Pastikan ada!
├── resources/
├── routes/
├── storage/
├── artisan
├── composer.json
└── composer.lock
```

---

## ⚙️ **After Upload - Setup di Server**

### 1. Create .env File
Di server, create file `.env` di `/home/ilab/laravel/.env`:

```env
APP_NAME="iLab UNMUL"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://ilab.unmul.ac.id
APP_TIMEZONE=Asia/Makassar

APP_LOCALE=id
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=id_ID

LOG_CHANNEL=daily
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ilab
DB_USERNAME=ilab
DB_PASSWORD=yG2cSqEwGWIKumX

SESSION_DRIVER=database
SESSION_LIFETIME=120

CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525

VITE_APP_NAME="${APP_NAME}"
```

### 2. Install Composer Dependencies
Via SSH atau Terminal di Web Panel:
```bash
cd /home/ilab/laravel
composer install --optimize-autoloader --no-dev
```

**Jika tidak ada composer**, alternatif:
- Install composer lokal dengan `--no-dev`
- Upload folder `vendor/` via SFTP (akan lama ~15-30 menit)

### 3. Generate Application Key
```bash
php artisan key:generate
```

### 4. Set Permissions
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### 5. Create Storage Link
```bash
php artisan storage:link
```

### 6. Run Migrations
```bash
php artisan migrate --force
php artisan db:seed --class=RolePermissionSeeder --force
```

### 7. Optimize for Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 8. Upload Logo Files
Upload ke `/home/ilab/laravel/public/images/`:
- logo-unmul.png
- logo-blu.png
- favicon.png
- og-image.jpg

---

## ✅ **Final Checklist**

### Files Structure
- [ ] Semua folder Laravel uploaded
- [ ] `public/build/` ada dan berisi assets
- [ ] `public/.htaccess` ada
- [ ] `public/index.php` ada
- [ ] `storage/` struktur lengkap
- [ ] `.env` file created di server
- [ ] `vendor/` terinstall via composer

### Configuration
- [ ] `.env` configured dengan kredensial UNMUL
- [ ] `APP_KEY` generated
- [ ] Database credentials correct
- [ ] Permissions set (775 for storage)

### Database
- [ ] Migrations run successfully
- [ ] RolePermissionSeeder run
- [ ] Database `ilab` has tables

### Testing
- [ ] https://ilab.unmul.ac.id loads
- [ ] Landing page displays correctly
- [ ] Login page accessible
- [ ] No 500 errors
- [ ] CSS/JS loaded correctly

---

## 🔧 **Quick Commands Reference**

### Via SSH
```bash
# Navigate to project
cd /home/ilab/laravel

# Install dependencies
composer install --optimize-autoloader --no-dev

# Generate key
php artisan key:generate

# Set permissions
chmod -R 775 storage bootstrap/cache

# Storage link
php artisan storage:link

# Run migrations
php artisan migrate --force
php artisan db:seed --class=RolePermissionSeeder --force

# Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Check Laravel version
php artisan --version

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit
```

---

## 📞 **Need Help?**

Jika mengalami kesulitan:
1. Check Laravel logs: `/home/ilab/laravel/storage/logs/laravel.log`
2. Contact UPT TIK: helpdesk@ict.unmul.ac.id
3. Phone: +62 541 735055 - 738327

---

**Last Updated:** 4 November 2024
**Version:** 0.3.0-beta
