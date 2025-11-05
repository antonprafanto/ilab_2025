# Changelog

All notable changes to iLab UNMUL project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

---

## [Unreleased]

### Planned Features (Coming Soon)
- **Fase 4:** Booking System (Equipment Reservation Calendar)
- **Fase 5:** SOP Management (Document Upload & Version Control)
- **Fase 6:** Analysis Request & Sample Tracking
- **Fase 7:** Maintenance & Calibration Scheduling
- **Fase 8:** Reports & Analytics Dashboard
- **Fase 9:** Billing & Payment System
- **Fase 10:** Email Notifications
- **Fase 11:** Mobile App
- **Fase 12:** API Integration

---

## [0.3.0-beta] - 2024-11-04

### Added - Fase 3 (Beta Release)
- **Beta Version Banner** - Announcement banner di landing page dan dashboard
- **Dashboard Beta Info Card** - Informasi fitur yang tersedia dan dalam pengembangan
- **Deployment Documentation** - DEPLOYMENT_GUIDE.md dengan panduan lengkap
- **Production Checklist** - PRODUCTION_CHECKLIST.md untuk pre/post deployment
- **Production Environment Template** - .env.production.example
- **Deployment Script** - deploy.sh untuk automated deployment
- **Security Headers** - .htaccess untuk root folder dengan security measures
- **Enhanced .gitignore** - Exclude debug files dan temporary files
- **Timezone Configuration** - Asia/Makassar (WITA) untuk Kalimantan Timur
- **Locale Configuration** - Bahasa Indonesia (id) sebagai default locale
- **Enhanced README** - Dokumentasi lengkap project dengan installation guide

### Changed
- Landing page hero section - Fixed wave decoration overflow issue
- .env.example - Updated dengan default values untuk iLab UNMUL
- config/app.php - Set timezone dan locale untuk Indonesia

### Fixed
- Landing page section "Fitur Unggulan" terpotong oleh wave decoration
- Garis putih tipis antara hero section dan features section

---

## [0.2.0] - 2024-11-03

### Added - User Approval System
- **Admin Approval Workflow** - User registration requires admin approval
- **Approval Status Field** - Enum: pending, approved, rejected
- **CheckUserApproved Middleware** - Block pending/rejected users from accessing system
- **User Approval Controller** - Handle approve/reject actions
- **User Approval Views** - Admin pages for pending, approved, rejected users
- **Approval Tracking** - Track who approved and when
- **Rejection Reason** - Admin can provide reason for rejection
- **User Scopes** - Eloquent scopes for approved() and pending() users
- **Navigation Updates** - User Management dropdown with approval badge counter

### Changed
- RegisteredUserController - Set approval_status to 'pending' on registration
- RegisteredUserController - Removed auto-login after registration
- Login page - Removed public registration link
- Landing page - Removed registration CTA
- Dashboard statistics - Only count approved users

### Database
- Migration: add_approval_fields_to_users_table
  - approval_status (enum: pending, approved, rejected)
  - approved_by (foreign key to users)
  - approved_at (timestamp)
  - rejection_reason (text)

---

## [0.1.0] - 2024-10-02

### Added - Initial Release
- **Landing Page** with full features:
  - Hero section with dynamic statistics
  - Features showcase (6 cards)
  - About section (Visi, Misi, ISO certification status)
  - Call-to-action section
  - Responsive footer with 5 columns
  - Mobile hamburger menu with Alpine.js
  - Loading screen with animated progress bar
  - Logo slots for UNMUL & BLU with fallback placeholders
  - Complete SEO meta tags
  - Open Graph tags for social media sharing
  - Favicon support
  - Wave decoration design

- **Authentication System**:
  - Laravel Breeze authentication
  - Login & Registration
  - Password reset
  - Email verification
  - Remember me functionality

- **Authorization System**:
  - Spatie Laravel Permission integration
  - 4 Roles: Super Admin, Peneliti, Mahasiswa, Dosen
  - Role-based access control
  - Permission management

- **Admin Panel**:
  - Dashboard with statistics
  - User management (CRUD)
  - Laboratory management (CRUD)
  - Room management (CRUD)
  - Equipment management (CRUD) with image upload
  - Sample management (CRUD)
  - Reagent management (CRUD)
  - Service catalog management (CRUD)

- **Database Structure**:
  - Users table with profile fields
  - Roles & Permissions tables (Spatie)
  - Laboratories table
  - Rooms table with laboratory relationship
  - Equipment table with image storage
  - Samples table
  - Reagents table
  - Services table

- **UI/UX**:
  - Tailwind CSS v4 styling
  - UNMUL color scheme (#0066CC blue, #FF9800 orange, #4CAF50 green)
  - Responsive design (mobile, tablet, desktop)
  - Dark mode support
  - Gradient designs
  - Smooth animations and transitions
  - Back to top button

### Technical
- **Framework**: Laravel 12
- **PHP**: 8.2+
- **Database**: MySQL
- **Frontend**: Tailwind CSS v4, Alpine.js
- **Asset Bundler**: Vite
- **Authentication**: Laravel Breeze
- **Authorization**: Spatie Laravel Permission

---

## Version History Summary

| Version | Release Date | Status | Description |
|---------|-------------|--------|-------------|
| 0.3.0-beta | 2024-11-04 | 🟡 Beta | Added deployment docs, beta banners, production ready |
| 0.2.0 | 2024-11-03 | ✅ Complete | User approval system implemented |
| 0.1.0 | 2024-10-02 | ✅ Complete | Initial release with core features |

---

## Migration Path

### From v0.2.0 to v0.3.0-beta
No database changes. Only configuration and documentation updates.

```bash
git pull origin main
composer install --optimize-autoloader --no-dev
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### From v0.1.0 to v0.2.0
Database migration required for user approval system.

```bash
git pull origin main
composer install
php artisan migrate
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## Support

For issues, questions, or feature requests, please contact:
- **Email**: support@yourdomain.com
- **Issue Tracker**: https://github.com/yourusername/ilab-unmul/issues

---

**Next Release**: v0.4.0 - Booking System (Equipment Reservation Calendar)
**Expected Date**: 2024-11-11
