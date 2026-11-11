# Dokumentasi TUGAS UAS PEMROGRAMAN WEB 2 - KLIKIN

Dokumentasi komprehensif ini disusun dalam format **LaTeX** (`docs/main.tex`) lengkap dengan seluruh tangkapan layar fitur sistem (`docs/images/`) sesuai instruksi pengerjaan UAS Pemrograman Web 2.

---

## 📁 Struktur Berkas Dokumentasi

```text
docs/
├── main.tex                 # Dokumen utama laporan dalam format LaTeX
├── README.md                # Panduan kompilasi dan ringkasan dokumentasi
├── take_screenshots.cjs     # Skrip otomatisasi pengambilan tangkapan layar browser
└── images/                  # Tangkapan layar resolusi tinggi seluruh fitur
    ├── 01_landing_page.png
    ├── 02_login_page.png
    ├── 03_register_page.png
    ├── 04_user_dashboard.png
    ├── 05_user_products.png
    ├── 06_user_product_create.png
    ├── 07_user_categories.png
    ├── 08_user_profile_edit.png
    ├── 09_public_profile_active.png
    ├── 10_public_profile_banned_donotcross.png
    ├── 11_master_dashboard.png
    ├── 12_master_users_panel.png
    ├── 13_master_ban_modal.png
    ├── 14_master_view_banned_profile.png
    └── 15_banned_login_attempt.png
```

---

## 🛠️ Cara Mengompilasi Dokumen LaTeX ke PDF

### Cara 1: Menggunakan Overleaf (Paling Mudah)
1. Buka [Overleaf](https://www.overleaf.com/).
2. Buat proyek baru (*New Project* $\rightarrow$ *Upload Project*).
3. Unggah seluruh isi folder `docs` (berkas `main.tex` beserta folder `images/`).
4. Klik tombol **Recompile** untuk menghasilkan dokumen PDF berkualitas tinggi.

### Cara 2: Menggunakan TeX Live / MiKTeX di Komputer Lokal
Jalankan perintah berikut di terminal pada direktori `docs`:
```bash
pdflatex main.tex
pdflatex main.tex  # Dijalankan 2 kali agar daftar isi dan referensi gambar tersinkronisasi
```

---

## 🔑 Akun Hasil Seeding untuk Pengujian

Semua akun berikut dibuat otomatis melalui `php artisan db:seed`:

| Role | Nama Pengguna | Username | Email | Password | Status |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **Master** | Master Administrator | `master` | `master@klikin.id` | `password` | **Aktif (Master Panel)** |
| **User** | Demo Creator | `demo` | `demo@example.com` | `password` | **Aktif (Creator)** |
| **User** | Budi Santoso | `budisantoso` | `budi@example.com` | `password` | **Aktif (Creator)** |
| **User** | Spammer Nakal | `violator` | `violator@example.com` | `password` | **BANNED (DO NOT CROSS)** |

---

## 🧪 Hasil Pengujian Otomatis (Automated Testing)

Pengujian dilakukan menggunakan framework **Pest PHP 5**:
```bash
php artisan test --compact
```
**Hasil:**
- **Total Tests:** 48 Passed (100%)
- **Total Assertions:** 146
- **Status:** **PASSED / GREEN**
- **Waktu Eksekusi:** ~6.09 detik

