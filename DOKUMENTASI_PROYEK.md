# 📚 Dokumentasi Proyek iLab UNMUL

## 📋 Ringkasan Proyek

**Nama Proyek**: iLab UNMUL - Sistem Manajemen Laboratorium Terpadu
**Nama Unit**: Unit Penunjang Akademik Laboratorium Terpadu (Integrated Laboratory)
**Institusi**: Universitas Mulawarman
**Developer**: Claude Code (Anthropic) & Anton Prafanto
**Teknologi**: Laravel 12, Tailwind CSS, Alpine.js
**Status**: Beta Version - Fase 3
**Launch Date**: Januari 2025

### 📜 Dasar Hukum

**Keputusan Rektor Universitas Mulawarman:**
- **Nomor:** 2846/UN17/HK.02.03/2025
- **Tanggal:** 7 Juli 2025
- **Tentang:** Struktur Organisasi Pengelola Unit Penunjang Akademik Laboratorium Terpadu (Integrated Laboratory) Universitas Mulawarman
- **Kepala Unit:** Dr. apt. Angga Cipta Narsa, M.Si.

---

## 🎯 Tujuan Proyek

Mengembangkan platform digital terintegrasi untuk:

1. **Digitalisasi Layanan Lab**: Menggantikan proses manual dengan sistem online
2. **Transparansi**: Real-time tracking status permohonan
3. **Efisiensi**: Mengurangi waktu proses dan administrasi
4. **Akuntabilitas**: Audit trail lengkap semua aktivitas
5. **Pelaporan**: Dashboard dan laporan otomatis
6. **Aksesibilitas**: Akses 24/7 untuk submit dan tracking

---

## 🏗️ Arsitektur Sistem

### Tech Stack

**Backend**:
- Laravel 12 (PHP 8.3)
- MySQL 8.0
- Spatie Laravel Permission (Role & Permission)
- Laravel Sanctum (API Authentication)

**Frontend**:
- Blade Templates
- Tailwind CSS 3.x
- Alpine.js
- Chart.js (untuk visualisasi)

**Infrastructure**:
- Web Server: Apache/Nginx
- Hosting: VPS Linux (Ubuntu/CentOS)
- Domain: ilab.unmul.ac.id
- SSL: Let's Encrypt

### Database Schema

**Core Tables**:
- `users` - User accounts
- `roles` - User roles (Spatie)
- `permissions` - System permissions (Spatie)
- `laboratories` - Lab units
- `equipment` - Lab equipment/instruments
- `services` - Service catalog
- `service_requests` - Service requests
- `samples` - Sample data
- `test_results` - Analysis results
- `invoices` - Financial invoices
- `payments` - Payment records
- `sops` - Standard Operating Procedures
- `maintenance_records` - Equipment maintenance
- `calibration_records` - Calibration records

---

## 👥 User Roles & Permissions

### Struktur Organisasi Unit (Berdasarkan SK Rektor)

**Pimpinan Unit:**
- Pelindung: Prof. Dr. Ir. H. Abdunnur, M.Si., IPU (Rektor)
- Pengarah: Prof. Dr. Lambang Subagiyo, M.Si
- Penanggung Jawab: apt. Fajar Prasetya, S.Farm., M.Si., Ph.D
- **Kepala Unit:** Dr. apt. Angga Cipta Narsa, M.Si.

**Kelompok Kerja (3 Kelompok):**
1. Bidang Teknis, Inovasi, dan Kerjasama
2. Bidang Pelayanan, Mutu & Penggunaan TI
3. Bidang Administrasi dan Umum

**Kelompok Fungsional (8 Kelompok Riset):**
1. Natural Product
2. Advanced Instrument
3. Environmental
4. Agriculture & Animal Husbandry Sciences Technology
5. Oceanography & Engineering
6. Social Innovation
7. E-commerce & IT Business (Anton Prafanto berada di kelompok ini)
8. Biotechnology

### 11 User Roles di Sistem iLab

**Pimpinan & Management:**
1. **Super Admin** - Full system access
2. **Wakil Direktur Pelayanan** - Service oversight
3. **Wakil Direktur PM & TI** - Equipment & IT management

**Staff Laboratorium:**
4. **Kepala Lab** - Lab management
5. **Anggota Lab** - Analyst/Researcher
6. **Laboran** - Lab technician

**Staff Administrasi:**
7. **Sub Bagian TU & Keuangan** - Finance & admin

**Pengguna Layanan:**
8. **Dosen** - Faculty member
9. **Mahasiswa** - Student
10. **Peneliti Eksternal** - External researcher
11. **Industri/Umum** - Industry/Public

**Note:** Role sistem akan disesuaikan dengan struktur organisasi SK Rektor di Fase 4.

### Permission Categories

- Dashboard & Profile (3 permissions)
- User Management (4 permissions)
- Role & Permission Management (5 permissions)
- Lab/Unit Management (4 permissions)
- Equipment Management (5 permissions)
- SOP Management (5 permissions)
- Service Request Management (8 permissions)
- Testing & Results (4 permissions)
- Calibration Management (4 permissions)
- Financial Management (6 permissions)
- Reporting (4 permissions)
- System Settings (3 permissions)

**Total**: 55 granular permissions

---

## 🔄 Request Workflow

### Standard Service Request Flow

```
1. Customer Creates Request
   ↓
2. Submitted (Auto notification to Kepala Lab)
   ↓
3. Kepala Lab Reviews
   ↓
4a. Approved → Assign to Analyst
4b. Rejected → Customer notified, can revise
   ↓
5. Analyst Updates Status to "In Progress"
   ↓
6. Analyst Completes Analysis
   ↓
7. Analyst Inputs Results
   ↓
8. Kepala Lab Approves Results
   ↓
9. TU & Keuangan Creates Invoice
   ↓
10. Customer Pays
   ↓
11. TU & Keuangan Records Payment
   ↓
12. Results Released to Customer
   ↓
13. Request Closed
```

### Status Transitions

```
Draft → Submitted → Under Review →
Approved → Assigned → In Progress →
Completed → Results Approved →
Invoiced → Paid → Closed

Alternative paths:
- Under Review → Rejected → [End or Revise]
- Any → Cancelled → [End]
```

---

## 📊 Key Features

### 1. Dashboard
- Role-based dashboard views
- Real-time statistics
- Recent activities
- Pending approvals
- SLA monitoring

### 2. Service Request Management
- **Wizard 4-step** untuk user-friendly submission
- File upload support (PDF, images)
- Real-time status tracking
- Email notifications
- Public tracking (tanpa login via tracking number)

### 3. Equipment Management
- Equipment catalog
- Availability status
- Maintenance scheduling
- Calibration tracking
- Usage history

### 4. SOP Management
- Digital SOP library
- Version control
- Approval workflow
- Easy download/print

### 5. Financial Management
- Auto-calculated invoicing
- Multiple payment methods
- Payment tracking
- Overdue alerts
- Financial reporting

### 6. Reporting & Analytics
- Activity reports
- Usage statistics
- Revenue reports
- Export to PDF/Excel
- Custom date ranges

### 7. Security Features
- Role-Based Access Control (RBAC)
- Audit logs
- Password hashing (bcrypt)
- CSRF protection
- SQL injection prevention
- XSS protection

---

## 🎨 UI/UX Highlights

### Design System
- **Color Scheme**:
  - Primary: #0066CC (UNMUL Blue)
  - Secondary: #4CAF50 (Tropical Green)
  - Accent: #FF9800 (Orange)
  - Warning: #FFD700 (Gold)

- **Typography**: System fonts (optimized for readability)

- **Components**:
  - Loading screen with progress bar
  - Beta floating bubble notification
  - Responsive navigation
  - Mobile-friendly forms
  - Interactive tables with sorting/filtering

### Accessibility
- WCAG 2.1 compliance efforts
- Keyboard navigation
- Screen reader friendly
- High contrast ratios
- Responsive design (mobile, tablet, desktop)

---

## 📁 File Structure (Key Files)

```
ilab_v1/
├── app/
│   ├── Http/Controllers/
│   │   ├── DashboardController.php
│   │   ├── ServiceRequestController.php
│   │   ├── EquipmentController.php
│   │   ├── InvoiceController.php
│   │   └── ...
│   ├── Models/
│   │   ├── User.php
│   │   ├── ServiceRequest.php
│   │   ├── Equipment.php
│   │   └── ...
│   └── Policies/
│       ├── ServiceRequestPolicy.php
│       └── ...
├── database/
│   ├── migrations/
│   └── seeders/
│       ├── PermissionSeeder.php
│       ├── ServiceSeeder.php
│       └── ...
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php
│   │   ├── dashboard.blade.php
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   └── guest.blade.php
│   │   └── ...
│   ├── css/
│   │   └── app.css
│   └── js/
│       └── app.js
├── public/
│   ├── images/
│   │   ├── logo-unmul.png
│   │   ├── logo-blu.png
│   │   ├── favicon.png
│   │   └── OG_IMAGE_GUIDE.md
│   └── ...
├── routes/
│   ├── web.php
│   └── api.php
├── PANDUAN_PENGGUNA_ILAB_UNMUL.md
├── QUICK_REFERENCE_CARD.md
├── DOKUMENTASI_PROYEK.md (this file)
├── DEPLOYMENT_UNMUL.md
└── README.md
```

---

## 🚀 Deployment

### Production Environment
- **URL**: https://ilab.unmul.ac.id
- **Server**: VPS Linux
- **Database**: MySQL 8.0
- **PHP**: 8.3
- **Web Server**: Apache with mod_rewrite

### Deployment Steps

1. **Prepare Server**
   ```bash
   sudo apt update
   sudo apt install php8.3 php8.3-mysql php8.3-xml php8.3-mbstring
   ```

2. **Clone & Install**
   ```bash
   cd /home/ilab/
   git clone [repo]
   cd laravel
   composer install --optimize-autoloader --no-dev
   ```

3. **Environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   # Edit .env with production credentials
   ```

4. **Database**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

5. **Permissions**
   ```bash
   chmod -R 755 storage bootstrap/cache
   chown -R www-data:www-data storage bootstrap/cache
   ```

6. **Optimize**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

---

## 🧪 Testing

### Test Coverage
- Unit Tests (Models, Services)
- Feature Tests (Controllers, API)
- Browser Tests (Dusk for E2E)

### Run Tests
```bash
php artisan test
php artisan dusk
```

---

## 📈 Future Roadmap

### Phase 2 (Q2 2025)
- [ ] Mobile app (Flutter/React Native)
- [ ] WhatsApp integration untuk notifikasi
- [ ] E-signature untuk approval digital
- [ ] Advance reporting dengan BI tools
- [ ] Integration dengan SIMAK UNMUL

### Phase 3 (Q3 2025)
- [ ] Equipment booking system
- [ ] Room reservation
- [ ] Inventory management (reagents, consumables)
- [ ] Research collaboration platform
- [ ] Publication tracking

### Phase 4 (Q4 2025)
- [ ] AI-powered sample analysis prediction
- [ ] Chatbot support
- [ ] Advanced analytics & ML insights
- [ ] API untuk external systems
- [ ] Multi-language support (EN)

---

## 🐛 Known Issues & Limitations

### Current Limitations
- No mobile app (only responsive web)
- Manual equipment booking (not automated)
- Limited export formats (PDF/Excel only)
- Single language (Bahasa Indonesia)

### Reported Bugs
- [None currently - Beta version launched]

### Bug Reporting
Report bugs to: antonprafanto@unmul.ac.id dengan format:
```
Subject: [BUG] Short description
Body:
- Steps to reproduce
- Expected behavior
- Actual behavior
- Screenshots (if applicable)
- Browser & OS info
```

---

## 👨‍💻 Development Team

**Lead Developer**: Anton Prafanto (antonprafanto@unmul.ac.id)
**AI Assistant**: Claude (Anthropic)
**Project Manager**: [Name]
**QA**: [Name]
**Stakeholders**:
- Direktur Pusat Unggulan Studi Tropis UNMUL
- Wakil Direktur Pelayanan
- Wakil Direktur PM & TI
- Kepala Lab Units

---

## 📄 License & Credits

### License
Proprietary software owned by **Universitas Mulawarman**.
All rights reserved. © 2025

### Credits & Acknowledgments
- **Laravel Framework**: Taylor Otwell & Laravel Community
- **Tailwind CSS**: Adam Wathan & Tailwind Labs
- **Spatie Laravel Permission**: Spatie Team
- **Icons**: Heroicons (Tailwind Labs)
- **AI Development**: Claude by Anthropic

---

## 📞 Support & Contact

### Technical Support
- **Email**: antonprafanto@unmul.ac.id
- **Phone**: 0811553393
- **Office Hours**: Senin-Jumat 08:00-16:00 WITA

### Documentation
- **User Guide**: PANDUAN_PENGGUNA_ILAB_UNMUL.md
- **Quick Reference**: QUICK_REFERENCE_CARD.md
- **Deployment**: DEPLOYMENT_UNMUL.md

---

## 📝 Changelog

### v1.0-beta (Januari 2025)
- ✅ Initial release
- ✅ 11 user roles with granular permissions
- ✅ Service request management
- ✅ Equipment management
- ✅ SOP digital library
- ✅ Financial management
- ✅ Reporting & analytics
- ✅ Landing page with beta notification bubble
- ✅ Responsive design
- ✅ Email notifications
- ✅ Public tracking feature

---

## 🙏 Acknowledgments

Terima kasih kepada semua pihak yang telah mendukung pengembangan iLab UNMUL:
- Universitas Mulawarman Leadership
- Seluruh staff dan pengguna lab UNMUL
- Claude AI by Anthropic untuk development assistance
- Open source community

---

**Last Updated**: Januari 2025
**Document Version**: 1.0

🚀 Generated with [Claude Code](https://claude.com/claude-code)

Co-Authored-By: Claude <noreply@anthropic.com>
