# 🔄 Role Mapping: SK Rektor → Sistem iLab UNMUL

**Dokumen Mapping Struktur Organisasi ke User Roles**

---

## 📋 Overview

Dokumen ini menjelaskan mapping antara struktur organisasi resmi di **SK Rektor No. 2846/UN17/HK.02.03/2025** dengan **User Roles di Sistem iLab UNMUL**.

### Tujuan Mapping:
1. ✅ Memastikan role sistem sesuai dengan struktur organisasi resmi
2. ✅ Mempermudah assignment user berdasarkan posisi di SK
3. ✅ Memberikan clarity untuk permission & access control
4. ✅ Dokumentasi untuk future development (Fase 4+)

---

## 🎯 Prinsip Mapping

### **1. Interpretasi "Kepala Lab"**
- **Di SK:** Kepala Kelompok Fungsional (8 orang)
- **Di Sistem:** Role "Kepala Lab"
- **Rasional:** Setiap kelompok fungsional beroperasi seperti lab spesifik dengan bidang riset tertentu

### **2. Interpretasi "Anggota Lab"**
- **Di SK:** Anggota Kelompok Fungsional (24 orang, 3 per kelompok)
- **Di Sistem:** Role "Anggota Lab" atau "Analis"
- **Rasional:** Mereka adalah researcher/analyst yang melakukan eksekusi penelitian

### **3. Simplified Roles untuk User Experience**
- Sistem menggunakan 11 roles yang lebih simple untuk kemudahan user
- SK memiliki struktur lebih kompleks (31 orang dengan berbagai posisi)
- Mapping dibuat fleksibel untuk accommodate keduanya

---

## 📊 MAPPING TABLE LENGKAP

### **A. Staff Internal Unit (Berdasarkan SK)**

| No | Posisi di SK Rektor | Role di Sistem iLab | Jumlah | Nama (contoh dari SK) | Permissions Utama |
|----|---------------------|---------------------|--------|----------------------|-------------------|
| 1 | **Pelindung** | Super Admin / Wadir Pelayanan | 1 | Prof. Dr. Ir. H. Abdunnur (Rektor) | View all, monitoring strategis |
| 2 | **Pengarah** | Wakil Direktur Pelayanan | 1 | Prof. Dr. Lambang Subagiyo, M.Si | Service oversight, approve requests |
| 3 | **Penanggung Jawab** | Wakil Direktur PM & TI | 1 | apt. Fajar Prasetya, M.Si., Ph.D | Equipment & quality oversight |
| 4 | **Kepala Unit** | Super Admin | 1 | Dr. apt. Angga Cipta Narsa, M.Si. | Full system access, final approval |
| 5 | **Kepala KK Teknis** | Kepala Lab (fungsional) | 1 | Hamdhani, S.P., M.Sc., Ph.D. | Technical coordination |
| 6 | **Kepala KK Pelayanan** | Wakil Direktur PM & TI | 1 | Dr. Chairul Saleh, M.Si. | Service quality & IT |
| 7 | **Kepala KK Admin** | Sub Bagian TU & Keuangan | 1 | Dr. Nurul Puspita Palupi, S.P., M.Si. | Admin & finance (Fase 4) |

### **B. Kelompok Fungsional → "Labs" di Sistem**

| No | Kelompok Fungsional (SK) | Nama "Lab" di Sistem | Kepala (Role: Kepala Lab) | Anggota (Role: Anggota Lab) |
|----|--------------------------|----------------------|---------------------------|----------------------------|
| 1 | **Natural Product** | Lab Produk Alami | Sabaniah Indjar Gama, M.Si. | 2 anggota (Dr. Vina, Alhawaris) |
| 2 | **Advanced Instrument** | Lab Instrumentasi Canggih | Rafitah Hasanah, S.Pi., M.Si., Ph.D. | 2 anggota (Dr. Pintaka, Moh. Syaiful) |
| 3 | **Environmental** | Lab Lingkungan | Atin Nuryadin, S.Pd., M.Si., Ph.D. | 2 anggota (Indah, Dr. Noor) |
| 4 | **Agriculture & Animal Husbandry** | Lab Pertanian & Peternakan | Prof. Dr. Ir. Taufan P.D., M.P. | 2 anggota (Kadis, Roro) |
| 5 | **Oceanography & Engineering** | Lab Oseanografi & Teknik | Nanda Khoirunisa, S.Pd., M.Sc. | 2 anggota (Anugrah, Irwan) |
| 6 | **Social Innovation** | Lab Inovasi Sosial | Etik Sulistiowati N., S.P., M.Si., Ph.D. | 2 anggota (Rahmawati, Kheyene) |
| 7 | **E-commerce & IT Business** | Lab Digital & IT Business | Hario Jati Setyadi, S.Kom., M.Kom. | 2 anggota (**Anton Prafanto**, Ellen) |
| 8 | **Biotechnology** | Lab Bioteknologi | Dr. rer. nat. Bodhi Dharma, M.Si. | 2 anggota (Dr. Dian, Muhammad Fauzi) |

**Total:** 8 Kepala Lab + 24 Anggota Lab = **32 orang staff peneliti**

### **C. Pengguna Layanan (Eksternal)**

| No | Kategori User | Role di Sistem | Estimasi Jumlah | Karakteristik |
|----|---------------|----------------|-----------------|---------------|
| 1 | Dosen UNMUL | Dosen | ~100-200 | Internal, subsidi/gratis |
| 2 | Mahasiswa UNMUL | Mahasiswa | ~1000-2000 | Internal, gratis untuk TA |
| 3 | Peneliti dari Universitas Lain | Peneliti Eksternal | Variabel | Eksternal, tarif khusus |
| 4 | Industri & Perusahaan | Industri/Umum | Variabel | Komersial, tarif penuh |

---

## 🔑 Permission Mapping

### **1. Super Admin (Kepala Unit)**
**Posisi SK:** Dr. apt. Angga Cipta Narsa, M.Si. (Kepala Unit)

**Permissions:**
- ✅ ALL Permissions (full system access)
- ✅ User management (create, edit, delete, assign roles)
- ✅ Final approval untuk request strategis
- ✅ System settings & configuration
- ✅ View audit logs & reports

**Jumlah:** 1-2 orang (Kepala Unit + IT Support jika ada)

---

### **2. Wakil Direktur Pelayanan**
**Posisi SK:** Prof. Dr. Lambang Subagiyo, M.Si. (Pengarah)

**Permissions:**
- ✅ view-dashboard
- ✅ view-all-requests
- ✅ approve-requests (untuk request strategis/besar)
- ✅ view-test-results
- ✅ view-activity-reports, view-usage-reports, view-revenue-reports
- ✅ export-reports

**Jumlah:** 1 orang

---

### **3. Wakil Direktur PM & TI**
**Posisi SK:**
- apt. Fajar Prasetya (Penanggung Jawab)
- Dr. Chairul Saleh (Kepala KK Pelayanan & TI)

**Permissions:**
- ✅ view-dashboard
- ✅ view-equipment, manage-equipment-maintenance
- ✅ view-sop, create-sop, edit-sop, delete-sop, approve-sop
- ✅ view-calibrations, create-calibrations, approve-calibrations
- ✅ manage-settings
- ✅ view-audit-logs

**Jumlah:** 1-2 orang

---

### **4. Kepala Lab (Kepala Kelompok Fungsional)**
**Posisi SK:** 8 Kepala Kelompok Fungsional

**Permissions:**
- ✅ view-dashboard
- ✅ view-all-requests (filter by lab mereka)
- ✅ approve-requests
- ✅ assign-analyst (ke anggota kelompok mereka)
- ✅ view-equipment, view-sop, create-sop, edit-sop
- ✅ view-test-results, approve-test-results
- ✅ view-activity-reports, view-usage-reports, export-reports

**Contoh:**
1. Sabaniah Indjar Gama → Kepala Lab Produk Alami
2. Rafitah Hasanah → Kepala Lab Instrumentasi
3. Atin Nuryadin → Kepala Lab Lingkungan
4. Prof. Taufan → Kepala Lab Pertanian
5. Nanda Khoirunisa → Kepala Lab Oseanografi
6. Etik Sulistiowati → Kepala Lab Inovasi Sosial
7. Hario Jati Setyadi → Kepala Lab Digital & IT
8. Dr. Bodhi Dharma → Kepala Lab Bioteknologi

**Jumlah:** 8 orang

---

### **5. Anggota Lab / Analis (Anggota Kelompok Fungsional)**
**Posisi SK:** 24 Anggota Kelompok Fungsional (3 per kelompok)

**Permissions:**
- ✅ view-dashboard
- ✅ view-all-requests (yang assigned ke mereka)
- ✅ update-request-status
- ✅ input-test-results (Fase 4)
- ✅ view-test-results
- ✅ export-test-results
- ✅ view-sop

**Contoh dari Kelompok E-commerce & IT:**
1. Hario Jati Setyadi (Kepala)
2. **Anton Prafanto, S.Kom., M.T.** (Anggota - Developer iLab)
3. Ellen D. Oktanti Irianto (Anggota)

**Jumlah:** 24 orang (8 kelompok × 3 anggota)

---

### **6. Laboran / Teknisi**
**Posisi SK:** Staff teknis (tidak eksplisit di SK, tapi dibutuhkan)

**Permissions:**
- ✅ view-dashboard
- ✅ view-equipment, edit-equipment
- ✅ manage-equipment-maintenance
- ✅ view-all-requests (untuk prepare equipment)
- ✅ view-sop

**Jumlah:** 2-4 orang (teknisi equipment)

---

### **7. Sub Bagian TU & Keuangan**
**Posisi SK:** Dr. Nurul Puspita Palupi (Kepala KK Admin & Umum)

**Permissions (Fase 4):**
- ✅ view-dashboard
- ✅ view-invoices, create-invoices, edit-invoices
- ✅ manage-payments
- ✅ view-financial-reports
- ✅ export-reports

**Jumlah:** 1-2 orang

---

### **8. Dosen**
**Posisi SK:** Pengguna Layanan (Internal UNMUL)

**Permissions:**
- ✅ view-dashboard
- ✅ view-own-requests, create-requests
- ✅ view-test-results (own), export-test-results
- ✅ view-invoices (own)

---

### **9. Mahasiswa**
**Posisi SK:** Pengguna Layanan (Internal UNMUL)

**Permissions:**
- ✅ view-dashboard
- ✅ view-own-requests, create-requests
- ✅ view-test-results (own)

---

### **10. Peneliti Eksternal**
**Posisi SK:** Pengguna Layanan (Eksternal)

**Permissions:**
- ✅ view-dashboard
- ✅ view-own-requests, create-requests
- ✅ view-test-results (own), export-test-results
- ✅ view-invoices (own)

---

### **11. Industri / Umum**
**Posisi SK:** Pengguna Layanan (Komersial)

**Permissions:**
- ✅ view-dashboard
- ✅ view-own-requests, create-requests
- ✅ view-test-results (own)
- ✅ view-invoices (own)

---

## 🔄 Workflow Assignment Berdasarkan SK

### **Scenario 1: Permohonan Analisis Produk Alami**

1. **User** (Dosen/Mahasiswa) → Submit request untuk "Analisis Proksimat"
2. **System** → Auto-assign ke Lab yang sesuai (Lab Produk Alami)
3. **Kepala Lab Produk Alami** (Sabaniah Indjar Gama) → Review & Approve
4. **Kepala Lab** → Assign ke salah satu anggota:
   - Dr. apt. Vina Maulidya, M.Farm., ATAU
   - Alhawaris, S.Si., M.Kes.
5. **Anggota Lab** → Update status "In Progress" → Lakukan analisis
6. **Anggota Lab** → Input hasil (Fase 4)
7. **Kepala Lab** → Approve hasil
8. **User** → Download hasil

---

### **Scenario 2: Equipment Maintenance**

1. **Laboran** → Deteksi equipment perlu maintenance
2. **Laboran** → Update status equipment jadi "Maintenance"
3. **Laboran** → Create maintenance record
4. **Wadir PM & TI** (Dr. Chairul Saleh) → Review maintenance schedule
5. **Laboran** → Lakukan maintenance
6. **Laboran** → Update status equipment kembali "Available"

---

## 📝 Notes untuk Developer

### **Database Implementation:**

```php
// Seeder: PermissionSeeder.php
// Sudah ada 11 roles dengan permissions yang sesuai

// User assignment example:
$user = User::find($userId);
$user->assignRole('Kepala Lab'); // Untuk 8 Kepala Kelompok Fungsional
$user->assignRole('Anggota Lab'); // Untuk 24 Anggota Kelompok
```

### **Future Development (Fase 4):**

Pertimbangkan menambah role lebih spesifik:
- `Pelindung` (Rektor)
- `Pengarah`
- `Penanggung Jawab`
- `Kepala Unit`
- `Kepala Kelompok Kerja`
- `Kepala Kelompok Fungsional` (rename dari "Kepala Lab")
- `Anggota Kelompok Fungsional` (rename dari "Anggota Lab")

**Tapi untuk Fase 3, 11 roles saat ini SUDAH CUKUP dan SESUAI dengan struktur SK.**

---

## ✅ Validasi Mapping

### **Checklist:**

- [x] Semua 31 orang di SK ter-mapping ke role sistem
- [x] Permissions sesuai dengan tanggung jawab di SK
- [x] "Kepala Lab" = "Kepala Kelompok Fungsional" (8 orang)
- [x] "Anggota Lab" = "Anggota Kelompok Fungsional" (24 orang)
- [x] Pengguna eksternal (Dosen, Mahasiswa, dll) sudah jelas rolenya
- [x] Workflow request → approval → assignment → execution ter-cover
- [x] Dokumentasi lengkap untuk future reference

---

## 📞 Kontak

**Developer:** Anton Prafanto, S.Kom., M.T.
- **Posisi di SK:** Anggota Kelompok Fungsional E-commerce & IT Business
- **Role di Sistem:** Anggota Lab (Developer iLab)
- **Email:** antonprafanto@unmul.ac.id
- **WhatsApp:** 0811553393

**Kepala Unit:** Dr. apt. Angga Cipta Narsa, M.Si.
- **Posisi di SK:** Kepala Unit Penunjang Akademik Laboratorium Terpadu
- **Role di Sistem:** Super Admin

---

**© 2025 Unit Penunjang Akademik Laboratorium Terpadu**
**Universitas Mulawarman**

**Berdasarkan SK Rektor No. 2846/UN17/HK.02.03/2025**
**Dokumentasi Version**: 1.0
**Last Update**: Januari 2025
