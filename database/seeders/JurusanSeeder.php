<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\User;
use App\Models\TugasAkhir;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        $jurusansData = [
            [
                'name'         => 'Bisnis Retail',
                'kode'         => 'BR',
                'slug'         => 'bisnis-retail',
                'accent_color' => '#8B5CF6',
                'description'  => 'Program keahlian yang menyiapkan peserta didik untuk mengelola aktivitas ritel dari penataan barang, pelayanan pelanggan, transaksi, promosi, hingga pengelolaan operasional toko dan kanal penjualan.',
                'akreditasi'   => 'A (Unggul)',
                'kurikulum'    => [
                    'Dasar-Dasar Bisnis Retail',
                    'Pengelolaan Barang dan Persediaan',
                    'Penataan dan Display Produk',
                    'Pelayanan dan Pengalaman Pelanggan',
                    'Transaksi Penjualan dan Kasir',
                    'Administrasi Penjualan',
                    'Promosi dan Visual Merchandising',
                    'Penjualan Berbasis Digital',
                ],
                'prospek_karir' => [
                    'Pramuniaga / Retail Associate',
                    'Kasir',
                    'Store Crew / Store Supervisor',
                    'Merchandiser',
                    'Sales Promotion',
                    'Admin Penjualan',
                    'Entrepreneur / Pemilik Usaha Ritel',
                ],
                'tools_industri' => [
                    'POS / sistem kasir',
                    'Microsoft Excel / Google Sheets',
                    'Platform marketplace',
                    'Canva',
                    'WhatsApp Business',
                    'Aplikasi inventori sederhana',
                ],
            ],
            [
                'name'         => 'Bisnis Digital',
                'kode'         => 'BD',
                'slug'         => 'bisnis-digital',
                'accent_color' => '#06B6D4',
                'description'  => 'Program keahlian yang berfokus pada pengelolaan bisnis dengan dukungan teknologi digital, mulai dari pemasaran digital, konten, marketplace, media sosial, analisis data sederhana, hingga pengembangan strategi bisnis online.',
                'akreditasi'   => 'A (Unggul)',
                'kurikulum'    => [
                    'Dasar-Dasar Bisnis Digital',
                    'Pemasaran Digital',
                    'Content Creation dan Content Planning',
                    'Marketplace dan E-Commerce',
                    'Media Sosial untuk Bisnis',
                    'Copywriting dan Komunikasi Pemasaran',
                    'Customer Relationship Management',
                    'Analisis Data Bisnis Dasar',
                ],
                'prospek_karir' => [
                    'Digital Marketing Specialist',
                    'Social Media Specialist',
                    'Content Creator',
                    'Marketplace Specialist',
                    'E-Commerce Admin',
                    'Customer Relationship Officer',
                    'Digital Sales',
                    'Entrepreneur / Online Business Owner',
                ],
                'tools_industri' => [
                    'Canva',
                    'Meta Business Suite',
                    'Google Analytics / tools analitik sejenis',
                    'Marketplace Seller Center',
                    'Google Workspace',
                    'Microsoft Excel / Google Sheets',
                    'Tools AI untuk ideasi dan produksi konten',
                ],
            ],
            [
                'name'         => 'Rekayasa Perangkat Lunak',
                'kode'         => 'RPL',
                'slug'         => 'rekayasa-perangkat-lunak',
                'accent_color' => '#3B82F6',
                'description'  => 'Program keahlian yang membekali peserta didik dengan kemampuan merancang, membangun, menguji, mendokumentasikan, dan memelihara perangkat lunak berbasis web, desktop, maupun aplikasi digital sesuai kebutuhan pengguna.',
                'akreditasi'   => 'A (Unggul)',
                'kurikulum'    => [
                    'Dasar-Dasar Pengembangan Perangkat Lunak',
                    'Algoritma dan Pemrograman',
                    'Pemrograman Berorientasi Objek',
                    'Basis Data',
                    'Pengembangan Web Front-End dan Back-End',
                    'Perancangan Antarmuka / UI-UX',
                    'Pengujian Perangkat Lunak',
                    'Proyek Perangkat Lunak dan Deployment',
                ],
                'prospek_karir' => [
                    'Web Developer / Full-Stack Developer',
                    'Front-End Developer',
                    'Back-End Developer',
                    'Software Engineer',
                    'Database Administrator Junior',
                    'QA / Software Tester',
                    'UI/UX Designer',
                    'Junior Mobile App Developer',
                ],
                'tools_industri' => [
                    'Visual Studio Code',
                    'Git & GitHub',
                    'PHP / Laravel',
                    'JavaScript',
                    'React.js',
                    'MySQL',
                    'Figma',
                    'Postman',
                    'Node.js / npm',
                ],
            ],
            [
                'name'         => 'Layanan Perbankan Syariah',
                'kode'         => 'LPS',
                'slug'         => 'layanan-perbankan-syariah',
                'accent_color' => '#10B981',
                'description'  => 'Program keahlian yang menyiapkan peserta didik memahami operasional layanan perbankan dengan prinsip syariah, pelayanan nasabah, administrasi transaksi, produk perbankan, dan prosedur kerja lembaga keuangan.',
                'akreditasi'   => 'A (Unggul)',
                'kurikulum'    => [
                    'Dasar-Dasar Perbankan Syariah',
                    'Produk dan Akad Perbankan Syariah',
                    'Layanan Nasabah',
                    'Administrasi dan Dokumentasi Perbankan',
                    'Transaksi dan Operasional Bank',
                    'Pengelolaan Kas dan Transaksi Teller',
                    'Pemasaran Produk Jasa Keuangan',
                    'Etika dan Kepatuhan Perbankan',
                ],
                'prospek_karir' => [
                    'Customer Service Bank Syariah',
                    'Teller',
                    'Admin Operasional Perbankan',
                    'Marketing Produk Keuangan',
                    'Staff Pembiayaan Junior',
                    'Staff Administrasi Lembaga Keuangan',
                    'Frontliner Lembaga Keuangan Syariah',
                ],
                'tools_industri' => [
                    'Microsoft Excel',
                    'Microsoft Word / Google Docs',
                    'Aplikasi administrasi perbankan',
                    'Sistem antrean / layanan nasabah',
                    'Aplikasi komunikasi dan CRM',
                    'Perangkat simulasi transaksi perbankan',
                ],
            ],
            [
                'name'         => 'Akuntansi dan Keuangan Lembaga',
                'kode'         => 'AKL',
                'slug'         => 'akuntansi-dan-keuangan-lembaga',
                'accent_color' => '#F59E0B',
                'description'  => 'Program keahlian yang membekali peserta didik untuk mengidentifikasi dan mencatat transaksi, menyusun laporan keuangan, mengelola administrasi keuangan, serta menggunakan aplikasi akuntansi secara terstruktur dan teliti.',
                'akreditasi'   => 'A (Unggul)',
                'kurikulum'    => [
                    'Dasar-Dasar Akuntansi dan Keuangan',
                    'Bukti Transaksi dan Jurnal',
                    'Buku Besar dan Neraca Saldo',
                    'Akuntansi Perusahaan Jasa dan Dagang',
                    'Akuntansi Perusahaan Manufaktur',
                    'Penyusunan Laporan Keuangan',
                    'Akuntansi Pajak',
                    'Akuntansi Berbasis Komputer dan Administrasi Perbankan',
                ],
                'prospek_karir' => [
                    'Staff Accounting',
                    'Accounting Administrator',
                    'Finance Administration Staff',
                    'Tax Administration Junior',
                    'Accounts Payable / Receivable Staff',
                    'Payroll Administration',
                    'Junior Bookkeeper',
                    'Admin Keuangan',
                ],
                'tools_industri' => [
                    'Microsoft Excel',
                    'Microsoft Word / Google Sheets',
                    'Aplikasi akuntansi',
                    'Software perpajakan',
                    'Sistem ERP / keuangan dasar',
                    'Google Workspace',
                ],
            ],
            [
                'name'         => 'Manajemen Perkantoran dan Layanan Bisnis',
                'kode'         => 'MPLB',
                'slug'         => 'manajemen-perkantoran-dan-layanan-bisnis',
                'accent_color' => '#EC4899',
                'description'  => 'Program keahlian yang mempersiapkan peserta didik mengelola administrasi perkantoran, korespondensi, kearsipan, pelayanan bisnis, pengelolaan dokumen, agenda, dan pekerjaan kantor berbasis teknologi digital.',
                'akreditasi'   => 'A (Unggul)',
                'kurikulum'    => [
                    'Dasar-Dasar Manajemen Perkantoran dan Layanan Bisnis',
                    'Administrasi Perkantoran',
                    'Korespondensi dan Surat-Menyurat',
                    'Kearsipan dan Pengelolaan Dokumen',
                    'Teknologi Perkantoran',
                    'Agenda dan Protokoler',
                    'Pelayanan Pelanggan / Layanan Bisnis',
                    'Pengelolaan Rapat dan Perjalanan Dinas',
                ],
                'prospek_karir' => [
                    'Administrasi Perkantoran',
                    'Office Administrator',
                    'Secretary / Administrative Assistant',
                    'Customer Service',
                    'Front Office Staff',
                    'Document Controller Junior',
                    'Receptionist',
                    'Staff Layanan Bisnis',
                ],
                'tools_industri' => [
                    'Microsoft Word',
                    'Microsoft Excel',
                    'Google Workspace',
                    'Microsoft PowerPoint',
                    'Google Drive',
                    'Aplikasi e-office / document management',
                    'Aplikasi rapat daring',
                ],
            ],
        ];

        // Seed 6 Official Jurusan
        $createdJurusans = [];
        foreach ($jurusansData as $data) {
            $createdJurusans[$data['kode']] = Jurusan::updateOrCreate(
                ['kode' => $data['kode']],
                $data
            );
        }

        // Roles
        $guruRole  = Role::firstOrCreate(['name' => 'Guru']);
        $siswaRole = Role::firstOrCreate(['name' => 'Siswa']);

        // Account configurations per Jurusan
        $accounts = [
            'BR' => [
                'guru_name'  => 'Guru Bisnis Retail',
                'guru_email' => 'guru.br@talogsmkn20.local',
                'siswa_name' => 'Siswa Bisnis Retail',
                'siswa_email'=> 'siswa.br@talogsmkn20.local',
                'ta_title'   => 'Pengembangan Standar Operasional Toko Retail Modern & Digital Point-of-Sale',
                'ta_desc'    => 'Penyusunan alur penataan rak display, manajemen stok inventori berbasis aplikasi, dan simulasi transaksi kasir POS terintegrasi.',
            ],
            'BD' => [
                'guru_name'  => 'Guru Bisnis Digital',
                'guru_email' => 'guru.bd@talogsmkn20.local',
                'siswa_name' => 'Siswa Bisnis Digital',
                'siswa_email'=> 'siswa.bd@talogsmkn20.local',
                'ta_title'   => 'Penerapan Strategi Pemasaran Digital Omnichannel & Manajemen Konten E-Commerce',
                'ta_desc'    => 'Optimalisasi kanal penjualan marketplace, perancangan konten promosi media sosial, dan analisis performa metrik pemasaran.',
            ],
            'RPL' => [
                'guru_name'  => 'Guru Rekayasa Perangkat Lunak',
                'guru_email' => 'guru.rpl@talogsmkn20.local',
                'siswa_name' => 'Siswa Rekayasa Perangkat Lunak',
                'siswa_email'=> 'siswa.rpl@talogsmkn20.local',
                'ta_title'   => 'Rancang Bangun Sistem Informasi Logistik & Dokumentasi Tugas Akhir Terpadu',
                'ta_desc'    => 'Pengembangan platform web interaktif berbasis arsitektur modern untuk pengelolaan alur bimbingan dan pelacakan progres siswa.',
            ],
            'LPS' => [
                'guru_name'  => 'Guru Layanan Perbankan Syariah',
                'guru_email' => 'guru.lps@talogsmkn20.local',
                'siswa_name' => 'Siswa Layanan Perbankan Syariah',
                'siswa_email'=> 'siswa.lps@talogsmkn20.local',
                'ta_title'   => 'Simulasi Pelayanan Frontliner & Pengelolaan Akad Pembiayaan Lembaga Keuangan Syariah',
                'ta_desc'    => 'Praktik administrasi pembukaan rekening, simulasi teller operasional, dan kepatuhan prosedur akad syariah berstandar perbankan.',
            ],
            'AKL' => [
                'guru_name'  => 'Guru Akuntansi Keuangan Lembaga',
                'guru_email' => 'guru.akl@talogsmkn20.local',
                'siswa_name' => 'Siswa Akuntansi Keuangan Lembaga',
                'siswa_email'=> 'siswa.akl@talogsmkn20.local',
                'ta_title'   => 'Penyusunan Laporan Keuangan Komprehensif Berbasis Siklus Akuntansi Perusahaan',
                'ta_desc'    => 'Pencatatan bukti transaksi, penyusunan jurnal umum, buku besar, neraca saldo hingga pelaporan keuangan terintegrasi spreadsheet.',
            ],
            'MPLB' => [
                'guru_name'  => 'Guru Manajemen Perkantoran',
                'guru_email' => 'guru.mplb@talogsmkn20.local',
                'siswa_name' => 'Siswa Manajemen Perkantoran',
                'siswa_email'=> 'siswa.mplb@talogsmkn20.local',
                'ta_title'   => 'Digitalisasi Tata Kelola Arsip Dinamis & Otomasi Korespondensi Administrasi Perkantoran',
                'ta_desc'    => 'Penerapan sistem pengelolaan naskah dinas elektronik, agenda pimpinan, dan pelayanan administrasi perkantoran digital.',
            ],
        ];

        foreach ($accounts as $kode => $acc) {
            $jurusan = $createdJurusans[$kode] ?? null;
            if (!$jurusan) continue;

            // 1. Create / Update Guru
            $guru = User::firstOrCreate(
                ['email' => $acc['guru_email']],
                [
                    'name'       => $acc['guru_name'],
                    'password'   => Hash::make('password123'),
                    'jurusan_id' => $jurusan->id,
                ]
            );
            $guru->jurusan_id = $jurusan->id;
            $guru->name = $acc['guru_name'];
            $guru->save();
            $guru->syncRoles([$guruRole]);

            // 2. Create / Update Siswa
            $siswa = User::firstOrCreate(
                ['email' => $acc['siswa_email']],
                [
                    'name'       => $acc['siswa_name'],
                    'password'   => Hash::make('password123'),
                    'jurusan_id' => $jurusan->id,
                ]
            );
            $siswa->jurusan_id = $jurusan->id;
            $siswa->name = $acc['siswa_name'];
            $siswa->save();
            $siswa->syncRoles([$siswaRole]);

            // 3. Create Sample Tugas Akhir for Guru & Siswa testing
            TugasAkhir::firstOrCreate(
                [
                    'guru_id'    => $guru->id,
                    'jurusan_id' => $jurusan->id,
                    'title'      => $acc['ta_title'],
                ],
                [
                    'description' => $acc['ta_desc'],
                ]
            );
        }

        // Additional test account for test compatibility
        $siswaRpl1 = User::firstOrCreate(
            ['email' => 'siswa.rpl1@talogsmkn20.local'],
            [
                'name'       => 'Siswa RPL 1',
                'password'   => Hash::make('password123'),
                'jurusan_id' => $createdJurusans['RPL']->id,
            ]
        );
        $siswaRpl1->syncRoles([$siswaRole]);
    }
}
