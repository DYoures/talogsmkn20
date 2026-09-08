# TALOG20 — MAIN DEVELOPMENT INSTRUCTION

# ⚠️ VERY IMPORTANT — FRESH BUILD FROM ZERO

Project ini harus dibangun sebagai **fresh project dari 0**.

Jangan menganggap ada aplikasi TALOG20 existing yang harus dipertahankan.

Jangan melakukan migration dari project lama.

Jangan meng-copy architecture project lama.

Jangan melakukan refactor terhadap aplikasi TALOG20 lama.

Jangan mempertahankan implementation lama hanya karena pernah ada.

Tujuan utama:

**BUILD TALOG20 FROM ZERO → CLEAN ARCHITECTURE → FULL FUNCTIONAL → POLISHED → RESPONSIVE → OPTIMIZED → STABLE**

Gunakan file dan asset yang berada di dalam folder project ini sebagai:

* instruction
* requirement
* visual reference
* asset reference

Jangan mencari project TALOG20 lama di lokasi lain kecuali pengguna secara eksplisit meminta.

---

# 1. CURRENT PROJECT LOCATION

Project ini berada di:

`C:\laragon\www\Talogsmkn20`

**Ini adalah satu-satunya project development utama.**

Semua source code, configuration, frontend, backend, database-related implementation, asset integration, dan feature development harus dilakukan di:

`C:\laragon\www\Talogsmkn20`

Jangan membuat project Laravel lain.

Jangan membuat folder project kedua.

Jangan memindahkan project ke lokasi lain.

---

# 2. RUN CLAUDE CODE FROM THIS PROJECT

Claude Code / FCC-Claude harus dijalankan dari:

`C:\laragon\www\Talogsmkn20`

Contoh:

```text
cd C:\laragon\www\Talogsmkn20
```

Kemudian jalankan Claude Code/FCC-Claude dari folder tersebut.

Dengan demikian:

**current working directory = project TALOG20**

Semua relative path harus dianggap relatif terhadap:

`C:\laragon\www\Talogsmkn20`

---

# 3. PROJECT FILES PROVIDED BY USER

File yang diberikan pengguna dan berada di project ini merupakan sumber resmi untuk development.

Contohnya:

```text
CLAUDE.md
logo SMKN 20
video reference 3D
```

Gunakan asset yang tersedia di project.

Jangan mengganti asset tersebut dengan asset random tanpa alasan.

Jangan mencari project lama hanya karena asset tersebut berasal dari hasil pekerjaan sebelumnya.

---

# 4. ROLE OF CLAUDE.md

`CLAUDE.md` adalah instruction utama project.

Baca seluruh isi `CLAUDE.md` terlebih dahulu sebelum melakukan development.

Jangan mengabaikannya.

Kemudian gabungkan instruction tersebut dengan requirement dalam prompt ini.

Jika menemukan bagian yang bertentangan dengan requirement terbaru:

**ikuti requirement terbaru dari pengguna.**

Jangan mengikuti konsep lama yang sudah secara eksplisit diganti.

---

# 5. FRESH PROJECT RULE

Project ini harus benar-benar dimulai dari:

**CLEAN FOUNDATION**

Artinya:

* desain architecture dari awal
* tentukan struktur backend dari awal
* tentukan struktur frontend dari awal
* tentukan database schema dari awal
* tentukan authentication dari awal
* tentukan authorization dari awal
* tentukan theme system dari awal
* tentukan component architecture dari awal
* tentukan 3D architecture dari awal

Jangan mencoba menghidupkan kembali implementation lama yang tidak diperlukan.

Jangan membuat compatibility layer terhadap project lama kecuali memang diperlukan untuk asset/data yang secara eksplisit masih digunakan.

---

# 6. LARAGON — USE EXISTING INSTALLATION ONLY

Gunakan Laragon yang sudah terinstall di device.

Lokasi Laragon:

`C:\laragon`

Executable:

`C:\laragon\laragon.exe`

Web root:

`C:\laragon\www`

Project:

`C:\laragon\www\Talogsmkn20`

## ABSOLUTE RESTRICTIONS

JANGAN:

* uninstall Laragon
* reinstall Laragon
* menghapus Laragon
* memindahkan Laragon
* membuat instalasi Laragon baru
* mengganti Laragon dengan XAMPP
* membuat server environment baru
* merombak environment Windows tanpa alasan yang benar-benar diperlukan

Gunakan Laragon yang sudah tersedia.

Jika terjadi masalah:

**DIAGNOSE → ROOT CAUSE → MINIMAL FIX**

Jangan langsung merusak environment.

---

# 7. EXISTING ENVIRONMENT

Environment yang sudah tersedia:

```text
Laragon:
C:\laragon

PHP:
8.3.33

Composer:
2.10.3

MySQL:
8.0.30

Node.js:
24.16.0

npm:
11.13.0
```

Gunakan environment tersebut.

Jangan downgrade atau reinstall component tanpa alasan compatibility yang jelas.

---

# 8. DATABASE

Gunakan:

**MySQL 8.0.30 dari Laragon**

sebagai database utama TALOG20.

Jangan menggunakan SQLite sebagai database utama.

Jika database belum ada:

buat database yang diperlukan untuk TALOG20.

Nama database utama:

`talogsmkn20`

Konfigurasi `.env` harus menggunakan MySQL Laragon.

Setelah project bisa diakses via Laragon, sesuaikan `APP_URL` di `.env`
dengan URL akses aktual (mis. `http://talogsmkn20.test`) bila diperlukan.

Database harus dibangun dari awal berdasarkan kebutuhan TALOG20.

Jangan membuat duplicate schema tanpa alasan.

---

# 9. INITIAL PROJECT SETUP

Project Laravel `Talogsmkn20` sudah dibuat.

**Jangan membuat Laravel project kedua.**

Pertama periksa kondisi project saat ini.

Periksa:

* `composer.json`
* `.env`
* `.env.example`
* `package.json`
* routes
* config
* database
* migrations
* resources
* app
* public
* existing dependencies

Jika masih berupa Laravel skeleton:

**itu normal.**

Bangun TALOG20 dari foundation tersebut.

---

# 10. THINK HARDER BEFORE IMPLEMENTATION

Sebelum membuat fitur besar:

analisis terlebih dahulu:

* architecture
* dependency
* database relationship
* frontend/backend interaction
* API
* authentication
* authorization
* performance
* responsive behaviour
* shared components
* theme system
* 3D architecture

Jangan langsung memilih solusi pertama.

Cari solution yang:

* clean
* maintainable
* scalable
* compatible
* performant
* sesuai requirement

---

# 11. DEVELOPMENT METHOD

Project besar jangan dibangun dengan pola:

```text
BUILD EVERYTHING
↓
TEST EVERYTHING
↓
PANIC FIX EVERYTHING
```

Gunakan:

```text
ANALYZE
↓
PLAN
↓
IMPLEMENT LOGICAL MILESTONE
↓
ASSESS RISK
↓
VERIFY WHEN NECESSARY
↓
FIX ROOT CAUSE
↓
CONTINUE
```

---

# 12. SMART TESTING

Jangan menjalankan full test setiap perubahan kecil.

Gunakan risk-based testing.

### LOW RISK

Contoh:

* text
* copywriting
* spacing
* minor styling
* isolated CSS

Cukup static verification atau targeted check bila diperlukan.

### MEDIUM RISK

Contoh:

* shared component
* frontend state
* navigation
* reusable logic
* theme logic
* API consumer

Lakukan targeted verification.

### HIGH RISK

Contoh:

* database
* migration
* authentication
* authorization
* RBAC
* backend
* API
* routing
* dependency
* environment
* major refactor
* WebGL architecture

Lakukan runtime/build/integration verification yang relevan.

### MAJOR MILESTONE

Setelah kelompok fitur besar selesai:

lakukan regression test terhadap area yang terkena perubahan.

Jangan melakukan testing hanya demi formalitas.

---

# 13. NEVER STACK KNOWN ERRORS

Jika menemukan error nyata:

**jangan sengaja membiarkan error tersebut menumpuk.**

Gunakan:

```text
IDENTIFY
↓
ROOT CAUSE
↓
IMPACT
↓
FIX
↓
VERIFY
```

Jangan hanya menambal error message.

---

# 14. BUILD THE BACKEND FROM ZERO

Bangun backend TALOG20 secara clean.

Rancang:

* authentication
* users
* roles
* permissions
* middleware
* API
* models
* relationships
* migrations
* controllers
* validation
* authorization

Gunakan database sebagai source of truth.

Jangan membuat fake backend.

Jangan membuat data penting hardcoded di frontend apabila seharusnya berasal dari database.

---

# 15. BUILD THE FRONTEND FROM ZERO

Bangun frontend TALOG20 dari foundation yang clean.

Gunakan architecture yang sesuai dengan stack project.

Pastikan:

* reusable components
* clean layout
* proper state management
* proper API integration
* responsive behaviour
* accessibility yang masuk akal
* loading state
* error state
* empty state

Jangan membuat UI yang hanya terlihat bekerja.

---

# 16. AUTHENTICATION + RBAC

Implementasikan:

* login
* logout
* authentication
* authorization
* roles
* permissions
* protected routes
* middleware

# SYSTEM ROLES
TALOG20 membutuhkan 3 role utama. Pendekatan saat ini adalah **Role-Based Only** (menggunakan pengecekan nama role tanpa mendefinisikan permission granular di database untuk saat ini).

1. **Admin** 
   * Akses penuh ke semua data, pengaturan sistem, kelola user/role, serta data operasional (jurusan, deskripsi, konten).
   * 1 akun default harus dibuat oleh seeder (`admin@talogsmkn20.local`).
2. **Guru** 
   * Bisa menambahkan tugas akhir baru sesuai dengan jurusan yang di-assign pada akunnya saat dibuat (oleh Admin).
3. **Siswa** 
   * Bisa melihat tugas akhir dari guru.
   * Bisa mengupdate progres tugas akhir dengan foto/lain sesuai dengan prompt awal.

# ADMIN

1 akun Admin default.

Admin harus benar-benar dapat:

* login
* mengakses admin area
* mengelola data operasional (jurusan, dll)
* mengelola user (CRUD user & role assignment)
* mengakses seluruh fitur administratif sistem dengan role-based check (`hasRole('Admin')`)

Credential final harus diberikan setelah account benar-benar berhasil dibuat dan diverifikasi.

---

# 17. ADMIN DATA MANAGEMENT

Admin harus dapat mengelola data yang diperlukan TALOG20.

Termasuk:

* jurusan
* deskripsi jurusan
* data yang diperlukan theme
* data aplikasi lain yang memang diperlukan

Data harus:

**database-driven**

jika memang harus customizable.

Jangan hardcode data yang seharusnya dapat diubah administrator.

---

# 18. THEME SYSTEM — BUILD FROM ZERO

Buat sistem theme dari awal.

Jangan menganggap ada theme lama yang harus dimodifikasi.

TALOG20 memiliki dua theme utama:

# EDUCATION

dan

# FUTURISTIC DIGITAL

Keduanya harus dibuat sebagai **dua visual identity yang berbeda dari awal**.

---

# 19. EDUCATION THEME

Education bukan:

> “theme lama Terang yang diganti nama”

Education harus merupakan:

# NEW THEME CREATED FROM ZERO

Tidak ada konsep:

`theme lama`

Tidak ada konsep:

`Terang`

yang harus dipertahankan.

Buat Education sebagai visual identity baru.

Karakter:

* educational
* elegant
* modern
* clean
* interactive
* cinematic
* sophisticated

Gunakan website:

`https://www.bimbelnurulfikri.id/`

sebagai visual reference.

Gunakan hanya sebagai:

* inspiration
* color reference
* atmosphere reference
* layout reference
* educational visual reference

Jangan copy-paste desain.

---

# 20. EDUCATION 3D EXPERIENCE

Buat 3D intro khusus Education dari awal.

Konsep:

# ANIMATED BOOK

Flow:

```text
Book Closed
↓
Book Opens
↓
First Page
↓
SMKN 20 Logo
↓
SMKN 20 Majors
↓
Navigation
↓
Majors Page
```

Gunakan logo SMKN 20 yang tersedia di folder project.

Jika diperlukan:

remove background agar cocok dengan scene.

Gunakan:

* lighting
* depth
* shadows
* smooth animation
* subtle VFX
* cursor interaction
* polished motion

---

# 21. EDUCATION — MAJORS PAGE

Halaman berikutnya:

tampilkan jurusan SMKN 20.

Data jurusan harus berasal dari database.

Hover jurusan:

→ tampilkan deskripsi/information tambahan.

Admin harus dapat mengubah:

* nama jurusan
* deskripsi
* informasi terkait

tanpa mengubah source code.

---

# 22. EDUCATION — BERANDA

Pada Education 3D experience:

tambahkan tombol:

# Beranda

Klik:

```text
Education 3D
↓
Transition
↓
Main Home
```

---

# 23. FUTURISTIC DIGITAL THEME

Futuristic Digital juga dibuat dari awal.

Jangan menganggapnya sebagai:

> “theme luar angkasa lama yang diganti nama”

Tidak ada theme lama yang harus dipertahankan.

Buat visual identity baru:

# FUTURISTIC DIGITAL / EXPERIMENTAL WEBGL

Karakter:

* dark futuristic
* cyber
* synthwave
* glassmorphism
* organic 3D
* particles
* digital glitch
* CRT atmosphere
* cinematic motion
* immersive interaction

---

# 24. FUTURISTIC DIGITAL 3D EXPERIENCE

Video reference yang berada di folder project harus digunakan sebagai **visual reference utama** untuk konsep motion Futuristic Digital.

Gunakan untuk memahami:

* camera movement
* object movement
* pacing
* scene composition
* cinematic feeling
* scroll-based interaction jika relevan
* visual transitions

Jangan copy-paste.

Buat implementation sendiri menggunakan teknologi project.

Jangan membuat versi sederhana hanya karena lebih mudah.

---

# 25. FUTURISTIC DIGITAL LOGO

Pada scene Futuristic Digital:

gunakan logo SMKN 20 yang tersedia di project sebagai logo utama.

Logo harus menyatu secara natural dengan scene.

Tambahkan:

# Beranda

pada lokasi yang sesuai dengan desain.

---

# 26. FUTURISTIC DIGITAL VISUAL SYSTEM

Gunakan:

### Dark Futuristic

Background dark.

### Cyber / Synthwave

Accent:

* purple
* cyan
* green
* glow

### Glassmorphism

Transparent glass panels.

### Organic 3D

Abstract 3D shapes.

### Particles

Gunakan secukupnya.

### Digital Glitch / CRT

Gunakan secara subtle.

### Cinematic

Gunakan smooth camera/object movement.

---

# 27. THEMES MUST BE VISUALLY DISTINCT

Education dan Futuristic Digital tidak boleh hanya berbeda warna.

Perbedaan harus terlihat pada:

* layout
* typography
* components
* navigation
* background
* animation
* 3D
* VFX
* transition
* interaction
* UX

Saat user mengganti theme:

harus langsung terasa bahwa ia masuk ke visual world yang berbeda.

---

# 28. DEFAULT THEME

Default theme:

# EDUCATION

Tidak perlu mempertahankan konsep theme lama.

Education adalah default sejak awal.

---

# 29. LOGIN EXPERIENCE

Setelah login:

```text
LOGIN
↓
LOADING TRANSITION
↓
THEME-SPECIFIC 3D EXPERIENCE
↓
BERANDA
↓
MAIN APPLICATION
```

Education mempunyai scene Education.

Futuristic Digital mempunyai scene Futuristic Digital.

Jangan memakai scene yang sama lalu hanya mengganti warna.

---

# 30. THEME SWITCHING

Saat user berpindah theme:

```text
CURRENT THEME
↓
THEME LOADING
↓
THEME-SPECIFIC TRANSITION / VFX
↓
NEW THEME
```

Transition harus terasa sesuai dengan theme tujuan.

---

# 31. PAGE TRANSITIONS

Gunakan smooth page transition.

Namun jangan membuat transition berlebihan sampai mengganggu usability.

Transition khusus:

* login → loading → 3D
* 3D → Beranda
* theme switching

harus memiliki behaviour yang berbeda dan sesuai konteks.

---

# 32. PERFORMANCE

Target:

# HIGH QUALITY + SMOOTH + OPTIMIZED

Optimalkan:

* geometry
* polygons
* textures
* particles
* render resolution
* GPU
* CPU
* memory
* asset loading
* lazy loading
* WebGL rendering

Gunakan fallback/reduced effects bila memang diperlukan pada perangkat yang lebih lemah.

Jangan mengorbankan visual secara berlebihan.

Namun jangan membuat visual sangat berat hanya demi efek.

---

# 33. RESPONSIVE

Pastikan:

* desktop
* tablet jika relevan
* mobile

memiliki behaviour yang masuk akal.

3D tidak boleh menghancurkan layout mobile.

UI harus tetap usable meskipun device tidak mendukung pengalaman 3D secara optimal.

---

# 34. ASSET MANAGEMENT

Gunakan asset yang tersedia di folder project.

Contoh:

```text
C:\laragon\www\Talogsmkn20\
```

Cari asset berdasarkan nama dan tipe file.

Jangan mengasumsikan nama asset secara persis.

Jangan membuat duplicate asset tanpa alasan.

Jangan memindahkan asset user ke lokasi random.

Buat struktur asset yang clean.

---

# 35. DO NOT OVERWRITE USER ASSETS

Jangan menimpa asset asli yang diberikan pengguna.

Jika perlu melakukan:

* optimization
* background removal
* conversion
* compression
* resizing

buat versi processed/copy untuk digunakan aplikasi.

Tetap pertahankan original asset.

---

# 36. NO FAKE FUNCTIONALITY

Jangan membuat:

* fake CRUD
* fake authentication
* fake loading
* fake database
* fake API
* static admin UI
* hardcoded database replacement

Jika sebuah feature terlihat bisa digunakan:

feature tersebut harus benar-benar bekerja.

---

# 37. REFACTORING

Karena ini fresh build:

prioritaskan architecture yang clean sejak awal.

Tidak perlu compatibility terhadap architecture lama.

Jika menemukan implementation yang buruk di project baru:

perbaiki sedini mungkin.

Jangan membangun lebih banyak feature di atas foundation yang diketahui rusak.

---

# 38. SMART DEBUGGING

Ketika terjadi error:

jangan langsung membuat workaround acak.

Analisis:

* root cause
* dependency
* data flow
* relationship
* state
* environment
* side effects

Kemudian lakukan:

```text
ROOT CAUSE
↓
FIX
↓
TARGETED VERIFY
```

---

# 39. WHEN TO RUN / TEST

Tidak semua perubahan membutuhkan full test.

### Tidak perlu full test:

* perubahan text
* copywriting
* minor CSS
* spacing
* isolated visual adjustments

### Perlu targeted test:

* shared components
* navigation
* API integration
* frontend state
* theme switching

### Wajib verification serius:

* authentication
* authorization
* database
* migrations
* backend
* API
* routing
* dependencies
* WebGL architecture
* major refactoring
* production/build configuration

### Final stage:

lakukan comprehensive regression test.

---

# 40. FINAL TESTING

Sebelum menyatakan selesai:

periksa:

### Authentication

* login
* logout
* protected route
* permissions
* roles
* Super Admin

### Database

* connection
* migrations
* relationships
* CRUD
* persistence

### Admin

* jurusan
* deskripsi
* data management

### Education

* theme
* default theme
* book 3D
* logo
* majors
* hover information
* Beranda
* transition

### Futuristic Digital

* theme
* 3D experience
* logo
* interaction
* Beranda
* transition

### Navigation

* page transition
* buttons
* links
* routes

### Technical

* runtime errors
* console errors
* failed requests
* broken assets
* API errors
* database errors
* responsive behaviour
* performance

---

# 41. FINAL QUALITY GATE

Jangan menyatakan project selesai hanya karena:

* source code selesai
* build berhasil
* UI terlihat bagus

Project hanya selesai apabila:

```text
FUNCTIONAL
+
DATABASE CONNECTED
+
BACKEND CONNECTED
+
FRONTEND CONNECTED
+
AUTH WORKS
+
ADMIN WORKS
+
THEMES WORK
+
3D WORKS
+
NAVIGATION WORKS
+
RESPONSIVE
+
PERFORMANCE ACCEPTABLE
+
NO KNOWN CRITICAL BUG
```

---

# 42. DEVELOPMENT ORDER

Gunakan urutan:

```text
READ CLAUDE.md
↓
INSPECT CURRENT LARAVEL SKELETON
↓
INSPECT USER-PROVIDED ASSETS
↓
PLAN CLEAN ARCHITECTURE
↓
DATABASE FOUNDATION
↓
AUTHENTICATION
↓
RBAC
↓
CORE BACKEND
↓
CORE FRONTEND
↓
ADMIN
↓
JURUSAN + DESCRIPTIONS
↓
TUGAS AKHIR (ASSIGNMENT & PROGRESS)
↓
EDUCATION THEME
↓
EDUCATION 3D BOOK
↓
FUTURISTIC DIGITAL THEME
↓
FUTURISTIC DIGITAL 3D
↓
THEME SWITCHING
↓
PAGE TRANSITIONS
↓
RESPONSIVE
↓
PERFORMANCE
↓
REGRESSION TEST
↓
FINAL FIXES
↓
FINAL VERIFICATION
```

Gunakan development secara bertahap.

Jangan melakukan huge implementation dump yang membuat debugging sulit.

Namun jangan menjalankan full test suite setelah setiap perubahan kecil.

Gunakan:

**RISK ASSESSMENT → APPROPRIATE VERIFICATION**

---

# 43. WHEN USER SAYS "LANJUT"

Jika pengguna hanya mengatakan:

# `lanjut`

maka:

1. periksa kondisi project saat ini
2. identifikasi milestone terakhir
3. periksa known issues
4. lanjutkan dari progress terakhir

Jangan:

* membuat project baru
* menghapus progress
* mengulang pekerjaan yang sudah selesai
* mengubah architecture tanpa alasan

---

# 44. ABSOLUTE ENVIRONMENT RULE

Target project:

`C:\laragon\www\Talogsmkn20`

Laragon:

`C:\laragon\laragon.exe`

Web root:

`C:\laragon\www`

PHP:

`8.3.33`

Composer:

`2.10.3`

MySQL:

`8.0.30`

Node.js:

`24.16.0`

npm:

`11.13.0`

**Gunakan environment yang sudah tersedia.**

**JANGAN UNINSTALL LARAGON.**

**JANGAN REINSTALL LARAGON.**

**JANGAN MEMBUAT LARAGON BARU.**

**JANGAN MEMBUAT PROJECT LARAVEL KEDUA.**

---

# 45. ABSOLUTE DEVELOPMENT PRINCIPLE

Project ini adalah:

# FRESH BUILD FROM ZERO

Bukan:

# REFRESH / REFACTOR / MIGRATE PROJECT LAMA

Gunakan:

**ANALYZE → PLAN → BUILD → VERIFY WHEN NECESSARY → FIX → CONTINUE**

Bukan:

**COPY OLD PROJECT → MODIFY EVERYTHING → HOPE IT WORKS**

dan bukan:

**BUILD EVERYTHING → TEST EVERYTHING AT THE END**

Tujuan akhir:

# TALOG20

sebagai:

**PREMIUM MODERN WEB EXPERIENCE**

dengan:

**FULL FUNCTIONALITY + POLISHED UI + RESPONSIVE + OPTIMIZED + STABLE + CLEAN ARCHITECTURE**
