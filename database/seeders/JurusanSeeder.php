<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class JurusanSeeder extends Seeder
{
    public function run(): void
    {
        // Create Jurusans
        $jurusans = [
            ['name' => 'Rekayasa Perangkat Lunak', 'description' => 'Jurusan yang mempelajari pengembangan perangkat lunak, pemrograman, dan sistem informasi.'],
            ['name' => 'Teknik Komputer dan Jaringan', 'description' => 'Jurusan yang mempelajari jaringan komputer, instalasi, dan pemeliharaan sistem komputer.'],
            ['name' => 'Multimedia', 'description' => 'Jurusan yang mempelajari desain grafis, videografi, animasi, dan produksi konten digital.'],
            ['name' => 'Akuntansi', 'description' => 'Jurusan yang mempelajari pembukuan, laporan keuangan, dan manajemen keuangan bisnis.'],
        ];

        foreach ($jurusans as $jurusanData) {
            Jurusan::firstOrCreate(['name' => $jurusanData['name']], $jurusanData);
        }

        $rpl = Jurusan::where('name', 'Rekayasa Perangkat Lunak')->first();
        $tkj = Jurusan::where('name', 'Teknik Komputer dan Jaringan')->first();

        $guruRole = Role::findByName('Guru');
        $siswaRole = Role::findByName('Siswa');

        // Create dummy Guru
        $guru1 = User::firstOrCreate(
            ['email' => 'guru.rpl@talogsmkn20.local'],
            [
                'name' => 'Guru RPL',
                'password' => Hash::make('password123'),
                'jurusan_id' => $rpl->id,
            ]
        );
        $guru1->syncRoles([$guruRole]);

        $guru2 = User::firstOrCreate(
            ['email' => 'guru.tkj@talogsmkn20.local'],
            [
                'name' => 'Guru TKJ',
                'password' => Hash::make('password123'),
                'jurusan_id' => $tkj->id,
            ]
        );
        $guru2->syncRoles([$guruRole]);

        // Create dummy Siswa
        $siswa1 = User::firstOrCreate(
            ['email' => 'siswa.rpl1@talogsmkn20.local'],
            [
                'name' => 'Siswa RPL 1',
                'password' => Hash::make('password123'),
                'jurusan_id' => $rpl->id,
            ]
        );
        $siswa1->syncRoles([$siswaRole]);

        $siswa2 = User::firstOrCreate(
            ['email' => 'siswa.tkj1@talogsmkn20.local'],
            [
                'name' => 'Siswa TKJ 1',
                'password' => Hash::make('password123'),
                'jurusan_id' => $tkj->id,
            ]
        );
        $siswa2->syncRoles([$siswaRole]);
    }
}
