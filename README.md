# iLab UNMUL - Sistem Manajemen Laboratorium Terpadu

<p align="center">
  <img src="public/images/logo-unmul.png" width="150" alt="Logo UNMUL">
</p>

<p align="center">
<strong>Pusat Unggulan Studi Tropis - Universitas Mulawarman</strong>
</p>

---

## 🚀 Quick Start - Deployment

**Mau deploy ke hosting?** Baca dulu:

👉 **[FILES_TO_UPLOAD.md](FILES_TO_UPLOAD.md)** - Daftar file yang harus diupload (SIMPEL!)

👉 **[_docs/DEPLOYMENT_UNMUL.md](_docs/DEPLOYMENT_UNMUL.md)** - Panduan lengkap deployment ke ilab.unmul.ac.id

---

## Tentang iLab UNMUL

iLab UNMUL adalah sistem manajemen laboratorium terpadu yang dikembangkan untuk Universitas Mulawarman, Kalimantan Timur. Platform ini dirancang untuk mengintegrasikan layanan analisis, booking peralatan, dan manajemen penelitian guna mendukung pengembangan ilmu pengetahuan tropis.

### Fitur Utama

- **Manajemen Laboratorium** - Kelola data laboratorium dengan mudah
- **Booking Peralatan** - Sistem reservasi peralatan laboratorium
- **Layanan Analisis** - Manajemen permintaan analisis sampel
- **User Approval System** - Persetujuan admin untuk registrasi pengguna
- **Role-Based Access Control** - 4 roles: Super Admin, Peneliti, Mahasiswa, Dosen
- **SOP Management** - Dokumentasi Standard Operating Procedures
- **Reporting** - Laporan dan statistik laboratorium
- **Responsive Design** - Optimized untuk desktop dan mobile

---

## Tech Stack

- **Backend:** Laravel 12
- **Frontend:** Tailwind CSS v4, Alpine.js
- **Database:** MySQL
- **Asset Bundler:** Vite
- **Authentication:** Laravel Breeze
- **Authorization:** Spatie Laravel Permission
- **Calendar:** FullCalendar v6

---

## Requirements

### Server Requirements

- PHP >= 8.2
- MySQL >= 5.7 atau MariaDB >= 10.3
- Composer
- Node.js >= 18.x
- NPM >= 9.x

### PHP Extensions

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
- GD

---

## Installation

### 1. Clone Repository

```bash
git clone https://github.com/yourusername/ilab-unmul.git
cd ilab-unmul
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

Edit `.env` file dengan konfigurasi Anda:

```env
APP_NAME="iLab UNMUL"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost
APP_TIMEZONE=Asia/Makassar

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ilab_unmul
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Database Setup

```bash
# Run migrations
php artisan migrate

# Seed roles and permissions
php artisan db:seed --class=RolePermissionSeeder
```

### 5. Create Storage Link

```bash
php artisan storage:link
```

### 6. Build Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 7. Start Development Server

```bash
php artisan serve
```

Visit: http://localhost:8000

---

## Default Roles

Sistem ini menggunakan 4 roles utama:

1. **Super Admin** - Full akses ke semua fitur sistem
2. **Peneliti** - Dapat mengajukan booking dan analisis
3. **Mahasiswa** - Akses terbatas untuk keperluan penelitian
4. **Dosen** - Dapat membimbing dan approve pengajuan mahasiswa

---

## User Registration & Approval

### Alur Registrasi

1. User mengakses halaman register (`/register`)
2. Mengisi form pendaftaran dengan memilih role
3. Setelah submit, akun dibuat dengan status **"pending"**
4. User tidak dapat login sampai di-approve oleh admin
5. Super Admin menerima notifikasi pendaftaran baru
6. Admin approve atau reject di halaman **User Approvals**
7. User menerima email notifikasi (jika approved)
8. User dapat login ke sistem

### Manual Testing Registration

```bash
# Create test user manually
php artisan tinker

>>> use App\Models\User;
>>> use Spatie\Permission\Models\Role;
>>> $user = User::create([
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => bcrypt('password'),
    'approval_status' => 'approved',
]);
>>> $user->assignRole('Peneliti');
```

---

## Deployment

Untuk deployment ke production, ikuti panduan lengkap di [DEPLOYMENT_GUIDE.md](DEPLOYMENT_GUIDE.md).

### Quick Deployment Steps

```bash
# 1. Build assets
npm run build

# 2. Upload files ke hosting
# 3. Set document root ke folder /public
# 4. Install dependencies
composer install --optimize-autoloader --no-dev

# 5. Configure .env untuk production
cp .env.production.example .env
nano .env

# 6. Generate key
php artisan key:generate

# 7. Run migrations
php artisan migrate --force
php artisan db:seed --class=RolePermissionSeeder --force

# 8. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 9. Set permissions
chmod -R 775 storage bootstrap/cache
```

Lihat [PRODUCTION_CHECKLIST.md](PRODUCTION_CHECKLIST.md) untuk checklist lengkap.

---

## Development

### Running Tests

```bash
php artisan test
```

### Code Style

```bash
# Fix code style
./vendor/bin/pint
```

### Clear Caches

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Database

```bash
# Fresh migration with seed
php artisan migrate:fresh --seed

# Rollback migration
php artisan migrate:rollback

# Create new migration
php artisan make:migration create_tablename_table
```

---

## Project Structure

```
ilab_unmul/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Controllers
│   │   └── Middleware/        # Custom middleware
│   ├── Models/                # Eloquent models
│   └── Providers/             # Service providers
├── bootstrap/
├── config/                    # Configuration files
├── database/
│   ├── migrations/            # Database migrations
│   └── seeders/               # Database seeders
├── public/
│   ├── build/                 # Compiled assets (Vite)
│   └── images/                # Public images
├── resources/
│   ├── css/                   # Stylesheets
│   ├── js/                    # JavaScript
│   └── views/                 # Blade templates
├── routes/
│   ├── web.php                # Web routes
│   └── auth.php               # Authentication routes
├── storage/
│   ├── app/                   # Application storage
│   ├── framework/             # Framework storage
│   └── logs/                  # Log files
├── tests/                     # Unit & Feature tests
├── .env.example               # Environment example
├── .env.production.example    # Production environment example
├── composer.json              # PHP dependencies
├── package.json               # JavaScript dependencies
├── DEPLOYMENT_GUIDE.md        # Deployment guide
└── PRODUCTION_CHECKLIST.md    # Production checklist
```

---

## Key Features Detail

### 1. Landing Page

- Hero section dengan statistics dinamis
- Features showcase (6 cards)
- About section (Visi, Misi, ISO certification status)
- Call-to-action section
- Responsive footer dengan legal links
- Mobile-optimized dengan hamburger menu
- Loading screen animation

### 2. Authentication System

- Laravel Breeze untuk authentication
- User approval system (pending/approved/rejected)
- Middleware untuk block pending users
- Role-based access control
- Password reset functionality

### 3. Admin Panel

- User management dengan approval workflow
- Laboratory CRUD
- Equipment CRUD dengan image upload
- Service management
- Booking calendar dengan FullCalendar
- SOP document management
- Reports dan analytics

### 4. Booking System

- Calendar view untuk availability
- Multi-step booking form
- Status tracking (pending/approved/completed/cancelled)
- Email notifications
- Conflict prevention

---

## API Documentation

(Coming soon - jika API akan diimplementasikan)

---

## Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## Security

Jika menemukan security vulnerability, silakan email ke:
- **Email:** security@yourdomain.com
- **Phone:** +62 xxx-xxxx-xxxx

Jangan post security issues di public issue tracker.

---

## Support

- **Documentation:** [docs/](docs/)
- **Issue Tracker:** https://github.com/yourusername/ilab-unmul/issues
- **Email:** support@yourdomain.com
- **Website:** https://yourdomain.com

---

## Changelog

### Version 1.0.0 (2024-11-04)

**Added:**
- Initial release
- User registration dengan admin approval system
- Landing page dengan dynamic statistics
- Role-based access control (4 roles)
- Laboratory, Equipment, Service management
- Booking system dengan calendar
- SOP management
- Responsive design dengan Tailwind CSS v4
- Loading screen animation
- Email notifications

**Security:**
- CSRF protection
- XSS protection
- SQL injection protection
- Rate limiting
- File upload validation

---

## License

This project is proprietary software developed for Universitas Mulawarman.

**Copyright © 2024 Universitas Mulawarman - iLab UNMUL**

All rights reserved. Unauthorized copying, distribution, or modification of this software is strictly prohibited.

---

## Credits

**Developed by:**
- [Your Name] - Lead Developer
- [Team Member 2] - Frontend Developer
- [Team Member 3] - Database Administrator

**Special Thanks:**
- Universitas Mulawarman
- Tim Laboratorium Terpadu UNMUL

**Built with:**
- [Laravel](https://laravel.com) - PHP Framework
- [Tailwind CSS](https://tailwindcss.com) - CSS Framework
- [Alpine.js](https://alpinejs.dev) - JavaScript Framework
- [FullCalendar](https://fullcalendar.io) - Calendar Library

---

## Contact

**iLab UNMUL - Pusat Unggulan Studi Tropis**

- **Website:** https://unmul.ac.id
- **Email:** ilab@unmul.ac.id
- **Address:** Universitas Mulawarman, Samarinda, Kalimantan Timur
- **Phone:** +62 xxx-xxxx-xxxx

---

<p align="center">Made with ❤️ for Universitas Mulawarman</p>
