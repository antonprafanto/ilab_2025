# 🧪 MANUAL TESTING GUIDE - FASE 3

**Tanggal**: 3 November 2025
**Tester**: [Nama Anda]
**Fase**: 3 (Service Catalog, Service Request, Booking System)
**Estimasi Waktu**: 60-90 menit

---

## 📋 PERSIAPAN TESTING

### 1. START APPLICATION

**Langkah 1: Buka Terminal/Command Prompt**
```bash
cd C:\xampp\htdocs\ilab_v1
```

**Langkah 2: Start Laravel Server**
```bash
php artisan serve
```

**Expected Output:**
```
Starting Laravel development server: http://127.0.0.1:8000
```

**Langkah 3: Buka Browser**
- Buka browser (Chrome/Firefox/Edge)
- Ketik: `http://localhost:8000`
- ✅ **Checkpoint**: Home page harus muncul

---

### 2. LOGIN KE APLIKASI

**URL**: `http://localhost:8000/login`

**Test Users (pilih salah satu):**

| Role | Email | Password | Use Case |
|------|-------|----------|----------|
| Super Admin | admin@ilab.unmul.ac.id | password | Test semua fitur |
| Dosen | dosen@ilab.unmul.ac.id | password | Submit service request |
| Mahasiswa | mahasiswa@ilab.unmul.ac.id | password | Create booking |

**Langkah:**
1. Klik "Login" di navigation
2. Masukkan email & password
3. Klik "Log in"
4. ✅ **Checkpoint**: Redirect ke `/dashboard`

---

## 🧪 TEST SCENARIO 1: SERVICE CATALOG

**Estimasi Waktu**: 10 menit

### Test 1.1: Browse Service Catalog

**URL**: `http://localhost:8000/services`

**Langkah:**
1. Di navigation menu, klik **"Services"** → **"Service Catalog"**
2. Halaman service catalog akan muncul

**✅ Checklist:**
- [ ] Page loads tanpa error
- [ ] Ada minimal 20+ service cards
- [ ] Setiap card menampilkan:
  - [ ] Service name
  - [ ] Service code (contoh: SVC-CHEM-001)
  - [ ] Category badge
  - [ ] Price (Rp format)
  - [ ] Duration
  - [ ] Laboratory name
- [ ] Pagination muncul di bawah (jika > 15 services)

**Screenshot**: 📸 Ambil screenshot halaman ini

---

### Test 1.2: Filter Services

**Langkah:**
1. Scroll ke bagian **Filters** di atas service list
2. Test filter **Category**:
   - Pilih "Kimia" dari dropdown
   - Klik "Apply Filters"
   - ✅ **Expected**: Hanya services dengan category "kimia" yang muncul
3. Test filter **Price Range**:
   - Masukkan Min: 100000, Max: 500000
   - Klik "Apply Filters"
   - ✅ **Expected**: Services dalam range tersebut
4. Klik **"Reset Filters"**
   - ✅ **Expected**: Semua services muncul kembali

**✅ Checklist:**
- [ ] Category filter working
- [ ] Price range filter working
- [ ] Duration filter working (jika ada)
- [ ] Reset filters working
- [ ] Multiple filters dapat dikombinasi

---

### Test 1.3: Search Services

**Langkah:**
1. Di search box, ketik: **"HPLC"**
2. Tekan Enter atau klik Search
3. ✅ **Expected**: Services dengan "HPLC" di nama muncul

**✅ Checklist:**
- [ ] Search box working
- [ ] Results match search term
- [ ] "No results found" jika tidak ada match

---

### Test 1.4: View Service Detail

**Langkah:**
1. Klik **"View Details"** pada salah satu service
2. ✅ **Expected**: Redirect ke `/services/{id}`

**✅ Checklist:**
- [ ] Service name & code displayed
- [ ] Full description visible
- [ ] Pricing table (3 tiers):
  - [ ] Internal (Mahasiswa/Dosen UNMUL)
  - [ ] External Education (Universitas Lain)
  - [ ] External (Industri/Umum)
- [ ] Requirements list
- [ ] Deliverables list
- [ ] Equipment needed (if any)
- [ ] Sample preparation instructions
- [ ] Method/Standards
- [ ] Laboratory information
- [ ] **"Request Service"** button visible (untuk logged in user)

**Screenshot**: 📸 Ambil screenshot service detail

---

## 🧪 TEST SCENARIO 2: SERVICE REQUEST WORKFLOW

**Estimasi Waktu**: 20 menit

### Test 2.1: Create Service Request (4-Step Wizard)

**URL**: `http://localhost:8000/service-requests/create`

**Langkah:**
1. Klik **"Services"** → **"Service Requests"** → **"Create Request"**
2. ✅ **Expected**: Wizard step 1 muncul dengan progress bar

---

#### **STEP 1: Select Service**

**Langkah:**
1. Select service dari dropdown: Pilih **"Analisis HPLC"**
2. ✅ **Expected**: Service details muncul (description, price, duration)
3. Klik **"Next"**

**✅ Checklist:**
- [ ] Service dropdown populated
- [ ] Service details auto-load setelah select
- [ ] Price displayed
- [ ] Duration displayed
- [ ] "Next" button enabled setelah select service

---

#### **STEP 2: Sample Information**

**Langkah:**
1. **Sample Type**: Ketik "Tanaman Obat"
2. **Number of Samples**: Ketik "3"
3. **Sample Description**: Ketik "Ekstrak daun sambiloto untuk analisis senyawa aktif"
4. **Quantity**: Ketik "50"
5. **Unit**: Ketik "gram"
6. **Special Preparation**: Ketik "Sampel sudah diekstraksi dengan etanol 70%"
7. Klik **"Next"**

**✅ Checklist:**
- [ ] Semua form fields muncul
- [ ] Validation bekerja (required fields)
- [ ] Bisa kembali ke step 1 dengan "Previous"
- [ ] Data persist saat navigasi step

---

#### **STEP 3: Research Information**

**Langkah:**
1. **Research Title**: Ketik "Identifikasi Senyawa Aktif pada Sambiloto"
2. **Purpose of Testing**: Ketik "Untuk penelitian skripsi tentang potensi antibakteri sambiloto"
3. **Urgency**: Pilih **"Normal"**
4. **Priority**: Pilih **"Standard"**
5. **Supervisor Name**: Ketik "Dr. Budi Santoso, M.Si"
6. **Supervisor Email**: Ketik "budi.santoso@unmul.ac.id"
7. **Expected Completion Date**: Pilih tanggal 2 minggu dari hari ini
8. Klik **"Next"**

**✅ Checklist:**
- [ ] Semua form fields ada
- [ ] Date picker working
- [ ] Urgency selection changes price estimate
- [ ] Estimated completion auto-calculated

---

#### **STEP 4: Review & Submit**

**Langkah:**
1. Review semua informasi yang ditampilkan
2. **Notes** (optional): Ketik "Mohon segera diproses karena deadline skripsi"
3. ✅ **Verify Summary Shows**:
   - Service name & code
   - Sample details
   - Research information
   - Total estimated cost
   - Estimated completion date
4. Klik **"Submit Request"**

**✅ Checklist:**
- [ ] Summary lengkap dan benar
- [ ] Estimated cost calculated
- [ ] Working days calculation correct
- [ ] Submit button working
- [ ] Redirect to request detail setelah submit
- [ ] Success message muncul
- [ ] **Request Number auto-generated** (format: SR-YYYYMMDD-XXXX)

**Screenshot**: 📸 Ambil screenshot request detail setelah submit

---

### Test 2.2: View My Requests

**URL**: `http://localhost:8000/service-requests`

**Langkah:**
1. Klik **"Services"** → **"Service Requests"**
2. ✅ **Expected**: List of your service requests

**✅ Checklist:**
- [ ] Request yang baru dibuat muncul di list
- [ ] Request number displayed
- [ ] Service name displayed
- [ ] Status badge (pending/verified/approved/etc.)
- [ ] Request date
- [ ] Actions: View button
- [ ] Filter by status working
- [ ] Search working

---

### Test 2.3: Public Tracking (No Login Required)

**Langkah:**
1. **Logout** dari aplikasi
2. Buka: `http://localhost:8000/tracking`
3. Masukkan **Request Number** yang baru dibuat (contoh: SR-20251103-0001)
4. Klik **"Track Request"**

**✅ Checklist:**
- [ ] Tracking page accessible tanpa login
- [ ] Request number validation
- [ ] Request details displayed
- [ ] Status timeline visible
- [ ] Current status highlighted
- [ ] Timestamps shown
- [ ] **User info hidden** (privacy)

**Screenshot**: 📸 Ambil screenshot tracking page

---

### Test 2.4: Approval Workflow (Admin/Staff Only)

**Langkah:**
1. **Login kembali** sebagai **Admin** (admin@ilab.unmul.ac.id)
2. Klik **"Services"** → **"Pending Approval"**

**✅ Checklist:**
- [ ] Pending approval dashboard muncul
- [ ] Badge counter di navigation menu showing count
- [ ] Table showing pending requests:
  - [ ] Request number
  - [ ] User name
  - [ ] Service requested
  - [ ] Submit date
  - [ ] SLA countdown (24 hours)
  - [ ] Actions: View/Verify buttons

---

#### **Test Verify Request**

**Langkah:**
1. Klik **"View"** pada request yang pending
2. Review request details
3. Klik **"Verify Request"** button
4. ✅ **Expected**:
   - Status berubah ke "verified"
   - Timestamp "verified_at" terupdate
   - Success message muncul

**✅ Checklist:**
- [ ] Verify button visible (role: Admin/TU)
- [ ] Confirmation dialog muncul
- [ ] Status updated successfully
- [ ] Email logged (check storage/logs/laravel.log)
- [ ] Redirect back to pending approval

---

#### **Test Approve Request (as Direktur)**

**Langkah:**
1. **Logout** dan **Login** sebagai user dengan role **"Direktur"** (jika ada)
2. Atau gunakan Admin untuk simulasi
3. Buka request yang sudah "verified"
4. Klik **"Approve Request"**
5. ✅ **Expected**: Status → "approved"

**✅ Checklist:**
- [ ] Approve button visible
- [ ] Status updated
- [ ] approved_at timestamp set
- [ ] Email notification logged

---

## 🧪 TEST SCENARIO 3: BOOKING SYSTEM

**Estimasi Waktu**: 15 menit

### Test 3.1: Calendar View

**URL**: `http://localhost:8000/bookings/calendar`

**Langkah:**
1. Klik **"Booking"** → **"Calendar"**
2. ✅ **Expected**: FullCalendar muncul

**✅ Checklist:**
- [ ] Calendar loads (FullCalendar library)
- [ ] Current month displayed
- [ ] Navigation buttons (Prev/Next/Today) working
- [ ] View switcher (Month/Week/Day) working
- [ ] Existing bookings displayed as events
- [ ] Event colors match status:
  - [ ] Gray = pending
  - [ ] Blue = approved
  - [ ] Green = confirmed
  - [ ] Yellow = checked_in
- [ ] Click date opens create booking form
- [ ] Click event shows booking details

**Screenshot**: 📸 Ambil screenshot calendar view

---

### Test 3.2: Create Booking

**Langkah:**
1. Di calendar, klik **tanggal besok** (pilih slot kosong)
2. ✅ **Expected**: Booking form modal/page muncul

**Form Data:**
1. **Laboratory**: Pilih "Laboratorium Kimia Analitik"
2. **Equipment** (optional): Pilih "HPLC" atau leave blank
3. **Booking Type**: Pilih "testing" (Pengujian/Analisis)
4. **Date**: Auto-filled (besok)
5. **Start Time**: Pilih "09:00"
6. **End Time**: Pilih "11:00"
7. **Purpose**: Ketik "Analisis sampel penelitian"
8. **Participants**: Ketik "2"
9. **Special Requirements**: Ketik "Perlu bantuan preparasi sampel"
10. Klik **"Create Booking"**

**✅ Checklist:**
- [ ] Form muncul dengan semua fields
- [ ] Laboratory dropdown populated
- [ ] Equipment filtered by selected lab
- [ ] Date picker working
- [ ] Time picker working
- [ ] **Duration auto-calculated** (2 hours)
- [ ] **Conflict detection** check:
  - [ ] If no conflict → "Available ✓"
  - [ ] If conflict → "Conflict detected ✗" with list
- [ ] Submit disabled if conflict
- [ ] **Booking number auto-generated** (BOOK-YYYYMMDD-XXXX)
- [ ] Success message after creation
- [ ] Redirect to booking detail or calendar

**Screenshot**: 📸 Ambil screenshot booking form

---

### Test 3.3: My Bookings

**URL**: `http://localhost:8000/bookings/my-bookings`

**Langkah:**
1. Klik **"Booking"** → **"My Bookings"**
2. ✅ **Expected**: List of your bookings

**✅ Checklist:**
- [ ] Booking baru muncul di list
- [ ] Booking number displayed
- [ ] Laboratory & equipment shown
- [ ] Date & time displayed
- [ ] Status badge (pending/approved/etc.)
- [ ] Duration shown
- [ ] Actions: View/Edit/Cancel buttons
- [ ] Filter by status working
- [ ] Sorted by date (upcoming first)

---

### Test 3.4: Booking Approval (Kepala Lab)

**Langkah:**
1. **Login** sebagai user dengan role **"Kepala Lab"** (jika ada)
2. Atau simulasi dengan Admin
3. Klik **"Booking"** → **"Approval Queue"**

**✅ Checklist:**
- [ ] Approval queue page muncul
- [ ] Badge counter di navigation
- [ ] Pending bookings displayed
- [ ] Only bookings for their lab shown (role-based)
- [ ] Approve button working
- [ ] Reject button working (with reason modal)
- [ ] Status updated after approval

---

### Test 3.5: Kiosk Interface

**URL**: `http://localhost:8000/bookings/kiosk`

**Langkah:**
1. Klik **"Booking"** → **"Check-in Kiosk"**
2. ✅ **Expected**: Kiosk view with today's bookings

**✅ Checklist:**
- [ ] Kiosk page muncul
- [ ] Statistics cards (3 cards):
  - [ ] Today's Bookings
  - [ ] Checked In
  - [ ] Completed
- [ ] Today's booking list
- [ ] Check-in button visible (15 min before start)
- [ ] Check-out button visible (after check-in)
- [ ] Auto-refresh every 30 seconds (optional)
- [ ] Large, easy-to-read display

**Screenshot**: 📸 Ambil screenshot kiosk view

---

## 🧪 TEST SCENARIO 4: EMAIL NOTIFICATIONS

**Estimasi Waktu**: 10 menit

### Test 4.1: Check Email Logs

**Langkah:**
1. Buka file: `C:\xampp\htdocs\ilab_v1\storage\logs\laravel.log`
2. Scroll ke bagian bawah (recent logs)
3. Cari entries dengan keyword "Mail" atau "Email"

**✅ Checklist:**
- [ ] Email "RequestSubmitted" logged saat create request
- [ ] Email "RequestVerified" logged saat verify
- [ ] Email "RequestApproved" logged saat approve
- [ ] Email contains correct recipient
- [ ] Email contains correct subject
- [ ] No errors in email sending

**Alternative Test (Optional):**
```bash
# Di terminal, run:
php artisan tinker

# Test email sending:
$request = App\Models\ServiceRequest::first();
Mail::to('test@example.com')->send(new App\Mail\RequestSubmitted($request));

# Check log setelahnya
```

---

## 🧪 TEST SCENARIO 5: UI/UX TESTING

**Estimasi Waktu**: 10 menit

### Test 5.1: Responsive Design (Mobile)

**Langkah:**
1. Buka Chrome DevTools (F12)
2. Klik "Toggle Device Toolbar" (Ctrl+Shift+M)
3. Pilih device: **iPhone 12 Pro**
4. Test setiap page

**✅ Checklist:**
- [ ] Navigation menu → hamburger menu di mobile
- [ ] Service cards → stack vertically
- [ ] Forms → full width, touch-friendly
- [ ] Tables → scrollable horizontal
- [ ] Buttons → large enough for touch
- [ ] Calendar → responsive (Month view default)

**Test Devices:**
- [ ] iPhone 12 Pro (390x844)
- [ ] iPad (768x1024)
- [ ] Samsung Galaxy S20 (360x800)

---

### Test 5.2: Dark Mode (Optional)

**Langkah:**
1. Cari dark mode toggle di navigation (if implemented)
2. Toggle dark mode ON
3. Browse through pages

**✅ Checklist:**
- [ ] All pages readable in dark mode
- [ ] Colors appropriate
- [ ] No white flashes
- [ ] Forms styled correctly
- [ ] Calendar colors adjusted

---

### Test 5.3: Browser Compatibility

**Test di 3 browsers berbeda:**

**✅ Checklist:**
- [ ] **Chrome**: All features working
- [ ] **Firefox**: All features working
- [ ] **Edge**: All features working
- [ ] Calendar rendering correctly in all
- [ ] Date pickers working in all
- [ ] No JavaScript errors (check Console)

---

## 📊 TESTING RESULTS TEMPLATE

Setelah selesai testing, isi tabel ini:

### Overall Results

| Scenario | Tests | Passed | Failed | Notes |
|----------|-------|--------|--------|-------|
| Service Catalog | 4 | __ | __ | |
| Service Request | 4 | __ | __ | |
| Booking System | 5 | __ | __ | |
| Email Notifications | 1 | __ | __ | |
| UI/UX Testing | 3 | __ | __ | |
| **TOTAL** | **17** | __ | __ | |

**Success Rate**: ___%

---

## 🐛 BUG REPORT TEMPLATE

Jika menemukan bug, catat di sini:

### Bug #1
- **Severity**: Critical / High / Medium / Low
- **Page/Feature**: [nama page/fitur]
- **Steps to Reproduce**:
  1. ...
  2. ...
  3. ...
- **Expected Result**: ...
- **Actual Result**: ...
- **Screenshot**: [attach if possible]
- **Browser/Device**: ...

### Bug #2
...

---

## ✅ FINAL CHECKLIST

Sebelum menyelesaikan testing:

- [ ] Semua 17 test scenarios executed
- [ ] Screenshots collected (minimal 5)
- [ ] Bugs documented (if any)
- [ ] Test results table filled
- [ ] Browser compatibility checked
- [ ] Mobile responsiveness checked
- [ ] Email logs verified
- [ ] No critical bugs found

---

## 🎉 SETELAH TESTING SELESAI

1. **Save this document** with test results
2. **Report bugs** (jika ada) ke developer
3. **Ambil keputusan**:
   - ✅ **PASS**: Siap production jika success rate > 90%
   - ⚠️ **CONDITIONAL**: Fix bugs dulu jika 70-90%
   - ❌ **FAIL**: Perlu re-work jika < 70%

---

**Happy Testing! 🧪**

**Estimasi Total Waktu**: 60-90 menit
**Difficulty**: Easy to Medium
**Prerequisites**: Basic understanding of web applications

---

**Tips:**
- Ambil screenshot di setiap step penting
- Catat semua bug/issue yang ditemukan
- Test dengan data realistis
- Jangan skip step - ikuti urutan
- Gunakan different users untuk test role-based features

**END OF MANUAL TESTING GUIDE**
