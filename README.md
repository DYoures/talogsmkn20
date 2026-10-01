# TALOG20 v2

TALOG20 adalah aplikasi web SMKN 20 Jakarta untuk mengelola Tugas Akhir siswa dari awal pemberian tugas sampai proses monitoring dan penilaian. Versi 2 menambahkan sistem penilaian terintegrasi yang menghubungkan data tugas, progress siswa, nilai guru, dan rekap Excel dalam satu alur kerja.

## Gambaran Sistem

TALOG20 menggunakan tiga role utama: Admin, Guru, dan Siswa. Hak akses dibatasi berdasarkan role dan jurusan sehingga masing-masing pengguna hanya melihat data yang sesuai dengan tugasnya.

Alur utama sistem:

```text
Guru membuat Tugas Akhir
        |
        v
Sistem membaca siswa pada jurusan yang sama
        |
        v
Daftar penilaian siswa dibuat otomatis
        |
        v
Siswa melihat tugas dan mengirim progress
        |
        v
Progress diperbarui hingga status "completed"
        |
        v
Guru membuka halaman Penilaian
        |
        v
Nilai 1-100 dan catatan evaluasi disimpan ke database
        |
        v
Rekap nilai dapat diunduh sebagai Excel (.xlsx)
```

## Fitur Utama V2

### Sistem Tugas Akhir

Guru dapat membuat, mengubah, menghapus, dan melihat Tugas Akhir yang mereka kelola. Setiap tugas terhubung dengan guru dan jurusan, serta dapat memiliki dokumen panduan.

Siswa hanya melihat Tugas Akhir yang sesuai dengan jurusannya dan dapat membuka detail serta dokumen panduan tugas.

### Monitoring Progress Siswa

Siswa dapat mengirim progress secara berkala dengan:

- Status `pending`
- Status `in_progress`
- Status `completed`
- Catatan progress
- Foto dokumentasi
- File tambahan

Guru dapat melihat riwayat progress siswa dari halaman detail Tugas Akhir.

### Penilaian V2

Saat Guru membuat Tugas Akhir, sistem otomatis membuat data penilaian untuk siswa yang terdaftar pada jurusan tersebut. Data ini disimpan pada tabel `nilai_tugas` dan dibuat satu baris untuk setiap pasangan Tugas Akhir dan siswa.

Saat halaman penilaian dibuka, sistem juga melakukan sinkronisasi untuk memastikan siswa yang baru terdaftar pada jurusan tersebut tetap memiliki baris penilaian.

Guru dapat:

- Melihat seluruh siswa yang terkait dengan Tugas Akhir
- Melihat status progress masing-masing siswa
- Memberikan nilai dari 1 sampai 100
- Menambahkan atau mengubah catatan evaluasi
- Mengubah nilai yang sudah tersimpan
- Melihat jumlah siswa yang selesai, sudah dinilai, belum dinilai, dan rata-rata nilai
- Mengunduh rekap penilaian ke Excel

Nilai hanya dapat diisi ketika siswa sudah memiliki progress berstatus `completed`. Pemeriksaan ini dilakukan di frontend dan divalidasi kembali oleh server sebelum data disimpan.

### Penyimpanan Nilai

Perubahan nilai dan catatan dikirim menggunakan request `PATCH` tanpa perlu mengirim form penuh. Setelah server berhasil menyimpan data, halaman menampilkan status penyimpanan dan waktu penilaian terakhir.

Setiap nilai menyimpan informasi:

| Data | Keterangan |
|---|---|
| `tugas_akhir_id` | Tugas yang dinilai |
| `siswa_id` | Siswa yang menerima nilai |
| `nilai` | Nilai 1 sampai 100 |
| `catatan` | Catatan evaluasi Guru |
| `dinilai_oleh` | User yang memberikan nilai |
| `dinilai_at` | Waktu penilaian |

### Rekap Nilai Excel

TALOG20 menggunakan Maatwebsite Excel untuk membuat file `.xlsx` secara dinamis dari data database saat tombol unduh digunakan.

File berisi:

| Kolom | Isi |
|---|---|
| No | Nomor urut siswa |
| Nama Siswa | Nama siswa |
| Nilai | Nilai yang tersimpan |
| Catatan | Catatan evaluasi |

Bagian atas file juga menampilkan judul Tugas Akhir, jurusan, Guru pembimbing, dan waktu export. Nilai yang belum tersedia tetap ditampilkan sebagai `-`, sehingga daftar siswa tetap lengkap. Rata-rata nilai dihitung dari siswa yang sudah memiliki nilai.

Nama file dibuat otomatis berdasarkan judul Tugas Akhir dan waktu export, contoh:

```text
Nilai_pengembangan-sistem_20260920_143000.xlsx
```

### Hak Akses Penilaian

| Role | Akses |
|---|---|
| Admin | Melihat dan mengelola penilaian seluruh Tugas Akhir dari semua jurusan serta mengunduh Excel |
| Guru | Mengelola penilaian untuk Tugas Akhir yang dibuat sendiri serta mengunduh Excel |
| Siswa | Mengirim progress Tugas Akhir dan tidak memiliki akses ke modul penilaian |

## Fitur Admin

Admin menangani data operasional dan pengaturan sistem.

1. Dashboard statistik
2. CRUD jurusan
3. CRUD pengguna
4. Pengaturan role Admin, Guru, dan Siswa
5. Pengaturan jurusan pengguna
6. Melihat seluruh Tugas Akhir
7. Melihat dan mengelola nilai berdasarkan jurusan
8. Mengunduh rekap nilai Excel

## Fitur Guru

Guru menangani Tugas Akhir, monitoring, dan penilaian.

1. Melihat Tugas Akhir miliknya
2. Membuat Tugas Akhir baru
3. Mengubah dan menghapus Tugas Akhir
4. Mengunggah dokumen panduan
5. Melihat progress siswa
6. Membuka halaman penilaian
7. Memberikan dan mengubah nilai
8. Menambahkan catatan evaluasi
9. Melihat statistik penilaian
10. Mengunduh rekap nilai Excel

## Fitur Siswa

Siswa mengerjakan Tugas Akhir dan melaporkan perkembangannya.

1. Melihat Tugas Akhir sesuai jurusan
2. Melihat detail Tugas Akhir
3. Mengunduh dokumen panduan
4. Mengirim progress
5. Mengubah status progress
6. Menambahkan catatan
7. Mengunggah foto dokumentasi
8. Mengunggah file pendukung
9. Melihat riwayat progress
10. Menandai tugas selesai agar dapat dinilai Guru

## Alur Penilaian

### 1. Guru Membuat Tugas

Guru membuat Tugas Akhir dari halaman Guru. Sistem mengambil jurusan Guru yang sedang login lalu membuat Tugas Akhir dengan relasi Guru dan jurusan tersebut.

### 2. Daftar Nilai Dibuat Otomatis

Setelah Tugas Akhir berhasil dibuat, sistem mengambil seluruh user dengan role Siswa yang memiliki jurusan sama. Untuk setiap siswa, sistem membuat data `nilai_tugas` menggunakan pasangan unik:

```text
tugas_akhir_id + siswa_id
```

Dengan cara ini halaman penilaian sudah memiliki daftar siswa sebelum satu pun nilai dimasukkan.

### 3. Siswa Mengirim Progress

Siswa mengirim progress dari halaman detail Tugas Akhir. Setiap update membuat log progress baru dengan status dan dokumentasi yang dikirim.

### 4. Sistem Mengecek Status

Pada halaman penilaian, status terbaru siswa dibaca dari progress log. Jika status terbaru adalah `completed`, kolom nilai menjadi aktif.

### 5. Guru Mengisi Nilai

Guru mengisi angka 1 sampai 100. Perubahan dikirim dengan request `PATCH` dan langsung diproses oleh Laravel. Nilai, catatan, user penilai, dan waktu penilaian disimpan ke database.

### 6. Rekap dan Statistik

Halaman penilaian menghitung:

```text
Total Siswa
Progress Selesai
Sudah Dinilai
Belum Dinilai
Rata-rata Nilai
```

### 7. Export Excel

Saat export dijalankan, data penilaian dibaca kembali dari database sehingga file yang dihasilkan menggunakan data terbaru pada saat download.

## Struktur Data

Relasi utama aplikasi:

```text
Jurusan
  |
  +---- Users
  |       |
  |       +---- Admin
  |       +---- Guru
  |       +---- Siswa
  |
  +---- Tugas Akhir
          |
          +---- Progress Log
          |       |
          |       +---- File Progress
          |
          +---- Nilai Tugas
```

Tabel utama:

| Tabel | Fungsi |
|---|---|
| `users` | Data akun pengguna |
| `jurusans` | Data jurusan |
| `tugas_akhirs` | Data Tugas Akhir |
| `tugas_akhir_progress_logs` | Riwayat progress siswa |
| `progress_log_files` | File tambahan pada progress |
| `nilai_tugas` | Nilai dan catatan evaluasi |
| Tabel permission Spatie | Role dan hak akses pengguna |

Pada tabel `nilai_tugas`, kombinasi `tugas_akhir_id` dan `siswa_id` dibuat unik untuk mencegah satu siswa memiliki lebih dari satu baris nilai pada tugas yang sama.

## Tampilan dan Antarmuka

Dashboard internal memiliki tampilan responsif dengan statistik, tabel interaktif, status progress, dan komponen untuk pengelolaan data.

Tersedia tiga pilihan mode dashboard:

- Light
- Dark
- Auto

Halaman publik memiliki dua tema:

### Education

Tema akademik modern dengan dominasi biru tua dan aksen emas. Halaman publik menggunakan visual 3D interaktif berbasis Three.js dan animasi GSAP.

### Futuristic / Cyber

Tema bergaya sci-fi dengan nuansa gelap, aksen neon, efek glassmorphism, partikel 3D, dan motion.

Pergantian tema:

```text
/theme/switch/{theme}
```

Parameter yang tersedia:

```text
education
futuristic
```

## Teknologi yang Digunakan

### Backend

| Teknologi | Penggunaan |
|---|---|
| PHP 8.3+ | Bahasa utama backend |
| Laravel 13 | Framework aplikasi |
| Laravel Breeze | Autentikasi |
| Spatie Laravel Permission | Role dan permission |
| Maatwebsite Excel | Export nilai ke Excel |

### Frontend

| Teknologi | Penggunaan |
|---|---|
| Blade | Server-side rendering |
| Tailwind CSS | Styling dan layout |
| Alpine.js | Interaksi UI |
| Vite | Build asset |
| Axios | HTTP client |
| GSAP | Animasi |
| Three.js | Visual 3D |

### Database

```text
MySQL 8.0+
```

MySQL menjadi database utama yang direkomendasikan untuk development. SQLite juga dapat digunakan untuk kebutuhan testing lokal yang terisolasi.

## Struktur Folder

```text
talogsmkn20/
|
+-- app/
|   +-- Exports/
|   +-- Http/
|   |   +-- Controllers/
|   |       +-- Admin/
|   |       +-- Auth/
|   |       +-- Guru/
|   |       +-- Siswa/
|   +-- Models/
|   +-- Policies/
|   +-- Providers/
|   +-- Support/
|
+-- database/
|   +-- factories/
|   +-- migrations/
|   +-- seeders/
|
+-- resources/
|   +-- css/
|   +-- js/
|   +-- views/
|       +-- admin/
|       +-- auth/
|       +-- components/
|       +-- experience/
|       +-- exports/
|       +-- guru/
|       +-- layouts/
|       +-- siswa/
|
+-- routes/
|   +-- auth.php
|   +-- console.php
|   +-- web.php
|
+-- storage/
+-- tests/
+-- .env.example
+-- artisan
+-- composer.json
+-- package.json
+-- vite.config.js
```

## Persyaratan

Sebelum menjalankan project, siapkan:

```text
PHP 8.3+
Composer 2+
Node.js 20+
npm
MySQL 8.0+ atau SQLite
Git
```

Beberapa ekstensi PHP yang diperlukan, terutama untuk upload file dan export spreadsheet:

```text
zip
gd
xml
mbstring
fileinfo
pdo_mysql
```

## Instalasi

### 1. Clone repository

```bash
git clone https://github.com/DYoures/talogsmkn20.git
cd talogsmkn20
```

### 2. Install dependency PHP

```bash
composer install
```

### 3. Install dependency frontend

```bash
npm install
```

### 4. Siapkan file .env

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Linux / macOS:

```bash
cp .env.example .env
```

Contoh konfigurasi MySQL:

```env
APP_NAME=TALOG20
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=talogsmkn20
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Jalankan migration dan seeder

```bash
php artisan migrate --seed
```

### 7. Buat symbolic link storage

```bash
php artisan storage:link
```

### 8. Build frontend

```bash
npm run build
```

### 9. Jalankan aplikasi

```bash
php artisan serve
```

Buka:

```text
http://127.0.0.1:8000
```

## Development

Untuk menjalankan Vite dalam mode development:

```bash
npm run dev
```

Untuk menjalankan server Laravel:

```bash
php artisan serve
```

Project juga menyediakan script gabungan:

```bash
composer run dev
```

## Akun Demo

Password default akun demo:

```text
password123
```

### Admin

```text
Email    : admin@talogsmkn20.local
Password : password123
Role     : Admin
```

### Guru

Akun Guru tersedia berdasarkan jurusan:

```text
guru.br@talogsmkn20.local
guru.bd@talogsmkn20.local
guru.rpl@talogsmkn20.local
guru.lps@talogsmkn20.local
guru.akl@talogsmkn20.local
guru.mplb@talogsmkn20.local
```

Contoh Guru RPL:

```text
Email    : guru.rpl@talogsmkn20.local
Password : password123
Role     : Guru
Jurusan  : Rekayasa Perangkat Lunak
```

### Siswa

Akun Siswa tersedia berdasarkan jurusan:

```text
siswa.br@talogsmkn20.local
siswa.bd@talogsmkn20.local
siswa.rpl@talogsmkn20.local
siswa.lps@talogsmkn20.local
siswa.akl@talogsmkn20.local
siswa.mplb@talogsmkn20.local
```

Akun tambahan untuk testing:

```text
Email    : siswa.rpl1@talogsmkn20.local
Password : password123
Role     : Siswa
Jurusan  : Rekayasa Perangkat Lunak
```

## Testing

Menjalankan seluruh test:

```bash
php artisan test
```

Project memiliki feature test untuk beberapa area, termasuk:

- Autentikasi
- Role dan hak akses
- Progress siswa
- Sistem penilaian
- Export nilai
- Pengelolaan warna jurusan
- Tema Education
- Tema Futuristic
- Profile

## Keamanan dan Batasan Akses

Akses route internal dilindungi middleware autentikasi dan role. Data Tugas Akhir juga diperiksa berdasarkan user atau jurusan yang terkait.

Beberapa aturan penting pada modul penilaian:

1. Guru hanya dapat mengelola nilai dari Tugas Akhir yang dibuat sendiri.
2. Admin dapat mengelola nilai dari seluruh Tugas Akhir.
3. Nilai tidak dapat diberikan kepada siswa yang belum memiliki progress `completed`.
4. Nilai dibatasi dari 1 sampai 100.
5. Kombinasi Tugas Akhir dan siswa pada tabel nilai dibuat unik.
6. File upload dikelola melalui storage Laravel.
7. Password demo hanya ditujukan untuk development dan testing lokal.

## Repository

```text
https://github.com/DYoures/talogsmkn20
```

TALOG20 v2 — Sistem Pengelolaan, Monitoring, dan Penilaian Tugas Akhir Siswa SMKN 20 Jakarta.
