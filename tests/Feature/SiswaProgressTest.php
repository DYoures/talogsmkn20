<?php

namespace Tests\Feature;

use App\Models\Jurusan;
use App\Models\TugasAkhir;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class SiswaProgressTest extends TestCase
{
    use RefreshDatabase;

    public function test_siswa_can_submit_progress_with_photo()
    {
        Storage::fake('public');

        $roleGuru = Role::firstOrCreate(['name' => 'Guru']);
        $roleSiswa = Role::firstOrCreate(['name' => 'Siswa']);

        $jurusan = Jurusan::create([
            'name' => 'Rekayasa Perangkat Lunak',
            'description' => 'Jurusan RPL',
        ]);

        $guru = User::factory()->create([
            'jurusan_id' => $jurusan->id,
        ]);
        $guru->assignRole($roleGuru);

        $siswa = User::factory()->create([
            'jurusan_id' => $jurusan->id,
        ]);
        $siswa->assignRole($roleSiswa);

        $tugasAkhir = TugasAkhir::create([
            'guru_id' => $guru->id,
            'jurusan_id' => $jurusan->id,
            'title' => 'Project Akhir Web',
            'description' => 'Deskripsi tugas akhir',
        ]);

        $file = UploadedFile::fake()->image('progress.jpg', 600, 600);

        $response = $this->actingAs($siswa)->post("/siswa/progress/{$tugasAkhir->id}", [
            'status' => 'in_progress',
            'notes' => 'Mengerjakan halaman frontend',
            'photo' => $file,
        ]);

        $response->assertRedirect(route('siswa.tugas-akhir.show', $tugasAkhir));
        $log = \App\Models\TugasAkhirProgressLog::where('tugas_akhir_id', $tugasAkhir->id)->first();
        $this->assertNotNull($log);
        $this->assertNotNull($log->photo_path);
        Storage::disk('public')->assertExists($log->photo_path);
    }

    public function test_siswa_can_submit_progress_without_photo()
    {
        Storage::fake('public');

        $roleGuru = Role::firstOrCreate(['name' => 'Guru']);
        $roleSiswa = Role::firstOrCreate(['name' => 'Siswa']);

        $jurusan = Jurusan::create([
            'name' => 'Multimedia',
            'description' => 'Jurusan MM',
        ]);

        $guru = User::factory()->create(['jurusan_id' => $jurusan->id]);
        $guru->assignRole($roleGuru);

        $siswa = User::factory()->create(['jurusan_id' => $jurusan->id]);
        $siswa->assignRole($roleSiswa);

        $tugasAkhir = TugasAkhir::create([
            'guru_id' => $guru->id,
            'jurusan_id' => $jurusan->id,
            'title' => 'Video Animasi 3D',
            'description' => 'Deskripsi tugas',
        ]);

        $response = $this->actingAs($siswa)->post("/siswa/progress/{$tugasAkhir->id}", [
            'status' => 'completed',
            'notes' => 'Tugas telah selesai',
        ]);

        $response->assertRedirect(route('siswa.tugas-akhir.show', $tugasAkhir));
        $this->assertDatabaseHas('tugas_akhir_progress_logs', [
            'tugas_akhir_id' => $tugasAkhir->id,
            'siswa_id' => $siswa->id,
            'status' => 'completed',
            'notes' => 'Tugas telah selesai',
            'photo_path' => null,
        ]);
    }

    public function test_siswa_cannot_submit_progress_for_different_jurusan()
    {
        $roleGuru = Role::firstOrCreate(['name' => 'Guru']);
        $roleSiswa = Role::firstOrCreate(['name' => 'Siswa']);

        $jurusan1 = Jurusan::create(['name' => 'RPL', 'description' => 'Jurusan 1']);
        $jurusan2 = Jurusan::create(['name' => 'TKJ', 'description' => 'Jurusan 2']);

        $guru = User::factory()->create(['jurusan_id' => $jurusan2->id]);
        $guru->assignRole($roleGuru);

        $siswa = User::factory()->create(['jurusan_id' => $jurusan1->id]);
        $siswa->assignRole($roleSiswa);

        $tugasAkhir = TugasAkhir::create([
            'guru_id' => $guru->id,
            'jurusan_id' => $jurusan2->id,
            'title' => 'Jaringan LAN',
            'description' => 'Deskripsi',
        ]);

        $response = $this->actingAs($siswa)->post("/siswa/progress/{$tugasAkhir->id}", [
            'status' => 'in_progress',
            'notes' => 'Coba akses',
        ]);

        $response->assertStatus(403);
    }
}
