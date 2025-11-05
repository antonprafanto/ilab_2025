# 📦 FILE & FOLDER UNTUK UPLOAD KE HOSTING

## ✅ WAJIB UPLOAD (Drag & Drop ini saja!)

```
📁 FOLDER WAJIB:
├── app/                    ✅ Upload seluruh folder
├── bootstrap/              ✅ Upload seluruh folder
├── config/                 ✅ Upload seluruh folder
├── database/               ✅ Upload seluruh folder
├── public/                 ✅ Upload seluruh folder (PENTING!)
├── resources/              ✅ Upload seluruh folder
├── routes/                 ✅ Upload seluruh folder
└── storage/                ✅ Upload struktur folder (lihat catatan di bawah)

📄 FILE WAJIB di ROOT:
├── .htaccess               ✅ Upload
├── artisan                 ✅ Upload
├── composer.json           ✅ Upload
├── composer.lock           ✅ Upload
├── deploy.sh               ✅ Upload
├── package.json            ✅ Upload
├── package-lock.json       ✅ Upload
├── postcss.config.js       ✅ Upload
├── README.md               ✅ Upload
├── tailwind.config.js      ✅ Upload
└── vite.config.js          ✅ Upload
```

### ⚠️ CATATAN PENTING untuk `storage/`:

**HANYA upload struktur folder, KOSONGKAN isinya:**

```
storage/
├── app/
│   ├── private/
│   │   └── .gitignore      ✅ Upload file ini saja
│   ├── public/
│   │   └── .gitignore      ✅ Upload file ini saja
│   └── .gitignore          ✅ Upload file ini saja
├── framework/
│   ├── cache/
│   │   ├── data/
│   │   │   └── .gitignore  ✅ Upload file ini saja
│   │   └── .gitignore      ✅ Upload file ini saja
│   ├── sessions/
│   │   └── .gitignore      ✅ Upload file ini saja
│   ├── testing/
│   │   └── .gitignore      ✅ Upload file ini saja
│   └── views/
│       └── .gitignore      ✅ Upload file ini saja
└── logs/
    └── .gitignore          ✅ Upload file ini saja

❌ JANGAN upload:
- storage/logs/*.log
- storage/framework/cache/*
- storage/framework/sessions/*
- storage/framework/views/*
```

**Cara mudah:** Kosongkan isi folder storage dulu sebelum upload!

---

## ❌ JANGAN UPLOAD INI!

```
📁 FOLDER JANGAN UPLOAD:
├── node_modules/           ❌ Terlalu besar (~300 MB)
├── vendor/                 ❌ Install via composer di server
├── .git/                   ❌ Git history
├── .vscode/                ❌ Editor config
├── .idea/                  ❌ Editor config
├── .claude/                ❌ Claude config
├── _docs/                  ⚠️  Optional (dokumentasi)
├── docs/                   ⚠️  Optional (dokumentasi)
├── tasks/                  ⚠️  Optional (task management)
└── tests/                  ⚠️  Optional (unit tests)

📄 FILE JANGAN UPLOAD:
├── .env                    ❌ JANGAN! Buat baru di server
├── .env.backup             ❌ JANGAN!
├── .phpunit.result.cache   ❌ Test cache
└── phpunit.xml             ⚠️  Optional (hanya untuk testing)
```

---

## 📊 TOTAL SIZE UPLOAD

- **Total yang diupload:** ~10-15 MB
- **Upload time:** 5-10 menit (tergantung koneksi)

---

## 🚀 CARA UPLOAD (Paling Mudah!)

### Menggunakan WinSCP:

1. **Connect ke Server:**
   - Host: `ilab.unmul.ac.id`
   - Port: `22`
   - Username: `ilab`
   - Password: `yG2cSqEwGWIKumX`

2. **Buat Folder di Server:**
   ```
   /home/ilab/laravel/    ← Buat folder ini
   ```

3. **Kosongkan Storage (PENTING!):**
   Di lokal, hapus dulu isi storage sebelum upload:
   - Hapus semua file `.log` di `storage/logs/`
   - Hapus semua file di `storage/framework/cache/data/`
   - Hapus semua file di `storage/framework/sessions/`
   - Hapus semua file di `storage/framework/views/`
   - **JANGAN hapus folder dan file `.gitignore`**

4. **Upload via Drag & Drop:**

   **Kiri (Lokal) → Kanan (Server)**

   Select & drag folder-folder ini:
   ```
   ✅ app/
   ✅ bootstrap/
   ✅ config/
   ✅ database/
   ✅ public/
   ✅ resources/
   ✅ routes/
   ✅ storage/         (sudah dikosongkan isinya)
   ```

   Kemudian select & drag file-file ini:
   ```
   ✅ .htaccess
   ✅ artisan
   ✅ composer.json
   ✅ composer.lock
   ✅ deploy.sh
   ✅ package.json
   ✅ package-lock.json
   ✅ postcss.config.js
   ✅ README.md
   ✅ tailwind.config.js
   ✅ vite.config.js
   ```

5. **Tunggu Upload Selesai** (~5-10 menit)

---

## ✅ CHECKLIST SETELAH UPLOAD

- [ ] Semua folder Laravel ada di server
- [ ] File `public/build/` ada (hasil npm run build)
- [ ] File `public/.htaccess` ada
- [ ] File `public/index.php` ada
- [ ] Folder `storage/` ada dengan struktur lengkap
- [ ] File `.htaccess` di root ada
- [ ] File `artisan` ada
- [ ] File `composer.json` dan `composer.lock` ada

---

## 📝 LANGKAH SELANJUTNYA

Setelah upload selesai, lihat panduan:

👉 **[_docs/DEPLOYMENT_UNMUL.md](_docs/DEPLOYMENT_UNMUL.md)**

Untuk:
1. Buat file `.env` di server
2. Install composer dependencies
3. Generate APP_KEY
4. Run migrations
5. Set permissions
6. Test website

---

**SELESAI!** File sudah terorganisir dengan baik.

Dokumentasi lengkap ada di folder **`_docs/`** (tidak wajib diupload).
