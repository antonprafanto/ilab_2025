# 📋 TESTING CHECKLIST & RESULT TEMPLATES

**For Structured Testing and Documentation**
**Created**: 3 November 2025
**Estimated Total Time**: 30-45 minutes

---

## 🚀 **QUICK START (5 minutes)**

```bash
# 1. Start server
cd C:\xampp\htdocs\ilab_v1
php artisan serve

# 2. Open browser
http://localhost:8000

# 3. Test users needed:
- Regular User: [email]
- Admin: [email]
- Direktur: [email]
- Wakil Direktur: [email]
- Kepala Lab: [email]

# 4. Test files:
- PDF: C:\temp\test-files\proposal.pdf (max 2MB)
```

---

## 🗓️ **SCENARIO 1: CALENDAR (15 min)**

### **Quick Test Path:**
```
Login User → Bookings → Calendar → Test Drag Create → Test Click Events → Test Mobile View
```

**Checklist:**
- [ ] Drag calendar to create booking ✅
- [ ] Click event to view/edit ✅
- [ ] Month/week/day switch ✅
- [ ] Mobile responsive (resize browser) ✅

**Critical URL:** `http://localhost:8000/bookings/calendar`

---

## 👥 **SCENARIO 2: MULTI-USER WORKFLOW (20 min)**

### **Workflow Path:**
```
User Submit → Admin Verify → Director Approve → Wakil Direktur Assign Lab → Kepala Lab Assign Analyst
```

**Critical URLs:**
- User: `http://localhost:8000/service-requests/create`
- Admin: `http://localhost:8000/service-requests/pending-verification`
- Direktur: `http://localhost:8000/service-requests/pending-approval`
- Wakil Direktur: `http://localhost:8000/service-requests/pending-lab-assignment`
- Kepala Lab: `http://localhost:8000/service-requests/lab-queue`

**Key Tests:**
- [ ] Complete 4-step wizard ✅
- [ ] Upload PDF proposal ✅
- [ ] Save request number (SR-XXXX) ✅
- [ ] Each role approval step ✅
- [ ] Final analyst assignment ✅

---

## 📱 **SCENARIO 3: MOBILE (10 min)**

### **Quick Mobile Test:**
```
F12 → Device Mode → Test 3 key pages
```

**Pages to Test:**
1. **Service Request Form**: Mobile layout ✅
2. **Calendar**: Touch interactions ✅
3. **Approval Dashboard**: Table scroll ✅

**Devices:**
- iPhone 12 (390x844)
- iPad Air (820x1180)
- Samsung Galaxy (360x640)

---

## 📄 **SCENARIO 4: FILE UPLOAD (5 min)**

### **Quick Upload Test:**
```
Service Request → Step 3 → Upload PDF
```

**Tests:**
- [ ] Valid PDF uploads ✅
- [ ] File size validation ✅
- [ ] File type validation ✅
- [ ] Remove file option ✅

---

## 📋 **FINAL CHECKLIST (5 min)**

### **Production Ready Check:**
- [ ] All scenarios completed ✅
- [ ] No critical errors ✅
- [ ] Email notifications working ✅
- [ ] Mobile experience acceptable ✅

### **Email Log Check:**
```bash
# Check email notifications were sent
tail -f storage/logs/laravel.log | grep -i "mail"
```

---

## 🆘 **TROUBLESHOOTING**

### **Common Issues & Fixes:**

| Issue | Solution |
|-------|----------|
| **Calendar not loading** | Check browser console for JavaScript errors |
| **File upload fails** | Verify PDF < 5MB and correct format |
| **Login fails** | Use Super Admin for all roles in testing |
| **Routes not found** | Run `php artisan route:cache` |
| **Email not sending** | Check MAIL_MAILER=log in .env |

### **Quick Commands:**
```bash
# Cache routes
php artisan route:cache

# Clear cache if needed
php artisan cache:clear

# Check users
php artisan tinker
> User::pluck('name', 'email')
```

---

## 📊 **RESULTS TEMPLATE**

```
✅ CALENDAR: [All/Some/None] working
✅ WORKFLOW: [Complete/Partial/Failed]
✅ MOBILE: [Responsive/Issues]
✅ UPLOAD: [Working/Failed]
✅ EMAILS: [Sent/Failed]

OVERALL: [READY FOR PRODUCTION / NEEDS FIXES]
```

---

## 🎯 **SUCCESS CRITERIA**

**Ready for Production IF:**
- ✅ Calendar creates and displays events
- ✅ Complete workflow steps work
- ✅ Mobile layouts are usable
- ✅ File uploads work correctly
- ✅ No critical JavaScript errors
- ✅ All roles can perform their tasks

---

## 📞 **NEED HELP?**

**Common Issues:**
- User account problems → Use Super Admin account
- Calendar errors → Refresh page, check console
- File upload fails → Check file size/type
- Role access → Check permissions in database

**Quick Debug:**
```bash
# Check Laravel logs
tail storage/logs/laravel.log

# Check specific error
grep "error" storage/logs/laravel.log
```

---

*Last Updated: 3 November 2025*
*For detailed steps, see: MANUAL_TESTING_GUIDE_PHASE_3.md*