# Panduan Deployment ke ilab.unmul.ac.id

**Domain:** ilab.unmul.ac.id
**Hosting Provider:** UPT Teknologi Informasi dan Komunikasi - Universitas Mulawarman
**Tanggal Penyediaan:** 09 Oktober 2024

---

## 🔐 Kredensial Hosting

**PENTING:** Simpan informasi ini dengan aman dan jangan share ke publik!

### Server Information
```
Domain: ilab.unmul.ac.id
IP Publik: 103.187.89.240
IP Lokal: 192.168.33.240
```

### SFTP Access (File Upload)
```
Host: ilab.unmul.ac.id
Port: 22
Username: ilab
Password: yG2cSqEwGWIKumX
Protocol: SFTP
```

**Recommended SFTP Client:** WinSCP, FileZilla

### Database Access
```
phpMyAdmin: https://ilab.unmul.ac.id/phpmyadmin/
Database Name: ilab
Username: ilab
Password: yG2cSqEwGWIKumX
Port: 3306
Host: localhost (atau 127.0.0.1)
```

### Web Hosting Panel
```
URL: https://ilab.unmul.ac.id:10000
```

### Support Contact
```
Email: helpdesk@ict.unmul.ac.id
UPT TIK UNMUL
Telp/Fax: +62 541 735055 - 738327
```

---

## 📋 Pre-Deployment Checklist

### 1. Persiapan Lokal

- [ ] Build production assets
```bash
npm run build
```

- [ ] Clear semua cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

- [ ] Test aplikasi lokal
```bash
php artisan serve
# Akses http://localhost:8000 dan test semua fitur
```

- [ ] Backup database lokal (jika ada data)
```bash
mysqldump -u root -p ilab_unmul > backup_local_$(date +%Y%m%d).sql
```

### 2. Persiapan Files untuk Upload

**Exclude dari upload (sudah ada di .gitignore):**
- `/node_modules` (besar, tidak perlu)
- `/vendor` (akan install di server)
- `.env` (akan create baru di server)
- `/storage/logs/*` (file log lama)
- `/storage/framework/cache/*`
- `/storage/framework/sessions/*`
- `/storage/framework/views/*`

**Files yang HARUS diupload:**
- Semua file Laravel (app, config, database, routes, resources, public, dll)
- `/public/build` (hasil npm run build)
- `/storage` directory structure (tapi bukan isinya)
- `composer.json` dan `composer.lock`
- `.htaccess` files

---

## 🚀 Deployment Steps

### Step 1: Connect via SFTP

**Menggunakan WinSCP:**

1. Download WinSCP: https://winscp.net/
2. Install dan buka WinSCP
3. Klik **New Session**
4. Isi konfigurasi:
   - **File protocol:** SFTP
   - **Host name:** ilab.unmul.ac.id
   - **Port number:** 22
   - **User name:** ilab
   - **Password:** yG2cSqEwGWIKumX
5. Klik **Login**

**Menggunakan FileZilla:**

1. Download FileZilla: https://filezilla-project.org/
2. Install dan buka FileZilla
3. Pilih **File** → **Site Manager** → **New Site**
4. Isi konfigurasi:
   - **Protocol:** SFTP
   - **Host:** ilab.unmul.ac.id
   - **Port:** 22
   - **Logon Type:** Normal
   - **User:** ilab
   - **Password:** yG2cSqEwGWIKumX
5. Klik **Connect**

### Step 2: Cek Struktur Server

Setelah connect, explore struktur directory server:

```
/home/ilab/
├── public_html/        ← Document root (ini yang diakses via browser)
├── logs/
└── ...
```

**PENTING:** Pastikan document root mengarah ke `/home/ilab/public_html`

### Step 3: Upload Files

**Opsi A: Upload Langsung ke public_html (Tidak Recommended)**
- Document root harus ke `public_html/public`

**Opsi B: Upload ke Parent Directory (Recommended)**
```
/home/ilab/
├── laravel/                  ← Upload semua file Laravel ke sini
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/              ← Ini yang harus jadi document root
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   ├── .env
│   ├── artisan
│   └── composer.json
└── public_html/             ← Symlink atau redirect ke laravel/public
```

**Upload Process:**

1. Create folder `laravel` di server (via SFTP atau panel)
2. Upload semua file ke `/home/ilab/laravel/`
3. **Exclude**: node_modules, vendor, .env, storage/logs/*

**Progress Upload:**
- Total file size: ~50-100 MB (tanpa node_modules & vendor)
- Upload time: ~5-15 menit (tergantung koneksi)

### Step 4: Setup Document Root

Ada 2 cara:

**Cara 1: Via Web Hosting Panel**
1. Login ke https://ilab.unmul.ac.id:10000
2. Masuk ke **Apache Webserver** atau **Virtual Hosts**
3. Set document root ke: `/home/ilab/laravel/public`
4. Save dan restart Apache

**Cara 2: Via Symlink** (jika cara 1 tidak bisa)
1. Connect via SFTP
2. Hapus folder `public_html` (backup dulu jika ada isi)
3. Buat symlink:
```bash
# Via SSH (jika ada akses SSH)
cd /home/ilab
ln -s laravel/public public_html
```

### Step 5: Setup Environment File

1. Via SFTP, buat file `.env` di `/home/ilab/laravel/`
2. Copy dari `.env.production.example` atau isi manual:

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

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@ilab.unmul.ac.id"
MAIL_FROM_NAME="${APP_NAME}"

VITE_APP_NAME="${APP_NAME}"
```

### Step 6: Install Composer Dependencies

**Opsi A: Via SSH (jika ada akses)**
```bash
cd /home/ilab/laravel
composer install --optimize-autoloader --no-dev
```

**Opsi B: Via Web Hosting Panel**
- Cari menu **Terminal** atau **SSH Access**
- Run command di atas

**Opsi C: Install Lokal, Upload vendor** (jika tidak ada composer di server)
```bash
# Di lokal
composer install --optimize-autoloader --no-dev

# Upload folder vendor/ via SFTP
# WARNING: Ini akan lama karena vendor/ besar (~50MB)
```

### Step 7: Setup Application Key

Via SSH atau Terminal di panel:
```bash
cd /home/ilab/laravel
php artisan key:generate
```

Atau generate manual:
```bash
# Di lokal, generate key
php artisan key:generate --show
# Copy output, paste ke .env di server
```

### Step 8: Setup Database

1. **Access phpMyAdmin**: https://ilab.unmul.ac.id/phpmyadmin/
2. **Login** dengan:
   - Username: `ilab`
   - Password: `yG2cSqEwGWIKumX`
3. **Database `ilab` sudah ada**, klik untuk select
4. **Import atau Run Migrations**

**Opsi A: Import Backup** (jika ada data dari lokal)
- Klik **Import** tab
- Choose file backup SQL
- Klik **Go**

**Opsi B: Run Migrations** (fresh install)
Via SSH/Terminal:
```bash
cd /home/ilab/laravel
php artisan migrate --force
php artisan db:seed --class=RolePermissionSeeder --force
```

### Step 9: Setup Storage & Permissions

Via SSH/Terminal:
```bash
cd /home/ilab/laravel

# Create storage symlink
php artisan storage:link

# Set permissions (adjust as needed)
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Set ownership (adjust with actual server user)
chown -R ilab:ilab storage
chown -R ilab:ilab bootstrap/cache
```

**Jika tidak ada akses SSH**, set permissions via WinSCP:
- Right click folder `storage` → Properties → Permissions
- Set ke 775 (rwxrwxr-x)
- Apply to subdirectories

### Step 10: Optimize for Production

Via SSH/Terminal:
```bash
cd /home/ilab/laravel

# Cache config
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache
```

### Step 11: Upload Logo Files

Upload logo ke `/home/ilab/laravel/public/images/`:

- `logo-unmul.png` (200x200 px)
- `logo-blu.png` (200x200 px)
- `favicon.png` (32x32 atau 64x64 px)
- `og-image.jpg` (1200x630 px)

### Step 12: Test Website

1. **Akses landing page**: https://ilab.unmul.ac.id
   - ✅ Check loading screen
   - ✅ Check hero section
   - ✅ Check statistics
   - ✅ Check all links
   - ✅ Check mobile responsive

2. **Test login**: https://ilab.unmul.ac.id/login
   - ✅ Try login (jika sudah ada user)
   - ✅ Check error handling

3. **Test register**: https://ilab.unmul.ac.id/register
   - ✅ Register dummy user
   - ✅ Check redirect to login
   - ✅ Check approval message

4. **Check admin panel** (setelah login sebagai admin)
   - ✅ Dashboard loads
   - ✅ Beta banner appears
   - ✅ All menu accessible
   - ✅ CRUD operations working

---

## 🔍 Troubleshooting

### Error 500 - Internal Server Error

**Penyebab:**
- File permissions salah
- `.env` tidak configured
- APP_KEY tidak di-set

**Solusi:**
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Set permissions
chmod -R 775 storage bootstrap/cache

# Generate key
php artisan key:generate

# Clear cache
php artisan cache:clear
php artisan config:clear
```

### Error 404 - Not Found

**Penyebab:**
- Document root salah
- `.htaccess` tidak aktif
- mod_rewrite tidak enabled

**Solusi:**
- Pastikan document root ke `public/` folder
- Check `.htaccess` ada di `public/`
- Contact helpdesk@ict.unmul.ac.id untuk enable mod_rewrite

### Database Connection Error

**Penyebab:**
- Kredensial database salah
- Host salah

**Solusi:**
```env
# Try different host
DB_HOST=127.0.0.1
# atau
DB_HOST=localhost
# atau
DB_HOST=192.168.33.240
```

### CSS/JS Not Loading

**Penyebab:**
- Assets belum di-build
- ASSET_URL salah
- Mixed content (HTTP vs HTTPS)

**Solusi:**
```bash
# Rebuild assets
npm run build

# Upload public/build/ folder
```

Di `.env`:
```env
ASSET_URL=https://ilab.unmul.ac.id
```

### Permission Denied Errors

**Solusi:**
```bash
# Set correct permissions
chmod -R 775 storage bootstrap/cache

# Check ownership
ls -la storage/
# Adjust if needed
chown -R ilab:ilab storage
```

---

## 📊 Post-Deployment Checklist

### Functional Testing
- [ ] Landing page loads correctly
- [ ] Statistics showing correct data
- [ ] All navigation links working
- [ ] Mobile responsive working
- [ ] Loading screen animation
- [ ] Logo UNMUL & BLU displaying

### Authentication Testing
- [ ] Login working
- [ ] Logout working
- [ ] Password reset working
- [ ] Registration creates pending user
- [ ] Pending user cannot login
- [ ] Approved user can login

### Admin Panel Testing
- [ ] Dashboard loads
- [ ] Beta banner displays
- [ ] User approvals working
- [ ] Laboratory CRUD working
- [ ] Equipment CRUD working
- [ ] Service CRUD working
- [ ] Image upload working

### Security Check
- [ ] HTTPS working (https://ilab.unmul.ac.id)
- [ ] .env file not accessible via browser
- [ ] APP_DEBUG=false
- [ ] APP_ENV=production
- [ ] File upload validation working

### Performance Check
- [ ] Page load < 3 seconds
- [ ] Images optimized
- [ ] Assets minified (via Vite)
- [ ] Database queries optimized

---

## 🔄 Future Updates (Fase 4+)

Untuk update aplikasi di masa depan:

### Manual Update
```bash
# 1. Backup database
mysqldump -u ilab -p ilab > backup_$(date +%Y%m%d).sql

# 2. Upload files baru via SFTP
# 3. Run migrations
php artisan migrate --force

# 4. Clear cache
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Using Git (jika ada akses SSH)
```bash
cd /home/ilab/laravel

# Pull latest changes
git pull origin main

# Install dependencies
composer install --optimize-autoloader --no-dev

# Run migrations
php artisan migrate --force

# Clear cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 📞 Support

Jika mengalami masalah deployment:

1. **Check Laravel logs**: `/home/ilab/laravel/storage/logs/laravel.log`
2. **Check Apache error logs**: via Web Hosting Panel
3. **Contact UPT TIK Support**:
   - Email: helpdesk@ict.unmul.ac.id
   - Phone: +62 541 735055 - 738327

---

## 📄 Related Documentation

- [README.md](README.md) - Project overview
- [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md) - General deployment guide
- [PRODUCTION_CHECKLIST.md](PRODUCTION_CHECKLIST.md) - Comprehensive checklist
- [BETA_NOTES.md](BETA_NOTES.md) - Beta release notes

---

**Deployment Date:** [To be filled after deployment]
**Deployed By:** [Your Name]
**Version:** 0.3.0-beta
**Status:** 🟡 Beta - Production Ready

---

<p align="center">
<strong>🎓 Universitas Mulawarman</strong><br>
<em>iLab - Integrated Laboratory</em><br>
<em>Pusat Unggulan Studi Tropis</em>
</p>
