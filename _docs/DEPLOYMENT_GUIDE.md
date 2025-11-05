# Panduan Deployment iLab UNMUL ke Hosting

**Version:** 0.3.0-beta
**Status:** 🟡 Beta Release - Production Ready (Fase 3)
**Last Updated:** 4 November 2024

---

## ⚠️ Important: Beta Deployment Notice

Platform iLab UNMUL saat ini dalam **Versi Beta (Fase 3 dari 12 fase)**. Deployment ini sudah production-ready dengan fitur-fitur core yang lengkap:

✅ **Fitur yang Sudah Working:**
- Landing Page dengan dynamic statistics
- User Registration dengan Admin Approval System
- Authentication & Authorization (4 roles)
- Master Data Management (Laboratories, Equipment, Services)
- User Management untuk Admin

⏳ **Fitur yang Akan Datang (Fase 4-12):**
- Booking System (Fase 4 - Target: 11 Nov 2024)
- SOP Management (Fase 5)
- Analysis Request (Fase 6)
- Reports & Analytics (Fase 7-12)

**Deployment Strategy:** Deploy early dan update incremental setiap fase selesai.

Lihat [BETA_NOTES.md](BETA_NOTES.md) untuk detail lengkap tentang beta release.

---

## Persiapan Sebelum Deploy

### 1. Requirement Hosting
Pastikan hosting Anda memiliki:
- **PHP >= 8.2** (Laravel 12 requirement)
- **MySQL/MariaDB** (untuk database)
- **Composer** (untuk dependency management)
- **Node.js & NPM** (untuk build assets) - opsional jika build lokal
- **Git** (opsional, untuk deployment otomatis)

**PHP Extensions yang dibutuhkan:**
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- cURL
- GD (untuk image processing)

### 2. Persiapan File Lokal

#### A. Build Production Assets
```bash
npm run build
```
Ini akan generate file di folder `public/build/`

#### B. Optimize Laravel
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### C. Set Environment Production
Edit file `.env` untuk production:
```env
APP_NAME="iLab UNMUL"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database Production
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Mail Configuration (untuk approval notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"

# Session & Cache (recommended untuk production)
SESSION_DRIVER=database
CACHE_STORE=database
```

#### D. Generate Application Key Baru (untuk production)
```bash
php artisan key:generate
```
**PENTING:** Simpan APP_KEY yang dihasilkan, Anda akan membutuhkannya di hosting.

---

## Metode Deployment

### **Metode 1: Upload Manual via FTP/cPanel File Manager**

#### Langkah 1: Compress Project
```bash
# Exclude node_modules dan file development
zip -r ilab_unmul.zip . -x "node_modules/*" ".git/*" "storage/logs/*" "storage/framework/cache/*"
```

Atau buat file `.zipignore` untuk exclude:
```
node_modules/
.git/
.env
storage/logs/*
storage/framework/cache/*
storage/framework/sessions/*
storage/framework/views/*
vendor/
```

#### Langkah 2: Upload ke Hosting
1. Login ke cPanel/FTP
2. Upload file `ilab_unmul.zip` ke folder home (bukan public_html)
3. Extract file zip di hosting
4. Pindahkan semua file Laravel ke folder `ilab_unmul` atau `laravel`

#### Langkah 3: Setup Document Root
**PENTING:** Document root harus mengarah ke folder `public`

**Di cPanel:**
1. Masuk ke **Domains** atau **Addon Domains**
2. Set document root ke: `/home/username/ilab_unmul/public`

**Struktur folder yang benar:**
```
/home/username/
├── public_html/           (domain utama, bisa diabaikan)
├── ilab_unmul/            (folder Laravel)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/            ← Document root domain harus ke sini
│   │   ├── index.php
│   │   ├── build/
│   │   └── images/
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   ├── .env
│   └── artisan
```

#### Langkah 4: Install Dependencies di Hosting
Login via SSH (jika tersedia) atau Terminal di cPanel:

```bash
cd ~/ilab_unmul

# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Set permissions
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

#### Langkah 5: Setup Database
1. Buat database baru di cPanel MySQL
2. Buat user database dan berikan semua privileges
3. Import database (jika ada backup):
   ```bash
   mysql -u username -p database_name < backup.sql
   ```
4. Atau jalankan migration:
   ```bash
   php artisan migrate --force
   php artisan db:seed --class=RolePermissionSeeder --force
   ```

#### Langkah 6: Setup Environment File
```bash
cp .env.example .env
nano .env  # atau edit via cPanel File Manager
```

Isi dengan konfigurasi production (lihat bagian 2C di atas)

#### Langkah 7: Setup Application
```bash
# Generate key (jika belum)
php artisan key:generate

# Create storage link
php artisan storage:link

# Cache untuk performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear old cache
php artisan cache:clear
```

#### Langkah 8: Set File Permissions
```bash
# Set owner (sesuaikan dengan user hosting)
chown -R username:username /home/username/ilab_unmul

# Set directory permissions
find /home/username/ilab_unmul -type d -exec chmod 755 {} \;

# Set file permissions
find /home/username/ilab_unmul -type f -exec chmod 644 {} \;

# Storage dan cache harus writable
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

---

### **Metode 2: Deploy via Git (Recommended)**

#### Langkah 1: Setup Git Repository
```bash
# Di lokal
git init
git add .
git commit -m "Initial commit for deployment"

# Push ke repository (GitHub/GitLab/Bitbucket)
git remote add origin https://github.com/username/ilab-unmul.git
git push -u origin main
```

#### Langkah 2: Clone di Hosting
```bash
# SSH ke hosting
ssh username@your-server.com

# Clone repository
cd ~
git clone https://github.com/username/ilab-unmul.git ilab_unmul
cd ilab_unmul

# Install dependencies
composer install --optimize-autoloader --no-dev

# Setup environment
cp .env.example .env
nano .env  # edit dengan konfigurasi production
php artisan key:generate

# Run migrations
php artisan migrate --force
php artisan db:seed --class=RolePermissionSeeder --force

# Create storage link
php artisan storage:link

# Set permissions
chmod -R 775 storage bootstrap/cache

# Cache production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### Langkah 3: Setup Auto-Deployment (Optional)
Buat file `deploy.sh`:
```bash
#!/bin/bash

cd /home/username/ilab_unmul

# Pull latest changes
git pull origin main

# Update dependencies
composer install --optimize-autoloader --no-dev

# Run migrations
php artisan migrate --force

# Clear and cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
chmod -R 775 storage bootstrap/cache

echo "Deployment completed!"
```

Jalankan setiap kali ada update:
```bash
chmod +x deploy.sh
./deploy.sh
```

---

## Setup .htaccess (Jika Diperlukan)

### File: `public/.htaccess`
Pastikan file ini ada dan berisi:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### File: Root `.htaccess` (jika domain root = folder Laravel)
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

---

## Setup SSL/HTTPS

### 1. Via cPanel (Let's Encrypt - Gratis)
1. Login cPanel
2. Masuk ke **SSL/TLS Status**
3. Pilih domain → **Run AutoSSL**
4. Tunggu proses selesai (biasanya 1-2 menit)

### 2. Force HTTPS di Laravel
Edit `app/Providers/AppServiceProvider.php`:

```php
use Illuminate\Support\Facades\URL;

public function boot(): void
{
    if ($this->app->environment('production')) {
        URL::forceScheme('https');
    }
}
```

Atau tambahkan di `.env`:
```env
ASSET_URL=https://yourdomain.com
```

---

## Upload Logo & Images

Upload file berikut ke folder `public/images/`:

1. **logo-unmul.png** (200x200 pixels) - Logo UNMUL
2. **logo-blu.png** (200x200 pixels) - Logo BLU
3. **favicon.png** (32x32 atau 64x64 pixels) - Favicon
4. **og-image.jpg** (1200x630 pixels) - Open Graph image untuk social sharing

Via cPanel File Manager:
1. Navigate ke `/home/username/ilab_unmul/public/images/`
2. Upload file-file di atas
3. Set permissions ke 644

---

## Setup Cron Jobs (Untuk Laravel Scheduler)

Laravel memerlukan cron job untuk menjalankan scheduled tasks.

### Di cPanel:
1. Masuk ke **Cron Jobs**
2. Tambahkan cron job baru:
   - **Minute:** `*`
   - **Hour:** `*`
   - **Day:** `*`
   - **Month:** `*`
   - **Weekday:** `*`
   - **Command:**
     ```
     cd /home/username/ilab_unmul && php artisan schedule:run >> /dev/null 2>&1
     ```

Atau dalam format lengkap:
```
* * * * * cd /home/username/ilab_unmul && php artisan schedule:run >> /dev/null 2>&1
```

---

## Setup Email Notifications

Untuk fitur approval notifications, setup email di `.env`:

### 1. Gmail SMTP
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="iLab UNMUL"
```

**Catatan:** Untuk Gmail, gunakan **App Password**, bukan password biasa.

### 2. cPanel Email
```env
MAIL_MAILER=smtp
MAIL_HOST=mail.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your-email-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="iLab UNMUL"
```

### Test Email
```bash
php artisan tinker
>>> Mail::raw('Test email from iLab UNMUL', function($msg) { $msg->to('test@example.com')->subject('Test'); });
```

---

## Troubleshooting

### 1. **Error 500 - Internal Server Error**
**Penyebab:**
- File permissions salah
- `.env` tidak dikonfigurasi
- APP_KEY tidak di-set

**Solusi:**
```bash
chmod -R 775 storage bootstrap/cache
php artisan key:generate
php artisan config:cache
```

Cek error log:
```bash
tail -f storage/logs/laravel.log
```

### 2. **Error 404 - Not Found**
**Penyebab:**
- Document root salah
- `.htaccess` tidak aktif
- mod_rewrite tidak enabled

**Solusi:**
- Pastikan document root ke folder `public`
- Cek `.htaccess` ada di folder `public`
- Hubungi hosting support untuk enable mod_rewrite

### 3. **CSS/JS Tidak Load**
**Penyebab:**
- Asset tidak di-build
- ASSET_URL salah
- Mixed content (HTTP vs HTTPS)

**Solusi:**
```bash
npm run build  # di lokal
php artisan config:cache
```

Pastikan `.env`:
```env
ASSET_URL=https://yourdomain.com
```

### 4. **Database Connection Error**
**Penyebab:**
- Kredensial database salah
- Host database salah

**Solusi:**
```env
# Cek di .env
DB_HOST=localhost  # atau 127.0.0.1
DB_DATABASE=correct_db_name
DB_USERNAME=correct_user
DB_PASSWORD=correct_password
```

Test koneksi:
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

### 5. **Permission Denied Errors**
**Solusi:**
```bash
# Set correct ownership
chown -R username:username /home/username/ilab_unmul

# Set correct permissions
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod -R 775 storage bootstrap/cache
```

### 6. **Storage Link Error**
**Jika `php artisan storage:link` error:**
```bash
# Manual symlink
ln -s /home/username/ilab_unmul/storage/app/public /home/username/ilab_unmul/public/storage
```

---

## Checklist Deployment

- [ ] Build production assets (`npm run build`)
- [ ] Setup `.env` production
- [ ] Generate APP_KEY
- [ ] Upload files ke hosting
- [ ] Set document root ke folder `public`
- [ ] Install composer dependencies
- [ ] Setup database (create + migrate)
- [ ] Run seeders (roles & permissions)
- [ ] Create storage link
- [ ] Set file permissions (775 untuk storage)
- [ ] Setup SSL/HTTPS
- [ ] Upload logo files
- [ ] Setup cron jobs
- [ ] Configure email (untuk notifications)
- [ ] Test registrasi & approval flow
- [ ] Clear cache & optimize
- [ ] Test semua fitur

---

## Optimasi Production

### 1. Enable OPcache
Tambahkan di `php.ini`:
```ini
opcache.enable=1
opcache.memory_consumption=256
opcache.max_accelerated_files=20000
opcache.validate_timestamps=0
```

### 2. Config Cache
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 3. Composer Optimize
```bash
composer install --optimize-autoloader --no-dev
composer dump-autoload --optimize
```

### 4. Database Query Optimization
Enable query caching di `config/database.php` untuk production.

---

## Maintenance Mode

Saat melakukan update, aktifkan maintenance mode:

```bash
# Aktifkan
php artisan down --secret="your-secret-token"

# Update aplikasi
git pull
composer install
php artisan migrate --force

# Nonaktifkan
php artisan up
```

Akses saat maintenance: `https://yourdomain.com/your-secret-token`

---

## Security Checklist

- [ ] APP_DEBUG=false di production
- [ ] APP_ENV=production
- [ ] Force HTTPS
- [ ] Database credentials aman
- [ ] File `.env` tidak bisa diakses public
- [ ] CSRF protection aktif
- [ ] XSS protection aktif (sudah built-in Laravel)
- [ ] SQL injection protection (gunakan Eloquent/Query Builder)
- [ ] Rate limiting untuk login
- [ ] User approval system aktif
- [ ] File upload validation
- [ ] Regular backup database & files

---

## Backup Strategy

### 1. Database Backup (Otomatis)
```bash
# Tambahkan cron job untuk backup database
0 2 * * * mysqldump -u username -ppassword database_name > /home/username/backups/ilab_$(date +\%Y\%m\%d).sql
```

### 2. File Backup
```bash
# Backup mingguan
0 3 * * 0 tar -czf /home/username/backups/ilab_$(date +\%Y\%m\%d).tar.gz /home/username/ilab_unmul
```

---

## Support & Monitoring

### 1. Error Monitoring
- Setup Laravel Telescope (development)
- Monitor `storage/logs/laravel.log`
- Setup external monitoring (e.g., Sentry, Bugsnag)

### 2. Performance Monitoring
- Enable query logging saat development
- Monitor slow queries
- Use Laravel Debugbar (development only)

### 3. Uptime Monitoring
- Setup ping monitoring (e.g., UptimeRobot - gratis)
- Monitor response time
- Alert jika down

---

## Contact for Deployment Issues

Jika mengalami masalah:
1. Cek error log: `storage/logs/laravel.log`
2. Cek web server error log (di cPanel)
3. Hubungi hosting support untuk issues server
4. Dokumentasi Laravel: https://laravel.com/docs/12.x/deployment

---

**Deployment Success! 🚀**

Selamat, aplikasi iLab UNMUL sudah live di production!
