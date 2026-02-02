# Panduan Deployment ke Shared Hosting (cPanel)

Panduan ini akan membantu Anda mengupload dan mengatur aplikasi PMB Online (Laravel) ke hosting berbasis cPanel.

## 1. Persiapan Lokal (Di Komputer Anda)

Sebelum mengupload, pastikan aplikasi siap:

1.  **Build Assets (CSS/JS)**:
    Jalankan perintah ini di terminal VS Code untuk mengompilasi file asset:
    ```bash
    npm run build
    ```
    *Pastikan folder `public/build` sudah terbentuk.*

2.  **Bersihkan Cache**:
    ```bash
    php artisan optimize:clear
    ```

3.  **Hapus Folder yang Tidak Perlu**:
    Hapus folder `node_modules` (kita tidak butuh ini di server, dan ukurannya besar).
    *Jangan hapus folder `vendor` jika Anda tidak bisa menjalankan `composer install` di hosting. Namun idealnya, `vendor` juga diinstall di server. Untuk shared hosting biasa, lebih aman upload folder `vendor` yang sudah ada dari lokal jika versi PHP sama.*
    **Rekomendasi**: Upload folder `vendor` dari lokal saja untuk kemudahan.

4.  **Zip Project**:
    Compress semua file dalam folder project menjadi satu file `project.zip`.
    Pastikan file `.env` juga ikut ter-zip (biasanya tersembunyi).

## 2. Persiapan Database (cPanel)

1.  **Export Database Lokal**:
    - Buka phpMyAdmin lokal / HeidiSQL / DBeaver.
    - Export database aplikasi Anda ke file `.sql`.

2.  **Buat Database di Hosting**:
    - Login ke cPanel.
    - Buka menu **MySQL® Database Wizard**.
    - Buat Database baru (misal: `u12345_pmb`).
    - Buat User Database baru (misal: `u12345_master`).
    - **PENTING**: Centang "ALL PRIVILEGES" saat menghubungkan User ke Database.
    - Catat: Nama Database, Username, dan Password.

3.  **Import Database**:
    - Buka menu **phpMyAdmin** di cPanel.
    - Pilih database yang baru dibuat.
    - Klik menu **Import** -> Upload file `.sql` dari langkah 1 -> Klik **Go**.

## 3. Upload File (cPanel)

1.  **File Manager**:
    - Buka menu **File Manager** di cPanel.
    - Masuk ke folder `public_html` (ini adalah folder utama website Anda).
    - Jika Anda ingin install di subdomain (misal `pmb.sekolah.sch.id`), masuk ke folder subdomain tersebut.

2.  **Upload & Extract**:
    - Klik tombol **Upload**, pilih file `project.zip`.
    - Setelah selesai, klik kanan file zip -> **Extract**.
    - Pindahkan semua file hasil extract agar berada langsung di dalam `public_html` (atau folder tujuan).

## 4. Konfigurasi (.env)

1.  Cari file `.env` di File Manager (jika tidak ada, cari `.env.example`, rename jadi `.env`).
2.  Klik kanan -> **Edit**.
3.  Sesuaikan konfigurasi berikut:

    ```ini
    APP_NAME="PMB MAN 1 Palembang"
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=https://domain-anda.com

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=u12345_pmb      <-- Sesuaikan dengan nama database di cPanel
    DB_USERNAME=u12345_master   <-- Sesuaikan dengan username database
    DB_PASSWORD=password_db     <-- Sesuaikan dengan password database
    ```
    
4.  **Simpan Changes**.

## 5. Mengatur Folder Public (PENTING)

Laravel menggunakan folder `public` sebagai entry point, sedangkan shared hosting menggunakan `public_html`. Ada dua cara:

**Cara A: Menggunakan .htaccess (Paling Mudah)**
1.  Buat file baru bernama `.htaccess` di dalam folder root project (sejajar dengan `.env`, biasanya di `public_html`).
2.  Isi dengan kode berikut:

    ```apache
    <IfModule mod_rewrite.c>
        RewriteEngine On
        RewriteRule ^(.*)$ public/$1 [L]
    </IfModule>
    ```
    *Ini akan mengarahkan semua trafik ke folder public.*

**Cara B: Memisahkan Core dan Public (Lebih Aman)**
1.  Buat file baru `pmb-core` di luar `public_html`.
2.  Pindahkan SEMUA file project ke `pmb-core`, KECUALI isi folder `public`.
3.  Pindahkan ISI folder `public` ke dalam `public_html`.
4.  Edit file `public_html/index.php`. Ubah baris berikut:
    ```php
    require __DIR__.'/../pmb-core/vendor/autoload.php';
    $app = require_once __DIR__.'/../pmb-core/bootstrap/app.php';
    ```

## 6. Storage Link

Agar foto/dokumen bisa diakses:
1.  Di cPanel, cari menu **Terminal** (jika ada).
    Jalankan: `ln -s /home/username/public_html/storage/app/public /home/username/public_html/public/storage`
2.  **Alternatif (Tanpa Terminal)**:
    - Di File Manager, masuk ke `public_html`.
    - Hapus folder `public/storage` (jika ada).
    - Masuk ke `storage/app/public`.
    - Zip isinya, download, lalu upload dan extract manual ke `public/storage` (Cara ini manual dan merepotkan untuk update).
    - **Cara PHP Script**: Buat file `link.php` di `public_html` berisi:
      ```php
      <?php
      $target = $_SERVER['DOCUMENT_ROOT'] . '/storage/app/public';
      $shortcut = $_SERVER['DOCUMENT_ROOT'] . '/public/storage';
      symlink($target, $shortcut);
      echo "Link created from $target to $shortcut";
      ?>
      ```
      Akses `domain-anda.com/link.php` sekali, lalu hapus filenya.

## Selesai!

Situs Anda seharusnya sudah bisa diakses.
Jika ada error 500, pastikan:
1.  User database punya hak akses penuh.
2.  Versi PHP di cPanel sesuai dengan kebutuhan Laravel (minimal 8.1/8.2).
3.  Folder `storage` dan `bootstrap/cache` memiliki permission 775 atau 755.

Selamat mencoba!
