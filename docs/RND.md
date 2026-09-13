## RND - Toko HP (Sistem Manajemen Produk)

**Judul Proyek:** Toko HP - Sistem Manajemen Produk Penjualan Telepon Genggam

**Institusi:** Politeknik Negeri Lampung

**Periode:** 2026-06-22 — 2026-06-23

### Latar Belakang

Dalam era digital saat ini, toko-toko ritel telepon genggam memerlukan sistem manajemen inventaris yang efisien untuk mengelola stok produk, informasi brand, dan detail spesifikasi HP. Sistem ini dirancang untuk memudahkan pengusaha toko HP dalam mencatat, memperbarui, dan mengelola data produk dengan antarmuka yang user-friendly.

### Rumusan Masalah

Bagaimana cara membuat sistem manajemen produk penjualan telepon genggam yang dapat menampilkan daftar produk, menambah produk baru, mengubah informasi produk, dan menghapus produk yang sudah tidak dijual dengan efisien?

### Tujuan Proyek

Membuat aplikasi web berbasis Laravel untuk mengelola data produk telepon genggam dengan fitur lengkap CRUD (Create, Read, Update, Delete) yang terintegrasi dengan sistem manajemen brand dan pencarian produk.

### Lingkup Pekerjaan

-   Membuat database dengan tabel `brands` dan `products`
-   Membuat model dan migration Laravel
-   Membuat controller dengan operasi CRUD
-   Membuat views untuk menampilkan, menambah, mengedit, dan menghapus produk
-   Implementasikan fitur pencarian, pagination, bulk delete, validasi, dan upload gambar

### Bukan Lingkup

-   Sistem autentikasi dan manajemen user
-   Sistem pembayaran dan transaksi
-   Laporan penjualan dan analytics

### Tech Stack

-   Backend: Laravel 13.8, PHP 8.3
-   Database: MySQL/SQLite (Eloquent)
-   Frontend: Blade, Bootstrap 5, Vite
-   Build: Vite + electron-builder (Electron untuk desktop wrapper)

### Struktur Folder (utama)

See repository root; project already contains `app/`, `routes/`, `resources/`, `database/`, `public/`, `main.js` (Electron entry), and build scripts in `package.json`.

### Ringkasan Hasil Pengujian

-   CRUD produk: Berfungsi
-   Pencarian & pagination: Berfungsi
-   Bulk delete: Berfungsi
-   Upload gambar: Berfungsi (perlu permission storage publik)

### Lampiran SQL (singkat)

```sql
CREATE TABLE brands (
  brand_id INT PRIMARY KEY AUTO_INCREMENT,
  brand_name VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE products (
  product_id INT PRIMARY KEY AUTO_INCREMENT,
  brand_id INT NOT NULL,
  model_name VARCHAR(150) NOT NULL,
  price DECIMAL(12,2) NOT NULL,
  image VARCHAR(255) NULL,
  stock INT DEFAULT 0 NOT NULL,
  release_year YEAR NULL,
  FOREIGN KEY (brand_id) REFERENCES brands(brand_id) ON DELETE CASCADE
);
```

---

Dokumen ini dihasilkan dari file `RND_SQL2_mahasiswa.json` dan disesuaikan dengan struktur repository saat ini.
