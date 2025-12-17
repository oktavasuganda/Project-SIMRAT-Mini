# 📂 SIMRAT - Sistem Informasi Manajemen Surat

SIMRAT adalah aplikasi berbasis web untuk manajemen surat masuk dan surat keluar dalam sebuah organisasi atau instansi. Aplikasi ini bertujuan untuk mempermudah pencatatan, pengarsipan, dan pelacakan surat secara digital.

[![Laravel v12.x](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php)](https://www.php.net/)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com/)

## ⚠️ PERHATIAN PENTING (DISCLAIMER)

Proyek **SIMRAT** ini **JAUH DARI SEMPURNA** dan masih dalam **TAHAP PENGEMBANGAN AKTIF**.

Tujuan utama proyek ini adalah sebagai sarana **BELAJAR** dan eksplorasi fitur-fitur baru dari Laravel 12 dan TailAdmin.

Kami tidak bertanggung jawab atas segala kerusakan, kerugian data, atau masalah lainnya yang timbul dari penggunaan proyek ini di luar tujuan pembelajaran. **Semua penggunaan dalam lingkungan produksi atau operasional adalah di luar tanggung jawab kami.**

---

## ✨ Fitur Utama

SIMRAT menyediakan fitur-fitur penting untuk mengelola dokumen persuratan:

-   **Manajemen Surat Masuk:** Pencatatan detail surat yang diterima, termasuk pengirim, tanggal, nomor surat, dan _file_ lampiran.
-   **Manajemen Surat Keluar:** Pencatatan detail surat yang dikirim, termasuk penerima, tanggal, dan pengarsipan _file_ surat yang telah ditandatangani.
-   **Pengarsipan Digital:** Menyimpan _file_ surat (PDF, DOCX, dll.) secara terpusat.
-   **Klasifikasi Surat:** Pengelompokan surat berdasarkan jenis, sifat, atau kategori (misalnya: Penting, Rahasia, Edaran).
-   **Fungsi Pencarian & Filter:** Pencarian cepat berdasarkan nomor surat, perihal, atau rentang tanggal.
-   **Dasbor Informatif:** Ringkasan statistik surat masuk dan keluar.
-   **Manajemen Pengguna & Hak Akses (RBAC).**

## 🛠️ Teknologi yang Digunakan

Proyek ini dibangun menggunakan _stack_ teknologi modern:

| Kategori           | Teknologi              | Deskripsi                                                                           |
| :----------------- | :--------------------- | :---------------------------------------------------------------------------------- |
| **Backend**        | **Laravel 12**         | _Framework_ PHP terpopuler untuk pengembangan aplikasi web yang cepat dan elegan.   |
| **Database**       | **MySQL / PostgreSQL** | Sistem manajemen basis data relasional yang andal.                                  |
| **Frontend**       | **Tailwind CSS**       | _Framework_ CSS _utility-first_ untuk _styling_ yang responsif.                     |
| **Admin Template** | **TailAdmin**          | Template _dashboard_ admin yang bersih dan profesional, didukung oleh Tailwind CSS. |
| **Bahasa**         | **PHP 8.2+**           | Bahasa pemrograman utama.                                                           |

## 🚀 Instalasi Lokal

Ikuti langkah-langkah di bawah ini untuk menjalankan SIMRAT di lingkungan lokal Anda.

### Prasyarat

Pastikan sistem Anda telah terinstal:

-   **PHP** (Versi 8.2 atau lebih tinggi)
-   **Composer**
-   **Node.js & NPM**
-   **Database** (MySQL / SQLite)

### Langkah-langkah

1.  **Kloning Repositori:**

    ```bash
    git clone [https://github.com/oktavasuganda/Project-SIMRAT-Mini](https://github.com/oktavasuganda/Project-SIMRAT-Mini)
    cd SIMRAT
    ```

2.  **Instalasi Dependensi PHP:**

    ```bash
    composer install
    ```

3.  **Konfigurasi Environment:**

    -   Duplikat file `.env.example` menjadi `.env`.
        ```bash
        cp .env.example .env
        ```
    -   Buat _Application Key_:
        ```bash
        php artisan key:generate
        ```
    -   Edit file `.env` dan konfigurasikan detail _database_ Anda (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

4.  **Konfigurasi Database:**

    -   Jalankan migrasi untuk membuat tabel:
        ```bash
        php artisan migrate
        ```
    -   (Opsional) Isi data awal (seeding):
        ```bash
        php artisan db:seed
        ```

5.  **Instalasi Dependensi Frontend & Kompilasi Asset:**

    -   Instal dependensi Node.js:
        ```bash
        npm install
        ```
    -   Kompilasi _asset_ (CSS dan JS):
        ```bash
        npm run dev
        # Atau untuk mode pengawasan otomatis saat pengembangan:
        # npm run watch
        ```

6.  **Jalankan Aplikasi:**
    ```bash
    php artisan serve
    ```
    Aplikasi akan tersedia di `http://127.0.0.1:8000`.

## 🔒 Hak Akses Awal

Setelah menjalankan `php artisan db:seed`, Anda mungkin memiliki akun pengguna _default_.

| Peran             | Email                 | Password   |
| :---------------- | :-------------------- | :--------- |
| **Administrator** | `oktava.id@gmail.com` | `password` |

---

*Catatan: Pastikan Anda mengubah kredensial *default* ini segera setelah instalasi di lingkungan produksi.*

## 🤝 Kontribusi

SIMRAT dikembangkan sebagai proyek sumber terbuka (jika diizinkan). Kami sangat menyambut kontribusi Anda.

1.  _Fork_ Repositori ini.
2.  Buat _branch_ baru: `git checkout -b fitur/nama-fitur-baru`
3.  Lakukan _commit_ perubahan Anda: `git commit -m 'Menambahkan fitur baru: [Deskripsi Singkat]'`
4.  Dorong ke _branch_ Anda: `git push origin fitur/nama-fitur-baru`
5.  Buka _Pull Request_.

## 👨‍💻 Kontak

[Nama Anda/Organisasi Anda] – [@oktavasuganda](https://instagram.com/oktavasuganda)
_Link_ Proyek: [https://github.com/oktavasuganda/Project-SIMRAT-Mini](https://github.com/oktavasuganda/Project-SIMRAT-Mini)
