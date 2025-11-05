# 📁 Struktur Project iLab UNMUL (Setelah Dirapikan)

## 🎯 Root Directory (Yang Terlihat Sekarang)

```
C:\xampp\htdocs\ilab_v1\
│
├── 📁 app/                          ✅ UPLOAD - Laravel application code
├── 📁 bootstrap/                    ✅ UPLOAD - Bootstrap files
├── 📁 config/                       ✅ UPLOAD - Configuration files
├── 📁 database/                     ✅ UPLOAD - Migrations & seeders
├── 📁 public/                       ✅ UPLOAD - Public assets (PENTING!)
│   ├── build/                       ← Hasil npm run build
│   ├── images/                      ← Logo & favicon
│   ├── .htaccess                    ← Rewrite rules
│   └── index.php                    ← Laravel entry point
├── 📁 resources/                    ✅ UPLOAD - Views, CSS, JS
├── 📁 routes/                       ✅ UPLOAD - Route definitions
├── 📁 storage/                      ✅ UPLOAD (kosongkan isinya!)
│
├── 📁 _docs/                        ⚠️  OPTIONAL (dokumentasi deployment)
│   ├── BETA_NOTES.md
│   ├── CHANGELOG.md
│   ├── DEPLOYMENT_GUIDE.md
│   ├── DEPLOYMENT_UNMUL.md          ← Panduan khusus UNMUL
│   ├── PRODUCTION_CHECKLIST.md
│   └── UPLOAD_CHECKLIST.md
│
├── 📁 docs/                         ⚠️  OPTIONAL (dokumentasi lama)
├── 📁 tasks/                        ⚠️  OPTIONAL (task management)
├── 📁 tests/                        ⚠️  OPTIONAL (unit tests)
│
├── 📁 node_modules/                 ❌ JANGAN UPLOAD (~300 MB)
├── 📁 vendor/                       ❌ JANGAN UPLOAD (install di server)
│
├── 📄 .editorconfig                 ⚠️  Optional
├── 📄 .env                          ❌ JANGAN UPLOAD (buat baru di server)
├── 📄 .env.example                  ✅ UPLOAD (template)
├── 📄 .env.production.example       ✅ UPLOAD (template production)
├── 📄 .gitattributes                ⚠️  Optional
├── 📄 .gitignore                    ⚠️  Optional
├── 📄 .htaccess                     ✅ UPLOAD (security untuk root)
├── 📄 .phpunit.result.cache         ❌ JANGAN UPLOAD
│
├── 📄 artisan                       ✅ UPLOAD (Laravel CLI)
├── 📄 composer.json                 ✅ UPLOAD (PHP dependencies)
├── 📄 composer.lock                 ✅ UPLOAD (dependency versions)
├── 📄 deploy.sh                     ✅ UPLOAD (deployment script)
├── 📄 package.json                  ✅ UPLOAD (JS dependencies)
├── 📄 package-lock.json             ✅ UPLOAD (dependency versions)
├── 📄 phpunit.xml                   ⚠️  Optional (testing config)
├── 📄 postcss.config.js             ✅ UPLOAD
├── 📄 tailwind.config.js            ✅ UPLOAD
├── 📄 vite.config.js                ✅ UPLOAD
│
├── 📄 FILES_TO_UPLOAD.md            📖 BACA INI DULU! (panduan upload)
├── 📄 PROJECT_STRUCTURE.md          📖 File ini
└── 📄 README.md                     📖 Dokumentasi utama
```

---

## ✅ File yang Sudah DIRAPIKAN

### File Debug/Temporary yang DIHAPUS:
```
✅ debug_fullcalendar.html          - Dihapus
✅ simple_calendar_test.html        - Dihapus
✅ test_calendar.html               - Dihapus
✅ CALENDAR_DEBUG_REPORT.md         - Dihapus
✅ nul                               - Dihapus
```

### Folder Aneh yang DIHAPUS:
```
✅ c:xampphtdocsilab_v1resourcesviewsequipment  - Dihapus
✅ resourcesviewssops                            - Dihapus
✅ resourcesviewssopspartials                    - Dihapus
```

### Dokumentasi yang DIPINDAHKAN ke `_docs/`:
```
✅ BETA_NOTES.md                    → _docs/
✅ CHANGELOG.md                     → _docs/
✅ DEPLOYMENT_GUIDE.md              → _docs/
✅ DEPLOYMENT_UNMUL.md              → _docs/
✅ PRODUCTION_CHECKLIST.md          → _docs/
✅ UPLOAD_CHECKLIST.md              → _docs/
```

---

## 📊 Size Summary

| Category | Size | Upload? |
|----------|------|---------|
| **Laravel Core** (app, config, routes) | ~5 MB | ✅ Ya |
| **Database** (migrations, seeders) | ~1 MB | ✅ Ya |
| **Resources** (views, css, js) | ~2 MB | ✅ Ya |
| **Public** (build assets) | ~2 MB | ✅ Ya |
| **Storage** (struktur kosong) | ~100 KB | ✅ Ya |
| **Config files** (.htaccess, composer.json, dll) | ~500 KB | ✅ Ya |
| **Documentation** (_docs, README) | ~500 KB | ⚠️  Optional |
| | | |
| **TOTAL UPLOAD** | **~10-15 MB** | ✅ |
| | | |
| node_modules | ~300 MB | ❌ Jangan |
| vendor | ~80 MB | ❌ Jangan |
| .git | ~50 MB | ❌ Jangan |

---

## 🎯 Langkah Selanjutnya

### 1. Persiapan Upload (5 menit)
```bash
# Build assets production
npm run build

# Clear Laravel cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Kosongkan storage content (PENTING!)
# Hapus file .log, cache, sessions, views
# Tapi JANGAN hapus folder dan .gitignore
```

### 2. Upload ke Hosting (10 menit)
Baca: **[FILES_TO_UPLOAD.md](FILES_TO_UPLOAD.md)**

Drag & drop folder & file yang ditandai ✅ ke WinSCP.

### 3. Setup di Server (10 menit)
Baca: **[_docs/DEPLOYMENT_UNMUL.md](_docs/DEPLOYMENT_UNMUL.md)**

- Buat .env file
- Install composer dependencies
- Generate APP_KEY
- Run migrations
- Set permissions

### 4. Test Website (5 menit)
Akses: https://ilab.unmul.ac.id

---

## 📝 Quick Reference

### File Penting yang Harus Ada Setelah Upload:

```
✅ public/index.php              - Entry point Laravel
✅ public/.htaccess              - Rewrite rules
✅ public/build/manifest.json    - Asset manifest (dari npm run build)
✅ .htaccess (root)              - Security headers
✅ artisan                       - Laravel CLI
✅ composer.json                 - Dependencies
✅ storage/                      - Struktur folder lengkap
```

### Credentials Server:

```
Domain: ilab.unmul.ac.id
SFTP Host: ilab.unmul.ac.id
Port: 22
Username: ilab
Password: yG2cSqEwGWIKumX

Database: ilab
DB User: ilab
DB Pass: yG2cSqEwGWIKumX
phpMyAdmin: https://ilab.unmul.ac.id/phpmyadmin/
```

---

## ✅ Status Project

**Version:** 0.3.0-beta
**Status:** 🟡 Production Ready (Fase 3)
**Last Updated:** 4 November 2024

**Fitur Working:**
- ✅ Landing Page
- ✅ Authentication & User Approval
- ✅ Master Data Management
- ✅ Admin Panel

**Coming Soon (Fase 4+):**
- ⏳ Booking System
- ⏳ Service Request
- ⏳ SOP Management
- ⏳ Reports & Analytics

---

**🎉 Project sudah RAPI dan SIAP DEPLOY!**
