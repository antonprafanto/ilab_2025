# 📅 CALENDAR & WORKFLOW & UPLOAD & MOBILE & BROWSER TESTING

**Phase 3 Critical Areas Testing** - **Total Duration: 60-75 minutes**
**Version**: 2.0 - Complete Coverage
**Date**: 3 November 2025
**Tester**: [Your Name]
**Status**: Ready for Execution

---

## 🎯 **TESTING OVERVIEW**

### **Mission Critical Areas to Test:**
1. **📅 FullCalendar Interactions** - Cannot be automated (25 min)
2. **👥 Complete Multi-User Workflow** - Role switching required (20 min)
3. **📄 File Upload & Validation** - Real file interactions needed (10 min)
4. **📱 Mobile Responsiveness** - Device testing mandatory (10 min)
5. **🌐 Browser Compatibility** - Cross-browser verification (10 min)

### **Prerequisites:**
- [ ] Laravel server running: `php artisan serve`
- [ ] Test files prepared: PDF (<2MB), invalid file
- [ ] Multiple user accounts ready
- [ ] Multiple browsers available
- [ ] Mobile device or DevTools device mode

---

## 📋 **PRE-TESTING PREPARATION (5 minutes)**

### **Step 0.1: Environment Setup**
```bash
# 1. Start Laravel server
cd C:\xampp\htdocs\ilab_v1
php artisan serve

# 2. Verify server is running
# Open http://localhost:8000 in browser
# Should see iLab UNMUL homepage
```

### **Step 0.2: Test Files Preparation**
```bash
# Create test files folder
mkdir -p C:\temp\test-files

# Test files needed:
✅ valid-proposal.pdf (under 2MB)
✅ invalid-large.pdf (over 5MB)
✅ invalid-file.exe (wrong extension)
✅ test-image.jpg (optional)
```

### **Step 0.3: User Account Verification**
```bash
# Check available users
php artisan tinker
# Copy paste this:
$users = User::with('roles')->get();
foreach($users as $user) {
    echo $user->name . ' - ' . $user->email . ' - ' . $user->roles->pluck('name')->join(', ') . PHP_EOL;
}
```

**Required Roles:**
- ✅ Regular User (for service request submission)
- ✅ Admin (for verification)
- ✅ Direktur (for approval)
- ✅ Wakil Direktur (for lab assignment)
- ✅ Kepala Lab (for analyst assignment)
- ✅ Anggota Lab (as recipient)

**Missing users? Use Super Admin for testing, document in notes.**

---

## 📅 **TESTING SCENARIO 1: FULLCALENDAR INTERACTIONS**
**Duration**: 25 minutes | **Criticality**: 🔥 CANNOT BE AUTOMATED

### **1.1 Calendar Access & Initial Load (5 min)**

#### **Test 1.1.1: Navigate to Calendar**
1. **Login sebagai Regular User**
   ```
   URL: http://localhost:8000/login
   Email: [regular-user@example.com]
   Password: [password]
   ```

2. **Navigate to Calendar**
   ```
   Menu Navigation: Bookings → Calendar
   Expected URL: http://localhost:8000/bookings/calendar
   ```

3. **Verification Checklist:**
   - [ ] Page loads without JavaScript errors
     - **Check**: Open browser DevTools → Console
     - **Expected**: No red error messages
   - [ ] Calendar displays current month
     - **Expected**: Current month/year visible
   - [ ] FullCalendar controls visible
     - **Expected**: Today, Previous, Next buttons present
   - [ ] View switcher present (month/week/day)
     - **Expected**: Dropdown with view options
   - [ ] Loading indicator disappears
     - **Expected**: No spinning indicators after load
   - [ ] Navigation menu still accessible
     - **Expected**: Top menu visible and clickable

### **1.2 Calendar Navigation Controls (5 min)**

#### **Test 1.2.1: Month Navigation**
1. **Previous Month Button**
   - [ ] Click "<" (previous month) button
   - **Expected**: Calendar shows previous month
   - [ ] Verify month/year updates correctly
   - [ ] Check events from previous month load

2. **Next Month Button**
   - [ ] Click ">" (next month) button
   - **Expected**: Calendar shows next month
   - [ ] Verify month/year updates correctly
   - [ ] Check events from next month load

3. **Today Button**
   - [ ] Navigate to any month
   - [ ] Click "Today" button
   - **Expected**: Calendar returns to current month
   - [ ] Verify correct date highlighted

4. **View Switcher**
   - [ ] Click "Month" → Expected: Month view
   - [ ] Click "Week" → Expected: Week view (7 days)
   - [ ] Click "Day" → Expected: Single day view
   - [ ] Click "Month" again → Expected: Returns to month view

### **1.3 Create Booking via Drag Interaction (8 min)**

#### **Test 1.3.1: Drag to Create Booking**
1. **Find Empty Calendar Slot**
   - [ ] Click on empty day/time slot
   - **Expected**: Should see empty calendar area

2. **Drag to Create**
   - [ ] **Click and hold** on empty calendar cell
   - [ ] **Drag** down/right to create selection
   - **Expected**: Selection overlay appears
   - [ ] **Release mouse** - Modal should appear

#### **Test 1.3.2: Create Booking Modal**
1. **Modal Appears**
   - [ ] Modal dialog opens automatically
   - [ ] Modal has proper title ("Create Booking")
   - [ ] Modal is properly centered on screen
   - [ ] Background is dimmed/overlayed

2. **Form Fields Verification**
   - [ ] Title field present and focusable
   - [ ] Description field present (textarea)
   - [ ] Laboratory dropdown present and populated
   - [ ] Room dropdown present and populated
   - [ ] Equipment dropdown present (if lab selected)
   - [ ] Start time pre-filled correctly
   - [ ] End time pre-filled correctly
   - [ ] All required fields marked (*)

3. **Form Interaction Testing**
   - [ ] Can type in title field
   - [ ] Laboratory dropdown opens on click
   - [ ] Laboratory selection triggers room dropdown update
   - [ ] Room selection works
   - [ ] Equipment selection works (if available)

#### **Test 1.3.3: Save Booking**
1. **Fill Complete Form**
   ```
   Title: "Manual Test Booking"
   Description: "Testing drag create functionality"
   Laboratory: [Select first available]
   Room: [Select first available]
   Equipment: [Select if available]
   ```

2. **Submit Booking**
   - [ ] Click "Save" or "Create Booking" button
   - **Expected**: Loading indicator appears
   - **Expected**: Modal closes
   - **Expected**: New event appears on calendar
   - **Expected**: Success notification/message appears

### **1.4 Event Interactions (4 min)**

#### **Test 1.4.1: Click Existing Event**
1. **Find Existing Event**
   - [ ] Look for any colored event on calendar
   - [ ] Move mouse over event
   - **Expected**: Event becomes highlighted/hovered

2. **Click Event**
   - [ ] **Click** on event
   - **Expected**: Modal opens with event details
   - **Expected**: Modal title shows event title
   - **Expected**: All event information displayed correctly

3. **Event Details Modal**
   - [ ] Title displayed correctly
   - [ ] Description displayed (if any)
   - [ ] Start/end times correct
   - [ ] Laboratory/Room information displayed
   - [ ] Edit button present (if authorized)
   - [ ] Delete button present (if authorized)
   - [ ] Close button present

#### **Test 1.4.2: Edit Event**
1. **Click Edit Button**
   - [ ] Click "Edit" button in event modal
   - **Expected**: Form opens with current data
   - [ ] All fields pre-filled with existing data

2. **Modify Event**
   - [ ] Change title to "Edited Manual Test"
   - [ ] Modify description if desired
   - [ ] Click "Update" or "Save Changes"

3. **Verify Update**
   - [ ] Modal closes
   - [ ] Event on calendar updates with new title
   - [ ] Success notification appears

#### **Test 1.4.3: Delete Event**
1. **Click Delete Button**
   - [ ] Click "Delete" button in event modal
   - **Expected**: Confirmation dialog appears
   - [ ] Confirmation message asks if sure to delete

2. **Confirm Delete**
   - [ ] Click "Yes" or "Confirm Delete"
   - **Expected**: Modal closes
   - [ ] Event removed from calendar
   - [ ] Success confirmation appears

3. **Verify Deletion**
   - [ ] Event no longer visible on calendar
   - [ ] No errors in browser console
   - [ ] Other events remain intact

### **1.5 Calendar Responsiveness Testing (3 min)**

#### **Test 1.5.1: Desktop to Tablet Transition**
1. **Open Developer Tools** (F12)
2. **Toggle Device Mode** (mobile icon)
3. **Select Tablet Preset**
   ```
   Device: iPad Air (820x1180)
   ```

4. **Verify Tablet Layout**
   - [ ] Calendar resizes properly
   - [ ] Navigation buttons still accessible
   - [ ] Events remain readable
   - [ ] Touch targets are large enough (>44px)

5. **Test Tablet Interactions**
   - [ ] Click on event (touch simulation)
   - [ ] Month navigation works
   - [ ] View switcher works
   - [ ] Modal appears correctly sized

#### **Test 1.5.2: Mobile Layout Testing**
1. **Select Mobile Preset**
   ```
   Device: iPhone 12 (390x844)
   ```

2. **Verify Mobile Layout**
   - [ ] Calendar fits screen without horizontal scroll
   - [ ] Text remains readable
   - [ ] Navigation controls adapted for touch
   - [ ] Events display appropriately for mobile

3. **Test Mobile Interactions**
   - [ ] Tap events work
   - [ ] Month navigation works
   - [ ] Modal fits screen properly
   - [ ] Can scroll within modal if needed

4. **Test Mobile Create**
   - [ ] Tap and drag to create (may be different on mobile)
   - [ ] Alternative create method works
   - [ ] Form fits mobile screen
   - [ ] Virtual keyboard doesn't obscure form

---

## 👥 **TESTING SCENARIO 2: COMPLETE MULTI-USER WORKFLOW**
**Duration**: 20 minutes | **Criticality**: 🔥 BUSINESS LOGIC CRITICAL

### **2.1 User Submits Service Request (6 min)**

#### **Test 2.1.1: Login & Navigate**
1. **Login sebagai Regular User**
   ```
   URL: http://localhost:8000/login
   Email: [regular-user@example.com]
   Password: [password]
   ```

2. **Navigate to Service Catalog**
   - [ ] Click "Services" menu
   - [ ] Click "Service Catalog"
   - **Expected**: List of services displayed

3. **Browse Services**
   - [ ] Verify services listed
   - [ ] Test search functionality
   - [ ] Test filters (category, laboratory, price)
   - [ ] Select one service for request

#### **Test 2.1.2: Start Service Request Wizard**
1. **Select Service**
   - [ ] Click "Ajukan Permohonan" on chosen service
   - **Expected**: Redirected to wizard step 1
   - [ ] Verify wizard progress indicator shows Step 1

#### **Test 2.1.3: Complete Step 1 - Basic Information**
1. **Fill Required Fields**
   ```
   Judul Permohonan: "Manual Test Multi-User Workflow"
   Deskripsi: "Testing complete approval chain"
   Urgensi: Standard
   Alasan Urgensi: [leave empty since not urgent]
   ```

2. **Validation Testing**
   - [ ] Try to continue without title → Should show error
   - [ ] Fill all required fields
   - [ ] Click "Selanjutnya" (Next)
   - **Expected**: Progress to Step 2

#### **Test 2.1.4: Complete Step 2 - Sample Information**
1. **Fill Sample Information**
   ```
   Jumlah Sampel: 5
   Tipe Sampel: Sampel Uji Laboratorium
   Deskripsi Sampel: "Test sample untuk manual testing workflow"
   Persiapan Sampel: "Sample sudah siap untuk analisis"
   ```

2. **Validation**
   - [ ] Try to continue without sample count → Error
   - [ ] Try sample count = 0 → Error
   - [ ] Fill all required fields
   - [ ] Click "Selanjutnya" → Expected: Step 3

#### **Test 2.1.5: Complete Step 3 - Research Information**
1. **Fill Research Information**
   ```
   Judul Penelitian: "Manual Testing Research Project"
   Tujuan Penelitian: "Validasi multi-user workflow iLab UNMUL"
   Institusi: "Universitas Mulawarman"
   Departemen: "Fakultas MIPA"
   Nama Pembimbing: "Prof. Test User"
   Kontak Pembimbing: "test@example.com"
   Tanggal Disukai: [Select date > tomorrow]
   ```

2. **File Upload Testing**
   - [ ] Click "Choose File" or "Upload Proposal"
   - [ ] Select valid-proposal.pdf (under 2MB)
   - [ ] **Expected**: File name appears, progress if available
   - [ ] Try to upload invalid-large.pdf (>5MB)
     - **Expected**: Error message about file size
   - [ ] Try to upload invalid-file.exe
     - **Expected**: Error message about file type
   - [ ] Use valid PDF for final submission
   - [ ] Click "Remove" on uploaded file (test)
   - [ ] Re-upload valid PDF
   - [ ] Click "Selanjutnya" → Expected: Step 4

#### **Test 2.1.6: Complete Step 4 - Review & Submit**
1. **Review All Information**
   - [ ] Verify Step 1 information displayed correctly
   - [ ] Verify Step 2 information displayed correctly
   - [ ] Verify Step 3 information displayed correctly
   - [ ] Verify PDF file listed with name
   - [ ] Estimated completion date calculated
   - [ ] Working days calculated correctly

2. **Submit Request**
   - [ ] Click "Ajukan Permohonan" button
   - **Expected**: Loading indicator
   - **Expected**: Redirect to request detail page
   - **Expected**: Success message appears
   - [ ] **SAVE THE REQUEST NUMBER** (format: SR-YYYYMMDD-XXXX)
   - [ ] Verify request status shows "Menunggu Verifikasi"

### **2.2 Admin Verification (4 min)**

#### **Test 2.2.1: Login sebagai Admin**
1. **Logout Current User**
   - [ ] Click user profile → Logout
   - **Expected**: Redirected to login page

2. **Login sebagai Admin**
   ```
   URL: http://localhost:8000/login
   Email: [admin@example.com]
   Password: [password]
   ```

#### **Test 2.2.2: Navigate to Pending Verification**
1. **Find Pending Requests**
   - [ ] Navigate to "Service Requests" → "Pending Verification"
   - **Expected URL**: http://localhost:8000/service-requests/pending-verification
   - [ ] Find your request from Step 1
   - [ ] Verify request number matches saved number

#### **Test 2.2.3: Verify Request**
1. **Review Request Details**
   - [ ] Click on your request
   - [ ] Review all submitted information
   - [ ] Check PDF attachment is accessible
   - [ ] Verify sample information is complete
   - [ ] Check research information is complete

2. **Add Verification Notes**
   - [ ] Click "Verify" button
   - [ ] Add verification notes: "Manual testing - all information complete"
   - [ ] Click "Confirm Verification"

3. **Verify Status Change**
   - [ ] Request status changes to "Terverifikasi"
   - [ ] Verification timestamp appears
   - [ ] Verifier information appears
   - [ ] Success notification appears

### **2.3 Director Approval (4 min)**

#### **Test 2.3.1: Login sebagai Direktur**
1. **Logout Admin**
   - [ ] Logout current admin session

2. **Login sebagai Direktur**
   ```
   Email: [direktur@example.com]
   Password: [password]
   ```

#### **Test 2.3.2: Navigate to Pending Approval**
1. **Find Pending Approvals**
   - [ ] Navigate to "Service Requests" → "Pending Approval"
   - **Expected URL**: http://localhost:8000/service-requests/pending-approval
   - [ ] Find verified request (should be first in queue)

#### **Test 2.3.3: Review and Approve**
1. **Review Request Details**
   - [ ] Click on verified request
   - [ ] Review verification details
   - [ ] Check admin verification notes
   - [ ] Verify SLA countdown is working

2. **Approval Process**
   - [ ] Click "Approve" button
   - [ ] Add approval notes: "Approved for manual testing workflow"
   - [ ] Click "Confirm Approval"

3. **Verify Approval**
   - [ ] Request status changes to "Disetujui"
   - [ ] Approval timestamp appears
   - [ ] Approver information appears
   - [ ] Success notification appears

### **2.4 Wakil Direktur Lab Assignment (3 min)**

#### **Test 2.4.1: Login sebagai Wakil Direktur**
1. **Logout Direktur**
   - [ ] Logout current director session

2. **Login sebagai Wakil Direktur**
   ```
   Email: [wakil-direktur@example.com]
   Password: [password]
   ```

#### **Test 2.4.2: Navigate to Lab Assignment Queue**
1. **Find Pending Lab Assignment**
   - [ ] Navigate to "Service Requests" → "Pending Lab Assignment"
   - **Expected URL**: http://localhost:8000/service-requests/pending-lab-assignment
   - [ ] Find approved request in queue

#### **Test 2.4.3: Assign Laboratory**
1. **Review Request**
   - [ ] Click on approved request
   - [ ] Review all request details
   - [ ] Check service requirements

2. **Assign Laboratory**
   - [ ] Click "Assign Laboratory" button
   - [ ] Modal appears with laboratory options
   - [ ] Select appropriate laboratory from dropdown
   - [ ] Add assignment notes: "Manual testing lab assignment"
   - [ ] Click "Assign" button

3. **Verify Assignment**
   - [ ] Request status changes to "Lab Assigned"
   - [ ] Lab assignment timestamp appears
   - [ ] Assigned laboratory information appears
   - [ ] Success notification appears

### **2.5 Kepala Lab Analyst Assignment (3 min)**

#### **Test 2.5.1: Login sebagai Kepala Lab**
1. **Logout Wakil Direktur**
   - [ ] Logout current session

2. **Login sebagai Kepala Lab**
   ```
   Email: [kepala-lab@example.com]
   Password: [password]
   ```

#### **Test 2.5.2: Navigate to Lab Queue**
1. **Find Lab Queue**
   - [ ] Navigate to "Service Requests" → "Lab Queue"
   - **Expected URL**: http://localhost:8000/service-requests/lab-queue
   - [ ] Find lab-assigned request

#### **Test 2.5.3: Assign Analyst**
1. **Review Request Details**
   - [ ] Click on lab-assigned request
   - [ ] Review all request information
   - [ ] Check laboratory assignment details

2. **Assign to Analyst**
   - [ ] Click "Assign Analyst" button
   - [ ] Modal appears with analyst list
   - [ ] Select available analyst from dropdown
   - [ ] Add assignment notes: "Manual testing analyst assignment"
   - [ ] Click "Assign" button

3. **Verify Final Assignment**
   - [ ] Request status changes to "Assigned"
   - [ ] Assignment timestamp appears
   - [ ] Assigned analyst information appears
   - [ ] Analyst contact information displayed
   - [ ] Success notification appears

### **2.6 Verify Complete Workflow (1 min)**

#### **Test 2.6.1: Check Request Status**
1. **Final Status Verification**
   - [ ] Request number remains consistent throughout workflow
   - [ ] Final status: "Assigned"
   - [ ] All timestamps present (submitted, verified, approved, assigned)
   - [ ] All user assignments visible (verified by, approved by, assigned to)

2. **Email Notification Verification**
   ```bash
   # Check email log for notifications
   tail -50 storage/logs/laravel.log | grep -i "mail"
   ```
   - [ ] RequestSubmitted email sent to user
   - [ ] RequestVerified email sent to director
   - [ ] RequestApproved email sent to wakil direktur
   - [ ] RequestAssignedToLab email sent to kepala lab
   - [ ] RequestAssignedToAnalyst email sent to analyst and user

---

## 📱 **TESTING SCENARIO 3: MOBILE RESPONSIVENESS**
**Duration**: 10 minutes | **Criticality**: ⚠️ USER EXPERIENCE CRITICAL

### **3.1 Service Request Wizard on Mobile (4 min)**

#### **Test 3.1.1: Mobile Access Setup**
1. **Open Developer Tools** (F12)
2. **Toggle Device Mode**
3. **Select Mobile Device**
   ```
   Device: iPhone 12 (390x844)
   User Agent: Mobile Safari
   ```

#### **Test 3.1.2: Login and Navigation**
1. **Mobile Login**
   - [ ] Navigate to http://localhost:8000/login
   - [ ] Login form fits screen without horizontal scroll
   - [ ] Input fields are touch-friendly (>44px)
   - [ ] Login button easily tappable
   - [ ] After login, navigation menu is accessible

2. **Mobile Navigation**
   - [ ] Hamburger menu works (if collapsed)
   - [ ] Service Request menu accessible
   - [ ] Service Catalog browsable on mobile

#### **Test 3.1.3: Mobile Wizard Testing**
1. **Step 1 - Basic Info on Mobile**
   - [ ] Form fields are properly sized
   - [ ] Text input works with mobile keyboard
   - [ ] Select dropdowns work with touch
   - [ ] "Selanjutnya" button easily tappable
   - [ ] Progress indicator visible

2. **Step 2 - Sample Info on Mobile**
   - [ ] Numeric inputs work with mobile number keypad
   - [ ] Textarea areas are scrollable if needed
   - [ ] Form validation messages are visible
   - [ ] Continue button accessible

3. **Step 3 - Research Info on Mobile**
   - [ ] Date picker works with mobile calendar
   - [ ] File upload button is tappable
   - [ ] File selection works with mobile file picker
   - [ ] File name appears after selection
   - [ ] Remove file option accessible

4. **Step 4 - Review on Mobile**
   - [ ] Review information fits screen
   - [ ] All sections readable without horizontal scroll
   - [ ] Submit button prominent and accessible
   - [ ] Final submission works on mobile

### **3.2 Calendar on Mobile (3 min)**

#### **Test 3.2.1: Mobile Calendar Layout**
1. **Navigate to Calendar**
   - [ ] Calendar fits mobile screen
   - [ ] Month view is primary mobile view
   - [ ] Navigation controls are touch-friendly
   - [ ] Events display properly sized

2. **Mobile Calendar Interactions**
   - [ ] Tap on empty cell works (alternative to drag)
   - [ ] Tap on existing events opens details
   - [ ] Month navigation works with touch
   - [ ] View switcher works (if accessible)

3. **Mobile Event Creation**
   - [ ] Create event modal fits mobile screen
   - [ ] Form fields scrollable within modal
   - [ ] Dropdowns work with touch
   - [ ] Save button easily accessible
   - [ ] Virtual keyboard doesn't obscure important fields

### **3.3 Approval Dashboards on Mobile (3 min)**

#### **Test 3.3.1: Admin Dashboard Mobile**
1. **Navigate to Pending Verification**
   - [ ] Table adapts for mobile view
   - [ ] Horizontal scroll works if needed
   - [ ] Request details accessible via mobile
   - [ ] Action buttons (Verify) are tappable

2. **Mobile Approval Process**
   - [ ] Clicking request works on mobile
   - [ ] Verification modal fits screen
   - [ ] Form inputs work with mobile keyboard
   - [ ] Confirm button accessible

#### **Test 3.3.2: Director Dashboard Mobile**
1. **Pending Approval Mobile**
   - [ ] Approval queue viewable on mobile
   - [ ] Request details accessible
   - [ ] Approval buttons are tappable
   - [ ] Approval process works on mobile

---

## 📄 **TESTING SCENARIO 4: FILE UPLOAD & VALIDATION**
**Duration**: 10 minutes | **Criticality**: 🔥 FUNCTIONALITY CRITICAL

### **4.1 Valid File Upload (3 min)**

#### **Test 4.1.1: Standard PDF Upload**
1. **Navigate to Service Request Wizard Step 3**
   - [ ] Login as Regular User
   - [ ] Start service request wizard
   - [ ] Complete Steps 1-2
   - [ ] Proceed to Step 3

2. **Upload Valid PDF**
   - [ ] Click "Choose File" or "Upload" button
   - [ ] Select valid-proposal.pdf (<2MB)
   - [ ] **Expected**: File name appears in UI
   - [ ] **Expected**: File size displayed (if available)
   - [ ] **Expected**: "Remove" or "Delete" button appears
   - [ ] **Expected**: No error messages
   - [ ] **Expected**: Can continue to next step

3. **Verify File Properties**
   - [ ] File name matches uploaded file
   - [ ] File size within limits
   - [ ] File extension is .pdf
   - [ ] Preview icon appears (if implemented)

### **4.2 File Size Validation (3 min)**

#### **Test 4.2.1: Oversized File Upload**
1. **Upload Large File**
   - [ ] Click "Choose File"
   - [ ] Select invalid-large.pdf (>5MB)
   - [ ] **Expected**: Error message about file size
   - [ ] **Expected**: File is not accepted
   - [ ] **Expected**: Can try again with different file
   - [ ] **Expected**: Error message is user-friendly

2. **Test Size Limit Boundary**
   - [ ] Try exactly 5MB file (if available)
   - [ ] Try 5.1MB file
   - [ ] Verify boundary conditions work correctly

### **4.3 File Type Validation (2 min)**

#### **Test 4.3.1: Invalid File Type Upload**
1. **Upload Executable File**
   - [ ] Click "Choose File"
   - [ ] Select invalid-file.exe
   - [ ] **Expected**: Error message about file type
   - [ ] **Expected**: Only PDF, DOC, DOCX allowed
   - [ ] **Expected**: File is rejected
   - [ ] **Expected**: Clear explanation of allowed types

2. **Test Other Invalid Types**
   - [ ] Try .zip file → Should be rejected
   - [ ] Try .jpg file → Should be rejected (unless image allowed)
   - [ ] Try .txt file → Should be rejected
   - [ ] Verify all rejections have appropriate error messages

### **4.4 File Removal and Re-upload (2 min)**

#### **Test 4.4.1: Remove Uploaded File**
1. **Remove Valid File**
   - [ ] Upload valid PDF first
   - [ ] Click "Remove" or "Delete" button
   - [ ] **Expected**: Confirmation prompt (if implemented)
   - [ ] **Expected**: File is removed from form
   - [ ] **Expected**: File input becomes empty
   - [ ] **Expected**: Can upload new file

2. **Re-upload After Removal**
   - [ ] Upload different valid PDF
   - [ ] **Expected**: New file replaces old one
   - [ ] **Expected**: New file details displayed
   - [ ] **Expected**: Form remains functional

---

## 🌐 **TESTING SCENARIO 5: BROWSER COMPATIBILITY**
**Duration**: 10 minutes | **Criticality**: ⚠️ CROSS-PLATFORM REQUIREMENT

### **5.1 Chrome Testing (3 min)**

#### **Test 5.1.1: Chrome Full Workflow**
1. **Open Chrome Browser**
   - [ ] Navigate to http://localhost:8000
   - [ ] Login and test basic functionality
   - [ ] Test service request wizard
   - [ ] Check for any Chrome-specific issues
   - [ ] Verify DevTools console shows no errors

### **5.2 Firefox Testing (3 min)**

#### **Test 5.2.1: Firefox Compatibility**
1. **Open Firefox Browser**
   - [ ] Navigate to http://localhost:8000
   - [ ] Test login functionality
   - [ ] Test service request creation
   - [ ] Check calendar functionality
   - [ ] Look for any Firefox-specific rendering issues

### **5.3 Edge Testing (3 min)**

#### **Test 5.3.1: Edge Compatibility**
1. **Open Microsoft Edge**
   - [ ] Navigate to http://localhost:8000
   - [ ] Test core functionality
   - [ ] Check file upload works
   - [ ] Verify calendar interactions
   - [ ] Look for any Edge-specific issues

### **5.4 Cross-Browser Issues Documentation (1 min)**

#### **Test 5.4.1: Issue Tracking**
Record any browser-specific issues found:
- [ ] Chrome: ___________________________
- [ ] Firefox: _________________________
- [ ] Edge: ___________________________
- [ ] Safari (if available): ___________

---

## 📊 **TESTING RESULTS SUMMARY**

### **Scenario 1: Calendar Interactions Results**
| Test | Status | Issues Found | Resolution |
|------|--------|---------------|------------|
| Calendar Load | [ ] | | |
| Navigation Controls | [ ] | | |
| Drag Create Booking | [ ] | | |
| Event Interactions | [ ] | | |
| Edit/Delete Events | [ ] | | |
| Mobile Responsiveness | [ ] | | |

### **Scenario 2: Multi-User Workflow Results**
| Step | Status | Request # | Issues Found |
|------|--------|-----------|--------------|
| User Submission | [ ] | SR-XXXX | |
| Admin Verification | [ ] | | |
| Director Approval | [ ] | | |
| Wakil Direktur Assignment | [ ] | | |
| Kepala Lab Analyst Assignment | [ ] | | |
| Email Notifications | [ ] | | |

### **Scenario 3: Mobile Responsiveness Results**
| Page | Status | Issues Found |
|------|--------|--------------|
| Service Request Wizard | [ ] | |
| Calendar | [ ] | |
| Approval Dashboards | [ ] | |

### **Scenario 4: File Upload Results**
| Test | Status | Issues Found |
|------|--------|--------------|
| Valid PDF Upload | [ ] | |
| File Size Validation | [ ] | |
| File Type Validation | [ ] | |
| File Removal | [ ] | |

### **Scenario 5: Browser Compatibility Results**
| Browser | Status | Issues Found |
|---------|--------|--------------|
| Chrome | [ ] | |
| Firefox | [ ] | |
| Edge | [ ] | |

---

## 🐛 **ISSUES TRACKING**

### **Critical Issues (Blockers)**
1. **Issue #1**: [Description]
   - **Expected Behavior**: [What should happen]
   - **Actual Behavior**: [What actually happened]
   - **Steps to Reproduce**: [Detailed steps]
   - **Browser**: [Chrome/Firefox/Edge/Mobile]
   - **Screenshot**: [Attach if possible]

### **Major Issues (Non-blockers)**
2. **Issue #2**: [Description]
   - **Impact**: [How it affects user experience]
   - **Priority**: [High/Medium]

### **Minor Issues (UX Improvements)**
3. **Issue #3**: [Description]
   - **Suggestion**: [How to improve]

---

## ✅ **PRODUCTION READINESS ASSESSMENT**

### **Final Checklist**
- [ ] **All Critical Tests Passed**: Calendar, Workflow, File Upload
- [ ] **Mobile Experience Acceptable**: Touch interactions work
- [ ] **Cross-Browser Compatibility**: Core functionality works
- [ ] **No Critical Blocker Issues**: System functions end-to-end
- [ ] **User Feedback Collected**: Manual testing notes complete

### **Overall Assessment**
- [ ] **Ready for Production** 🚀
- [ ] **Ready with Minor Fixes** ⚠️
- [ ] **Needs Major Fixes** ❌

### **Recommendations**
1. **Immediate Actions**: [Critical fixes needed]
2. **Future Improvements**: [Nice-to-have enhancements]
3. **Documentation Updates**: [Documentation changes needed]

---

## 📝 **TESTING EXECUTION NOTES**

### **Environment Information**
- **Date**: _____________________
- **Time Started**: ________________
- **Time Completed**: _____________
- **Tester**: _____________________
- **Operating System**: ____________
- **Browser Versions**: _____________

### **Test Account Information**
- **Regular User**: _________________
- **Admin**: ______________________
- **Director**: _____________________
- **Wakil Direktur**: _____________
- **Kepala Lab**: __________________

### **Test Files Used**
- **valid-proposal.pdf**: _________ (Size: ______)
- **invalid-large.pdf**: _________ (Size: ______)
- **invalid-file.exe**: _________ (Size: ______)

### **Special Notes**
_________________________________________________________________________________________________
_________________________________________________________________________________________________
_________________________________________________________________________________________________

---

## 🎯 **CONCLUSION**

### **Testing Summary**
- **Total Scenarios Tested**: ___/5
- **Total Test Cases**: ___/___
- **Critical Issues**: ___
- **Major Issues**: ___
- **Minor Issues**: ___
- **Overall Success Rate**: ___%

### **Final Recommendation**
- [ ] **PRODUCTION READY** - System meets all requirements
- [ ] **PRODUCTION READY WITH CAVEATS** - Minor issues acceptable
- [ ] **NOT PRODUCTION READY** - Critical issues must be resolved

### **Next Steps**
1. [ ] Fix all critical issues identified
2. [ ] Implement minor improvements if time permits
3. [ ] Update documentation with findings
4. [ ] Schedule production deployment
5. [ ] Plan user training and rollout

---

*This comprehensive manual testing script ensures 100% coverage of all critical functionality that cannot be automated. Follow each step carefully to validate production readiness.*

**Created by**: Claude AI Assistant
**Date**: 3 November 2025
**Version**: 2.0 - Complete Coverage
**Status**: Ready for Execution

**Testing Focus**: Calendar Interactions, Multi-User Workflow, File Uploads, Mobile Responsiveness, Browser Compatibility