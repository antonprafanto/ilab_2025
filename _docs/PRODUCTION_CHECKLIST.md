# iLab UNMUL - Production Deployment Checklist

Gunakan checklist ini sebelum dan setelah deployment ke production untuk memastikan semua konfigurasi sudah benar.

## Pre-Deployment Checklist

### 1. Environment Configuration
- [ ] Copy `.env.production.example` ke `.env`
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_URL` sesuai domain production (https://yourdomain.com)
- [ ] Set `APP_TIMEZONE=Asia/Makassar`
- [ ] Generate new `APP_KEY` dengan `php artisan key:generate`
- [ ] Configure database credentials (DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD)
- [ ] Configure email settings (MAIL_HOST, MAIL_USERNAME, MAIL_PASSWORD)
- [ ] Set `LOG_LEVEL=error` untuk production

### 2. Database Setup
- [ ] Create database di hosting
- [ ] Create database user dengan privileges yang tepat
- [ ] Test koneksi database: `php artisan tinker` → `DB::connection()->getPdo();`
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Run seeders: `php artisan db:seed --class=RolePermissionSeeder --force`
- [ ] Verify tables created: `php artisan db:show`

### 3. File Upload & Assets
- [ ] Build production assets: `npm run build`
- [ ] Upload logo files ke `public/images/`:
  - [ ] logo-unmul.png (200x200)
  - [ ] logo-blu.png (200x200)
  - [ ] favicon.png (32x32 atau 64x64)
  - [ ] og-image.jpg (1200x630)
- [ ] Create storage link: `php artisan storage:link`
- [ ] Verify `public/storage` symlink exists

### 4. Server Configuration
- [ ] Document root mengarah ke folder `public`
- [ ] PHP version >= 8.2
- [ ] Enable required PHP extensions:
  - [ ] BCMath
  - [ ] Ctype
  - [ ] Fileinfo
  - [ ] JSON
  - [ ] Mbstring
  - [ ] OpenSSL
  - [ ] PDO
  - [ ] Tokenizer
  - [ ] XML
  - [ ] cURL
  - [ ] GD
- [ ] Enable `mod_rewrite` (Apache) atau configure nginx
- [ ] Verify `.htaccess` file exists di folder `public`

### 5. File Permissions
- [ ] Set ownership: `chown -R username:username /path/to/project`
- [ ] Set directory permissions: `find . -type d -exec chmod 755 {} \;`
- [ ] Set file permissions: `find . -type f -exec chmod 644 {} \;`
- [ ] Set storage writable: `chmod -R 775 storage bootstrap/cache`
- [ ] Verify `.env` tidak bisa diakses public (403 Forbidden)

### 6. Security Configuration
- [ ] Force HTTPS di Laravel (AppServiceProvider)
- [ ] Setup SSL certificate (Let's Encrypt via cPanel)
- [ ] Verify CSRF protection enabled
- [ ] Verify XSS protection enabled
- [ ] Change default database ports jika perlu
- [ ] Setup firewall rules
- [ ] Disable directory listing
- [ ] Hide Laravel version headers

### 7. Cron Jobs Setup
- [ ] Add Laravel scheduler cron:
  ```
  * * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
  ```
- [ ] Verify cron is running: check logs

### 8. Email Configuration
- [ ] Test email sending:
  ```php
  php artisan tinker
  Mail::raw('Test email', function($msg) {
    $msg->to('admin@yourdomain.com')->subject('Test iLab UNMUL');
  });
  ```
- [ ] Configure email templates branding
- [ ] Setup email notifications untuk user approvals

### 9. Backup Strategy
- [ ] Setup database backup cron (daily):
  ```bash
  0 2 * * * mysqldump -u user -p'pass' db > /backups/db_$(date +\%Y\%m\%d).sql
  ```
- [ ] Setup file backup cron (weekly):
  ```bash
  0 3 * * 0 tar -czf /backups/files_$(date +\%Y\%m\%d).tar.gz /path/to/project
  ```
- [ ] Verify backup storage location
- [ ] Test restore procedure

### 10. Performance Optimization
- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Enable OPcache di php.ini
- [ ] Configure query caching
- [ ] Setup CDN untuk assets (optional)

---

## Post-Deployment Checklist

### 1. Functional Testing
- [ ] Access landing page (https://yourdomain.com)
- [ ] Verify all sections load correctly:
  - [ ] Hero section dengan statistics
  - [ ] Fitur section (6 cards)
  - [ ] Tentang section (Visi, Misi, ISO)
  - [ ] CTA section
  - [ ] Footer dengan all links
- [ ] Test mobile responsiveness
- [ ] Test hamburger menu (mobile)
- [ ] Verify logos display correctly (UNMUL, BLU)
- [ ] Check loading screen animation
- [ ] Test all navigation links

### 2. Authentication Testing
- [ ] Access login page (/login)
- [ ] Test login dengan admin credentials
- [ ] Verify redirect to dashboard after login
- [ ] Test logout functionality
- [ ] Verify cannot access admin pages without login
- [ ] Test "Remember Me" functionality

### 3. Registration & Approval Testing
- [ ] Access registration page (/register)
- [ ] Register new user (Peneliti/Mahasiswa/Dosen)
- [ ] Verify user created with status "pending"
- [ ] Verify redirect to login dengan success message
- [ ] Verify cannot login dengan pending status
- [ ] Login as Super Admin
- [ ] Navigate to User Approvals
- [ ] Verify pending user appears
- [ ] Test approve user
- [ ] Verify approved user can login
- [ ] Test reject user dengan reason
- [ ] Verify rejected user cannot login dan sees rejection reason

### 4. Admin Panel Testing
- [ ] Test all Super Admin menu items accessible
- [ ] Test Laboratory management (CRUD)
- [ ] Test Equipment management (CRUD)
- [ ] Test Service management (CRUD)
- [ ] Test User management
- [ ] Test Booking system
- [ ] Test SOP management
- [ ] Test Reports

### 5. Email Testing
- [ ] Register new user dan verify no auto-login
- [ ] Approve user dan verify email sent (jika configured)
- [ ] Reject user dan verify email sent (jika configured)
- [ ] Test password reset email
- [ ] Test booking confirmation email (jika implemented)

### 6. Database Testing
- [ ] Verify all migrations ran successfully
- [ ] Check roles & permissions seeded:
  - [ ] Super Admin role exists
  - [ ] Peneliti role exists
  - [ ] Mahasiswa role exists
  - [ ] Dosen role exists
- [ ] Verify relationships working (User → Roles, etc.)
- [ ] Test database backups restore

### 7. File Upload Testing
- [ ] Test equipment image upload
- [ ] Test profile photo upload (jika implemented)
- [ ] Test SOP document upload
- [ ] Verify files saved to correct location
- [ ] Verify file permissions correct
- [ ] Test file deletion

### 8. Performance Testing
- [ ] Check page load times (< 3 seconds)
- [ ] Test with multiple concurrent users
- [ ] Monitor database query performance
- [ ] Check memory usage
- [ ] Verify no N+1 query issues
- [ ] Test caching working correctly

### 9. Security Testing
- [ ] Verify HTTPS working (no mixed content warnings)
- [ ] Test CSRF protection (form submissions)
- [ ] Test XSS protection (try injecting scripts)
- [ ] Test SQL injection protection
- [ ] Verify file upload validation working
- [ ] Test authorization (user cannot access admin pages)
- [ ] Verify `.env` tidak bisa diakses via browser
- [ ] Test rate limiting pada login

### 10. Browser Compatibility
- [ ] Test di Chrome
- [ ] Test di Firefox
- [ ] Test di Safari
- [ ] Test di Edge
- [ ] Test di mobile browsers (iOS Safari, Chrome Mobile)

### 11. SEO & Social Media
- [ ] Verify meta tags di landing page:
  - [ ] Title tag correct
  - [ ] Description tag correct
  - [ ] Keywords tag present
- [ ] Verify Open Graph tags:
  - [ ] og:title
  - [ ] og:description
  - [ ] og:image
  - [ ] og:url
- [ ] Test social media sharing (Facebook, Twitter)
- [ ] Verify favicon displays di browser tabs
- [ ] Submit sitemap ke Google Search Console (optional)

### 12. Monitoring Setup
- [ ] Setup uptime monitoring (UptimeRobot, Pingdom)
- [ ] Setup error tracking (Sentry, Bugsnag - optional)
- [ ] Configure log monitoring
- [ ] Setup performance monitoring (New Relic, Blackfire - optional)
- [ ] Configure alerts untuk downtime
- [ ] Monitor disk space usage

### 13. Documentation
- [ ] Document admin credentials (secure location)
- [ ] Document database credentials (secure location)
- [ ] Document deployment process
- [ ] Create user manual for administrators
- [ ] Document maintenance procedures
- [ ] Document backup/restore procedures

### 14. Final Verification
- [ ] All features working as expected
- [ ] No errors in Laravel logs (`storage/logs/laravel.log`)
- [ ] No errors in web server logs
- [ ] No JavaScript console errors
- [ ] All CSS/images loading correctly
- [ ] Mobile version fully functional
- [ ] Email notifications working
- [ ] Cron jobs running
- [ ] Backups configured and tested

---

## Go-Live Checklist

### Before Going Live
- [ ] Notify stakeholders about deployment
- [ ] Schedule deployment during low-traffic time
- [ ] Create full backup (database + files)
- [ ] Prepare rollback plan
- [ ] Test on staging environment first (if available)

### During Deployment
- [ ] Enable maintenance mode: `php artisan down`
- [ ] Deploy new code
- [ ] Run migrations
- [ ] Clear and rebuild caches
- [ ] Test critical functionality
- [ ] Disable maintenance mode: `php artisan up`

### After Going Live
- [ ] Monitor error logs for 30 minutes
- [ ] Monitor server resources (CPU, memory, disk)
- [ ] Test all critical user flows
- [ ] Verify email notifications working
- [ ] Check database queries performance
- [ ] Monitor uptime
- [ ] Notify stakeholders deployment complete

---

## Rollback Plan

If deployment fails:

```bash
# 1. Enable maintenance mode
php artisan down

# 2. Restore previous code version
git reset --hard previous_commit_hash

# 3. Restore database backup (if migrations failed)
mysql -u user -p database < backup.sql

# 4. Clear caches
php artisan cache:clear
php artisan config:clear

# 5. Rebuild caches
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Disable maintenance mode
php artisan up

# 7. Notify stakeholders about rollback
```

---

## Support Contacts

- **Developer:** [Your Name]
- **System Admin:** [Admin Name]
- **Hosting Support:** [Hosting Company Support]
- **Email:** support@yourdomain.com
- **Emergency Contact:** [Phone Number]

---

## Notes

- Selalu test di staging environment sebelum deploy ke production
- Backup sebelum setiap deployment
- Monitor logs setelah deployment
- Document semua perubahan di CHANGELOG.md
- Update dokumentasi jika ada perubahan workflow

---

**Last Updated:** 2024-11-04
**Version:** 1.0.0
