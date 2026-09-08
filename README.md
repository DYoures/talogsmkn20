# TALOG20

TALOG20 adalah aplikasi web untuk membantu pengelolaan dan pemantauan Tugas Akhir siswa SMKN 20 Jakarta.

Aplikasi ini menggunakan tiga jenis akun: Admin, Guru, dan Siswa. Setiap role memiliki akses yang berbeda. Admin mengelola data sistem, Guru mengelola Tugas Akhir dan memantau perkembangan siswa, sedangkan Siswa melihat tugas sesuai jurusan dan mengirimkan perkembangan pekerjaannya.

Selain fitur pengelolaan Tugas Akhir, TALOG20 juga memiliki halaman informasi sekolah dan jurusan dengan tampilan modern, animasi, dan beberapa bagian visual 3D.

## Fitur

### Admin

Admin digunakan untuk mengelola data utama pada sistem.

1. Mengakses dashboard Admin
2. Melihat statistik data sistem
3. Mengelola data jurusan
4. Mengelola data pengguna
5. Mengatur role pengguna
6. Mengatur jurusan pengguna
7. Melihat data Tugas Akhir

### Guru

Guru digunakan untuk mengelola Tugas Akhir dan memantau perkembangan siswa.

1. Melihat daftar Tugas Akhir
2. Membuat Tugas Akhir
3. Mengubah Tugas Akhir
4. Menghapus Tugas Akhir
5. Melihat detail Tugas Akhir
6. Melihat progress siswa
7. Melihat riwayat progress

### Siswa

Siswa dapat melihat Tugas Akhir yang sesuai dengan jurusannya dan mengirimkan perkembangan pekerjaan.

1. Melihat daftar Tugas Akhir sesuai jurusan
2. Melihat detail Tugas Akhir
3. Mengirim update progress
4. Mengubah status progress
5. Menambahkan catatan progress
6. Mengunggah foto progress
7. Melihat riwayat progress pribadi

Status progress yang digunakan:

```text
pending
in_progress
completed
```

### Informasi Jurusan

TALOG20 menyediakan halaman informasi jurusan yang terdapat di SMKN 20 Jakarta.

Informasi yang ditampilkan meliputi nama jurusan, kode jurusan, deskripsi, akreditasi, kurikulum, prospek karier, dan tools yang digunakan di dunia industri.

Jurusan yang tersedia pada data awal:

```text
BR    Bisnis Retail
BD    Bisnis Digital
RPL   Rekayasa Perangkat Lunak
LPS   Layanan Perbankan Syariah
AKL   Akuntansi dan Keuangan Lembaga
MPLB  Manajemen Perkantoran dan Layanan Bisnis
```

### Tampilan dan Animasi

Bagian frontend TALOG20 menggunakan beberapa library untuk membuat tampilan yang lebih interaktif.

```text
GSAP       Animasi dan transisi
Three.js   Visual 3D
Tailwind   Styling antarmuka
```

Tersedia dua tema utama:

```text
Education
Futuristic
```

## Teknologi

### Backend

```text
PHP 8.3+
Laravel 13
Laravel Breeze
Spatie Laravel Permission
```

Laravel digunakan sebagai framework utama untuk routing, autentikasi, pengelolaan database, dan proses aplikasi.

Spatie Laravel Permission digunakan untuk pengaturan role dan hak akses pengguna.

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

Blade digunakan untuk halaman server-rendered Laravel. Tailwind CSS digunakan untuk styling, Vite untuk proses build asset, GSAP untuk animasi, dan Three.js untuk bagian visual 3D.

### Database

Konfigurasi database ditentukan melalui file `.env`.

Contoh database yang dapat digunakan pada development:

```text
MySQL
```

Repository juga menyediakan konfigurasi awal Laravel untuk SQLite.

## Persyaratan

Sebelum menjalankan project, siapkan:

```text
PHP 8.3 atau lebih baru
Composer
Node.js
npm
MySQL atau SQLite
Git
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

Migration membuat struktur tabel database. Seeder memasukkan data awal seperti role, akun demo, jurusan, dan data untuk kebutuhan testing.

### 7. Buat storage link

```bash
php artisan storage:link
```

Perintah ini menghubungkan `storage/app/public` dengan `public/storage` sehingga file publik seperti foto progress dapat ditampilkan oleh aplikasi.

### 8. Build asset frontend

```bash
npm run build
```

### 9. Jalankan server

```bash
php artisan serve
```

Kemudian buka:

```text
http://127.0.0.1:8000
```

## Development

Untuk pengembangan frontend menggunakan Vite:

```bash
npm run dev
```

Laravel dijalankan pada terminal lain:

```bash
php artisan serve
```

Project juga menyediakan script development:

```bash
composer run dev
```

## Akun Demo

Seeder menyediakan akun demo untuk mencoba role yang berbeda.

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

Contoh akun Guru untuk Rekayasa Perangkat Lunak:

```text
Email    : guru.rpl@talogsmkn20.local
Password : password123
Role     : Guru
Jurusan  : Rekayasa Perangkat Lunak
```

Akun Guru untuk jurusan lain mengikuti pola kode jurusan. Contohnya:

```text
guru.br@talogsmkn20.local
guru.bd@talogsmkn20.local
guru.lps@talogsmkn20.local
guru.akl@talogsmkn20.local
guru.mplb@talogsmkn20.local
```

### Siswa

Contoh akun Siswa:

```text
Email    : siswa.rpl@talogsmkn20.local
Password : password123
Role     : Siswa
Jurusan  : Rekayasa Perangkat Lunak
```

Akun Siswa tambahan untuk testing:

```text
Email    : siswa.rpl1@talogsmkn20.local
Password : password123
Role     : Siswa
Jurusan  : Rekayasa Perangkat Lunak
```

Akun demo digunakan untuk testing lokal. Password demo sebaiknya tidak digunakan pada environment production.

## Alur Sistem

### Admin

```text
Login
  |
  v
Dashboard Admin
  |
  +---- Kelola User
  |
  +---- Kelola Jurusan
  |
  +---- Lihat data Tugas Akhir
```

### Guru

```text
Login
  |
  v
Tugas Akhir
  |
  +---- Buat
  |
  +---- Edit
  |
  +---- Hapus
  |
  v
Pantau Progress Siswa
```

### Siswa

```text
Login
  |
  v
Tugas Akhir sesuai Jurusan
  |
  v
Detail Tugas Akhir
  |
  v
Update Progress
  |
  +---- Status
  +---- Catatan
  +---- Foto Progress
```

## Struktur Folder

Struktur folder utama project:

```text
talogsmkn20/
|
+-- app/
|   +-- Http/
|   |   +-- Controllers/
|   |       +-- Admin/
|   |       +-- Auth/
|   |       +-- Guru/
|   |       +-- Siswa/
|   +-- Models/
|   +-- Providers/
|
+-- bootstrap/
+-- config/
|
+-- database/
|   +-- factories/
|   +-- migrations/
|   +-- seeders/
|
+-- public/
|
+-- resources/
|   +-- css/
|   +-- js/
|   +-- views/
|       +-- admin/
|       +-- auth/
|       +-- guru/
|       +-- siswa/
|       +-- experience/
|       +-- layouts/
|       +-- components/
|
+-- routes/
|   +-- auth.php
|   +-- console.php
|   +-- web.php
|
+-- storage/
+-- tests/
|
+-- .env.example
+-- artisan
+-- composer.json
+-- package.json
+-- package-lock.json
+-- tailwind.config.js
+-- vite.config.js
```

### Folder penting

`app/Http/Controllers/` berisi controller yang menangani request dan proses utama aplikasi.

`app/Models/` berisi model Eloquent untuk berinteraksi dengan database.

`database/migrations/` berisi struktur tabel database.

`database/seeders/` berisi data awal yang digunakan oleh aplikasi dan testing.

`resources/views/` berisi halaman Blade untuk Admin, Guru, Siswa, autentikasi, layout, dan halaman publik.

`resources/js/` dan `resources/css/` berisi asset frontend yang diproses oleh Vite.

`routes/web.php` berisi route utama website.

`routes/auth.php` berisi route autentikasi.

## Theme

TALOG20 mempunyai dua tema utama:

```text
education
futuristic
```

Route untuk mengganti theme:

```text
/theme/switch/{theme}
```

## Testing

Untuk menjalankan test Laravel:

```bash
php artisan test
```

## Catatan

File `.env` berisi konfigurasi lokal dan tidak boleh dimasukkan ke repository.

Setelah clone pada komputer baru, urutan setup yang umum digunakan:

```bash
composer install
npm install
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve
```

Untuk development frontend:

```bash
npm run dev
```

## Repository

```text
https://github.com/DYoures/talogsmkn20
```

TALOG20
Sistem Manajemen Proyek Tugas Akhir Siswa SMKN 20 Jakarta
