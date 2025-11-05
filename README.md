# iLab UNMUL - Sistem Manajemen Laboratorium Terpadu

<p align="center">
  <img src="public/images/logo-unmul.png" width="150" alt="Logo UNMUL">
</p>

<p align="center">
<strong>Pusat Unggulan Studi Tropis - Universitas Mulawarman</strong>
</p>

---

## 📚 Dokumentasi

**📑 [DOKUMENTASI_INDEX.md](DOKUMENTASI_INDEX.md)** ← **START HERE!** Panduan memilih dokumentasi yang tepat

**Panduan Pengguna:**
- 📖 **[PANDUAN_PENGGUNA_ILAB_UNMUL_V2.md](PANDUAN_PENGGUNA_ILAB_UNMUL_V2.md)** - Panduan lengkap untuk semua role (User-Friendly)
- 📋 **[QUICK_REFERENCE_FASE3.md](QUICK_REFERENCE_FASE3.md)** - Quick reference card untuk Fase 3

**Dokumentasi Teknis:**
- 📝 **[DOKUMENTASI_PROYEK.md](DOKUMENTASI_PROYEK.md)** - Dokumentasi teknis untuk developer
- 🏛️ **[STRUKTUR_ORGANISASI.md](STRUKTUR_ORGANISASI.md)** - Struktur organisasi lengkap berdasarkan SK Rektor
- 🔄 **[ROLE_MAPPING_SK_TO_SYSTEM.md](ROLE_MAPPING_SK_TO_SYSTEM.md)** - Mapping role SK Rektor ke sistem iLab

---

## Tentang iLab UNMUL

iLab UNMUL adalah sistem manajemen laboratorium terpadu yang dikembangkan untuk **Unit Penunjang Akademik Laboratorium Terpadu (Integrated Laboratory)** Universitas Mulawarman, Kalimantan Timur. Platform ini dirancang untuk mengintegrasikan layanan analisis, booking peralatan, dan manajemen penelitian guna mendukung pengembangan ilmu pengetahuan tropis.

### 📜 Dasar Hukum

Platform ini dikembangkan berdasarkan:
- **Keputusan Rektor Universitas Mulawarman**
- **Nomor:** 2846/UN17/HK.02.03/2025
- **Tanggal:** 7 Juli 2025
- **Tentang:** Struktur Organisasi Pengelola Unit Penunjang Akademik Laboratorium Terpadu (Integrated Laboratory) Universitas Mulawarman

### 🌟 Fitur Fase 3 (Tersedia Saat Ini)

- ✅ **Dashboard & Profile Management** - Dashboard berbasis role
- ✅ **User & Role Management** - 11 tipe role dengan granular permissions
- ✅ **Laboratory Management** - Manajemen unit laboratorium
- ✅ **Service Management** - Katalog layanan analisis
- ✅ **Equipment Management** - Manajemen peralatan + maintenance + calibration
- ✅ **Equipment Booking System** - Sistem reservasi peralatan
- ✅ **Service Request Management** - Wizard 4-step submission & tracking
- ✅ **SOP Digital Library** - Version control & download PDF
- ✅ **Sample & Reagent Management** - Tracking sample & inventory
- ✅ **Responsive Design** - Optimized untuk desktop dan mobile

### 🚧 Coming Soon (Fase 4)
- ⏳ Test Results Management
- ⏳ Invoice & Payment System
- ⏳ Financial Reporting
- ⏳ Email Notifications
- ⏳ Advanced Analytics

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

## Struktur Organisasi

Berdasarkan SK Rektor No. 2846/UN17/HK.02.03/2025, Unit Penunjang Akademik Laboratorium Terpadu memiliki struktur:

### Pimpinan Unit:
- **Pelindung:** Prof. Dr. Ir. H. Abdunnur, M.Si., IPU (Rektor)
- **Pengarah:** Prof. Dr. Lambang Subagiyo, M.Si
- **Penanggung Jawab:** apt. Fajar Prasetya, S.Farm., M.Si., Ph.D
- **Kepala Unit:** Dr. apt. Angga Cipta Narsa, M.Si.

### Kelompok Kerja (3 Kelompok):
1. **Bidang Teknis, Inovasi, dan Kerjasama** - Hamdhani, S.P., M.Sc., Ph.D.
2. **Bidang Pelayanan, Mutu & Penggunaan TI** - Dr. Chairul Saleh, M.Si.
3. **Bidang Administrasi dan Umum** - Dr. Nurul Puspita Palupi, S.P., M.Si.

### Kelompok Fungsional (8 Kelompok):
1. **Natural Product** - Sabaniah Indjar Gama, M.Si.
2. **Advanced Instrument** - Rafitah Hasanah, S.Pi., M.Si., Ph.D.
3. **Environmental** - Atin Nuryadin, S.Pd., M.Si., Ph.D.
4. **Agriculture & Animal Husbandry** - Prof. Dr. Ir. Taufan Purwokusumaning Daru, M.P.
5. **Oceanography & Engineering** - Nanda Khoirunisa, S.Pd., M.Sc.
6. **Social Innovation** - Etik Sulistiowati Ningsih, S.P., M.Si., Ph.D.
7. **E-commerce & IT Business** - Hario Jati Setyadi, S.Kom., M.Kom.
8. **Biotechnology** - Dr. rer. nat. Bodhi Dharma, M.Si.

### User Roles di Sistem iLab (11 Roles):

**Pimpinan & Management:**
1. **Super Admin** - Full system access
2. **Wakil Direktur Pelayanan** - Service oversight
3. **Wakil Direktur PM & TI** - Equipment & IT management

**Staff Laboratorium:**
4. **Kepala Lab** - Lab management & approval
5. **Anggota Lab (Analis)** - Analyst/Researcher
6. **Laboran (Teknisi)** - Lab technician

**Staff Administrasi:**
7. **Sub Bagian TU & Keuangan** - Finance & admin (Fase 4)

**Pengguna Layanan:**
8. **Dosen** - Faculty member
9. **Mahasiswa** - Student
10. **Peneliti Eksternal** - External researcher
11. **Industri/Umum** - Industry/Public

Lihat [PANDUAN_PENGGUNA_ILAB_UNMUL_V2.md](PANDUAN_PENGGUNA_ILAB_UNMUL_V2.md) untuk detail akses setiap role.

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

### Quick Deployment Steps

```bash
# 1. Build assets
npm run build

# 2. Upload files ke hosting
# Set document root ke folder /public

# 3. Install dependencies
composer install --optimize-autoloader --no-dev

# 4. Configure .env untuk production
cp .env.example .env
nano .env

# 5. Generate key
php artisan key:generate

# 6. Run migrations & seeders
php artisan migrate --force
php artisan db:seed --force

# 7. Optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 8. Set permissions
chmod -R 775 storage bootstrap/cache
```

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

### Version 0.3.0-beta - Fase 3 (Januari 2025)

**Status:** Beta Version - Production Ready

**Fitur Fase 3 (Tersedia):**
- ✅ Dashboard & Profile Management
- ✅ User & Role Management (11 roles)
- ✅ Laboratory Management
- ✅ Service Management & Request (Wizard 4-step)
- ✅ Equipment Management + Maintenance + Calibration
- ✅ Equipment Booking System
- ✅ SOP Digital Library
- ✅ Sample & Reagent Management
- ✅ Room Management
- ✅ Landing page dengan beta bubble notification
- ✅ Responsive design (mobile-friendly)

**Coming in Fase 4 (Q2 2025):**
- ⏳ Test Results Management
- ⏳ Invoice & Payment System
- ⏳ Financial Reporting
- ⏳ Email Notifications
- ⏳ Advanced Analytics

**Security:**
- CSRF protection
- XSS protection
- SQL injection protection
- Role-based access control (RBAC)
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

- **Website:** https://ilab.unmul.ac.id
- **Email:** antonprafanto@unmul.ac.id
- **WhatsApp:** 0811553393
- **Address:** Jl. Kuaro, Gn. Kelua, Samarinda, Kalimantan Timur

---

<p align="center">Made with ❤️ for Universitas Mulawarman</p>
