# Panduan Deploy ke Vercel

Ringkas langkah yang perlu Anda siapkan untuk mendeploy project PHP (Laravel-like) ini ke Vercel.

1. File konfigurasi (sudah ditambahkan)

    - `vercel.json` untuk menggunakan builder PHP dan route ke `public/index.php`.
    - `.vercelignore` untuk mengecualikan `vendor/`, `node_modules/`, `.env`, dan file besar.

2. Build Command (Vercel Project Settings)

    - Build Command: `npm run vercel-build`
    - Output Directory: (kosong) — runtime PHP akan melayani dari `public/index.php`

3. Skrip build (di repo)

    - `package.json` sudah berisi `vercel-build` yang menjalankan: composer install + npm install + npm run build.

4. Environment Variables (SET DI VERCEL Dashboard)

    - APP: `APP_KEY`, `APP_ENV=production`, `APP_DEBUG=false`
    - Database: `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
    - Mail: `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME`
    - Storage: `FILESYSTEM_DRIVER` dan `AWS_*` (atau provider S3-compatible) untuk uploads
    - 3rd-party: Pusher, Sentry, OAuth keys sesuai kebutuhan

5. Persistent Storage

    - Vercel filesystem bersifat ephemeral — jangan bergantung pada `storage/` untuk upload.
    - Gunakan S3 / Spaces / Blob storage; set env vars dan update `filesystems.php` jika perlu.

6. Database akses

    - Gunakan managed DB yang dapat diakses dari Vercel (atau gunakan private network / proxy).
    - Pastikan connection string dan IP allowlist (jika ada).

7. Migrations & Seed

    - Jalankan `php artisan migrate --force` setelah deploy. Opsi:
        - Gunakan script CI (GitHub Actions) yang menjalankan migrasi ke DB produksi, atau
        - Gunakan remote runner/SSH atau webhook release hook yang memicu server yang punya akses DB.

8. Testing lokal sebelum deploy

    - Build lokal & jalankan dev server:
        ```bash
        npm run vercel-build
        npx vercel dev
        # atau quick check
        php -S localhost:8000 -t public
        ```

9. Checklist sebelum klik Deploy

    - Semua env vars diatur di Vercel
    - DB dapat diakses dan kredensial benar
    - Storage eksternal di-set dan tes upload berhasil
    - Assets (`/public`) ter-build dan dimuat

10. Tips tambahan

-   Untuk menjalankan Artisan commands otomatis, gunakan CI/CD (GitHub Actions) dengan step `composer install` lalu `php artisan migrate --force`.
-   Simpan `APP_KEY` di Vercel, jangan commit `.env`.

Contoh minimal `.env.example` (isi sensitif di Vercel):

```
APP_NAME=MyApp
APP_ENV=production
APP_KEY=base64:...
APP_DEBUG=false

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_pass

FILESYSTEM_DRIVER=s3
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=
AWS_BUCKET=

MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=hello@example.com
MAIL_FROM_NAME="MyApp"
```

File ini dibuat untuk memudahkan deploy — beri tahu jika mau saya juga tambahkan GitHub Actions contoh untuk migrasi otomatis.
