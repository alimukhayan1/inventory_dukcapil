# 📦 Sistem Informasi Inventaris Barang (Disdukcapil)

Aplikasi berbasis web untuk pencatatan dan pengelolaan aset barang inventaris khusus pada satu **Kantor Cabang Dinas Kependudukan dan Pencatatan Sipil (Disdukcapil)**. Aplikasi ini dibangun sebagai Minimum Viable Product (MVP) untuk keperluan Kerja Praktik (KP) dengan mengedepankan desain yang sederhana, fungsional, dan *maintainable*.

---

## 🚀 Fitur Utama

- **📊 Dashboard Eksekutif**: Ringkasan total barang, kondisi aset, nilai aset, dan tabel aktivitas mutasi terbaru.
- **🏢 Manajemen Master Data**: Pengelolaan Kategori Barang, Ruangan, dan Pegawai/Penanggung Jawab secara mandiri.
- **💻 Inventaris Aset Terpusat**: Pencatatan spesifikasi barang, tahun pengadaan, harga perolehan, dan lokasinya. Dilengkapi dengan fitur penamaan kode inventaris (*Inventory Code*) yang unik.
- **🔄 Sistem Mutasi Barang**: Pemindahan barang antar ruangan atau pergantian penanggung jawab yang berjalan secara *atomic*. Mendukung pencatatan riwayat perpindahan (*immutable*).
- **📋 Pemeriksaan Berkala**: Pengecekan kondisi barang berkala. Mendukung fitur auto-update status barang menjadi "Hilang" jika tidak ditemukan.
- **🔒 Audit Trail (Log Aktivitas)**: Seluruh riwayat operasi (Create, Update, Delete, Restore, Mutasi, Inspeksi) dicatat secara otomatis, menyediakan jejak rekam transparan bagi Administrator.
- **🗑️ Soft Deletes**: Pencegahan hilangnya data aset berharga secara tidak sengaja. Data dapat dipulihkan (*restore*) dari tong sampah (*trash*).

---

## 🛠️ Teknologi yang Digunakan

Aplikasi ini dikembangkan dengan *tech-stack* modern:
- **[PHP 8.2+](https://php.net/)**
- **[Laravel 12](https://laravel.com/)** - *Backend Web Framework*
- **[Filament v5](https://filamentphp.com/)** - *Admin Panel, Table Builder, & Form Builder*
- **[MySQL](https://www.mysql.com/)** - *Relational Database*
- **[TailwindCSS](https://tailwindcss.com/)** - *Utility-first CSS framework (Internal Filament)*

---

## ⚙️ Persyaratan Sistem (*Requirements*)

Pastikan sistem Anda (atau XAMPP Anda) memenuhi persyaratan berikut:
- PHP >= 8.2
- MySQL / MariaDB
- Composer (v2.8+)
- Node.js (v22+)
- Ekstensi PHP yang aktif di `php.ini`:
  - `pdo_mysql`
  - `intl` (Sangat penting untuk Filament)
  - `mbstring`
  - `openssl`
  - `curl`

---

## 📦 Panduan Instalasi & Menjalankan Aplikasi

Langkah-langkah untuk menjalankan project ini di komputer lokal (Windows/Mac/Linux):

1. **Clone repositori ini** (Jika belum)
   ```bash
   git clone https://github.com/alimukhayan1/inventory_dukcapil.git
   cd inventory_dukcapil
   ```

2. **Install Dependensi PHP & Node**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Konfigurasi Environment**
   Gandakan file konfigurasi lokal Anda:
   ```bash
   cp .env.example .env
   ```
   Buka file `.env`, lalu pastikan koneksi database Anda benar:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=inventory_app
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   *(Catatan: Buat database kosong bernama `inventory_app` di phpMyAdmin / MySQL CLI)*

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi Database & Data Awal (Seeder)**
   Proses ini akan membangun struktur tabel sekaligus mengisi data *dummy* awal agar bisa langsung digunakan.
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Jalankan Development Server**
   ```bash
   php artisan serve
   ```

Aplikasi kini dapat diakses melalui browser Anda di:
👉 **[http://localhost:8000/admin](http://localhost:8000/admin)**

---

## 🔑 Hak Akses & Akun Demo

Aplikasi menggunakan sistem autentikasi sederhana dari Filament dengan dua *Role* (Peran) Enum:
1. **Administrator**: Memiliki akses penuh ke seluruh menu, termasuk Log Aktivitas sistem dan manajemen pengguna.
2. **Petugas**: Dapat mengelola barang, mutasi, dan master data dasar, namun tidak dapat melihat log rahasia atau mengatur akun pengguna lain.

Jika Anda telah menjalankan *Seeder* pada langkah di atas, Anda dapat login menggunakan kredensial demo berikut:

| Role | Email | Password |
|------|-------|----------|
| **Admin** | `admin@example.com` | `password` |
| **Petugas**| `petugas@example.com` | `password` |

---

## 📂 Struktur Penting Aplikasi

Kode inti atau *Business Logic* aplikasi dapat Anda telusuri di beberapa direktori utama berikut:

- `app/Filament/Resources/` -> Berisi semua antarmuka Admin (Form, Table, Action).
- `app/Models/` -> Skema dan Relasi *Eloquent ORM*.
- `app/Services/` -> Lapisan logika bisnis (Transaksi DB, Pencatatan Log, Mutasi Atomic).
- `app/Policies/` -> Gerbang Autorisasi & Keamanan per Modul (Misal: Hanya Admin yang bisa buka Log).
- `app/Enums/` -> Konstanta sistem (Role, Kondisi Barang, Status Barang).
- `database/migrations/` -> Definisi Skema Database (*ERD source of truth*).

---

## 📝 Lisensi

Aplikasi ini dikembangkan murni untuk studi kasus dan laporan **Kerja Praktik**. Dapat digunakan, didistribusikan, maupun dimodifikasi untuk tujuan pembelajaran.
