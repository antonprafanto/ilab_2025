# Dokumentasi Deployment iLab UNMUL

## Daftar Isi
1. [Informasi Server](#informasi-server)
2. [Flow Development & Deployment](#flow-development--deployment)
3. [Langkah-langkah Deployment](#langkah-langkah-deployment)
4. [Troubleshooting](#troubleshooting)
5. [Checklist Deployment](#checklist-deployment)

---

## Informasi Server

### Production Server
- **Domain**: ilab.unmul.ac.id
- **SSH User**: ilab@ilab.unmul.ac.id
- **Laravel Path**: `/home/ilab/laravel`
- **Public Path**: `/home/ilab/public_html`
- **PHP Version**: 8.4.14
- **Laravel Version**: 12.32.5
- **Server Management**: Virtualmin/Webmin

### Repository
- **GitHub**: https://github.com/[your-username]/ilab_v1
- **Branch**: main

---

## Flow Development & Deployment

### Development (Local Environment)

```
┌─────────────────────────────────────────────────────────────┐
│ 1. Fix Bug / Add Feature                                    │
│    - Edit code di local                                      │
│    - Test di local environment                               │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│ 2. Build Frontend Assets                                    │
│    $ npm run build                                           │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│ 3. Commit & Push to GitHub                                  │
│    $ git add .                                               │
│    $ git commit -m "fix: description"                        │
│    $ git push origin main                                    │
└─────────────────────────────────────────────────────────────┘
```

### Deployment (Production Server)

```
┌─────────────────────────────────────────────────────────────┐
│ 4. SSH ke Production Server                                 │
│    $ ssh ilab@ilab.unmul.ac.id                              │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│ 5. Pull Latest Changes                                      │
│    $ cd /home/ilab/laravel                                  │
│    $ git pull origin main                                   │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│ 6. Update Dependencies (jika ada perubahan)                 │
│    $ composer install --optimize-autoloader --no-dev        │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│ 7. Clear & Cache Optimization                               │
│    $ php artisan optimize:clear                             │
│    $ php artisan config:cache                               │
│    $ php artisan route:cache                                │
│    $ php artisan view:cache                                 │
└─────────────────────────────────────────────────────────────┘
                           ↓
┌─────────────────────────────────────────────────────────────┐
│ 8. Verify Website                                           │
│    - Akses https://ilab.unmul.ac.id                         │
│    - Test fitur yang diubah                                 │
└─────────────────────────────────────────────────────────────┘
```

---

## Langkah-langkah Deployment

### A. Di Local (Development)

#### 1. Fix Bug atau Add Feature
```bash
# Edit code menggunakan editor favorit
# Test di local: http://localhost/ilab_v1
```

#### 2. Build Frontend Assets
```bash
npm run build
```

**Output yang diharapkan:**
```
vite v7.1.7 building for production...
✓ 66 modules transformed.
public/build/manifest.json              0.31 kB │ gzip:   0.17 kB
public/build/assets/app-RCRfJARG.css   75.48 kB │ gzip:  11.33 kB
public/build/assets/app-DrMxDsOA.js   338.57 kB │ gzip: 104.89 kB
✓ built in 4.19s
```

#### 3. Commit & Push ke GitHub
```bash
git add .
git commit -m "fix: deskripsi perubahan"
git push origin main
```

**Format Commit Message:**
- `fix:` - Bug fix
- `feat:` - New feature
- `refactor:` - Code refactoring
- `docs:` - Documentation changes
- `style:` - UI/styling changes
- `test:` - Adding tests
- `chore:` - Maintenance tasks

---

### B. Di Production Server

#### 1. SSH ke Server
```bash
ssh ilab@ilab.unmul.ac.id
```

Atau dari Windows menggunakan PuTTY dengan:
- Host: ilab.unmul.ac.id
- Port: 22
- Username: ilab

#### 2. Navigate ke Laravel Directory
```bash
cd /home/ilab/laravel
```

#### 3. Pull Latest Changes dari GitHub
```bash
git pull origin main
```

**Jika ada conflict:**
```bash
# Backup file .env
cp .env .env.backup

# Force pull
git fetch origin
git reset --hard origin/main

# Restore .env
cp .env.backup .env
```

#### 4. Update Composer Dependencies (Jika Diperlukan)
```bash
composer install --optimize-autoloader --no-dev
```

**Kapan perlu dijalankan:**
- Ada perubahan di `composer.json`
- Ada package baru yang ditambahkan
- Setelah first-time deployment

#### 5. Run Database Migrations (Jika Ada)
```bash
php artisan migrate --force
```

**PENTING:** Gunakan `--force` flag karena production environment.

#### 6. Clear All Caches
```bash
# Clear semua cache
php artisan optimize:clear

# Cache optimization untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Penjelasan:**
- `optimize:clear` - Clear config, cache, compiled, events, routes, views
- `config:cache` - Cache konfigurasi untuk performance
- `route:cache` - Cache routing untuk performance
- `view:cache` - Compile semua Blade templates

#### 7. Set File Permissions (Jika Diperlukan)
```bash
chmod -R 775 storage bootstrap/cache
```

#### 8. Verify Deployment
```bash
# Cek status git
git status

# Cek versi terakhir
git log -1 --oneline

# Cek Laravel environment
php artisan about
```

---

## Troubleshooting

### Problem 1: 500 Internal Server Error

**Kemungkinan Penyebab:**
1. APP_KEY belum di-generate
2. Cache issue
3. Permission issue
4. Vite manifest not found

**Solusi:**

```bash
# Enable debug mode sementara
sed -i 's/APP_DEBUG=false/APP_DEBUG=true/' .env
php artisan config:clear

# Lihat error detail di browser
# Setelah ketahuan errornya, fix lalu disable debug

sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env
php artisan config:cache
```

### Problem 2: Vite Manifest Not Found

**Error Message:**
```
Vite manifest not found at: /home/ilab/laravel/public/build/manifest.json
```

**Solusi:**

**Option A: Build di local & push ke Git (Recommended)**
```bash
# Di local
npm run build
git add public/build
git commit -m "build: Update assets"
git push origin main

# Di server
git pull origin main
```

**Option B: Upload manual via SCP**
```bash
# Di local (Windows Git Bash)
scp -r public/build ilab@ilab.unmul.ac.id:/home/ilab/laravel/public/
```

### Problem 3: Git Pull Conflicts

**Error Message:**
```
error: Your local changes to the following files would be overwritten by checkout
```

**Solusi:**
```bash
# Backup .env
cp .env .env.backup

# Force reset
git fetch origin
git reset --hard origin/main

# Restore .env
cp .env.backup .env

# Clear cache
php artisan optimize:clear
```

### Problem 4: Permission Denied

**Solusi:**
```bash
# Set ownership
chown -R ilab:ilab /home/ilab/laravel

# Set permissions
chmod -R 775 storage bootstrap/cache
chmod -R 664 storage/logs/*.log
```

### Problem 5: Composer Dependencies Error

**Error Message:**
```
Fatal error: require(/home/ilab/laravel/vendor/autoload.php): Failed to open stream
```

**Solusi:**
```bash
composer install --optimize-autoloader --no-dev
```

### Problem 6: Database Connection Error

**Solusi:**
```bash
# Cek konfigurasi database di .env
cat .env | grep DB_

# Test koneksi database
php artisan tinker
>>> DB::connection()->getPdo();
```

---

## Checklist Deployment

### Pre-Deployment (Local)
- [ ] Semua fitur baru sudah di-test di local
- [ ] Tidak ada error di local environment
- [ ] Run `npm run build` berhasil
- [ ] Commit message jelas dan deskriptif
- [ ] Push ke GitHub berhasil

### Deployment (Production)
- [ ] SSH ke server production
- [ ] Navigate ke `/home/ilab/laravel`
- [ ] Backup file `.env` (jika perlu)
- [ ] `git pull origin main` berhasil
- [ ] `composer install` (jika ada perubahan dependencies)
- [ ] `php artisan migrate --force` (jika ada migration baru)
- [ ] `php artisan optimize:clear` berhasil
- [ ] `php artisan config:cache` berhasil
- [ ] `php artisan route:cache` berhasil
- [ ] `php artisan view:cache` berhasil
- [ ] File permissions sudah benar (775 untuk storage)

### Post-Deployment Verification
- [ ] Website https://ilab.unmul.ac.id bisa diakses
- [ ] Tidak ada 500 error
- [ ] Login berfungsi normal
- [ ] Fitur baru/yang di-fix berfungsi dengan baik
- [ ] UI tampil dengan benar (CSS & JS loaded)
- [ ] Test di berbagai browser (Chrome, Firefox, Safari)
- [ ] Check mobile responsiveness

### Final Steps
- [ ] `APP_DEBUG=false` di production
- [ ] `APP_ENV=production` di production
- [ ] Monitor error logs: `tail -f storage/logs/laravel.log`
- [ ] Update dokumentasi jika ada perubahan flow

---

## Tips & Best Practices

### 1. Selalu Build di Local Sebelum Push
```bash
# GOOD ✅
npm run build
git add .
git commit -m "feat: new feature"
git push

# BAD ❌
git add .
git commit -m "feat: new feature"
git push
npm run build  # Terlambat!
```

### 2. Jangan Commit File Sensitive
File yang harus di `.gitignore`:
- `.env`
- `node_modules/`
- `vendor/` (optional, tapi biasanya di-ignore)
- `storage/logs/*.log`
- `*.key`, `*.pem`

File yang HARUS di-commit:
- `public/build/` (hasil build Vite)
- `composer.lock`
- `package-lock.json`

### 3. Gunakan Meaningful Commit Messages
```bash
# GOOD ✅
git commit -m "fix: Resolve null reference errors in user approval pages"
git commit -m "feat: Add dark mode support"
git commit -m "refactor: Optimize database queries in dashboard"

# BAD ❌
git commit -m "fix bug"
git commit -m "update"
git commit -m "asdfsadf"
```

### 4. Clear Cache Setelah Setiap Deploy
```bash
# Minimal command
php artisan optimize:clear

# Full optimization (production)
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 5. Monitor Logs di Production
```bash
# Follow log secara real-time
tail -f storage/logs/laravel.log

# Lihat 50 baris terakhir
tail -50 storage/logs/laravel.log

# Search error tertentu
grep "ERROR" storage/logs/laravel.log | tail -20
```

### 6. Backup Database Sebelum Migration
```bash
# Backup database
mysqldump -u username -p database_name > backup_$(date +%Y%m%d).sql

# Atau via Virtualmin/Webmin interface
```

---

## Emergency Rollback

Jika deployment menyebabkan error critical:

### 1. Rollback ke Commit Sebelumnya
```bash
# Lihat commit history
git log --oneline -5

# Rollback ke commit tertentu
git reset --hard <commit-hash>

# Clear cache
php artisan optimize:clear
```

### 2. Restore dari Backup
```bash
# Restore .env
cp .env.backup .env

# Restore database
mysql -u username -p database_name < backup_YYYYMMDD.sql
```

---

## Quick Reference Commands

### Local Development
```bash
npm run dev          # Development server dengan hot reload
npm run build        # Build untuk production
php artisan serve    # Laravel development server
```

### Production Deployment
```bash
ssh ilab@ilab.unmul.ac.id
cd /home/ilab/laravel
git pull origin main
composer install --optimize-autoloader --no-dev
php artisan migrate --force
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Debugging
```bash
php artisan about                    # System information
php artisan route:list              # List semua routes
php artisan tinker                  # Laravel REPL
tail -f storage/logs/laravel.log    # Monitor logs
```

---

## Kontak & Support

### Project Maintainer
- **Email**: [your-email@unmul.ac.id]
- **GitHub Issues**: https://github.com/[your-username]/ilab_v1/issues

### Server Administrator
- **Virtualmin**: https://ilab.unmul.ac.id:10000
- **Support**: [admin-email@unmul.ac.id]

---

**Last Updated**: 2025-01-06
**Version**: 1.0.0
