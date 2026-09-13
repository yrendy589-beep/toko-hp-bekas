## Laporan Proyek Web Toko HP

**Judul:** Toko HP - Sistem Informasi Penjualan dan Pengelolaan Produk

**Institusi:** Politeknik Negeri Lampung

**Periode:** 2026

### 1. Latar Belakang

Toko telepon genggam membutuhkan sistem yang dapat membantu pengelolaan produk, stok, customer, dan pesanan secara terpusat. Pencatatan manual dapat menyebabkan data produk sulit diperbarui, stok tidak akurat, dan proses verifikasi pesanan menjadi lebih lambat.

Website Toko HP dibuat sebagai aplikasi penjualan dan manajemen produk berbasis web. Aplikasi ini menyediakan halaman katalog untuk customer serta dashboard admin untuk mengelola produk dan memproses pesanan.

### 2. Rumusan Masalah

Bagaimana membangun website toko HP yang dapat mengelola katalog produk, menyediakan autentikasi admin dan customer, memproses pesanan, serta membantu admin memverifikasi transaksi dengan alur yang sederhana?

### 3. Tujuan

1. Membuat katalog produk HP yang mudah dicari dan dilihat.
2. Menyediakan fitur CRUD produk bagi admin.
3. Menyediakan registrasi dan login berdasarkan peran pengguna.
4. Memungkinkan customer membuat pesanan dan mengunggah bukti pembayaran.
5. Memungkinkan admin melihat serta memverifikasi pesanan customer.

### 4. Manfaat

-   Admin dapat memperbarui data produk, harga, stok, brand, dan gambar.
-   Customer dapat melihat katalog dan melakukan pembelian dari website.
-   Data pesanan tersimpan dalam database sehingga lebih mudah dilacak.
-   Proses verifikasi pesanan menjadi lebih terstruktur.

### 5. Ruang Lingkup Sistem

#### Admin

-   Login sebagai admin.
-   Melihat dashboard dan daftar pesanan.
-   Menambah, melihat, mengubah, dan menghapus produk.
-   Menghapus beberapa produk sekaligus.
-   Mencari produk berdasarkan brand atau model.
-   Memverifikasi pesanan dan bukti pembayaran.

#### Customer

-   Registrasi dan login sebagai customer.
-   Melihat katalog serta detail produk.
-   Memilih produk dan membuat pesanan.
-   Memilih metode pembayaran cash atau transfer.
-   Mengunggah bukti pembayaran.
-   Melihat daftar dan detail pesanan sendiri.

### 6. Teknologi yang Digunakan

-   Backend: Laravel 13.8 dan PHP 8.3.
-   Database: MySQL atau SQLite melalui Eloquent ORM.
-   Frontend: Blade Template dan Bootstrap 5.
-   Asset bundling: Vite.
-   Desktop wrapper: Electron.
-   Dependency manager: Composer dan npm.

### 7. Struktur Data

Tabel utama yang digunakan aplikasi adalah:

-   `users`: menyimpan akun admin dan customer.
-   `brands`: menyimpan data merek HP.
-   `products`: menyimpan model, harga, stok, tahun rilis, dan gambar.
-   `customers`: menyimpan data customer untuk transaksi.
-   `orders`: menyimpan data pesanan, status, metode pembayaran, dan bukti pembayaran.
-   `order_items`: menyimpan produk, jumlah, dan harga pada setiap pesanan.
-   Tabel Laravel pendukung: `sessions`, `cache`, `jobs`, `failed_jobs`, dan `migrations`.

Relasi utama sistem adalah satu brand memiliki banyak produk, satu customer memiliki banyak pesanan, satu pesanan memiliki banyak item, dan satu produk dapat muncul pada banyak item pesanan.

### 8. Alur Kerja Aplikasi

1. Pengunjung membuka katalog produk.
2. Admin login untuk mengelola produk atau pesanan.
3. Customer mendaftar atau login sebagai customer.
4. Customer memilih produk dan mengisi data pesanan.
5. Sistem menyimpan order dan order item serta mengurangi stok sesuai proses aplikasi.
6. Customer mengunggah bukti pembayaran jika menggunakan transfer.
7. Admin memeriksa pesanan dan mengubah status pesanan.

### 9. Validasi dan Keamanan

-   Route yang mengubah data dilindungi middleware `auth`.
-   Operasi create, update, delete, dan verifikasi hanya dapat dilakukan oleh admin sesuai otorisasi controller.
-   Input produk divalidasi untuk brand, nama model, harga, stok, tahun rilis, URL, dan file gambar.
-   File gambar dibatasi pada format JPG, JPEG, PNG, GIF dengan ukuran maksimal 2 MB.
-   Password pengguna disimpan menggunakan hashing Laravel.
-   Form perubahan data menggunakan CSRF protection.
-   Customer hanya dapat melihat pesanan miliknya melalui pemeriksaan akses.

### 10. Hasil Implementasi

Website telah memiliki halaman beranda, katalog produk, detail produk, login, register, dashboard, checkout, daftar pesanan customer, dan halaman pesanan admin. Admin juga memiliki tombol `Hapus` pada setiap produk serta fitur `Hapus Produk Terpilih`.

### 11. Pengujian Fungsional

| Fitur                       | Hasil                                |
| --------------------------- | ------------------------------------ |
| Membuka beranda dan katalog | Berhasil                             |
| Registrasi customer         | Berhasil                             |
| Login admin dan customer    | Berhasil                             |
| Menambah produk             | Berhasil                             |
| Mengubah produk             | Berhasil                             |
| Menghapus satu produk       | Berhasil                             |
| Menghapus beberapa produk   | Berhasil                             |
| Pencarian dan pagination    | Berhasil                             |
| Checkout pesanan            | Berhasil                             |
| Upload bukti pembayaran     | Berhasil dengan storage publik aktif |
| Verifikasi pesanan admin    | Berhasil                             |

### 12. Kesimpulan

Website Toko HP telah berhasil dibangun sebagai sistem informasi penjualan dan pengelolaan produk. Aplikasi mendukung dua jenis pengguna, yaitu admin dan customer. Fitur utama yang tersedia meliputi pengelolaan produk, pencarian katalog, autentikasi, checkout, upload bukti pembayaran, serta verifikasi pesanan.

### 13. Saran Pengembangan

-   Menambahkan laporan penjualan berdasarkan periode.
-   Menambahkan notifikasi status pesanan melalui email atau WhatsApp.
-   Menambahkan payment gateway untuk pembayaran otomatis.
-   Menambahkan pengujian feature untuk alur login, CRUD produk, checkout, dan verifikasi order.
-   Menggunakan transaksi database pada proses pembuatan order dan order item agar konsistensi data lebih terjamin.
