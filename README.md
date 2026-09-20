# TALOG20

TALOG20 adalah aplikasi web untuk membantu pengelolaan dan pemantauan Tugas Akhir siswa SMKN 20 Jakarta.

Aplikasi ini menggunakan tiga jenis akun: Admin, Guru, dan Siswa. Setiap role memiliki akses yang berbeda. Admin mengelola data sistem, Guru mengelola Tugas Akhir dan memantau perkembangan siswa, sedangkan Siswa melihat tugas sesuai jurusan dan mengirimkan perkembangan pekerjaannya.

Selain fitur pengelolaan Tugas Akhir, TALOG20 juga memiliki halaman informasi sekolah dan jurusan dengan tampilan modern, animasi, dan beberapa bagian visual 3D.

## Fitur Unggulan: Penilaian Otomatis & Ekspor Excel

TALOG20 dilengkapi sistem penilaian terintegrasi yang memudahkan Guru dan Administrator dalam mengevaluasi pengerjaan Tugas Akhir serta merekap nilai ke dalam format spreadsheet:

- **Otomasi Daftar Siswa per Tugas**: Saat Guru membuat Tugas Akhir baru, sistem secara otomatis menyiapkan baris penilaian untuk seluruh siswa yang terdaftar di jurusan tersebut. Setiap Tugas Akhir memiliki daftar dan tabel nilainya masing-masing.
- **Pengisian Nilai Terkunci & Real-Time**: Guru hanya dapat memberikan nilai (skala 1–100) dan catatan evaluasi kepada siswa yang telah menyelesaikan tugas (status progres *completed*). Baris penilaian siswa yang belum selesai tetap terkunci. Nilai yang diisi langsung tersimpan ke database secara real-time.
- **Ekspor Excel (.xlsx) Dinamis**: Data nilai dapat diunduh menjadi file Excel (`.xlsx`) per tugas kapan saja. File digenerate langsung dari database saat proses unduh berlangsung sehingga data yang tercantum selalu merupakan data mutakhir.

### Alur Penilaian & Ekspor Excel:

1. **Guru membuat Tugas Akhir**: Sistem secara otomatis mendaftarkan seluruh siswa pada jurusan terkait ke dalam tabel nilai tugas tersebut.
2. **Siswa mengerjakan tugas**: Siswa mengirimkan perkembangan pekerjaan secara berkala hingga menandai status progres menjadi selesai (*completed*).
3. **Guru memberikan nilai**: Guru membuka halaman nilai tugas, lalu mengisi nilai (1–100) serta catatan evaluasi pada baris siswa yang telah menyelesaikan tugas.
4. **Nilai tersimpan di database**: Nilai dan catatan tersimpan langsung ke database serta memperbarui ringkasan statistik (jumlah siswa dinilai dan rata-rata nilai).
5. **Unduh file Excel**: Guru atau Admin dapat mengunduh rekap nilai tugas ke file Excel (`.xlsx`) kapan saja dengan data yang selalu *up-to-date*.

### Hak Akses Penilaian:

- **Guru**: Hanya dapat melihat, menginput/mengubah nilai, dan mengunduh file Excel untuk Tugas Akhir miliknya sendiri.
- **Admin**: Dapat melihat, mengedit nilai, dan mengunduh file Excel untuk seluruh Tugas Akhir dari semua guru (tampilan dikelompokkan per jurusan).
- **Siswa**: Tidak memiliki akses ke sistem penilaian.

## Fitur

### Admin

Admin digunakan untuk mengelola data operasional dan administrasi sistem.

1. Mengakses dashboard Admin (statistik total jurusan, tugas akhir, guru, dan siswa)
2. Mengelola data jurusan (nama, kode, deskripsi, akreditasi, kurikulum, prospek karier, tools industri, dan warna aksen)
3. Mengelola data pengguna (CRUD user dan pengaturan akun)
4. Mengatur role pengguna (Admin, Guru, Siswa)
5. Mengatur jurusan pengguna
6. Melihat data Tugas Akhir seluruh jurusan
7. Mengelola penilaian Tugas Akhir (melihat daftar nilai per jurusan, mengisi/mengubah nilai dan catatan siswa)
8. Mengunduh rekap nilai Tugas Akhir ke format Excel (`.xlsx`)

### Guru

Guru digunakan untuk mengelola Tugas Akhir, memantau perkembangan siswa, dan melakukan penilaian.

1. Melihat daftar Tugas Akhir miliknya
2. Membuat Tugas Akhir baru (otomatis menyiapkan daftar penilaian siswa sesuai jurusan)
3. Mengubah dan menghapus Tugas Akhir beserta lampiran dokumen panduan
4. Melihat detail Tugas Akhir dan riwayat progres siswa
5. Mengelola penilaian tugas (memberi nilai 1–100 dan catatan evaluasi untuk siswa yang sudah menyelesaikan tugas)
6. Mengunduh rekap nilai Tugas Akhir ke format Excel (`.xlsx`) per tugas kapan saja

### Siswa

Siswa dapat melihat Tugas Akhir yang sesuai dengan jurusannya dan mengirimkan perkembangan pekerjaan secara berkala.

1. Melihat daftar Tugas Akhir sesuai jurusan
2. Melihat detail Tugas Akhir dan mengunduh dokumen panduan
3. Mengirim pembaruan progres pengerjaan
4. Mengubah status progres pengerjaan
5. Menambahkan catatan pada setiap progres
6. Mengunggah foto/bukti dokumentasi progres
7. Melihat riwayat progres pribadi
8. Menandai progres tugas hingga selesai (*completed*) agar dapat dinilai oleh guru

Status progress yang digunakan:

```text
pending
in_progress
completed
```

### Informasi Jurusan

TALOG20 menyediakan halaman informasi jurusan yang terdapat di SMKN 20 Jakarta.

Informasi yang ditampilkan meliputi nama jurusan, kode jurusan, deskripsi, akreditasi, kurikulum, prospek karier, tools yang digunakan di dunia industri, dan warna aksen khas tiap jurusan.

Jurusan yang tersedia pada data awal:

```text
BR    Bisnis Retail
BD    Bisnis Digital
RPL   Rekayasa Perangkat Lunak
LPS   Layanan Perbankan Syariah
AKL   Akuntansi dan Keuangan Lembaga
MPLB  Manajemen Perkantoran dan Layanan Bisnis
```

### Tampilan dan Antarmuka

Antarmuka TALOG20 dirancang responsif dan interaktif dengan beberapa fitur visual utama:

#### 1. Dashboard yang Di-revamp
Dashboard internal (Admin, Guru, Siswa) menggunakan layout modern dengan komponen kartu statistik, tabel interaktif, badge status indikatif, empty state terarah, dan transisi halaman yang rapi.

#### 2. Mode Terang, Gelap, dan Otomatis
Dashboard dilengkapi tombol switch mode di bagian atas untuk memilih tema tampilan:
- **Mode Terang (Light)**: Tampilan kontras bersih untuk pencahayaan terang.
- **Mode Gelap (Dark)**: Tampilan bernuansa gelap yang nyaman untuk mata di kondisi redup.
- **Mode Otomatis (Auto)**: Menyesuaikan mode secara dinamis mengikuti pengaturan sistem operasi / browser pengguna.

Pergantian mode memanfaatkan View Transitions API untuk menghasilkan transisi yang halus dan bebas kedipan (*flash-free*).

#### 3. Tema Halaman Publik
Tersedia dua tema visual berbeda untuk halaman publik (Beranda, Jurusan, Tentang):
- **Education (Default)**: Nuansa akademik modern dan elegan dengan palet warna dominan biru tua (`#0B1F4B`) dan aksen emas (`#F2B705` / `edu-gold`), tanpa warna oranye. Dilengkapi visual 3D interaktif buku beranimasi menggunakan Three.js dan GSAP.
- **Futuristic / Cyber**: Nuansa visual sci-fi cyber/synthwave berlatar gelap dengan aksen neon (cyan, purple, green), efek glassmorphism, partikel 3D organik, dan motion sinematik.

Route untuk beralih tema halaman publik:

```text
/theme/switch/{theme}
```

Pilihan parameter `{theme}`: `education` atau `futuristic`.

## Teknologi

### Backend

```text
PHP 8.3+
Laravel 13
Laravel Breeze
Spatie Laravel Permission
Maatwebsite Excel
```

Laravel digunakan sebagai framework utama untuk routing, autentikasi, pengelolaan database, dan alur aplikasi.

Spatie Laravel Permission digunakan untuk pengaturan role dan hak akses pengguna.

Maatwebsite Excel digunakan untuk memproses dan mengekspor rekap penilaian ke format spreadsheet (`.xlsx`).

### Frontend

```text
Blade
Tailwind CSS
Vite
Alpine.js
Axios
GSAP
Three.js
```

Blade digunakan untuk rendering antarmuka server-side. Tailwind CSS digunakan untuk styling, Vite untuk proses kompilasi asset, Alpine.js untuk reaktivitas komponen UI, GSAP untuk animasi, dan Three.js untuk visual 3D interaktif.

### Database

Konfigurasi database ditentukan melalui file `.env`.

Database utama yang direkomendasikan pada development:

```text
MySQL 8.0+
```

Aplikasi juga mendukung SQLite untuk pengujian lokal terisolasi.

## Persyaratan

Sebelum menjalankan project, pastikan server atau mesin lokal telah terpasang:

```text
PHP 8.3 atau lebih baru
Composer 2+
Node.js (v20+ atau v24+)
npm
MySQL 8.0+ atau SQLite
Git
```

Ekstensi PHP yang dibutuhkan (khususnya untuk framework Laravel dan export Excel):
- `zip` (dibutuhkan untuk pembuatan file spreadsheet `.xlsx`)
- `gd` (dibutuhkan untuk manipulasi gambar dan grafik spreadsheet)
- `xml` (dibutuhkan untuk membaca/menulis struktur XML spreadsheet)
- `mbstring` (dibutuhkan untuk pemrosesan string multi-byte)
- `fileinfo` (dibutuhkan untuk validasi unggahan dokumen/foto)
- `pdo_mysql` (dibutuhkan untuk koneksi ke database MySQL)

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

### 4. Siapkan file `.env`

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Linux / macOS:

```bash
cp .env.example .env
```

Setelah file `.env` dibuat, sesuaikan konfigurasi aplikasi dan database.

Contoh konfigurasi menggunakan MySQL:

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

Migration membuat struktur tabel database. Seeder memasukkan data awal seperti role, akun demo (Admin, Guru, Siswa per jurusan), data jurusan lengkap, serta contoh tugas akhir.

### 7. Buat storage link

```bash
php artisan storage:link
```

Perintah ini menghubungkan `storage/app/public` dengan `public/storage` sehingga file publik seperti foto progres dan dokumen panduan tugas akhir dapat diakses oleh aplikasi.

### 8. Build asset frontend

```bash
npm run build
```

### 9. Jalankan server

```bash
php artisan serve
```

Kemudian buka aplikasi di browser:

```text
http://127.0.0.1:8000
```

## Development

Untuk menjalankan Vite dalam mode watch saat pengembangan frontend:

```bash
npm run dev
```

Jalankan server Laravel pada terminal terpisah:

```bash
php artisan serve
```

Tersedia juga script development bersama:

```bash
composer run dev
```

## Akun Demo

Database seeder menyediakan akun demo siap pakai untuk menguji setiap peran.

Password default seluruh akun demo:

```text
password123
```

### 1. Admin

```text
Email    : admin@talogsmkn20.local
Password : password123
Role     : Admin
```

### 2. Guru

Akun Guru tersedia untuk setiap jurusan:

```text
guru.br@talogsmkn20.local    (Bisnis Retail)
guru.bd@talogsmkn20.local    (Bisnis Digital)
guru.rpl@talogsmkn20.local   (Rekayasa Perangkat Lunak)
guru.lps@talogsmkn20.local   (Layanan Perbankan Syariah)
guru.akl@talogsmkn20.local   (Akuntansi dan Keuangan Lembaga)
guru.mplb@talogsmkn20.local  (Manajemen Perkantoran dan Layanan Bisnis)
```

Contoh kredensial Guru RPL:

```text
Email    : guru.rpl@talogsmkn20.local
Password : password123
Role     : Guru
Jurusan  : Rekayasa Perangkat Lunak
```

### 3. Siswa

Akun Siswa tersedia untuk setiap jurusan:

```text
siswa.br@talogsmkn20.local    (Bisnis Retail)
siswa.bd@talogsmkn20.local    (Bisnis Digital)
siswa.rpl@talogsmkn20.local   (Rekayasa Perangkat Lunak)
siswa.lps@talogsmkn20.local   (Layanan Perbankan Syariah)
siswa.akl@talogsmkn20.local   (Akuntansi dan Keuangan Lembaga)
siswa.mplb@talogsmkn20.local  (Manajemen Perkantoran dan Layanan Bisnis)
```

Akun Siswa tambahan untuk keperluan testing:

```text
Email    : siswa.rpl1@talogsmkn20.local
Password : password123
Role     : Siswa
Jurusan  : Rekayasa Perangkat Lunak
```

> **Catatan Pengelolaan Akun**: Seluruh akun dan kredensial pengguna dikelola secara terpusat oleh Administrator. Sistem tidak menyediakan fitur lupa kata sandi mandiri. Jika pengguna lupa kata sandi atau membutuhkan penyesuaian akun, silakan hubungi Administrator.

## Alur Sistem

### Admin

```text
Login
  |
  v
Dashboard Admin
  |
  +---- Kelola User (CRUD, Role, Jurusan)
  |
  +---- Kelola Jurusan (CRUD, Kurikulum, Aksen)
  |
  +---- Monitoring Tugas Akhir Semua Jurusan
  |
  +---- Kelola & Input Nilai (Per Jurusan)
  |
  +---- Unduh Rekap Nilai ke Excel (.xlsx)
```

### Guru

```text
Login
  |
  v
Tugas Akhir
  |
  +---- Buat Tugas (Daftar Siswa Otomatis Dibuat)
  |
  +---- Edit / Hapus / Upload Dokumen Panduan
  |
  +---- Pantau Progress Siswa (Catatan & Foto)
  |
  v
Kelola Nilai
  |
  +---- Input Nilai (1-100) & Catatan untuk Siswa Selesai
  |
  +---- Unduh Rekap Nilai Tugas ke Excel (.xlsx)
```

### Siswa

```text
Login
  |
  v
Tugas Akhir sesuai Jurusan
  |
  v
Detail Tugas Akhir & Unduh Panduan
  |
  v
Update Progress
  |
  +---- Status (Pending -> In Progress -> Completed)
  +---- Catatan Progres
  +---- Foto Dokumentasi Progres
```

## Struktur Folder

Struktur folder utama project TALOG20:

```text
talogsmkn20/
|
+-- app/
|   +-- Exports/                  # Class ekspor spreadsheet Excel (Maatwebsite/Excel)
|   +-- Http/
|   |   +-- Controllers/
|   |       +-- Admin/            # Controller area Admin (Dashboard, Jurusan, User, Nilai)
|   |       +-- Auth/             # Controller autentikasi (Breeze)
|   |       +-- Guru/             # Controller area Guru (Tugas Akhir, Nilai)
|   |       +-- Siswa/            # Controller area Siswa (Tugas Akhir, Progress Log)
|   +-- Models/                   # Model Eloquent (User, Jurusan, TugasAkhir, NilaiTugas, dll)
|   +-- Policies/                 # Policy otorisasi hak akses (NilaiTugasPolicy)
|   +-- Providers/
|   +-- Support/                  # Helper pendukung (UploadedDocument)
|
+-- bootstrap/
+-- config/
|
+-- database/
|   +-- factories/
|   +-- migrations/               # Struktur skema tabel database
|   +-- seeders/                  # Data awal role, akun demo, jurusan, dan tugas
|
+-- public/
|   +-- build/                    # Hasil kompilasi Vite (CSS, JS)
|   +-- storage/                  # Symlink file upload publik
|
+-- resources/
|   +-- css/                      # Stylesheet Tailwind CSS
|   +-- js/                       # Script interaktivitas frontend
|   +-- views/
|       +-- admin/                # View Blade Admin (Dashboard, Jurusan, User, Nilai)
|       +-- auth/                 # View Blade login & otentikasi
|       +-- components/           # Komponen Blade reusable (dashboard, mode-switch, UI)
|       +-- experience/           # Halaman publik & visual 3D (Beranda, Jurusan, Tentang)
|       +-- exports/              # Template Blade untuk render dokumen Excel
|       +-- guru/                 # View Blade Guru (Tugas Akhir, Nilai)
|       +-- layouts/              # Layout Blade (Dashboard, Education, Futuristic)
|       +-- siswa/                # View Blade Siswa (Tugas Akhir, Detail, Progress)
|
+-- routes/
|   +-- auth.php                  # Route autentikasi
|   +-- console.php
|   +-- web.php                   # Route utama aplikasi, peran, dan tema
|
+-- storage/
+-- tests/
|   +-- Feature/                  # Pengujian fitur (Auth, Nilai, Progress, Theme, dll)
|   +-- Unit/
|
+-- .env.example
+-- artisan
+-- composer.json
+-- package.json
+-- tailwind.config.js
+-- vite.config.js
```

## Testing

Aplikasi dilengkapi pengujian otomatis (*feature tests*) untuk memastikan fungsionalitas dan otorisasi berjalan stabil.

Jalankan test dengan perintah:

```bash
php artisan test
```

Cakupan pengujian meliputi:
- Autentikasi dan proteksi route
- Pemisahan hak akses role (Admin, Guru, Siswa)
- Alur pelaporan progres siswa
- Sistem pengisian nilai, validasi siswa selesai, dan ekspor Excel
- Pengaturan warna aksen dan pengelolaan jurusan oleh Admin
- Render tema publik Education dan Futuristic

## Catatan Keamanan

1. **Ganti Password Demo**: Password akun demo default (`password123`) ditujukan untuk keperluan pengembangan dan pengujian lokal. Segera ubah seluruh kata sandi saat aplikasi diterapkan pada lingkungan *production*.
2. **Kerahasiaan File Lingkungan**: Jangan pernah melakukan commit atau membagikan file konfigurasi `.env`, salinan database lokal, atau file sesi browser (`cookies.txt`) ke repository publik.
3. **Manajemen Akun Terpusat**: Pendaftaran akun dan penugasan peran (*role assignment*) dikendalikan penuh oleh Administrator untuk menjamin hanya pengguna berwenang yang dapat mengakses sistem.

## Repository

```text
https://github.com/DYoures/talogsmkn20
```

TALOG20 — Sistem Manajemen Proyek Tugas Akhir Siswa SMKN 20 Jakarta

