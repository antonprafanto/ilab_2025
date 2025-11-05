# ⚡ QUICK REFERENCE GUIDE FOR TESTING

**Quick Reference During Testing**
**Created**: 3 November 2025
**Estimated Total Time**: 45-60 minutes

---

## 🎯 **QUICK START GUIDE**

### **Setup (5 minutes)**
```bash
1. cd C:\xampp\htdocs\ilab_v1
2. php artisan serve
3. Open http://localhost:8000
4. Test users: Verify with 'php artisan tinker'
5. Test files: Prepare PDF <2MB, PDF >5MB, .exe file
```

### **Critical Testing Flow**
```
📅 Calendar (25 min) → 👥 Workflow (20 min) → 📱 Mobile (10 min) → 📄 Files (10 min) → 🌐 Browsers (10 min)
```

---

## 🗓️ **SCENARIO 1: CALENDAR QUICK TEST (25 min)**

### **Must-Do Items:**
- [ ] **Drag to create booking** - Click+drag empty slot
- [ ] **Click existing event** - Should open modal
- [ ] **Month navigation** - Previous/Next/Today buttons
- [ ] **View switcher** - Month/Week/Day
- [ ] **Mobile test** - Resize browser to iPhone size
- [ ] **Create modal** - Form should be complete
- [ ] **Event edit/delete** - Should work correctly

### **Quick URLs:**
- Calendar: `http://localhost:8000/bookings/calendar`
- Login: `http://localhost:8000/login`

---

## 👥 **SCENARIO 2: WORKFLOW QUICK TEST (20 min)**

### **Step-by-Step Quick Guide:**

#### **1. User Submission (6 min)**
```
Login User → Services → Catalog → Pick Service → Wizard
Step 1: Title + Description → Next
Step 2: Sample count + type + description → Next
Step 3: Research info + Upload PDF → Next
Step 4: Review → Submit → SAVE REQUEST NUMBER
```

#### **2. Admin Verification (4 min)**
```
Logout → Login Admin → Service Requests → Pending Verification
Find your request → Review → Click Verify → Add notes → Confirm
Status should change to "Terverifikasi"
```

#### **3. Director Approval (4 min)**
```
Logout → Login Director → Pending Approval
Find verified request → Review → Click Approve → Add notes → Confirm
Status should change to "Disetujui"
```

#### **4. Wakil Direktur Lab Assignment (3 min)**
```
Logout → Login Wakil Direktur → Pending Lab Assignment
Find approved request → Click Assign Lab → Select lab → Assign
Status should change to "Lab Assigned"
```

#### **5. Kepala Lab Analyst Assignment (3 min)**
```
Logout → Login Kepala Lab → Lab Queue
Find lab-assigned request → Click Assign Analyst → Select analyst → Assign
Status should change to "Assigned"
```

### **🔍 After Workflow:**
```bash
# Check email notifications
tail -50 storage/logs/laravel.log | grep -i "mail"
```

---

## 📱 **SCENARIO 3: MOBILE QUICK TEST (10 min)**

### **Mobile Testing Quick Steps:**
1. **Open DevTools** (F12) → Device Mode
2. **Test Service Request Wizard** on mobile
   - Form fields touch-friendly (>44px)
   - No horizontal scroll needed
   - File upload works
3. **Test Calendar** on mobile
   - Events readable
   - Navigation works
   - Modals fit screen
4. **Test Approval Dashboards** on mobile
   - Tables scroll properly
   - Action buttons tappable

---

## 📄 **SCENARIO 4: FILE UPLOAD QUICK TEST (10 min)**

### **File Upload Quick Test:**
1. **Navigate**: Service Request → Step 3
2. **Upload valid PDF** (<2MB) → Should work
3. **Upload large file** (>5MB) → Should fail with error
4. **Upload .exe file** → Should fail with error
5. **Remove file** → Should work
6. **Re-upload different PDF** → Should work

### **Test Files Needed:**
- ✅ `valid-proposal.pdf` (<2MB)
- ✅ `invalid-large.pdf` (>5MB)
- ✅ `invalid-file.exe`

---

## 🌐 **SCENARIO 5: BROWSER QUICK TEST (10 min)**

### **Cross-Browser Quick Test:**
1. **Chrome**: Basic functionality ✓
2. **Firefox**: Login + Wizard ✓
3. **Edge**: File upload + Calendar ✓
4. **Mobile Chrome**: Touch interactions ✓

---

## ✅ **SUCCESS CRITERIA CHECKLIST**

### **🚀 Ready for Production IF:**
- [ ] **Calendar drag-create works** ✓
- [ ] **Complete workflow ends with "Assigned" status** ✓
- [ ] **File upload validation works** ✓
- [ ] **Mobile layouts are usable** ✓
- [ ] **No critical JavaScript errors** ✓
- [ ] **Email notifications in logs** ✓

### **⚠️ Minor Issues Acceptable:**
- [ ] Small UI inconsistencies
- [ ] Minor styling issues
- [ ] Non-critical JavaScript warnings

### **❌ Not Ready IF:**
- [ ] Calendar doesn't load or function
- [ ] Workflow breaks at any step
- [ ] File upload fails completely
- [ ] Critical JavaScript errors
- [ ] Mobile completely unusable

---

## 🐛 **COMMON ISSUES & QUICK FIXES**

### **Calendar Issues:**
- **Problem**: Drag doesn't work
- **Fix**: Try clicking empty cell instead
- **Check**: Browser console for JavaScript errors

### **Workflow Issues:**
- **Problem**: Can't find requests in queue
- **Fix**: Check user roles and permissions
- **Fix**: Verify request number matches

### **File Upload Issues:**
- **Problem**: Upload fails silently
- **Fix**: Check file size and type
- **Fix**: Verify upload directory permissions

### **Mobile Issues:**
- **Problem**: Horizontal scroll
- **Fix**: Check CSS responsive breakpoints
- **Fix**: Test with smaller screen size

---

## 📊 **TESTING RESULTS TEMPLATE**

### **Copy This for Your Results:**

```
📋 TESTING RESULTS - [Date]

📅 CALENDAR: [✅ PASS/❌ FAIL]
- Load: [✅/❌]
- Drag create: [✅/❌]
- Navigation: [✅/❌]
- Mobile: [✅/❌]
- Issues: [List any problems]

👥 WORKFLOW: [✅ PASS/❌ FAIL]
- User submission: [✅/❌] Request #: SR-XXXX
- Admin verify: [✅/❌]
- Director approve: [✅/❌]
- Wakil assign: [✅/❌]
- Kepala lab assign: [✅/❌]
- Email notifications: [✅/❌]
- Issues: [List any problems]

📱 MOBILE: [✅ PASS/❌ FAIL]
- Wizard responsive: [✅/❌]
- Calendar mobile: [✅/❌]
- Issues: [List any problems]

📄 FILES: [✅ PASS/❌ FAIL]
- Valid upload: [✅/❌]
- Size validation: [✅/❌]
- Type validation: [✅/❌]
- Issues: [List any problems]

🌐 BROWSERS: [✅ PASS/❌ FAIL]
- Chrome: [✅/❌]
- Firefox: [✅/❌]
- Edge: [✅/❌]
- Issues: [List any problems]

📊 OVERALL: [🚀 READY FOR PRODUCTION / ⚠️ READY WITH MINOR FIXES / ❌ NEEDS FIXES]

⏱️ TIME SPENT: ___ minutes
🔧 CRITICAL ISSUES FOUND: ___
💡 RECOMMENDATIONS: [List your recommendations]
```

---

## 🎯 **FINAL DECISION GUIDE**

### **🚀 GO PRODUCTION IF:**
- All critical tests pass
- No workflow blockage
- Mobile is usable
- File uploads work
- Less than 3 minor issues

### **⚠️ PROCEED WITH FIXES IF:**
- 1-2 minor issues
- Workarounds available
- Issues don't affect core functionality

### **❌ DELAY DEPLOYMENT IF:**
- Any workflow step fails completely
- File upload doesn't work
- Calendar completely non-functional
- Critical JavaScript errors
- Mobile completely unusable

---

## 📞 **QUICK HELP**

### **Emergency Commands:**
```bash
# Clear cache if issues
php artisan cache:clear

# Check Laravel logs
tail -f storage/logs/laravel.log

# Check user roles
php artisan tinker
> User::with('roles')->get()->each(function($u) { echo $u->name . ' - ' . $u->roles->pluck('name')->join(', ') . PHP_EOL; })
```

### **Quick Debug:**
1. **Browser Console**: F12 → Console (Check for red errors)
2. **Network Tab**: Check for failed requests
3. **Elements Tab**: Check if elements exist on page

---

*Use this summary as your quick reference during actual testing. For detailed step-by-step instructions, refer to the main COMPREHENSIVE_MANUAL_TESTING_SCRIPT.md file.*