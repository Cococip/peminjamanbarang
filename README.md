# Sistem Peminjaman Barang

Aplikasi web sederhana untuk mencatat data barang dan transaksi peminjaman barang. Dibangun dengan **CodeIgniter 4**, **PHP**, dan **MySQL**. Cocok digunakan untuk tugas kuliah, project portfolio, organisasi kampus, laboratorium, kelas, atau kantor kecil.

## Fitur

- Login admin sederhana (session authentication)
- Dashboard ringkas (total barang, total peminjam, barang sedang dipinjam, peminjaman aktif, peminjaman terbaru)
- CRUD Data Barang (kode unik, kondisi, status, search, pagination)
- CRUD Data Peminjam (search, pagination)
- Peminjaman barang dengan pengecekan stok tersedia otomatis
- Pengembalian barang (stok otomatis bertambah kembali)
- Riwayat peminjaman lengkap dengan filter status dan pencarian
- Validasi server-side, flash message, konfirmasi hapus, dan proteksi CSRF
- Tampilan modern, clean, dan responsif (desktop, tablet, mobile)

## Teknologi

- CodeIgniter 4
- PHP 8.2+
- MySQL
- HTML5, CSS3, JavaScript vanilla

## Kebutuhan Sistem

- PHP 8.2 atau lebih baru dengan ekstensi: `intl`, `mysqli`, `mbstring`, `json`, `curl`
- MySQL 5.7+ / MariaDB 10.3+
- Composer

> Catatan: ekstensi `intl` wajib aktif karena digunakan langsung oleh core framework CodeIgniter 4. Jika muncul error terkait `Locale`/`intl` saat instalasi, aktifkan ekstensi tersebut di `php.ini` (`extension=intl`) lalu restart PHP.
>
> **Khusus di server ini**: ekstensi `intl` belum terpasang secara global dan instalasinya butuh akses `sudo` interaktif. Sebagai gantinya, folder `php-ext/intl.so` sudah disediakan di dalam project ini sebagai solusi sementara. Selama ekstensi `intl` belum terpasang secara permanen di server, jalankan setiap perintah `php spark ...` dengan tambahan flag berikut (ganti `/path/ke/project` dengan lokasi project ini):
> ```bash
> php -d extension=/path/ke/project/php-ext/intl.so spark migrate
> php -d extension=/path/ke/project/php-ext/intl.so spark db:seed DatabaseSeeder
> php -d extension=/path/ke/project/php-ext/intl.so spark serve
> ```
> Jika `sudo apt install php8.4-intl` (atau versi PHP yang sesuai) sudah dijalankan dan ekstensi `intl` aktif secara permanen, folder `php-ext/` boleh dihapus dan perintah `php spark ...` biasa (tanpa flag `-d`) bisa dipakai kembali.

## Langkah Instalasi

1. **Clone/copy project** ke folder yang diinginkan.

2. **Install dependency** dengan Composer:
   ```bash
   composer install
   ```

3. **Buat database MySQL** baru, misalnya `peminjaman_barang`:
   ```sql
   CREATE DATABASE peminjaman_barang CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

4. **Copy file environment**:
   ```bash
   cp env .env
   ```

5. **Atur koneksi database** pada file `.env`:
   ```
   CI_ENVIRONMENT = production

   app.baseURL = 'http://localhost:8080/'

   database.default.hostname = localhost
   database.default.database = peminjaman_barang
   database.default.username = root
   database.default.password =
   database.default.DBDriver = MySQLi
   database.default.DBPrefix =
   database.default.port = 3306
   ```
   Sesuaikan `username`, `password`, dan `app.baseURL` dengan konfigurasi server Anda.

6. **Jalankan migration** untuk membuat semua tabel (`users`, `items`, `borrowers`, `borrowings`):
   ```bash
   php spark migrate
   ```

7. **Jalankan seeder** untuk mengisi akun admin dan data contoh:
   ```bash
   php spark db:seed DatabaseSeeder
   ```

8. **Jalankan server** development bawaan CodeIgniter:
   ```bash
   php spark serve
   ```
   Aplikasi dapat diakses di `http://localhost:8080`.

9. **Login** menggunakan akun admin demo:
   - Email: `admin@example.com`
   - Password: `password`

## Struktur Data Contoh (Seeder)

Setelah menjalankan seeder, aplikasi sudah berisi:
- 1 akun admin
- 6 data barang contoh (Laptop, Proyektor, Kamera, Tripod, Mikrofon, Speaker)
- 4 data peminjam contoh
- 4 transaksi peminjaman contoh (3 aktif, 1 sudah dikembalikan)

## Struktur Folder Penting

```
app/Controllers/     Controller (Auth, Dashboard, Item, Borrower, Borrowing, History)
app/Models/           Model (User, Item, Borrower, Borrowing) beserta validasi
app/Views/            View, disusun per modul + layouts/main.php sebagai layout utama
app/Database/Migrations/  Struktur tabel database
app/Database/Seeds/       Data awal (admin, barang, peminjam, peminjaman)
app/Filters/AuthFilter.php  Proteksi halaman admin
app/Config/Routes.php       Definisi seluruh routing
public/assets/css/app.css   Styling utama aplikasi
public/assets/js/app.js     Interaksi sisi klien (sidebar, konfirmasi hapus, dll)
```

## Catatan

- Aplikasi ini sengaja dibuat sederhana sesuai kebutuhan dasar peminjaman barang: tidak ada fitur denda, barcode, API, multi-role, atau export laporan.
- Jumlah barang yang tersedia dihitung otomatis dari `jumlah` total dikurangi jumlah yang sedang dipinjam (status `Dipinjam`), sehingga field `jumlah` pada data barang selalu mencerminkan total stok yang dimiliki.
# peminjamanbarang
