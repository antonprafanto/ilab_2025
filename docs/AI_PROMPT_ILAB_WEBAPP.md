# 🤖 AI PROMPT: TUTORIAL LENGKAP MEMBUAT WEB APP ILAB UNMUL DENGAN LARAVEL 12

---

## 📋 METADATA PROMPT

**Versi**: 1.1 (Updated)
**Dibuat**: 2025-01-10
**Updated**: 2025-01-10 (Added: Branding, MariaDB, Workflow Matrix, Historical Data)
**Untuk**: AI Assistant (ChatGPT, Claude, Gemini, dll)
**Tujuan**: Generate tutorial step-by-step membuat Integrated Laboratory Management System
**Framework**: Laravel 12 (PHP 8.3+)
**Database**: MariaDB 10.11+ (instead of MySQL)
**Target**: Production-ready web application
**Level**: Intermediate to Advanced
**Estimasi**: 40-60 hours development time

**Update Log v1.1**:
- ✅ Added: Branding & Visual Identity section (Logo UNMUL, BLU, Tagline)
- ✅ Added: Workflow Matrix with detailed actor-SLA mapping
- ✅ Added: Historical data table dengan 9 kegiatan nyata (2024)
- ✅ Added: PT. Giat Madiri Sakti emphasis sebagai real industry client
- ✅ Changed: Database dari MySQL ke MariaDB
- ✅ Added: Implementation recommendations untuk seeder, testing, UI

---

## 🎯 INSTRUKSI UNTUK AI

Anda adalah seorang **Senior Laravel Developer Expert** yang akan membuat **tutorial komprehensif step-by-step** untuk membangun web application **Integrated Laboratory Management System (ILab UNMUL)** menggunakan **Laravel 12**.

### **ATURAN PENTING:**

1. ✅ **Tutorial harus LENGKAP dan DETAIL** - Setiap step dijelaskan dengan code lengkap
2. ✅ **Ikuti best practices Laravel 12** - Gunakan fitur terbaru Laravel
3. ✅ **Production-ready code** - Include security, validation, error handling
4. ✅ **Explain WHY, not just HOW** - Jelaskan alasan di balik setiap keputusan
5. ✅ **Progressive complexity** - Mulai dari dasar, bangun bertahap
6. ✅ **Include testing** - Unit tests dan feature tests
7. ✅ **Code yang bisa di-copy-paste** - Siap pakai, tidak ada placeholder
8. ✅ **Include troubleshooting** - Common errors dan solusinya
9. ✅ **Database seeding** - Sample data untuk testing
10. ✅ **Documentation** - Comment code dengan baik

### **FORMAT OUTPUT:**

```markdown
# TUTORIAL [NOMOR]: [JUDUL]

## 📚 Apa yang Akan Dipelajari
- Bullet point objectives

## 🎯 Prerequisites
- Requirements untuk chapter ini

## 📝 Step-by-Step Implementation

### Step 1: [Judul Step]
**Penjelasan**: Mengapa kita melakukan ini?

**Code**:
```php
// Code lengkap dengan comments
```

**Penjelasan Detail**:
- Baris per baris explanation jika kompleks

**Output Expected**:
- Screenshot atau deskripsi hasil

### Step 2: [Judul Step]
... dst

## ✅ Testing & Verification
- Cara test fitur yang baru dibuat

## 🐛 Troubleshooting
- Common errors dan solutions

## 📚 Summary
- Recap apa yang sudah dibuat
- Link ke chapter berikutnya
```

---

## 📖 INFORMASI PROYEK

### **A. TENTANG ILAB UNMUL**

**Nama Proyek**: Integrated Laboratory Management System (ILab UNMUL)
**Institusi**: Universitas Mulawarman, Samarinda, Kalimantan Timur
**Konteks**: Mendukung pembangunan Ibu Kota Negara (IKN) di Kalimantan Timur

**Visi**:
> "Menjadi pusat penelitian dan pengujian terkemuka di Kalimantan Timur, bahkan di tingkat nasional"

**Peran Strategis untuk IKN**:
- Penelitian material konstruksi dan infrastruktur
- Teknologi pertanian berkelanjutan
- Pemantauan kualitas udara dan air
- Studi keanekaragaman hayati
- Penelitian penyakit tropis
- Pengembangan energi terbarukan

**Alamat**:
```
Gedung Integrated Laboratory, Lantai 5
Jl. Kuaro Muara, Gn. Kelua
Samarinda – Kalimantan Timur 75123
Indonesia
```

**Contact**:
- Website: https://ilab.unmul.ac.id
- Email: info@ilab.unmul.ac.id
- Phone: +62 541 747432
- WhatsApp: +62 813-5151-7432

**Branding & Visual Identity**:
- **Logo Utama**: Logo Universitas Mulawarman (official UNMUL logo)
- **Logo Sekunder**: Logo BLU (Badan Layanan Umum)
- **Tagline**: "Pusat Unggulan Studi Tropis" (Center of Excellence for Tropical Studies)
- **Brand Colors**:
  - Primary: UNMUL Blue (#0066CC) - representing knowledge & trust
  - Secondary: Innovation Orange (#FF9800) - representing innovation
  - Accent: Tropical Green (#4CAF50) - representing tropical studies
- **Building**: 3-story modern laboratory building with clean architecture
- **Visual Assets Required**:
  - Logo UNMUL (SVG format untuk scalability)
  - Logo BLU (SVG format)
  - Building photos (exterior & interior)
  - Equipment photos untuk service catalog
  - Lab activity photos untuk testimonials/gallery

**Catatan Penting untuk Implementasi**:
- Tagline "Pusat Unggulan Studi Tropis" harus muncul di:
  - Landing page (hero section)
  - Email signatures
  - PDF reports (header/footer)
  - Certificates
- Logo placement: UNMUL (kiri) + BLU (kanan) di header aplikasi

---

### **B. FITUR UTAMA APLIKASI**

Aplikasi ini adalah **sistem manajemen laboratorium terpadu** dengan 17 modul utama:

#### **1. Dashboard & Analytics**
- Role-specific dashboards (Admin, Kepala Lab, User)
- Real-time statistics (services, bookings, revenue)
- Interactive charts (service trends, equipment usage)
- Quick actions (pending approvals, urgent tasks)
- Notification center

#### **2. User Management & RBAC**
- Multi-role authentication (11 role types)
- Fine-grained permissions system
- User profiles dengan expertise tracking
- Activity logs per user
- Account activation/deactivation

#### **3. Laboratory Management**
- CRUD laboratories (multiple labs: kimia, biologi, fisika, dll)
- Equipment inventory management
- Equipment condition tracking (baik, rusak, maintenance)
- Equipment availability calendar
- Maintenance scheduling & history
- Calibration tracking dengan reminders
- Equipment photos & documentation

#### **4. SOP Management**
- Upload & versioning SOP documents
- SOP per equipment dengan format standar
- SOP categories (safety, operation, maintenance)
- Full-text search SOP
- Download SOP PDF
- SOP update history & approval workflow
- Template SOP generator

#### **5. Service Request System**
- Online service request form (multi-step wizard)
- File upload (proposal, supporting docs)
- Service catalog dengan pricing tiers
- Request number auto-generation
- Multi-level approval workflow (Direktur → Wakil Dir → Kepala Lab)
- Request status tracking (8 status)
- Email notifications per stage
- Request cancellation & rescheduling

#### **6. Booking & Scheduling**
- Interactive calendar view (daily, weekly, monthly)
- Real-time availability check
- Conflict detection (lab + equipment)
- Multi-resource booking
- Recurring booking (untuk praktikum rutin)
- Booking approval workflow
- Automatic reminders (H-3, H-1, H-day)
- Check-in/check-out system
- Late cancellation penalty calculator

#### **7. Sample Management**
- Sample registration form
- Barcode/QR code generation & printing
- Sample tracking (received → storage → testing → disposal)
- Storage location management (grid-based)
- Sample photos & condition notes
- Sample history timeline
- Chain of custody tracking
- Sample disposal management

#### **8. Testing & Analysis**
- Test assignment ke operator
- Test method selection (ISO/SNI/AOAC)
- Parameter configuration
- Data entry interface dengan validation
- Result validation & QC checks
- Out-of-specification alerts
- Retest management
- Raw data file upload (chromatograms, spectra)

#### **9. Reporting System**
- Auto-generate test report dari template
- Multiple report templates (simple, detailed, research)
- Digital signature workflow
- Report approval process (Operator → Kepala Lab → Wakil Dir)
- Report versioning
- Download report (PDF, Excel)
- QR code untuk verifikasi online
- Email delivery dengan tracking

#### **10. Payment & Invoicing**
- Auto-generate invoice based on service
- Dynamic pricing (internal discount, external, urgent)
- Multiple payment methods (transfer, VA, e-wallet, cash, PO)
- Payment proof upload
- Payment verification workflow
- Payment reminders (H-7, H-3, overdue)
- Receipt generation
- Payment history & reconciliation
- Financial reports (daily, monthly, yearly)

#### **11. Training Management**
- Training catalog dengan categories
- Online registration form
- Quota management (min/max participants)
- Attendance tracking (QR code check-in)
- Training materials upload
- Certificate auto-generation (PDF dengan barcode)
- Training evaluation form
- Trainer assignment & rating
- Training history per user

#### **12. Internship & Practical Work**
- Online application form
- Supervisor assignment
- Digital logbook (daily entries)
- Progress monitoring dashboard
- File upload (proposal, reports)
- Evaluation form (multiple criteria)
- Certificate generation
- Document approval workflow

#### **13. Document Management**
- Categorized document library (SOP, forms, certificates, etc)
- Version control system
- Access control per role
- Full-text search dengan filters
- Document expiry tracking & alerts
- Document approval workflow
- Tags & metadata
- Download statistics

#### **14. Feedback & Evaluation**
- Service satisfaction survey (post-service)
- Star rating system (1-5)
- Comment & suggestions
- Feedback analytics dashboard
- Response management
- Sentiment analysis (optional)
- Evaluation reports per service/lab

#### **15. Notification System**
- Email notifications (transactional & marketing)
- In-app notifications (bell icon)
- SMS notifications (optional via gateway)
- Notification preferences per user
- Notification history
- Mark as read/unread
- Notification templates management
- Scheduled notifications

#### **16. Reporting & Analytics**
- Service statistics (count, revenue, avg time)
- Equipment utilization reports
- Revenue reports (per lab, per service, per month)
- User statistics (active users, new registrations)
- Lab performance metrics
- Custom report builder
- Export to Excel/PDF/CSV
- Scheduled reports (email weekly/monthly)
- Data visualization (charts, graphs)

#### **17. Settings & Configuration**
- General settings (site name, logo, contact)
- Email configuration (SMTP)
- Payment gateway configuration
- Notification templates editor
- System parameters (SLA, pricing, quota)
- Backup & restore database
- Activity audit log
- System health monitor

---

### **C. USER ROLES & PERMISSIONS**

Aplikasi memiliki **11 role** dengan permissions berbeda:

#### **Role 1: Super Admin / Direktur**
**Description**: Top management, full access
**Permissions**:
- ✅ Full access to all modules
- ✅ User & role management
- ✅ System configuration
- ✅ Financial reports
- ✅ Audit logs
- ✅ Backup & restore

**Dashboard Shows**:
- Total services (all time)
- Revenue (monthly, yearly)
- Active bookings
- Equipment status overview
- Pending approvals (high priority)
- System alerts

#### **Role 2: Wakil Direktur Pelayanan**
**Description**: Service & partnership management
**Permissions**:
- ✅ View all service requests
- ✅ Approve/reject service requests (level 2)
- ✅ Manage partnerships
- ✅ View revenue reports
- ✅ Manage promotions
- ✅ View feedback & analytics

**Dashboard Shows**:
- Pending approvals (for this role)
- Service statistics
- Partnership status
- Revenue trends
- Customer satisfaction scores

#### **Role 3: Wakil Direktur Penjaminan Mutu & TI**
**Description**: Quality assurance & IT management
**Permissions**:
- ✅ Manage SOPs
- ✅ Approve test reports (final)
- ✅ View audit logs
- ✅ Manage system settings
- ✅ Monitor equipment calibration
- ✅ View quality metrics

**Dashboard Shows**:
- SOP compliance status
- Overdue calibrations
- System health
- Report approval queue
- Quality incidents

#### **Role 4: Kepala Lab/Unit**
**Description**: Lab-specific management
**Permissions**:
- ✅ View service requests for their lab
- ✅ Approve/reject bookings for their lab
- ✅ Manage equipment in their lab
- ✅ Assign tests to operators
- ✅ Review test reports (first approval)
- ✅ Manage lab schedule
- ✅ View lab statistics

**Dashboard Shows**:
- Today's schedule
- Pending bookings
- Equipment maintenance alerts
- Lab utilization
- Team members status

#### **Role 5: Anggota Lab/Unit (Analyst/Researcher)**
**Description**: Lab staff, perform tests
**Permissions**:
- ✅ View assigned tests
- ✅ Enter test data
- ✅ Upload raw data files
- ✅ Generate draft reports
- ✅ View SOP for equipment
- ✅ Log equipment usage

**Dashboard Shows**:
- Assigned tests (pending, in progress)
- Today's schedule
- Equipment availability
- Recent results

#### **Role 6: Laboran (Technician)**
**Description**: Equipment preparation & maintenance
**Permissions**:
- ✅ Prepare equipment for tests
- ✅ Log maintenance activities
- ✅ Check-in/check-out samples
- ✅ View booking schedule
- ✅ Report equipment issues
- ✅ View SOP

**Dashboard Shows**:
- Today's bookings
- Equipment to prepare
- Maintenance schedule
- Sample check-ins

#### **Role 7: Sub Bagian TU & Keuangan**
**Description**: Admin & finance staff
**Permissions**:
- ✅ Verify service request documents
- ✅ Generate invoices
- ✅ Verify payments
- ✅ Issue receipts
- ✅ Manage documents
- ✅ View financial reports

**Dashboard Shows**:
- Pending verifications (documents, payments)
- Invoice status
- Payment summary
- Overdue payments

#### **Role 8: Dosen (Faculty)**
**Description**: University faculty
**Permissions**:
- ✅ Submit service requests
- ✅ Book facilities
- ✅ View test results
- ✅ Download reports
- ✅ Supervise students
- ✅ Apply for training

**Dashboard Shows**:
- My service requests
- My bookings
- My students' activities
- Available trainings

#### **Role 9: Mahasiswa (Student)**
**Description**: University students
**Permissions**:
- ✅ Submit service requests (with supervisor approval)
- ✅ Book facilities (limited)
- ✅ View test results
- ✅ Register for training
- ✅ Apply for internship/practical work

**Dashboard Shows**:
- My requests
- My bookings
- My results
- Upcoming trainings

#### **Role 10: Peneliti Eksternal (External Researcher)**
**Description**: Researchers from other institutions
**Permissions**:
- ✅ Submit service requests
- ✅ Book facilities (paid)
- ✅ View test results
- ✅ Download reports
- ✅ Pay invoices
- ✅ Give feedback

**Dashboard Shows**:
- My requests
- My bookings
- Payment status
- My results

#### **Role 11: Industri/Masyarakat Umum (Industry/Public)**
**Description**: Industry & general public
**Permissions**:
- ✅ Register account
- ✅ Submit service requests (paid)
- ✅ Book facilities (paid)
- ✅ Pay invoices
- ✅ View test results
- ✅ Download reports
- ✅ Give feedback

**Dashboard Shows**:
- My requests
- Payment history
- My reports
- Service catalog

---

### **D. DATABASE SCHEMA**

Tutorial harus membuat **47 tables** dengan relasi yang kompleks:

#### **Users & Authentication (5 tables)**
```sql
users
├── id: bigint (PK)
├── name: varchar(255)
├── email: varchar(255) UNIQUE
├── email_verified_at: timestamp NULL
├── password: varchar(255)
├── nip_nim: varchar(50) NULL (untuk mahasiswa/dosen)
├── phone: varchar(20) NULL
├── address: text NULL
├── institution: varchar(255) NULL (untuk eksternal)
├── role_id: bigint (FK → roles.id)
├── status: enum('active','inactive','suspended') DEFAULT 'active'
├── last_login_at: timestamp NULL
├── remember_token: varchar(100) NULL
├── created_at: timestamp
└── updated_at: timestamp

roles
├── id: bigint (PK)
├── name: varchar(100) (Super Admin, Wakil Direktur, dll)
├── slug: varchar(100) UNIQUE (super-admin, wakil-direktur, dll)
├── description: text NULL
├── created_at: timestamp
└── updated_at: timestamp

permissions
├── id: bigint (PK)
├── name: varchar(100) (view-dashboard, manage-users, dll)
├── slug: varchar(100) UNIQUE (view-dashboard, manage-users, dll)
├── module: varchar(50) (users, labs, bookings, dll)
├── description: text NULL
├── created_at: timestamp
└── updated_at: timestamp

role_permissions (pivot table)
├── role_id: bigint (FK → roles.id)
├── permission_id: bigint (FK → permissions.id)
└── PRIMARY KEY (role_id, permission_id)

user_profiles
├── id: bigint (PK)
├── user_id: bigint (FK → users.id) UNIQUE
├── photo: varchar(255) NULL (path to photo)
├── bio: text NULL
├── expertise: text NULL (JSON: ["Kimia Analitik", "GC-MS"])
├── education: varchar(100) NULL (S1, S2, S3)
├── institution_address: text NULL
├── supervisor_name: varchar(255) NULL (untuk mahasiswa)
├── supervisor_email: varchar(255) NULL
├── created_at: timestamp
└── updated_at: timestamp
```

#### **Laboratory Management (4 tables)**
```sql
laboratories
├── id: bigint (PK)
├── code: varchar(20) UNIQUE (LAB-CHEM-01, LAB-BIO-01, dll)
├── name: varchar(255) (Laboratorium Kimia Analitik)
├── type: enum('kimia','biologi','fisika','lingkungan','pangan','farmasi','instrumentasi')
├── location: varchar(255) (Gedung iLab, Lt. 2, Ruang 201)
├── floor: tinyint
├── room_number: varchar(20)
├── capacity: int (max people)
├── area_sqm: decimal(8,2) NULL (luas ruangan m²)
├── facilities: text NULL (JSON: ["Fume Hood", "AC", "Sink"])
├── status: enum('active','maintenance','closed') DEFAULT 'active'
├── description: text NULL
├── head_user_id: bigint NULL (FK → users.id, Kepala Lab)
├── photo: varchar(255) NULL
├── created_at: timestamp
└── updated_at: timestamp

equipment
├── id: bigint (PK)
├── laboratory_id: bigint (FK → laboratories.id)
├── code: varchar(50) UNIQUE (EQP-GCMS-001)
├── name: varchar(255) (GC-MS Shimadzu)
├── brand: varchar(100) (Shimadzu, Agilent, dll)
├── model: varchar(100) (QP2010 Ultra)
├── type: varchar(100) (GC-MS, HPLC, Spektrofotometer, dll)
├── serial_number: varchar(100) NULL
├── specification: text NULL (JSON spec lengkap)
├── purchase_date: date NULL
├── purchase_price: decimal(15,2) NULL
├── warranty_until: date NULL
├── status: enum('available','in_use','maintenance','broken','disposed') DEFAULT 'available'
├── condition: enum('excellent','good','fair','poor') DEFAULT 'good'
├── last_maintenance_date: date NULL
├── next_maintenance_date: date NULL
├── last_calibration_date: date NULL
├── next_calibration_date: date NULL
├── location_detail: varchar(255) NULL (Lab Kimia, Meja 3)
├── responsible_user_id: bigint NULL (FK → users.id, PIC alat)
├── usage_hours: int DEFAULT 0 (total jam pemakaian)
├── photo: varchar(255) NULL
├── notes: text NULL
├── created_at: timestamp
└── updated_at: timestamp

equipment_maintenance
├── id: bigint (PK)
├── equipment_id: bigint (FK → equipment.id)
├── type: enum('preventive','corrective','calibration')
├── maintenance_date: date
├── performed_by: varchar(255) (nama teknisi)
├── technician_company: varchar(255) NULL (vendor)
├── description: text (apa yang dilakukan)
├── findings: text NULL (temuan saat maintenance)
├── actions_taken: text NULL (tindakan perbaikan)
├── parts_replaced: text NULL (JSON: [{"part":"Filter","qty":2}])
├── cost: decimal(12,2) NULL
├── next_maintenance_date: date NULL
├── status: enum('scheduled','in_progress','completed','cancelled')
├── document_path: varchar(255) NULL (scan report)
├── created_by: bigint (FK → users.id)
├── created_at: timestamp
└── updated_at: timestamp

equipment_calibrations
├── id: bigint (PK)
├── equipment_id: bigint (FK → equipment.id)
├── calibration_date: date
├── valid_until: date (biasanya 1 tahun)
├── certificate_number: varchar(100)
├── calibration_agency: varchar(255) (KAN, vendor, dll)
├── accreditation_number: varchar(100) NULL (no akreditasi KAN)
├── calibration_method: varchar(255) NULL
├── results: text NULL (JSON hasil kalibrasi)
├── pass_fail: enum('pass','fail','conditional')
├── certificate_path: varchar(255) NULL (scan sertifikat)
├── cost: decimal(12,2) NULL
├── performed_by: varchar(255)
├── notes: text NULL
├── status: enum('valid','expired','pending')
├── reminder_sent: boolean DEFAULT false
├── created_by: bigint (FK → users.id)
├── created_at: timestamp
└── updated_at: timestamp
```

#### **SOP Management (3 tables)**
```sql
sops
├── id: bigint (PK)
├── equipment_id: bigint NULL (FK → equipment.id, NULL jika SOP umum)
├── laboratory_id: bigint NULL (FK → laboratories.id)
├── code: varchar(50) UNIQUE (SOP/EQP/GCMS/V01)
├── title: varchar(255) (SOP Penggunaan GC-MS)
├── category: enum('equipment','safety','quality','admin','emergency')
├── version: varchar(10) (V01, V02, dll)
├── effective_date: date
├── review_date: date NULL (tanggal review berikutnya)
├── status: enum('draft','active','archived','superseded')
├── document_path: varchar(255) (PDF file)
├── cover_image: varchar(255) NULL
├── approved_by: bigint NULL (FK → users.id, Wakil Dir PMTI)
├── approved_at: timestamp NULL
├── created_by: bigint (FK → users.id)
├── updated_by: bigint NULL (FK → users.id)
├── superseded_by: bigint NULL (FK → sops.id, SOP pengganti)
├── download_count: int DEFAULT 0
├── created_at: timestamp
└── updated_at: timestamp

sop_sections
├── id: bigint (PK)
├── sop_id: bigint (FK → sops.id)
├── section_order: int (1, 2, 3, ...)
├── title: varchar(255) (Fungsi Alat, Cara Penggunaan, dll)
├── content: text (isi section)
├── created_at: timestamp
└── updated_at: timestamp

sop_attachments
├── id: bigint (PK)
├── sop_id: bigint (FK → sops.id)
├── file_name: varchar(255)
├── file_path: varchar(255)
├── file_type: varchar(50) (image, video, doc)
├── file_size: int (bytes)
├── description: text NULL
├── uploaded_by: bigint (FK → users.id)
├── created_at: timestamp
└── updated_at: timestamp
```

#### **Service & Booking System (4 tables)**
```sql
services
├── id: bigint (PK)
├── laboratory_id: bigint (FK → laboratories.id)
├── code: varchar(50) UNIQUE (SVC-CHEM-001)
├── name: varchar(255) (Analisis GC-MS)
├── description: text
├── category: enum('kimia','biologi','fisika','mikrobiologi','material','lingkungan','pangan','farmasi')
├── subcategory: varchar(100) NULL (Analisis Organik, Analisis Anorganik)
├── method: varchar(255) NULL (ISO 17025, SNI 2354)
├── duration_days: int (estimasi hari)
├── price_internal: decimal(12,2) (tarif mahasiswa/dosen UNMUL)
├── price_external_edu: decimal(12,2) (tarif universitas lain)
├── price_external: decimal(12,2) (tarif industri/umum)
├── urgent_surcharge_percent: int DEFAULT 50 (biaya urgent %)
├── requirements: text NULL (JSON: ["Sampel min 50g", "Form permohonan"])
├── equipment_needed: text NULL (JSON: [1, 5, 8] → equipment IDs)
├── sample_preparation: text NULL (instruksi preparasi sampel)
├── deliverables: text NULL (JSON: ["Laporan PDF", "Raw data"])
├── min_sample: int NULL (jumlah minimal sampel)
├── max_sample: int NULL (jumlah maksimal per batch)
├── is_active: boolean DEFAULT true
├── popularity: int DEFAULT 0 (hit counter)
├── created_at: timestamp
└── updated_at: timestamp

service_requests
├── id: bigint (PK)
├── user_id: bigint (FK → users.id, pemohon)
├── service_id: bigint (FK → services.id)
├── request_number: varchar(50) UNIQUE (REQ/CHEM/01/2025/0001)
├── request_date: date
├── purpose: text (tujuan penelitian/pengujian)
├── urgency: enum('normal','urgent') DEFAULT 'normal'
├── priority: enum('low','normal','high','critical') DEFAULT 'normal'
├── status: enum('draft','submitted','verified','approved_director','approved_vp','assigned','scheduled','in_progress','testing','completed','reported','cancelled','rejected')
├── rejection_reason: text NULL
├── estimated_start_date: date NULL
├── estimated_completion_date: date NULL
├── actual_start_date: date NULL
├── actual_completion_date: date NULL
├── assigned_to_lab_id: bigint NULL (FK → laboratories.id)
├── assigned_to_user_id: bigint NULL (FK → users.id, analyst)
├── supervisor_name: varchar(255) NULL (untuk mahasiswa)
├── supervisor_email: varchar(255) NULL
├── institution: varchar(255) NULL (untuk eksternal)
├── research_title: varchar(500) NULL
├── proposal_file: varchar(255) NULL (PDF proposal)
├── support_document_1: varchar(255) NULL
├── support_document_2: varchar(255) NULL
├── ethical_clearance_file: varchar(255) NULL
├── notes: text NULL
├── internal_notes: text NULL (hanya untuk staff)
├── created_at: timestamp
└── updated_at: timestamp

bookings
├── id: bigint (PK)
├── service_request_id: bigint NULL (FK → service_requests.id, NULL jika booking langsung)
├── user_id: bigint (FK → users.id)
├── laboratory_id: bigint (FK → laboratories.id)
├── equipment_id: bigint NULL (FK → equipment.id, NULL jika booking ruang)
├── booking_number: varchar(50) UNIQUE (BKG/CHEM/01/2025/0001)
├── booking_type: enum('research','testing','training','maintenance','other')
├── booking_date: date
├── start_time: time
├── end_time: time
├── duration_hours: decimal(4,2)
├── status: enum('pending','approved','confirmed','checked_in','in_progress','checked_out','completed','cancelled','no_show')
├── approval_status: enum('pending','approved','rejected') DEFAULT 'pending'
├── approved_by: bigint NULL (FK → users.id, Kepala Lab)
├── approved_at: timestamp NULL
├── rejection_reason: text NULL
├── purpose: text NULL
├── special_requirements: text NULL
├── participants_count: int DEFAULT 1
├── check_in_time: timestamp NULL
├── check_out_time: timestamp NULL
├── actual_duration_hours: decimal(4,2) NULL
├── equipment_condition_before: enum('excellent','good','fair','poor') NULL
├── equipment_condition_after: enum('excellent','good','fair','poor') NULL
├── incident_report: text NULL
├── is_recurring: boolean DEFAULT false
├── recurring_pattern: varchar(50) NULL (weekly, monthly)
├── recurring_end_date: date NULL
├── parent_booking_id: bigint NULL (FK → bookings.id, untuk recurring)
├── cancellation_reason: text NULL
├── cancelled_at: timestamp NULL
├── cancelled_by: bigint NULL (FK → users.id)
├── reminder_sent_3days: boolean DEFAULT false
├── reminder_sent_1day: boolean DEFAULT false
├── reminder_sent_today: boolean DEFAULT false
├── notes: text NULL
├── created_at: timestamp
└── updated_at: timestamp

booking_approvals
├── id: bigint (PK)
├── booking_id: bigint (FK → bookings.id)
├── approver_id: bigint (FK → users.id)
├── approval_level: enum('lab_head','vice_director') (jika butuh multi-level)
├── status: enum('pending','approved','rejected')
├── notes: text NULL
├── approved_at: timestamp NULL
├── created_at: timestamp
└── updated_at: timestamp
```

#### **Sample & Testing (4 tables)**
```sql
samples
├── id: bigint (PK)
├── service_request_id: bigint (FK → service_requests.id)
├── sample_code: varchar(50) UNIQUE (auto-generated barcode)
├── sample_number: varchar(50) (nomor urut per request)
├── name: varchar(255) (Nama sampel)
├── type: varchar(100) (Air, Tanah, Makanan, dll)
├── description: text NULL
├── quantity: decimal(10,2)
├── unit: varchar(20) (gram, mL, pieces)
├── condition: enum('good','acceptable','poor','rejected') DEFAULT 'good'
├── condition_notes: text NULL (deskripsi kondisi)
├── received_date: date
├── received_by: bigint (FK → users.id, laboran)
├── received_time: time
├── expiry_date: date NULL
├── storage_location: varchar(100) (Freezer A, Rak B-3)
├── storage_temperature: varchar(50) NULL (-20°C, Room Temp)
├── photo: varchar(255) NULL
├── barcode_image: varchar(255) NULL (generated barcode image)
├── preparation_notes: text NULL
├── status: enum('received','stored','in_testing','tested','archived','disposed')
├── disposed_date: date NULL
├── disposed_by: bigint NULL (FK → users.id)
├── disposal_method: varchar(255) NULL
├── notes: text NULL
├── created_at: timestamp
└── updated_at: timestamp

tests
├── id: bigint (PK)
├── sample_id: bigint (FK → samples.id)
├── service_id: bigint (FK → services.id)
├── equipment_id: bigint (FK → equipment.id)
├── test_number: varchar(50) UNIQUE (TST/CHEM/01/2025/0001)
├── operator_id: bigint (FK → users.id, analyst)
├── test_date: date
├── start_time: time NULL
├── end_time: time NULL
├── method: varchar(255) (ISO 17025, SNI 2354, dll)
├── method_reference: varchar(255) NULL (link/doc reference)
├── parameters: text (JSON: [{"name":"pH","expected":"7.0"}])
├── status: enum('scheduled','in_progress','completed','failed','retest_required')
├── retest_reason: text NULL
├── retest_from_test_id: bigint NULL (FK → tests.id)
├── raw_data_file: varchar(255) NULL (chromatogram, spectra)
├── instrument_log_file: varchar(255) NULL
├── qc_check_pass: boolean NULL
├── qc_checked_by: bigint NULL (FK → users.id)
├── qc_checked_at: timestamp NULL
├── notes: text NULL
├── created_at: timestamp
└── updated_at: timestamp

test_results
├── id: bigint (PK)
├── test_id: bigint (FK → tests.id)
├── parameter: varchar(255) (pH, Temperature, E.coli, dll)
├── value: varchar(100) (hasil pengukuran)
├── unit: varchar(50) (mg/L, CFU/g, %, dll)
├── standard_value: varchar(100) NULL (nilai standar/batas)
├── standard_reference: varchar(255) NULL (SNI, ISO)
├── status: enum('pass','fail','acceptable','out_of_range')
├── deviation: decimal(10,4) NULL (deviation from standard)
├── uncertainty: decimal(10,4) NULL (measurement uncertainty)
├── lod: decimal(10,4) NULL (limit of detection)
├── loq: decimal(10,4) NULL (limit of quantification)
├── replicate_1: varchar(100) NULL
├── replicate_2: varchar(100) NULL
├── replicate_3: varchar(100) NULL
├── average: varchar(100) NULL
├── rsd: decimal(10,4) NULL (relative standard deviation)
├── notes: text NULL
├── created_at: timestamp
└── updated_at: timestamp

test_reports
├── id: bigint (PK)
├── service_request_id: bigint (FK → service_requests.id)
├── report_number: varchar(50) UNIQUE (RPT/CHEM/01/2025/0001)
├── report_date: date
├── report_type: enum('preliminary','final','revised')
├── revision_number: int DEFAULT 0
├── template_used: varchar(100) (template name)
├── tested_by: bigint (FK → users.id, analyst)
├── reviewed_by: bigint NULL (FK → users.id, Kepala Lab)
├── reviewed_at: timestamp NULL
├── approved_by: bigint NULL (FK → users.id, Wakil Dir)
├── approved_at: timestamp NULL
├── status: enum('draft','review','approved','issued','revised')
├── title: varchar(500)
├── summary: text NULL
├── methodology: text NULL
├── conclusion: text NULL
├── recommendations: text NULL
├── file_path: varchar(255) (final PDF)
├── qr_code: varchar(255) (untuk verifikasi online)
├── verification_url: varchar(500)
├── digital_signature_tested: varchar(255) NULL (signature image)
├── digital_signature_reviewed: varchar(255) NULL
├── digital_signature_approved: varchar(255) NULL
├── sent_to_user: boolean DEFAULT false
├── sent_at: timestamp NULL
├── download_count: int DEFAULT 0
├── is_public: boolean DEFAULT false
├── notes: text NULL
├── created_at: timestamp
└── updated_at: timestamp
```

#### **Payment & Finance (3 tables)**
```sql
invoices
├── id: bigint (PK)
├── service_request_id: bigint (FK → service_requests.id)
├── user_id: bigint (FK → users.id)
├── invoice_number: varchar(50) UNIQUE (INV/INT/01/2025/0001)
├── issue_date: date
├── due_date: date (biasanya +30 hari untuk PO, +7 hari untuk prepaid)
├── payment_term: enum('prepaid','postpaid_7','postpaid_14','postpaid_30')
├── subtotal: decimal(15,2)
├── tax_percentage: decimal(5,2) DEFAULT 0.00 (PPN %)
├── tax_amount: decimal(15,2) DEFAULT 0.00
├── discount_percentage: decimal(5,2) DEFAULT 0.00
├── discount_amount: decimal(15,2) DEFAULT 0.00
├── urgent_surcharge: decimal(15,2) DEFAULT 0.00
├── other_charges: decimal(15,2) DEFAULT 0.00
├── total: decimal(15,2)
├── status: enum('draft','issued','sent','partial_paid','paid','overdue','cancelled')
├── currency: varchar(3) DEFAULT 'IDR'
├── notes: text NULL
├── internal_notes: text NULL
├── created_by: bigint (FK → users.id, staff TU)
├── sent_at: timestamp NULL
├── created_at: timestamp
└── updated_at: timestamp

invoice_items
├── id: bigint (PK)
├── invoice_id: bigint (FK → invoices.id)
├── service_id: bigint NULL (FK → services.id)
├── description: varchar(500)
├── quantity: int
├── unit_price: decimal(12,2)
├── subtotal: decimal(15,2)
├── notes: text NULL
├── created_at: timestamp
└── updated_at: timestamp

payments
├── id: bigint (PK)
├── invoice_id: bigint (FK → invoices.id)
├── payment_number: varchar(50) UNIQUE (PAY/2025/0001)
├── payment_date: date
├── amount: decimal(15,2)
├── method: enum('transfer','va','ewallet','qris','cash','credit_card','po')
├── method_detail: varchar(255) NULL (nama bank, e-wallet, dll)
├── reference_number: varchar(255) NULL (no transaksi bank)
├── account_number: varchar(50) NULL (no rekening pengirim)
├── account_name: varchar(255) NULL (nama pengirim)
├── proof_path: varchar(255) NULL (upload bukti transfer)
├── status: enum('pending','verified','rejected','refunded')
├── verified_by: bigint NULL (FK → users.id, staff keuangan)
├── verified_at: timestamp NULL
├── verification_notes: text NULL
├── rejection_reason: text NULL
├── refund_amount: decimal(15,2) NULL
├── refund_date: date NULL
├── refund_reason: text NULL
├── receipt_number: varchar(50) NULL (kwitansi)
├── receipt_path: varchar(255) NULL (PDF kwitansi)
├── notes: text NULL
├── created_at: timestamp
└── updated_at: timestamp
```

#### **Training & Internship (4 tables)**
```sql
training_programs
├── id: bigint (PK)
├── code: varchar(50) UNIQUE (TRN-GCMS-2025-01)
├── title: varchar(255)
├── description: text
├── category: enum('equipment','safety','methodology','software','soft_skill')
├── level: enum('basic','intermediate','advanced')
├── trainer_user_id: bigint NULL (FK → users.id, internal trainer)
├── trainer_external: varchar(255) NULL (external trainer name)
├── trainer_bio: text NULL
├── start_date: date
├── end_date: date
├── duration_days: int
├── duration_hours: decimal(5,2)
├── schedule: text (JSON: [{"day":1,"date":"2025-01-10","start":"09:00","end":"17:00"}])
├── location: varchar(255) (Lab/Ruang/Online)
├── quota_min: int
├── quota_max: int
├── registered_count: int DEFAULT 0
├── price_internal: decimal(12,2)
├── price_external: decimal(12,2)
├── early_bird_discount: decimal(5,2) NULL (%)
├── early_bird_deadline: date NULL
├── registration_open_date: date
├── registration_close_date: date
├── status: enum('draft','open','full','ongoing','completed','cancelled')
├── syllabus: text NULL
├── requirements: text NULL (JSON)
├── materials_provided: text NULL (JSON)
├── certificate_template: varchar(255) NULL
├── evaluation_form_id: bigint NULL (FK untuk form evaluasi)
├── poster_image: varchar(255) NULL
├── created_by: bigint (FK → users.id)
├── created_at: timestamp
└── updated_at: timestamp

training_participants
├── id: bigint (PK)
├── training_program_id: bigint (FK → training_programs.id)
├── user_id: bigint (FK → users.id)
├── registration_number: varchar(50) UNIQUE
├── registration_date: date
├── payment_status: enum('pending','paid','exempt') DEFAULT 'pending'
├── invoice_id: bigint NULL (FK → invoices.id)
├── attendance_status: enum('registered','confirmed','attended','absent','cancelled')
├── attendance_percentage: decimal(5,2) NULL (%)
├── attendance_details: text NULL (JSON per session)
├── pre_test_score: decimal(5,2) NULL
├── post_test_score: decimal(5,2) NULL
├── evaluation_score: decimal(5,2) NULL
├── evaluation_feedback: text NULL
├── certificate_issued: boolean DEFAULT false
├── certificate_number: varchar(50) NULL
├── certificate_date: date NULL
├── certificate_path: varchar(255) NULL
├── notes: text NULL
├── created_at: timestamp
└── updated_at: timestamp

internships
├── id: bigint (PK)
├── user_id: bigint (FK → users.id, mahasiswa)
├── laboratory_id: bigint (FK → laboratories.id)
├── supervisor_id: bigint (FK → users.id, pembimbing)
├── application_number: varchar(50) UNIQUE (INT/2025/0001)
├── application_date: date
├── university: varchar(255) (universitas asal)
├── major: varchar(255) (jurusan)
├── student_id: varchar(50) (NIM)
├── semester: int
├── start_date: date
├── end_date: date
├── duration_weeks: int
├── topic: varchar(500) (topik magang)
├── objectives: text
├── proposal_file: varchar(255) NULL
├── status: enum('applied','reviewed','approved','rejected','ongoing','completed','terminated')
├── approval_date: date NULL
├── approved_by: bigint NULL (FK → users.id, Kepala Lab)
├── rejection_reason: text NULL
├── attendance_percentage: decimal(5,2) NULL
├── evaluation_score: decimal(5,2) NULL
├── evaluation_file: varchar(255) NULL (form evaluasi PDF)
├── final_report_file: varchar(255) NULL
├── certificate_issued: boolean DEFAULT false
├── certificate_number: varchar(50) NULL
├── certificate_path: varchar(255) NULL
├── notes: text NULL
├── created_at: timestamp
└── updated_at: timestamp

practical_works
├── id: bigint (PK)
├── user_id: bigint (FK → users.id, mahasiswa)
├── laboratory_id: bigint (FK → laboratories.id)
├── supervisor_id: bigint (FK → users.id)
├── application_number: varchar(50) UNIQUE (PKL/2025/0001)
├── application_date: date
├── university: varchar(255)
├── major: varchar(255)
├── student_id: varchar(50)
├── course: varchar(255) (mata kuliah)
├── course_code: varchar(50)
├── start_date: date
├── end_date: date
├── duration_weeks: int
├── schedule: text NULL (JSON jadwal per hari)
├── objectives: text
├── proposal_file: varchar(255) NULL
├── status: enum('applied','approved','rejected','ongoing','completed')
├── approved_by: bigint NULL (FK → users.id)
├── approval_date: date NULL
├── attendance_percentage: decimal(5,2) NULL
├── report_file: varchar(255) NULL
├── evaluation_score: decimal(5,2) NULL
├── certificate_issued: boolean DEFAULT false
├── certificate_path: varchar(255) NULL
├── notes: text NULL
├── created_at: timestamp
└── updated_at: timestamp
```

#### **Document Management (2 tables)**
```sql
documents
├── id: bigint (PK)
├── category: enum('sop','form','certificate','report','policy','manual','other')
├── title: varchar(255)
├── description: text NULL
├── document_number: varchar(50) NULL
├── version: varchar(10) NULL (V01, V02)
├── file_name: varchar(255)
├── file_path: varchar(255)
├── file_type: varchar(50) (pdf, docx, xlsx)
├── file_size: int (bytes)
├── tags: text NULL (JSON: ["Kimia", "Safety", "ISO"])
├── is_public: boolean DEFAULT false (public download tanpa login)
├── requires_approval: boolean DEFAULT false
├── expiry_date: date NULL
├── status: enum('draft','active','archived','expired')
├── uploaded_by: bigint (FK → users.id)
├── approved_by: bigint NULL (FK → users.id)
├── approved_at: timestamp NULL
├── download_count: int DEFAULT 0
├── last_downloaded_at: timestamp NULL
├── created_at: timestamp
└── updated_at: timestamp

equipment_documents
├── id: bigint (PK)
├── equipment_id: bigint (FK → equipment.id)
├── document_type: enum('manual','spec','certificate','warranty','maintenance_log','calibration','photo')
├── title: varchar(255)
├── description: text NULL
├── file_path: varchar(255)
├── file_size: int
├── upload_date: date
├── uploaded_by: bigint (FK → users.id)
├── created_at: timestamp
└── updated_at: timestamp
```

#### **Activity & Scheduling (2 tables)**
```sql
activities
├── id: bigint (PK)
├── laboratory_id: bigint (FK → laboratories.id)
├── title: varchar(255)
├── type: enum('workshop','seminar','training','meeting','maintenance','research','other')
├── description: text NULL
├── start_date: date
├── end_date: date
├── start_time: time NULL
├── end_time: time NULL
├── organizer: varchar(255)
├── organizer_contact: varchar(100) NULL
├── location: varchar(255)
├── participants_count: int NULL
├── max_capacity: int NULL
├── status: enum('planned','ongoing','completed','cancelled')
├── budget: decimal(15,2) NULL
├── actual_cost: decimal(15,2) NULL
├── poster_image: varchar(255) NULL
├── documentation_photos: text NULL (JSON array of image paths)
├── notes: text NULL
├── created_by: bigint (FK → users.id)
├── created_at: timestamp
└── updated_at: timestamp

schedules
├── id: bigint (PK)
├── laboratory_id: bigint (FK → laboratories.id)
├── equipment_id: bigint NULL (FK → equipment.id)
├── user_id: bigint (FK → users.id)
├── booking_id: bigint NULL (FK → bookings.id)
├── activity_id: bigint NULL (FK → activities.id)
├── date: date
├── start_time: time
├── end_time: time
├── activity_type: enum('booking','maintenance','training','blocked','other')
├── title: varchar(255)
├── description: text NULL
├── status: enum('scheduled','in_progress','completed','cancelled')
├── color: varchar(7) NULL (hex color untuk calendar view)
├── notes: text NULL
├── created_at: timestamp
└── updated_at: timestamp
```

#### **Feedback & Evaluation (2 tables)**
```sql
feedbacks
├── id: bigint (PK)
├── user_id: bigint (FK → users.id)
├── service_request_id: bigint NULL (FK → service_requests.id)
├── training_program_id: bigint NULL (FK → training_programs.id)
├── booking_id: bigint NULL (FK → bookings.id)
├── category: enum('service','facility','staff','training','system','other')
├── rating: tinyint (1-5 stars)
├── rating_criteria: text NULL (JSON: {"responsiveness":5,"accuracy":4,"speed":3})
├── comments: text NULL
├── suggestions: text NULL
├── is_anonymous: boolean DEFAULT false
├── submitted_date: date
├── status: enum('pending','reviewed','resolved','archived')
├── response: text NULL
├── responded_by: bigint NULL (FK → users.id)
├── responded_at: timestamp NULL
├── is_public: boolean DEFAULT false
├── sentiment: enum('positive','neutral','negative') NULL (auto-analyzed)
├── created_at: timestamp
└── updated_at: timestamp

evaluations
├── id: bigint (PK)
├── evaluator_id: bigint (FK → users.id, yang mengevaluasi)
├── evaluated_type: varchar(100) (User, Equipment, Service, Training)
├── evaluated_id: bigint (polymorphic ID)
├── evaluation_type: enum('performance','service_quality','equipment','training','internship')
├── criteria: text (JSON: [{"name":"Punctuality","weight":20}])
├── scores: text (JSON: [{"criterion":"Punctuality","score":85}])
├── total_score: decimal(5,2)
├── grade: varchar(2) NULL (A, B, C, D, E)
├── notes: text NULL
├── recommendations: text NULL
├── evaluation_date: date
├── created_at: timestamp
└── updated_at: timestamp
```

#### **Notification & Audit (2 tables)**
```sql
notifications
├── id: bigint (PK)
├── user_id: bigint (FK → users.id)
├── type: enum('info','success','warning','error','reminder')
├── category: enum('service','booking','payment','report','system','training')
├── title: varchar(255)
├── message: text
├── link: varchar(500) NULL (internal link to related resource)
├── action_text: varchar(100) NULL (button text: "View Details")
├── action_url: varchar(500) NULL
├── icon: varchar(50) NULL (icon class)
├── read_at: timestamp NULL
├── is_sent_email: boolean DEFAULT false
├── email_sent_at: timestamp NULL
├── is_sent_sms: boolean DEFAULT false
├── sms_sent_at: timestamp NULL
├── priority: enum('low','normal','high') DEFAULT 'normal'
├── expires_at: timestamp NULL
├── created_at: timestamp
└── updated_at: timestamp

audit_logs
├── id: bigint (PK)
├── user_id: bigint NULL (FK → users.id, NULL if system action)
├── action: varchar(100) (created, updated, deleted, viewed, approved, rejected)
├── model_type: varchar(100) (ServiceRequest, Booking, User, etc)
├── model_id: bigint NULL
├── description: text (human-readable description)
├── old_values: text NULL (JSON before change)
├── new_values: text NULL (JSON after change)
├── ip_address: varchar(45) NULL
├── user_agent: varchar(500) NULL
├── url: varchar(500) NULL
├── created_at: timestamp
└── INDEX (user_id, created_at)
└── INDEX (model_type, model_id)
```

---

### **D.1. HISTORICAL DATA & REAL-WORLD EXAMPLES**

**📊 CONTOH KEGIATAN NYATA DI ILAB UNMUL (2024)**

Berikut adalah **data AKTUAL** kegiatan yang telah dilaksanakan di iLab UNMUL. Data ini menunjukkan **real-world use cases** dan harus dijadikan referensi untuk:
- Sample data seeding
- User stories & test scenarios
- UI mockups & demonstrations

#### **Tabel Kegiatan Historis (Januari - September 2024)**

| No | Jenis Kegiatan | Tanggal | Pengguna | Asal Institusi | Kategori |
|----|----------------|---------|----------|----------------|----------|
| **1** | **Workshop: Discover the Selectivity and Provided Analysis with GC-MS, LC-MS/MS, and AAS** | 30 Januari 2024 | Dosen dan Laboran | • Fakultas Perikanan dan Ilmu Kelautan<br>• Fakultas Keguruan dan Ilmu Pendidikan<br>• Fakultas Farmasi<br>• Fakultas Pertanian dan Peternakan<br>• Fakultas Kedokteran<br>• Fakultas MIPA<br>• Fakultas Teknik | Training |
| **2** | **Workshop: Real time PCR and It's Applications** | 1 Februari 2024 | Dosen dan Laboran | (7 Fakultas yang sama dengan No. 1) | Training |
| **3** | **Workshop: Spektrometer FTIR, Pengertian, Fungsi dan Prinsip Kerja** | 16 Februari 2024 | Dosen dan Laboran | (7 Fakultas yang sama dengan No. 1) | Training |
| **4** | **Penelitian Tugas Akhir Mahasiswa:**<br>"Uji Efektifitas Ekstrak Daun Ekaliptus (Eucalyptus sp) sebagai Insektisida Nabati Terhadap Ulat Grayak (Spodoptera sp) pada Tanaman Jagung Manis (Zea Mays L) Secara In Vitro" | 23 April 2024 s/d ongoing | Mahasiswa | Fakultas Pertanian dan Peternakan | Research |
| **5** | **🏭 Pelayanan penggunaan Freeze dryer**<br>**KLIEN INDUSTRI** | 24 April 2024 s/d selesai | Peneliti | **PT. Giat Madiri Sakti**<br>(External Industry Client) | Commercial Service |
| **6** | **Pelayanan penggunaan Freeze dryer** | 26 April 2024 | Peneliti | Fakultas Farmasi dan FKIP | Research |
| **7** | **🏭 Analisis menggunakan FTIR**<br>**KLIEN INDUSTRI** | 30 Mei 2024 | Peneliti | • **PT. Giat Madiri Sakti**<br>• Fakultas Kedokteran<br>• Fakultas MIPA | Commercial Service + Research |
| **8** | **Kegiatan Program Kreativitas Mahasiswa (PKM)** | 12 Juni 2024 | Mahasiswa dan Dosen | Fakultas Pertanian (Faperta) | Student Activity |
| **9** | **Praktikum Mahasiswa Prodi Teknik Geologi** | September-Desember 2024 | Mahasiswa | Fakultas Teknik | Practicum |

#### **📌 INSIGHTS PENTING DARI DATA HISTORIS:**

**1. Multi-Stakeholder Collaboration** ✅
- **7 Fakultas** aktif menggunakan iLab (menunjukkan sukses integrasi)
- Mix antara internal UNMUL dan eksternal
- Kolaborasi antar fakultas dalam 1 kegiatan

**2. PT. Giat Madiri Sakti - Contoh Nyata Klien Industri** 🏭
- **Signifikansi**: Ini adalah **BUKTI KONKRET** bahwa iLab UNMUL sudah melayani **klien industri komersial**
- Muncul **2 kali** dalam periode 4 bulan (repeat customer)
- Jenis layanan: Freeze dryer & FTIR analysis
- **Implikasi untuk aplikasi**:
  - User role "Industry/External" harus fully functional
  - Payment system harus robust (tarif komersial)
  - SLA harus ketat (industri expect professional service)
  - Contract management untuk repeat customers
  - NDA/confidentiality features untuk data industri

**3. Variasi Durasi Kegiatan** ⏱️
- Workshop: 1 hari
- Penelitian: ongoing (months)
- Praktikum: 4 bulan (September-Desember)
- Service: ad-hoc (completion-based)
→ Sistem harus support multiple time models

**4. Multi-Faculty Workshops** 👥
- 3 workshop pertama melibatkan 7 fakultas sekaligus
- Koordinasi kompleks (30-50+ participants estimated)
- Resource sharing across departments
→ Sistem perlu: bulk participant management, cross-faculty reporting

#### **💡 REKOMENDASI IMPLEMENTASI:**

**Untuk Database Seeder:**
```php
// Buat seeder yang include PT. Giat Madiri Sakti sebagai external client
// Dengan 2 service requests (Freeze dryer & FTIR)
// Status: Completed (historical data)
// Include invoice & payment records
```

**Untuk Testing Scenarios:**
- Test Case: External industry client submits service request
- Test Case: Repeat customer (PT. Giat Madiri Sakti) books again
- Test Case: Multi-faculty workshop registration (7 fakultas)
- Test Case: Long-running research project (4-6 months)

**Untuk UI Demonstrations:**
- Showcase PT. Giat Madiri Sakti sebagai success story
- Testimonials dari industry partners
- Case study: "How iLab UNMUL serves both academia & industry"

---

### **E. BUSINESS LOGIC & RULES**

Tutorial harus mengimplementasikan logic berikut:

#### **1. Service Request Workflow**

**Status Flow**:
```
draft → submitted → verified → approved_director → approved_vp →
assigned → scheduled → in_progress → testing → completed → reported
```

**Workflow Matrix** (Berdasarkan Gambar 2 dari dokumen - Alur Pelayanan Penggunaan Fasilitas):

| Step | Kegiatan | Pelaksana | Mutu Baku (SLA) | Output |
|------|----------|-----------|-----------------|--------|
| 1 | Mengajukan surat permohonan Penggunaan Aset/Fasilitas iLab | **Pengguna** | - | Surat Permohonan |
| 2 | Mendisposisikan surat permohonan | **Direktur** | 1 hari | Disposisi |
| 3 | Wakil Direktur mendisposisikan kepada Kepala Laboratorium | **Wakil Direktur Pelayanan** | 1 hari | Disposisi |
| 4 | Penentuan Izin Penggunaan Fasilitas dan penelitian yang akan digunakan | **Kepala Lab + Laboran** | 1 hari | Draft Izin Penggunaan |
| 5 | Penggunaan Aset/Fasilitas iLab | **Pengguna** | - | Daftar nama pengguna |
| 6 | Penentuan alat penggunaan aset dari Kepala iLab | **Kepala Lab** | - | Daftar hasil pengguna |
| 7 | Pengembalian fasilitas Aset/Fasilitas iLab | **Pengguna + Laboran** | 1 jam | Bukti pengembalian aset/fasilitas |

**Catatan Penting**:
- "Mutu Baku" = Standard Lead Time (SLA) untuk setiap step
- Total waktu approval administratif: **3 hari kerja** (Step 2-4)
- Setiap pelaksana memiliki dashboard dengan task queue mereka
- Sistem harus track waktu setiap step untuk KPI monitoring

**Rules**:
1. User submit request → status = 'submitted'
2. Staff Admin verify dokumen (1 hari) → status = 'verified' ATAU 'rejected'
3. Direktur approve (1 hari) → status = 'approved_director'
4. Wakil Dir Pelayanan assign ke lab (1 hari) → status = 'approved_vp'
5. Kepala Lab assign analyst & schedule → status = 'assigned'
6. Laboran terima sampel → status = 'scheduled'
7. Analyst mulai test → status = 'in_progress'
8. Test selesai, input data → status = 'testing'
9. Semua test done → status = 'completed'
10. Laporan approved → status = 'reported'

**Email Notifications**:
- Setiap perubahan status → email ke user
- Approval pending → email ke approver
- H-3 deadline → reminder ke analyst
- Overdue → escalation ke Kepala Lab

**Auto-Actions**:
- Auto-generate request_number: `REQ/[LAB]/[MM]/[YYYY]/[0001]`
- Auto-calculate estimated_completion based on service duration
- Auto-generate invoice setelah approval_vp
- Auto-assign priority based on urgency

#### **2. Booking Workflow**

**Status Flow**:
```
pending → approved → confirmed → checked_in → in_progress →
checked_out → completed
```

**Conflict Detection**:
```php
// Pseudo-code
Check if (lab_id + date + time range) overlaps with existing bookings
Check if equipment_id is available (not in maintenance, not broken)
Check if booking is within lab operating hours
Check if user has no-show history (max 3 in 6 months)
```

**Rules**:
1. Booking minimal H-3 hari kerja
2. Max duration: 8 jam per day (kecuali special approval)
3. Mahasiswa harus attach surat dosen pembimbing
4. Eksternal harus lunas payment dulu
5. Check-in tolerance: 30 menit after start_time
6. No-show after 30 menit → auto-cancel + penalty

**Recurring Booking**:
```php
// Create child bookings based on pattern
if (is_recurring) {
    create child bookings (weekly/monthly)
    until recurring_end_date
    inherit all parent booking properties
}
```

#### **3. Payment Logic**

**Pricing Calculation**:
```php
// Pseudo-code
base_price = service.price_internal OR price_external (based on user role)
discount = calculate_discount(user.role, user.category)
urgent_surcharge = (urgency == 'urgent') ? base_price * 0.50 : 0
subtotal = (base_price - discount + urgent_surcharge) * quantity
tax = subtotal * 0.11 // PPN 11%
total = subtotal + tax
```

**Discount Rules**:
```
Internal UNMUL:
- Mahasiswa S1/Diploma: 80%
- Mahasiswa S2: 70%
- Mahasiswa S3: 60%
- Dosen: 70%
- Peneliti: 60%
- Unit/Fakultas: 50%

Eksternal Pendidikan:
- Mahasiswa: 40%
- Dosen/Peneliti: 30%
- Institusi: 20%

Eksternal Umum:
- Industri: 0%
- BUMN/BUMD: 10%
- Instansi Pemerintah: 15%
- NGO/Yayasan: 20%
```

**Payment Verification**:
```php
// TU Keuangan verify payment
1. Check transfer date vs invoice issue date
2. Check amount match with invoice total (allow ±Rp 500 for bank admin)
3. Check account_name contains user name
4. If all OK: status = 'verified', send receipt
5. If not match: status = 'rejected', notify user
```

#### **4. Report Generation Logic**

**Workflow**:
```
1. Analyst create draft report
2. Input all test results
3. Upload raw data files
4. Click "Submit for Review" → status = 'review'
5. Kepala Lab review → approve OR reject dengan notes
6. If approved → forward to Wakil Dir PMTI
7. Wakil Dir PMTI final approval → status = 'approved'
8. System auto-generate final PDF with signatures
9. System generate QR code for verification
10. Send report to user via email
11. status = 'issued'
```

**PDF Template Structure**:
```
Cover Page
- Logo iLab UNMUL
- "LAPORAN HASIL PENGUJIAN"
- Report Number
- Issue Date
- Confidentiality mark

Approval Page
- Signature boxes (Tested by, Reviewed by, Approved by)
- Digital signatures (images)
- Dates & stamps

Report Body
- Client Info
- Sample Info (with photo)
- Test Methods
- Results Table
- Graphs/Charts (if applicable)
- Interpretation
- Conclusion

Attachments
- Raw data
- Chromatograms/Spectra
- Calibration certificates

Footer
- QR Code for verification
- Page numbers
- "This report is valid without wet signature"
```

#### **5. SOP Management Logic**

**Versioning**:
```php
// When updating SOP
1. Current SOP status → 'superseded'
2. Set current.superseded_by = new_sop.id
3. New SOP version = current.version + 1
4. New SOP status = 'draft'
5. After approval → status = 'active'
6. Old SOP still accessible (for audit trail)
```

**Access Control**:
```
View SOP: All authenticated users
Download SOP: All authenticated users
Create/Edit SOP: Only Wakil Dir PMTI, Kepala Lab
Approve SOP: Only Wakil Dir PMTI
Archive SOP: Only Super Admin
```

#### **6. Notification Rules**

**Trigger Events**:
```
Service Request:
- Submitted → notify Admin
- Approved by Director → notify Wakil Dir
- Assigned to Lab → notify Kepala Lab
- Rejected → notify User with reason
- Completed → notify User

Booking:
- H-3 → reminder to User
- H-1 → reminder to User + Laboran
- Same day 08:00 → reminder to User
- Approved → notify User
- Rejected → notify User with reason

Payment:
- Invoice issued → notify User
- Payment verified → notify User + send receipt
- Payment rejected → notify User with reason
- H-3 due date → payment reminder
- Overdue → escalation notification

Equipment:
- Maintenance due in 7 days → notify Laboran + Kepala Lab
- Calibration due in 30 days → notify Wakil Dir PMTI
- Equipment broken → notify Kepala Lab + Wakil Dir
- Maintenance completed → notify Kepala Lab

Report:
- Report ready → notify User
- Report approved → notify User + auto-send
```

#### **7. Analytics & Metrics**

**Dashboard Metrics** (auto-calculated):
```sql
-- Service Statistics
Total Services: COUNT(service_requests)
This Month: COUNT WHERE MONTH(created_at) = current_month
Completed: COUNT WHERE status = 'reported'
In Progress: COUNT WHERE status IN ('in_progress', 'testing')
Pending Approval: COUNT WHERE status IN ('verified', 'approved_director')

-- Revenue
Total Revenue: SUM(invoices.total WHERE status = 'paid')
This Month: SUM WHERE MONTH(payment_date) = current_month
Outstanding: SUM WHERE status IN ('issued', 'sent', 'overdue')

-- Equipment
Total Equipment: COUNT(equipment)
Available: COUNT WHERE status = 'available'
In Use: COUNT WHERE status = 'in_use'
Maintenance: COUNT WHERE status = 'maintenance'
Broken: COUNT WHERE status = 'broken'
Overdue Calibration: COUNT WHERE next_calibration_date < today

-- Bookings
Today's Bookings: COUNT WHERE booking_date = today
This Week: COUNT WHERE booking_date BETWEEN monday AND sunday
Utilization Rate: (total_booked_hours / total_available_hours) * 100

-- User Activity
Active Users (30 days): COUNT DISTINCT users WHERE last_login_at > 30 days ago
New Registrations (this month): COUNT WHERE created_at current month
Top Users (by service count): TOP 10 users by service_request count
```

**Charts**:
- Service Trend (line chart: last 12 months)
- Revenue by Lab (pie chart)
- Equipment Utilization (bar chart)
- User Registrations (area chart)
- Service Status Distribution (donut chart)
- Top Services (horizontal bar chart)

---

### **F. UI/UX REQUIREMENTS**

#### **Design System**

**Colors** (UNMUL Branding):
```css
Primary: #0066CC (Blue - representing knowledge & trust)
Secondary: #FF9800 (Orange - representing innovation)
Success: #4CAF50 (Green)
Warning: #FFC107 (Yellow)
Danger: #F44336 (Red)
Info: #2196F3 (Light Blue)
Dark: #212121 (Almost Black)
Light: #F5F5F5 (Light Gray)
```

**Typography**:
```css
Font Family: 'Inter', 'Segoe UI', 'Roboto', sans-serif
Headings: 600 weight
Body: 400 weight
Line Height: 1.6
```

**Spacing** (Tailwind-inspired):
```
xs: 0.25rem (4px)
sm: 0.5rem (8px)
md: 1rem (16px)
lg: 1.5rem (24px)
xl: 2rem (32px)
2xl: 3rem (48px)
```

**Components** (Yang Harus Dibuat):

1. **Buttons**:
   - Primary Button (filled)
   - Secondary Button (outlined)
   - Danger Button
   - Icon Button
   - Loading state
   - Disabled state

2. **Forms**:
   - Text Input (with validation)
   - Textarea
   - Select / Dropdown
   - Multi-select (tags)
   - Date Picker
   - Time Picker
   - File Upload (drag & drop)
   - Radio Buttons
   - Checkboxes
   - Toggle Switch

3. **Cards**:
   - Service Card (for catalog)
   - Equipment Card
   - Stats Card (for dashboard)
   - Timeline Card (for status tracking)

4. **Tables**:
   - DataTable (sortable, filterable, paginated)
   - Action column (view, edit, delete)
   - Bulk actions
   - Export buttons

5. **Modals**:
   - Confirmation Modal
   - Form Modal
   - Image Viewer Modal
   - Alert Modal

6. **Notifications**:
   - Toast notifications (top-right)
   - Alert banners
   - Badge counters

7. **Navigation**:
   - Top Navbar (logo, search, profile menu, notifications)
   - Sidebar Menu (collapsible, icon + text, active state)
   - Breadcrumbs
   - Tabs

8. **Status Badges**:
```html
<span class="badge badge-pending">Pending</span>
<span class="badge badge-approved">Approved</span>
<span class="badge badge-rejected">Rejected</span>
<span class="badge badge-completed">Completed</span>
```

9. **Timeline Component** (untuk tracking status):
```
○ Submitted          ✓ Verified           ✓ Approved
  2025-01-01           2025-01-02           2025-01-03

                       ◉ In Progress        ○ Completed
                         (Current)            (Waiting)
```

#### **Key Pages & Layouts**

**1. Landing Page** (Public):
```
[Hero Section]
- Background: iLab building photo
- Headline: "Pusat Penelitian & Pengujian Terkemuka di Kalimantan Timur"
- CTA Buttons: "Mulai Pengujian" | "Lihat Layanan"

[About Section]
- Visi & Misi
- Peran untuk IKN
- Statistics (Total Services, Equipment, Partners)

[Services Section]
- Service categories with icons
- "Lihat Semua Layanan" button

[Facilities Section]
- Lab photos gallery
- Equipment highlights

[Testimonials Section]
- User testimonials carousel

[News/Activities Section]
- Recent workshops/training
- Publications

[Contact Section]
- Address, phone, email
- Google Maps embed
- Contact form

[Footer]
- Quick links
- Social media
- Copyright
```

**2. Login/Register Page**:
```
[Login Form]
- Email
- Password
- Remember Me checkbox
- "Lupa Password?" link
- Login button
- "Belum punya akun? Daftar" link

[Register Form - Multi-step]
Step 1: Account Info
- Name
- Email
- Password
- Confirm Password
- Role selection (Mahasiswa, Dosen, Eksternal, dll)

Step 2: Profile Info
- Phone
- Address
- Institution (jika eksternal)
- NIM/NIP (jika internal)
- Upload KTM/ID Card

Step 3: Verification
- Email verification code
- Submit
```

**3. Dashboard** (Role-specific):
```
[Top Section]
- Welcome message: "Selamat datang, [Name]"
- Quick stats cards (4 cards across)

[Main Section - 2 columns]
Left Column (60%):
- Recent Activities (table)
- Pending Tasks (list)

Right Column (40%):
- Quick Actions (buttons)
- Notifications (list)
- Calendar (mini)

[Bottom Section]
- Charts (service trend, revenue, etc)
```

**4. Service Catalog**:
```
[Header]
- Search bar
- Filter dropdown (category, lab, price range)
- Sort by (popularity, price, name)

[Grid Layout - 3 columns]
Each Service Card:
- Icon/Image
- Service Name
- Lab badge
- Duration
- Price (with discount info)
- "Lihat Detail" button

[Pagination]
```

**5. Service Request Form** (Multi-step wizard):
```
Step 1: Pilih Layanan
- Search services
- Select service
- Quantity
- Urgency (normal/urgent)

Step 2: Detail Sampel
- Nama sampel
- Jenis sampel
- Kondisi sampel
- Jumlah & unit
- Upload foto (optional)

Step 3: Informasi Penelitian
- Tujuan penelitian
- Judul penelitian
- Upload proposal
- Upload dokumen pendukung

Step 4: Review & Submit
- Summary of request
- Total price
- Terms & conditions checkbox
- Submit button

[Sidebar]
- Progress indicator (step 1 of 4)
- Selected service summary
- Price breakdown
```

**6. Booking Calendar**:
```
[Top Bar]
- Date navigation (prev, today, next)
- View switcher (day, week, month)
- Filter by lab/equipment

[Calendar Grid]
- Time slots (08:00 - 20:00)
- Booked slots (colored by status)
- Click slot to book

[Booking Form Modal]
- Lab/Equipment selection
- Date & Time
- Duration
- Purpose
- Submit
```

**7. Test Data Entry** (for Analyst):
```
[Sample Info Card]
- Sample code
- Sample name
- Service requested

[Test Form]
For each parameter:
- Parameter name
- Input field (with unit)
- Standard value (for comparison)
- Replicate fields (1, 2, 3)
- Auto-calculate average & RSD
- Status indicator (pass/fail)

[Raw Data Upload]
- Drag & drop area for chromatogram/spectra files

[Actions]
- Save Draft
- Submit for Review
```

**8. Report View**:
```
[Report Header]
- Report number
- Issue date
- Status badge
- Actions (Download PDF, Print, Email)

[Report Content]
- Cover page preview
- Client info
- Sample info (with photo)
- Test methods
- Results table (formatted)
- Graphs (if applicable)
- Signatures section

[Approval Workflow]
(For Kepala Lab & Wakil Dir)
- Approve button
- Reject button (with notes field)
```

**9. Payment Page**:
```
[Invoice Details Card]
- Invoice number
- Issue date
- Due date
- Items table
- Subtotal, Tax, Total
- Status badge

[Payment Methods]
- Transfer Bank (show bank accounts)
- Virtual Account (generate VA)
- E-Wallet (show QRIS)
- Cash (show address)

[Upload Payment Proof]
- File upload area
- Bank name
- Account name
- Transfer date
- Submit

[Payment History]
- List of past payments
```

#### **Responsive Design**

**Breakpoints**:
```css
mobile: 0-640px (1 column)
tablet: 641-1024px (2 columns)
desktop: 1025px+ (3+ columns)
```

**Mobile Adjustments**:
- Sidebar → bottom nav or hamburger menu
- Dashboard stats → vertical stack
- Tables → horizontal scroll or card view
- Forms → single column
- Multi-step forms → progress bar on top

---

### **G. SECURITY REQUIREMENTS**

Tutorial harus implement:

#### **1. Authentication & Authorization**
```php
// Middleware usage
Route::middleware(['auth'])->group(function() {
    // Authenticated routes
});

Route::middleware(['auth', 'role:admin'])->group(function() {
    // Admin only
});

Route::middleware(['auth', 'permission:manage-services'])->group(function() {
    // Specific permission
});
```

#### **2. Input Validation**
```php
// Form Request Validation
public function rules() {
    return [
        'email' => 'required|email|unique:users',
        'password' => 'required|min:8|confirmed',
        'phone' => 'required|regex:/^[0-9]{10,15}$/',
        'file' => 'required|file|mimes:pdf,jpg,png|max:5120', // 5MB
    ];
}
```

#### **3. SQL Injection Prevention**
```php
// ALWAYS use Eloquent ORM or Query Builder with bindings
// BAD (vulnerable):
DB::select("SELECT * FROM users WHERE email = '$email'");

// GOOD (safe):
DB::table('users')->where('email', $email)->get();
User::where('email', $email)->first();
```

#### **4. XSS Prevention**
```blade
{{-- Blade automatic escaping --}}
{{ $user->name }} {{-- Safe, auto-escaped --}}
{!! $user->bio !!} {{-- Unsafe, use with caution --}}

{{-- Use purifier for user-generated HTML --}}
{!! clean($user->bio) !!}
```

#### **5. CSRF Protection**
```blade
<form method="POST" action="/service-request">
    @csrf
    <!-- form fields -->
</form>
```

#### **6. File Upload Security**
```php
// Validate file type
'file' => 'required|mimes:pdf,jpg,png|max:5120',

// Generate random filename
$filename = Str::random(40) . '.' . $file->getClientOriginalExtension();

// Store in non-public folder
$path = $file->storeAs('private/documents', $filename);

// Serve via controller (with auth check)
public function download($id) {
    $document = Document::findOrFail($id);
    abort_unless(auth()->user()->can('view', $document), 403);
    return Storage::download($document->file_path);
}
```

#### **7. Rate Limiting**
```php
// In RouteServiceProvider or routes
Route::middleware('throttle:60,1')->group(function() {
    // Max 60 requests per minute
});

// For login (stricter)
Route::post('/login')->middleware('throttle:5,1'); // 5 attempts per minute
```

#### **8. Password Hashing**
```php
// Use bcrypt (Laravel default)
$user->password = bcrypt($request->password);
// OR
$user->password = Hash::make($request->password);

// Verification
if (Hash::check($request->password, $user->password)) {
    // Password correct
}
```

#### **9. Secure Headers**
```php
// In Middleware
public function handle($request, Closure $next) {
    $response = $next($request);
    $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
    $response->headers->set('X-Content-Type-Options', 'nosniff');
    $response->headers->set('X-XSS-Protection', '1; mode=block');
    return $response;
}
```

#### **10. Audit Logging**
```php
// Log all critical actions
AuditLog::create([
    'user_id' => auth()->id(),
    'action' => 'approved',
    'model_type' => 'ServiceRequest',
    'model_id' => $request->id,
    'old_values' => json_encode($request->getOriginal()),
    'new_values' => json_encode($request->getAttributes()),
    'ip_address' => request()->ip(),
    'user_agent' => request()->userAgent(),
]);
```

---

### **H. TESTING REQUIREMENTS**

Tutorial harus include:

#### **1. Feature Tests**
```php
// Test service request submission
public function test_user_can_submit_service_request() {
    $user = User::factory()->create(['role_id' => Role::mahasiswa()->id]);
    $service = Service::factory()->create();

    $this->actingAs($user)
        ->post('/service-requests', [
            'service_id' => $service->id,
            'purpose' => 'Research for thesis',
            'urgency' => 'normal',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    $this->assertDatabaseHas('service_requests', [
        'user_id' => $user->id,
        'service_id' => $service->id,
        'status' => 'submitted',
    ]);
}
```

#### **2. Unit Tests**
```php
// Test price calculation
public function test_calculate_price_with_discount() {
    $service = Service::factory()->create(['price_internal' => 100000]);
    $user = User::factory()->create(['role_id' => Role::mahasiswa()->id]);

    $calculator = new PriceCalculator($service, $user);
    $price = $calculator->calculate();

    // Mahasiswa get 80% discount
    $this->assertEquals(20000, $price);
}
```

#### **3. Browser Tests (Dusk)**
```php
// Test login flow
public function test_user_can_login() {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $this->browse(function (Browser $browser) use ($user) {
        $browser->visit('/login')
            ->type('email', $user->email)
            ->type('password', 'password')
            ->press('Login')
            ->assertPathIs('/dashboard')
            ->assertSee('Selamat datang');
    });
}
```

---

### **I. DEPLOYMENT & PRODUCTION**

Tutorial harus cover:

#### **1. Environment Setup**
```bash
# .env production
APP_ENV=production
APP_DEBUG=false
APP_URL=https://ilab.unmul.ac.id

DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ilab_unmul
DB_USERNAME=ilab_user
DB_PASSWORD=strong_password

# Note: MariaDB is used instead of MySQL for better performance and open-source compatibility
# MariaDB version recommended: 10.11+ (LTS) or 11.0+
# Ensure MariaDB server is installed and running

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=noreply@ilab.unmul.ac.id
MAIL_PASSWORD=app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@ilab.unmul.ac.id
MAIL_FROM_NAME="iLab UNMUL"
```

#### **2. Optimization**
```bash
# Config cache
php artisan config:cache

# Route cache
php artisan route:cache

# View cache
php artisan view:cache

# Optimize autoloader
composer install --optimize-autoloader --no-dev
```

#### **3. Scheduled Tasks**
```php
// In app/Console/Kernel.php
protected function schedule(Schedule $schedule) {
    // Send booking reminders
    $schedule->command('bookings:send-reminders')->dailyAt('08:00');

    // Check overdue calibrations
    $schedule->command('equipment:check-calibrations')->daily();

    // Send payment reminders
    $schedule->command('invoices:send-reminders')->daily();

    // Database backup
    $schedule->command('backup:run')->daily()->at('02:00');
}
```

#### **4. Queue Workers**
```bash
# Supervisor config for queue worker
[program:ilab-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/ilab/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/ilab/storage/logs/worker.log
stopwaitsecs=3600
```

---

### **J. PACKAGE & DEPENDENCIES**

Tutorial harus install & configure:

```json
{
    "require": {
        "php": "^8.3",
        "laravel/framework": "^12.0",
        "laravel/sanctum": "^4.0",
        "laravel/tinker": "^2.9",
        "spatie/laravel-permission": "^6.0",
        "barryvdh/laravel-dompdf": "^3.0",
        "maatwebsite/excel": "^3.1",
        "intervention/image": "^3.0",
        "spatie/laravel-backup": "^9.0",
        "spatie/laravel-activitylog": "^4.0",
        "mews/purifier": "^3.4"
    },
    "require-dev": {
        "laravel/pint": "^1.13",
        "laravel/sail": "^1.26",
        "mockery/mockery": "^1.6",
        "nunomaduro/collision": "^8.0",
        "phpunit/phpunit": "^11.0",
        "laravel/telescope": "^5.0"
    }
}
```

**Frontend (package.json)**:
```json
{
    "devDependencies": {
        "@tailwindcss/forms": "^0.5.7",
        "@tailwindcss/typography": "^0.5.10",
        "alpinejs": "^3.13.3",
        "autoprefixer": "^10.4.16",
        "axios": "^1.6.2",
        "laravel-vite-plugin": "^1.0.0",
        "postcss": "^8.4.32",
        "tailwindcss": "^3.4.0",
        "vite": "^5.0.0"
    },
    "dependencies": {
        "@fortawesome/fontawesome-free": "^6.5.1",
        "apexcharts": "^3.45.0",
        "fullcalendar": "^6.1.10",
        "sweetalert2": "^11.10.2",
        "tom-select": "^2.3.1"
    }
}
```

---

## 🎓 TUTORIAL STRUCTURE & CHAPTERS

Buat tutorial dengan **25 chapters** (setiap chapter 1-2 jam):

### **PHASE 1: SETUP & FOUNDATION (Chapters 1-5)**

**Chapter 1: Project Setup & Installation**
- Install Laravel 12
- Configure database
- Install dependencies
- Setup Tailwind CSS
- Setup Alpine.js
- Setup Vite
- First run & verify

**Chapter 2: Authentication System**
- Install Laravel Breeze
- Customize auth views
- Add role field to users table
- Create roles & permissions tables
- Seed default roles
- Test registration & login

**Chapter 3: Role-Based Access Control (RBAC)**
- Install Spatie Laravel Permission
- Create Permission seeder
- Create RolePermission seeder
- Create middleware (role, permission)
- Protect routes with middleware
- Test RBAC

**Chapter 4: User Profile & Dashboard**
- Create user_profiles table
- Build profile page
- Upload profile photo
- Create base dashboard layout
- Create role-specific dashboard views
- Add quick stats

**Chapter 5: UI Components Library**
- Create button components
- Create form components
- Create card components
- Create modal components
- Create table component
- Create notification (toast) component

---

### **PHASE 2: LABORATORY MANAGEMENT (Chapters 6-8)**

**Chapter 6: Laboratory Management**
- Create laboratories CRUD
- Add photo upload
- Add head_user relationship
- Create lab list view
- Create lab detail view
- Add status management

**Chapter 7: Equipment Management**
- Create equipment CRUD
- Add specification JSON field
- Add photo upload
- Create equipment list (DataTable)
- Add filters (by lab, by status)
- Add search

**Chapter 8: Equipment Maintenance & Calibration**
- Create equipment_maintenance CRUD
- Create equipment_calibrations CRUD
- Add reminder system (7 days before)
- Create maintenance history view
- Create calibration certificate upload
- Email notification for overdue

---

### **PHASE 3: SOP MANAGEMENT (Chapters 9-10)**

**Chapter 9: SOP Document Management**
- Create sops CRUD
- Add versioning logic
- Create SOP upload
- Create SOP approval workflow
- Create SOP list view (with search)
- Create SOP detail view

**Chapter 10: SOP Templates & Sections**
- Create sop_sections management
- Create SOP template builder
- Create SOP editor (WYSIWYG)
- Create SOP attachments
- Generate SOP PDF
- Download counter

---

### **PHASE 4: SERVICE & BOOKING (Chapters 11-14)**

**Chapter 11: Service Catalog**
- Create services CRUD
- Add pricing (internal, external_edu, external)
- Create service categories
- Create service catalog view (grid)
- Add search & filters
- Create service detail modal

**Chapter 12: Service Request System (Part 1)**
- Create service_requests table & model
- Create multi-step request form (wizard)
- Step 1: Pilih layanan
- Step 2: Detail sampel
- Step 3: Info penelitian
- Step 4: Review & submit

**Chapter 13: Service Request System (Part 2)**
- Create request number generator
- Implement status workflow (8 status)
- Create request list view (for user)
- Create request detail view
- Add file upload (proposal, docs)
- Create request tracking (timeline)

**Chapter 14: Service Request Approval Workflow**
- Create approval system (multi-level)
- Admin verification view
- Direktur approval view
- Wakil Dir assignment view
- Kepala Lab assignment
- Email notifications per stage

**Chapter 15: Booking & Scheduling**
- Create bookings table & model
- Create calendar view (FullCalendar.js)
- Implement conflict detection
- Create booking form
- Implement approval workflow
- Create my bookings view

**Chapter 16: Booking Management**
- Create booking list (for Kepala Lab)
- Implement check-in/check-out
- Add equipment condition tracking
- Create recurring booking
- Implement cancellation logic
- Add late cancellation penalty

---

### **PHASE 5: TESTING & REPORTING (Chapters 17-19)**

**Chapter 17: Sample Management**
- Create samples CRUD
- Generate barcode/QR code
- Create sample registration form
- Add sample tracking
- Create storage location management
- Add sample photo

**Chapter 18: Testing & Analysis**
- Create tests & test_results tables
- Create test assignment (by Kepala Lab)
- Create data entry form (for Analyst)
- Add parameter validation
- Calculate average & RSD
- Upload raw data files

**Chapter 19: Report Generation**
- Create test_reports table
- Build report template (PDF)
- Create report draft editor
- Implement approval workflow
- Generate QR code for verification
- Email report to user
- Download report

---

### **PHASE 6: PAYMENT & FINANCE (Chapters 20-21)**

**Chapter 20: Invoicing System**
- Create invoices & invoice_items tables
- Auto-generate invoice after approval
- Calculate price (with discount logic)
- Create invoice view
- Send invoice via email
- Add payment reminders

**Chapter 21: Payment Management**
- Create payments table
- Create payment upload form
- Implement payment verification
- Generate receipt (PDF)
- Add payment history
- Create financial reports

---

### **PHASE 7: TRAINING & INTERNSHIP (Chapters 22-23)**

**Chapter 22: Training Management**
- Create training_programs CRUD
- Create training catalog view
- Create registration form
- Implement quota management
- Create attendance tracking (QR code)
- Generate certificates (PDF with barcode)

**Chapter 23: Internship & Practical Work**
- Create internships & practical_works tables
- Create application forms
- Implement approval workflow
- Create digital logbook
- Add evaluation form
- Generate certificates

---

### **PHASE 8: ADVANCED FEATURES (Chapters 24-26)**

**Chapter 24: Notification System**
- Create notifications table
- Implement email notifications
- Create in-app notifications (bell icon)
- Add notification preferences
- Create notification templates
- Implement notification queue

**Chapter 25: Analytics & Reporting**
- Create dashboard statistics
- Build charts (ApexCharts)
- Create custom report builder
- Implement Excel export
- Create scheduled reports
- Add data visualization

**Chapter 26: Document Management & Settings**
- Create documents CRUD
- Add version control
- Implement access control
- Create system settings
- Add audit logging
- Create backup & restore

---

### **PHASE 9: OPTIMIZATION & DEPLOYMENT (Chapters 27-28)**

**Chapter 27: Testing & Quality Assurance**
- Write Feature Tests
- Write Unit Tests
- Write Browser Tests (Dusk)
- Test coverage report
- Performance testing
- Security testing

**Chapter 28: Deployment & Production**
- Server setup (LEMP stack)
- Configure .env production
- Setup SSL certificate
- Configure queue workers (Supervisor)
- Setup cron jobs
- Deploy to production
- Monitoring & logging

---

## 📝 OUTPUT YANG DIHARAPKAN

Untuk **SETIAP CHAPTER**, generate:

### **1. Chapter Overview**
```markdown
# CHAPTER [X]: [TITLE]

## 📚 Learning Objectives
- Specific skill atau knowledge yang didapat

## 🎯 Prerequisites
- Chapter sebelumnya yang harus diselesaikan
- Knowledge yang diperlukan

## ⏱️ Estimated Time
- Estimasi waktu penyelesaian (60-120 menit)

## 📦 What We'll Build
- List fitur konkret yang akan dibuat
```

### **2. Step-by-Step Implementation**
```markdown
## 📝 Implementation Steps

### Step 1: [Title]
**Why we do this**: [Explanation]

**Commands** (if any):
```bash
php artisan make:model ServiceRequest -mcr
```

**Code**: (full code dengan comments)
```php
// File: app/Models/ServiceRequest.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    // code...
}
```

**Explanation**:
- Jelaskan setiap bagian penting dari code
- Highlight best practices
- Explain design decisions

**Expected Output**:
- Describe hasil yang harus muncul
- Include screenshot (jika perlu)

### Step 2: [Title]
... dan seterusnya untuk setiap step
```

### **3. Testing & Verification**
```markdown
## ✅ Testing

### Manual Testing
1. Navigate to [URL]
2. Perform [action]
3. Verify [expected result]

### Automated Testing
```php
// tests/Feature/ServiceRequestTest.php
<?php

namespace Tests\Feature;

use Tests\TestCase;

class ServiceRequestTest extends TestCase
{
    public function test_user_can_create_service_request()
    {
        // test code
    }
}
```

**Run tests**:
```bash
php artisan test --filter ServiceRequestTest
```
```

### **4. Troubleshooting Guide**
```markdown
## 🐛 Common Issues & Solutions

### Issue 1: [Problem description]
**Symptom**: [What user sees]
**Cause**: [Why it happens]
**Solution**:
```bash
# Commands to fix
```
or
```php
// Code changes needed
```

### Issue 2: [Problem description]
... dst
```

### **5. Summary & Next Steps**
```markdown
## 📚 Chapter Summary

In this chapter, we:
- ✅ Created [feature 1]
- ✅ Implemented [feature 2]
- ✅ Learned [concept]

**Key Takeaways**:
- Important lesson 1
- Important lesson 2

**Files Created/Modified**:
- `app/Models/ServiceRequest.php`
- `database/migrations/2025_01_10_create_service_requests_table.php`
- `app/Http/Controllers/ServiceRequestController.php`

## 🔜 Next Chapter

In the next chapter, we'll build [preview of next chapter].

[Link to Chapter [X+1]]
```

---

## ⚙️ TECHNICAL GUIDELINES FOR AI

### **Code Quality Standards**

1. **Follow PSR-12** coding standard
2. **Type hinting** untuk semua method parameters dan return types
3. **DocBlocks** untuk semua public methods
4. **Use Eloquent** relationships (avoid raw queries)
5. **Use Form Requests** untuk validation (jangan di controller)
6. **Use Resource Classes** untuk API responses
7. **Use Enums** (PHP 8.3) untuk status fields
8. **Use Events & Listeners** untuk decoupled logic
9. **Use Queues** untuk long-running tasks (email, PDF generation)
10. **Use Cache** untuk expensive queries

### **Naming Conventions**

```php
// Models: Singular, PascalCase
ServiceRequest.php

// Controllers: Plural, PascalCase, suffix "Controller"
ServiceRequestController.php

// Migrations: snake_case, prefix with timestamp
2025_01_10_120000_create_service_requests_table.php

// Views: kebab-case
service-requests/create.blade.php

// Routes: kebab-case
/service-requests/create

// Database tables: plural, snake_case
service_requests

// Database columns: snake_case
created_at, updated_at, user_id

// Methods: camelCase
public function calculatePrice()

// Variables: camelCase
$serviceRequest, $totalPrice

// Constants: UPPER_SNAKE_CASE
const MAX_FILE_SIZE = 5120;
```

### **File Structure**

```
ilab-unmul/
├── app/
│   ├── Console/
│   │   └── Commands/
│   ├── Enums/
│   │   ├── ServiceRequestStatus.php
│   │   ├── BookingStatus.php
│   │   └── PaymentMethod.php
│   ├── Events/
│   │   └── ServiceRequestSubmitted.php
│   ├── Listeners/
│   │   └── SendServiceRequestNotification.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   ├── Lab/
│   │   │   └── User/
│   │   ├── Middleware/
│   │   ├── Requests/
│   │   │   └── StoreServiceRequestRequest.php
│   │   └── Resources/
│   ├── Models/
│   ├── Notifications/
│   ├── Policies/
│   ├── Services/ (Business logic)
│   │   ├── PriceCalculator.php
│   │   ├── ReportGenerator.php
│   │   └── BookingManager.php
│   └── Traits/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── components/
│       ├── layouts/
│       └── pages/
├── routes/
│   ├── web.php
│   ├── admin.php
│   ├── lab.php
│   └── api.php
├── storage/
│   ├── app/
│   │   ├── public/
│   │   └── private/
│   └── logs/
└── tests/
    ├── Feature/
    └── Unit/
```

### **Migration Best Practices**

```php
// Always use proper foreign keys
$table->foreignId('user_id')->constrained()->cascadeOnDelete();

// Use proper column types
$table->decimal('price', 15, 2); // for money
$table->date('booking_date'); // for dates
$table->time('start_time'); // for time
$table->enum('status', ['draft', 'submitted', ...]); // or use string + cast to enum

// Add indexes for frequently queried columns
$table->index('status');
$table->index(['laboratory_id', 'booking_date']);

// Use nullable() appropriately
$table->string('phone')->nullable();

// Add default values
$table->integer('download_count')->default(0);
$table->boolean('is_active')->default(true);
```

### **Eloquent Relationships**

```php
// Define all relationships in models

// One-to-Many
public function serviceRequests() {
    return $this->hasMany(ServiceRequest::class);
}

// Belongs To
public function user() {
    return $this->belongsTo(User::class);
}

// Many-to-Many
public function roles() {
    return $this->belongsToMany(Role::class, 'role_user');
}

// Has One Through
public function latestPayment() {
    return $this->hasOneThrough(Payment::class, Invoice::class);
}

// Polymorphic
public function evaluations() {
    return $this->morphMany(Evaluation::class, 'evaluated');
}

// Use eager loading to prevent N+1
$requests = ServiceRequest::with(['user', 'service', 'samples'])->get();
```

### **Blade Components**

```php
// Create reusable components
php artisan make:component Button

// Use slots
<x-button type="primary" size="lg">
    Submit Request
</x-button>

// Pass data
<x-service-card :service="$service" />
```

### **Error Handling**

```php
// Use try-catch for critical operations
try {
    DB::beginTransaction();

    $request = ServiceRequest::create($data);
    $invoice = Invoice::create($invoiceData);

    DB::commit();

    return redirect()->route('service-requests.show', $request)
        ->with('success', 'Service request created successfully!');

} catch (\Exception $e) {
    DB::rollBack();

    Log::error('Service request creation failed', [
        'user_id' => auth()->id(),
        'error' => $e->getMessage(),
    ]);

    return back()->with('error', 'Failed to create service request. Please try again.');
}
```

---

## 🎬 CALL TO ACTION

**AI, your task is**:

1. Start with **Chapter 1: Project Setup & Installation**
2. Follow the format specified above
3. Provide **complete, working code** (no placeholders, no "// your code here")
4. Include **detailed explanations** for each step
5. Add **comments** in code untuk clarification
6. Include **testing steps** untuk verify hasil
7. Add **troubleshooting guide** untuk common issues
8. End dengan **summary** dan preview next chapter

**When you finish Chapter 1**, ask:
> "Chapter 1 completed! Ready to continue to Chapter 2: Authentication System? (Type 'yes' to continue or 'revise' if you need changes in Chapter 1)"

**Continue this pattern** until all 28 chapters complete.

---

## ✅ CHECKLIST SEBELUM MULAI

Before starting the tutorial, confirm:

- [ ] Laravel 12 requirements understood
- [ ] PHP 8.3+ features will be used
- [ ] Database schema reviewed (47 tables)
- [ ] All business logic rules clear
- [ ] UI/UX requirements clear
- [ ] Security requirements clear
- [ ] Testing strategy clear

---

## 🚀 BEGIN TUTORIAL NOW

**AI, please start with Chapter 1!**

Generate the complete, detailed tutorial for **Chapter 1: Project Setup & Installation** following the format specified above.

---

**[END OF PROMPT]**

This prompt is designed to be comprehensive, unambiguous, and actionable. The AI should be able to generate a complete, production-ready tutorial for building the ILab UNMUL web application using Laravel 12.
