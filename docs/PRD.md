# PRD — Sistem Informasi Inventaris Barang
## Kantor Cabang Disdukcapil

**Version:** 1.0  
**Status:** Final MVP  
**Target:** Kerja Praktik Mahasiswa

---

# 1. Product Overview

## 1.1 Nama Produk

Sistem Informasi Inventaris Barang Kantor Cabang Disdukcapil.

## 1.2 Deskripsi

Sistem berbasis web yang digunakan untuk membantu pengelolaan inventaris barang pada satu kantor cabang Dinas Kependudukan dan Pencatatan Sipil.

Sistem digunakan untuk mencatat:

- Data barang inventaris.
- Kategori barang.
- Ruangan/lokasi barang.
- Pegawai penanggung jawab.
- Kondisi barang.
- Status barang.
- Riwayat perpindahan barang.
- Riwayat pemeriksaan barang.
- Aktivitas pengguna.

Sistem hanya mencakup **satu kantor cabang**.

Sistem tidak dirancang untuk mengelola banyak kantor cabang atau kantor pusat.

---

# 2. Background

Pengelolaan inventaris pada kantor pemerintahan membutuhkan pencatatan barang yang terstruktur agar keberadaan dan kondisi barang dapat diketahui dengan mudah.

Barang yang dapat dikelola antara lain:

- Komputer.
- Laptop.
- Printer.
- Scanner.
- Monitor.
- Meja.
- Kursi.
- Lemari.
- Peralatan jaringan.
- Peralatan elektronik.
- Peralatan kantor lainnya.

Pencatatan inventaris yang dilakukan secara manual dapat menimbulkan beberapa masalah:

- Data barang sulit dicari.
- Lokasi barang tidak selalu diperbarui.
- Penanggung jawab barang sulit diketahui.
- Riwayat perpindahan barang tidak terdokumentasi.
- Kondisi fisik barang sulit dipantau.
- Pemeriksaan inventaris membutuhkan waktu.
- Riwayat aktivitas pengguna sulit ditelusuri.

Sistem ini dibuat untuk menyediakan satu sumber data inventaris yang terpusat pada satu kantor cabang.

---

# 3. Problem Statement

Sistem harus menyelesaikan masalah berikut:

1. Bagaimana menyimpan data inventaris secara terstruktur?
2. Bagaimana mengetahui lokasi barang?
3. Bagaimana mengetahui penanggung jawab barang?
4. Bagaimana mengetahui kondisi terkini barang?
5. Bagaimana mencatat perpindahan barang?
6. Bagaimana mencatat hasil pemeriksaan fisik?
7. Bagaimana mengetahui aktivitas pengguna?
8. Bagaimana menampilkan ringkasan kondisi inventaris?

---

# 4. Goals

## 4.1 Primary Goals

Sistem harus:

1. Memusatkan data inventaris.
2. Mempermudah pencarian barang.
3. Menampilkan lokasi barang.
4. Menampilkan penanggung jawab barang.
5. Menampilkan kondisi barang.
6. Mencatat riwayat mutasi.
7. Mencatat riwayat pemeriksaan.
8. Menyediakan dashboard inventaris.
9. Mencatat aktivitas penting pengguna.
10. Menyediakan laporan inventaris.

---

# 5. Scope

## 5.1 In Scope

### Authentication

- Login.
- Logout.
- Session management.

### User Management

- Data pengguna.
- Role pengguna.
- Status aktif pengguna.

### Master Data

- Kategori barang.
- Ruangan.
- Pegawai.

### Inventory

- Data barang.
- Kode inventaris.
- Nomor seri.
- Merk.
- Model.
- Tahun perolehan.
- Harga perolehan.
- Lokasi.
- Penanggung jawab.
- Kondisi.
- Status.

### Mutation

- Mutasi lokasi.
- Mutasi penanggung jawab.
- Mutasi lokasi dan penanggung jawab.
- Riwayat mutasi.

### Inspection

- Pemeriksaan barang.
- Status ditemukan.
- Kondisi aktual.
- Catatan pemeriksaan.
- Riwayat pemeriksaan.

### Dashboard

- Total barang.
- Barang aktif.
- Barang tidak aktif.
- Barang dalam perbaikan.
- Barang berdasarkan kondisi.
- Barang berdasarkan kategori.
- Aktivitas terbaru.

### Reporting

- Laporan inventaris.
- Laporan mutasi.
- Laporan pemeriksaan.

### Audit

- Activity log untuk aktivitas penting.

---

# 6. Out of Scope

Fitur berikut tidak termasuk MVP:

- Multi-cabang.
- Kantor pusat.
- Pengadaan barang.
- Vendor/supplier.
- Pembelian barang.
- Manajemen anggaran.
- Akuntansi.
- Penyusutan aset.
- Sistem keuangan.
- Peminjaman barang.
- Stok barang habis pakai.
- QR Code.
- Barcode scanner.
- RFID.
- Mobile application.
- Integrasi WhatsApp.
- Integrasi SMS.
- Integrasi sistem pemerintahan eksternal.
- Approval workflow bertingkat.

---

# 7. User Roles

Sistem memiliki dua role utama:

```text
admin
petugas