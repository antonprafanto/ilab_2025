# Testing Checklist - Chapter 10: Service Request System

**Date**: 2025-10-23
**Chapter**: Chapter 10 - Service Request Management System
**Status**: 🧪 TESTING IN PROGRESS

---

## 📋 Pre-Testing Setup

### ✅ Database Migration
- [ ] Run migration: `php artisan migrate`
- [ ] Verify table structure: `service_requests` table exists
- [ ] Verify 50+ fields created correctly
- [ ] Verify 9 indexes created
- [ ] Verify soft deletes enabled

### ✅ Seeder Execution
- [ ] Run seeder: `php artisan db:seed --class=ServiceRequestSeeder`
- [ ] Verify 10 sample records created
- [ ] Verify different statuses: pending, verified, approved, assigned, in_progress, testing, completed
- [ ] Verify request numbers format: SR-YYYYMMDD-XXXX
- [ ] Verify relationships: user_id, service_id linked correctly

### ✅ Route Verification
- [ ] Run: `php artisan route:list --name=service-requests`
- [ ] Verify 15 routes registered
- [ ] Verify public tracking routes (no auth)
- [ ] Verify authenticated routes (with auth)

---

## 🧪 Feature Testing

### 1️⃣ Navigation Menu
**File**: `resources/views/layouts/navigation.blade.php`

**Desktop Navigation:**
- [ ] Services dropdown appears in navigation bar
- [ ] "Service Catalog" link works → routes to `services.index`
- [ ] "Service Requests" link works → routes to `service-requests.index`
- [ ] "Track Request" link works → routes to `service-requests.tracking`
- [ ] Active state highlighting works
- [ ] Dropdown styling consistent with other menus

**Mobile Navigation:**
- [ ] Services section appears in hamburger menu
- [ ] All 3 links work on mobile
- [ ] Active state works on mobile
- [ ] Responsive design works correctly

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 2️⃣ Service Requests Index Page
**Route**: `GET /service-requests` → `service-requests.index`

**Basic Display:**
- [ ] Page loads without errors
- [ ] Shows list of service requests
- [ ] Displays request number, title, service name
- [ ] Shows status badge with correct colors
- [ ] Shows priority badge (normal/urgent)
- [ ] Shows created date
- [ ] "View" button works

**Filters:**
- [ ] Status filter works (all, pending, verified, approved, assigned, in_progress, testing, completed, rejected, cancelled)
- [ ] Priority filter works (all, normal, urgent)
- [ ] Service filter works (shows all services)
- [ ] Date range filter works (from - to)
- [ ] Search box works (searches title, request number, sample name)
- [ ] Multiple filters work together
- [ ] Clear filters works

**Pagination:**
- [ ] Shows 10 items per page
- [ ] Pagination controls work
- [ ] Page numbers correct

**Permissions:**
- [ ] Regular users see only their requests
- [ ] Staff see all requests
- [ ] Admins see all requests

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 3️⃣ Multi-Step Wizard - Step 1
**Route**: `GET /service-requests/create` → `service-requests.create` (step=1)

**Form Display:**
- [ ] Progress indicator shows "Step 1 of 4"
- [ ] Progress bar shows 25%
- [ ] Service dropdown populated from database
- [ ] All fields visible:
  - Service selection
  - Title
  - Description
  - Purpose
  - Priority (normal/urgent)
  - Preferred date
  - Client name
  - Client institution
  - Client email
  - Client phone

**Validation:**
- [ ] Service required validation works
- [ ] Title required validation works
- [ ] Description required validation works
- [ ] Client name required validation works
- [ ] Email format validation works
- [ ] Phone format validation works
- [ ] Error messages displayed correctly

**Navigation:**
- [ ] "Cancel" button redirects to index
- [ ] "Next Step" button saves to session
- [ ] "Next Step" redirects to step 2
- [ ] Session data persists

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 4️⃣ Multi-Step Wizard - Step 2
**Route**: `GET /service-requests/create?step=2` → `service-requests.create` (step=2)

**Form Display:**
- [ ] Progress indicator shows "Step 2 of 4"
- [ ] Progress bar shows 50%
- [ ] All fields visible:
  - Sample name
  - Sample type
  - Sample quantity
  - Sample unit
  - Sample condition
  - Sample description
  - Storage requirements
  - Special handling

**Validation:**
- [ ] Sample name required validation works
- [ ] Sample type required validation works
- [ ] Quantity numeric validation works
- [ ] Quantity minimum (1) validation works
- [ ] Error messages displayed correctly

**Navigation:**
- [ ] "Back" button returns to step 1
- [ ] Step 1 data still populated
- [ ] "Next Step" button saves to session
- [ ] "Next Step" redirects to step 3
- [ ] Session data persists

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 5️⃣ Multi-Step Wizard - Step 3
**Route**: `GET /service-requests/create?step=3` → `service-requests.create` (step=3)

**Form Display:**
- [ ] Progress indicator shows "Step 3 of 4"
- [ ] Progress bar shows 75%
- [ ] All fields visible:
  - Research background
  - Expected results
  - Previous work
  - Proposal document upload
  - Budget range
  - Internal notes

**File Upload:**
- [ ] File input accepts PDF, DOC, DOCX
- [ ] File size validation (max 2MB)
- [ ] File type validation works
- [ ] Error messages for invalid files

**Validation:**
- [ ] Research background optional works
- [ ] Expected results optional works
- [ ] File upload optional works
- [ ] Budget range numeric validation works

**Navigation:**
- [ ] "Back" button returns to step 2
- [ ] Step 1 & 2 data still populated
- [ ] "Next Step" button saves to session
- [ ] "Next Step" redirects to step 4
- [ ] File upload saved to session (if uploaded)

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 6️⃣ Multi-Step Wizard - Step 4 (Review & Submit)
**Route**: `GET /service-requests/create?step=4` → `service-requests.create` (step=4)

**Display:**
- [ ] Progress indicator shows "Step 4 of 4"
- [ ] Progress bar shows 100%
- [ ] All data from steps 1-3 displayed
- [ ] Service information shown
- [ ] Client information shown
- [ ] Sample information shown
- [ ] Research information shown
- [ ] File name shown (if uploaded)
- [ ] Edit links for each section work

**Submit:**
- [ ] "Submit Request" button creates record
- [ ] Request number generated (SR-YYYYMMDD-XXXX)
- [ ] Status set to "pending"
- [ ] User ID assigned
- [ ] Service ID assigned
- [ ] Timestamps populated
- [ ] File uploaded to storage (if provided)
- [ ] Estimated completion calculated
- [ ] Session cleared after submit

**Post-Submit:**
- [ ] Redirects to request detail page
- [ ] Success message shown
- [ ] Request number displayed
- [ ] All data saved correctly

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 7️⃣ Service Request Detail Page
**Route**: `GET /service-requests/{id}` → `service-requests.show`

**Display:**
- [ ] Page loads without errors
- [ ] Request number shown
- [ ] Status badge shown with correct color
- [ ] Priority badge shown
- [ ] Service information displayed
- [ ] Client information displayed
- [ ] Sample information displayed
- [ ] Research information displayed
- [ ] Estimated completion date shown
- [ ] Timeline shown (created, verified, approved, etc.)
- [ ] Download link for proposal document (if exists)

**Workflow Actions (based on status):**

**If status = pending:**
- [ ] "Edit" button visible (owner only)
- [ ] "Delete" button visible (owner only)
- [ ] "Verify" button visible (staff/admin only)
- [ ] "Reject" button visible (staff/admin only)

**If status = verified:**
- [ ] "Approve" button visible (admin only)
- [ ] "Reject" button visible (admin only)

**If status = approved:**
- [ ] "Assign Staff" button visible (admin only)
- [ ] Staff selection dropdown works

**If status = assigned:**
- [ ] "Start Work" button visible (assigned staff only)

**If status = in_progress:**
- [ ] "Move to Testing" button visible (assigned staff only)

**If status = testing:**
- [ ] "Complete" button visible (assigned staff only)

**Timeline:**
- [ ] Shows all workflow events
- [ ] Shows timestamps
- [ ] Shows user who performed action
- [ ] Color-coded by status
- [ ] Most recent at top

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 8️⃣ Workflow Transitions

**Test Each Workflow Transition:**

**Pending → Verified:**
- [ ] Click "Verify" button
- [ ] Confirmation modal appears
- [ ] Notes field optional
- [ ] Submit updates status
- [ ] verified_at timestamp populated
- [ ] verified_by user_id populated
- [ ] Timeline updated
- [ ] Success message shown

**Verified → Approved:**
- [ ] Click "Approve" button
- [ ] Confirmation modal appears
- [ ] Notes field optional
- [ ] Submit updates status
- [ ] approved_at timestamp populated
- [ ] approved_by user_id populated
- [ ] Timeline updated
- [ ] Success message shown

**Approved → Assigned:**
- [ ] Click "Assign Staff" button
- [ ] Staff selection dropdown shown
- [ ] Select staff member
- [ ] Submit updates status
- [ ] assigned_to user_id populated
- [ ] assigned_at timestamp populated
- [ ] assigned_by user_id populated
- [ ] Timeline updated
- [ ] Email notification sent (if configured)

**Assigned → In Progress:**
- [ ] Click "Start Work" button
- [ ] Confirmation modal appears
- [ ] Submit updates status
- [ ] started_at timestamp populated
- [ ] Timeline updated

**In Progress → Testing:**
- [ ] Click "Move to Testing" button
- [ ] Confirmation modal appears
- [ ] Notes field optional
- [ ] Submit updates status
- [ ] testing_at timestamp populated
- [ ] Timeline updated

**Testing → Completed:**
- [ ] Click "Complete" button
- [ ] Confirmation modal appears
- [ ] Results field required
- [ ] Submit updates status
- [ ] completed_at timestamp populated
- [ ] Results saved
- [ ] Timeline updated
- [ ] Success message shown

**Any → Rejected:**
- [ ] Click "Reject" button
- [ ] Confirmation modal appears
- [ ] Reason field required
- [ ] Submit updates status
- [ ] rejected_at timestamp populated
- [ ] rejected_by user_id populated
- [ ] Rejection reason saved
- [ ] Timeline updated

**Any → Cancelled:**
- [ ] Click "Cancel Request" button
- [ ] Confirmation modal appears
- [ ] Reason field required
- [ ] Submit updates status
- [ ] Cancellation reason saved
- [ ] Timeline updated

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 9️⃣ Edit Service Request
**Route**: `GET /service-requests/{id}/edit` → `service-requests.edit`

**Access Control:**
- [ ] Only owner can edit
- [ ] Only editable if status = pending
- [ ] Returns 403 if not owner
- [ ] Returns error if status ≠ pending

**Form Display:**
- [ ] All fields populated with current data
- [ ] Service dropdown shows current selection
- [ ] Priority shows current value
- [ ] Client info populated
- [ ] Sample info populated
- [ ] Research info populated
- [ ] Proposal document shown (if exists)

**Validation:**
- [ ] Same validation rules as create
- [ ] All required fields validated
- [ ] Email format validated
- [ ] Phone format validated

**Submit:**
- [ ] "Update" button saves changes
- [ ] Redirects to detail page
- [ ] Success message shown
- [ ] Data updated in database
- [ ] Timestamps not overwritten

**File Upload:**
- [ ] Can replace existing file
- [ ] Old file deleted from storage
- [ ] New file uploaded
- [ ] Can keep existing file

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 🔟 Delete Service Request
**Route**: `DELETE /service-requests/{id}` → `service-requests.destroy`

**Access Control:**
- [ ] Only owner can delete
- [ ] Only deletable if status = pending
- [ ] Returns 403 if not owner
- [ ] Returns error if status ≠ pending

**Soft Delete:**
- [ ] Confirmation modal appears
- [ ] "Delete" button soft deletes record
- [ ] deleted_at timestamp populated
- [ ] Record not visible in index
- [ ] File not deleted from storage (kept for audit)
- [ ] Success message shown
- [ ] Redirects to index

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 1️⃣1️⃣ Public Tracking Page
**Route**: `GET /tracking` → `service-requests.tracking` (NO AUTH)

**Access:**
- [ ] Accessible without login
- [ ] Page loads for guests
- [ ] No authentication redirect

**Form:**
- [ ] Request number input field
- [ ] "Track Request" button
- [ ] Simple, clean design

**Search:**
- [ ] Enter valid request number
- [ ] Submit form
- [ ] Request details displayed
- [ ] Shows: request number, title, service, status, priority, created date
- [ ] Shows timeline (public-safe information only)
- [ ] Sensitive info hidden (client email, phone, internal notes, budget)

**Invalid Search:**
- [ ] Enter invalid request number
- [ ] Submit form
- [ ] Error message shown: "Request not found"
- [ ] No database errors

**Empty Search:**
- [ ] Submit without request number
- [ ] Validation error shown
- [ ] "Request number is required"

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 1️⃣2️⃣ Auto Request Number Generation

**Test Generation:**
- [ ] Create new request
- [ ] Request number auto-generated
- [ ] Format: SR-YYYYMMDD-XXXX
- [ ] Date matches current date
- [ ] Sequential number increments
- [ ] Create 5 requests same day → SR-20251023-0001, SR-20251023-0002, etc.
- [ ] Number resets next day

**Manual Override:**
- [ ] Can manually set request number (for imports)
- [ ] Manual number not overwritten
- [ ] Unique constraint enforced

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 1️⃣3️⃣ Working Days Calculator

**Normal Priority:**
- [ ] Create request with normal priority
- [ ] Service duration: 5 days
- [ ] Estimated completion = start date + 5 working days
- [ ] Weekends excluded
- [ ] Example: Start Monday → Complete next Monday

**Urgent Priority:**
- [ ] Create request with urgent priority
- [ ] Service duration: 10 days
- [ ] 30% reduction applied → 7 days
- [ ] Estimated completion = start date + 7 working days
- [ ] Weekends excluded
- [ ] Example: Start Monday → Complete next Wednesday

**Edge Cases:**
- [ ] Start on Friday → skip weekend
- [ ] Start on Saturday → starts Monday
- [ ] Duration 1 day → completes next working day

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 1️⃣4️⃣ File Upload & Download

**Upload:**
- [ ] Select PDF file
- [ ] Upload during create (step 3)
- [ ] File saved to `storage/app/proposals/`
- [ ] Original filename preserved
- [ ] File path saved to database

**Download:**
- [ ] View request detail
- [ ] "Download Proposal" link visible
- [ ] Click link
- [ ] File downloads correctly
- [ ] Filename correct
- [ ] Content intact

**Validation:**
- [ ] Try upload .exe → rejected
- [ ] Try upload 5MB file → rejected (max 2MB)
- [ ] Try upload without file → works (optional)
- [ ] Error messages displayed

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 1️⃣5️⃣ Role-Based Access Control

**As Guest:**
- [ ] Can access tracking page only
- [ ] Cannot access index, create, show, edit
- [ ] Redirects to login

**As Regular User:**
- [ ] Can create requests
- [ ] Can view own requests only
- [ ] Can edit own pending requests only
- [ ] Can delete own pending requests only
- [ ] Cannot verify, approve, assign
- [ ] Cannot view others' requests

**As Staff:**
- [ ] Can view all requests
- [ ] Can verify pending requests
- [ ] Can start work on assigned requests
- [ ] Can move to testing
- [ ] Can complete requests
- [ ] Cannot approve requests
- [ ] Cannot assign staff

**As Admin:**
- [ ] Can view all requests
- [ ] Can verify requests
- [ ] Can approve requests
- [ ] Can assign staff
- [ ] Can reject requests
- [ ] Can perform all actions
- [ ] Can access all features

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 1️⃣6️⃣ Integration with Services Module

**Service Selection:**
- [ ] Create request
- [ ] Service dropdown populated from `services` table
- [ ] Only active services shown
- [ ] Service name displayed
- [ ] Service duration used for estimation

**Service Details:**
- [ ] Request detail shows service info
- [ ] Service name displayed
- [ ] Service category shown (if exists)
- [ ] Service duration shown

**Relationship:**
- [ ] $serviceRequest->service works
- [ ] Returns Service model
- [ ] Eager loading works
- [ ] N+1 query avoided

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 1️⃣7️⃣ Database Queries & Performance

**Index Usage:**
- [ ] Check query plan: `EXPLAIN SELECT * FROM service_requests WHERE request_number = 'SR-20251023-0001'`
- [ ] Uses index: `service_requests_request_number_index`
- [ ] Query time < 10ms

**Status Filter:**
- [ ] Check query plan: `EXPLAIN SELECT * FROM service_requests WHERE status = 'pending' ORDER BY created_at DESC`
- [ ] Uses index: `service_requests_status_created_at_index`
- [ ] Query time < 50ms

**N+1 Queries:**
- [ ] Index page uses eager loading
- [ ] `with(['user', 'service'])`
- [ ] No N+1 queries
- [ ] Check with Laravel Debugbar

**Soft Deletes:**
- [ ] Deleted records excluded by default
- [ ] `withTrashed()` includes deleted
- [ ] `onlyTrashed()` shows only deleted

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

### 1️⃣8️⃣ UI/UX Testing

**Responsive Design:**
- [ ] Desktop (1920px) → layout correct
- [ ] Laptop (1366px) → layout correct
- [ ] Tablet (768px) → layout correct
- [ ] Mobile (375px) → layout correct
- [ ] All buttons accessible
- [ ] No horizontal scroll

**Dark Mode:**
- [ ] Toggle dark mode
- [ ] All pages render correctly
- [ ] Text readable
- [ ] Badges have correct colors
- [ ] Forms styled correctly

**Loading States:**
- [ ] Submit button shows loading
- [ ] Form disabled during submit
- [ ] No double-submit possible

**Error Messages:**
- [ ] Validation errors displayed
- [ ] Clear error messages
- [ ] Field-specific errors
- [ ] Error styling correct

**Success Messages:**
- [ ] Flash messages shown
- [ ] Auto-dismiss after 5s
- [ ] Dismissible manually
- [ ] Styling consistent

**Bugs Found**: _______________
**Fixes Applied**: _______________

---

## 📊 Testing Summary

### Statistics
- **Total Test Cases**: _______________
- **Passed**: _______________
- **Failed**: _______________
- **Pass Rate**: _______________%

### Bugs Found
1. _______________
2. _______________
3. _______________
4. _______________
5. _______________

### Critical Issues
1. _______________
2. _______________

### Minor Issues
1. _______________
2. _______________

### Fixes Applied
1. _______________
2. _______________
3. _______________

---

## ✅ Final Status

**Chapter 10 Testing Status**: 🧪 IN PROGRESS

**Next Steps**:
1. _______________
2. _______________
3. _______________

**Tested By**: Claude AI
**Date Started**: 2025-10-23
**Date Completed**: _______________

---

## 📝 Notes

_______________
_______________
_______________
