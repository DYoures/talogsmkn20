<?php

namespace Tests\Feature;

use App\Models\Jurusan;
use App\Models\NilaiTugas;
use App\Models\TugasAkhir;
use App\Models\TugasAkhirProgressLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class NilaiTugasTest extends TestCase
{
    use RefreshDatabase;

    private User $guru;
    private User $guruLain;
    private User $admin;
    private User $siswa;
    private Jurusan $jurusan;
    private TugasAkhir $tugasAkhir;

    protected function setUp(): void
    {
        parent::setUp();

        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        $roleGuru = Role::firstOrCreate(['name' => 'Guru']);
        $roleSiswa = Role::firstOrCreate(['name' => 'Siswa']);

        $this->jurusan = Jurusan::create([
            'name' => 'Rekayasa Perangkat Lunak',
            'description' => 'Jurusan RPL',
        ]);

        $this->admin = User::factory()->create(['name' => 'Admin User']);
        $this->admin->assignRole($roleAdmin);

        $this->guru = User::factory()->create(['name' => 'Guru RPL', 'jurusan_id' => $this->jurusan->id]);
        $this->guru->assignRole($roleGuru);

        $this->guruLain = User::factory()->create(['name' => 'Guru Lain', 'jurusan_id' => $this->jurusan->id]);
        $this->guruLain->assignRole($roleGuru);

        $this->siswa = User::factory()->create(['name' => 'Siswa 1', 'jurusan_id' => $this->jurusan->id]);
        $this->siswa->assignRole($roleSiswa);

        $this->tugasAkhir = TugasAkhir::create([
            'guru_id' => $this->guru->id,
            'jurusan_id' => $this->jurusan->id,
            'title' => 'Project Akhir Pemrograman Web',
            'description' => 'Instruksi tugas',
        ]);
    }

    public function test_baris_nilai_dibuat_otomatis_dan_disinkronkan(): void
    {
        // 1. Saat tugas dibuat melalui endpoint store oleh Guru
        $response = $this->actingAs($this->guru)->post(route('guru.tugas-akhir.store'), [
            'title' => 'Tugas Baru Otomatis',
            'description' => 'Deskripsi tugas baru',
        ]);

        $response->assertRedirect(route('guru.tugas-akhir.index'));
        $baru = TugasAkhir::where('title', 'Tugas Baru Otomatis')->first();
        $this->assertNotNull($baru);

        $this->assertDatabaseHas('nilai_tugas', [
            'tugas_akhir_id' => $baru->id,
            'siswa_id' => $this->siswa->id,
        ]);

        // 2. Tambah siswa baru di jurusan, lalu buka halaman nilai untuk cek firstOrCreate sinkronisasi
        $roleSiswa = Role::firstOrCreate(['name' => 'Siswa']);
        $siswaBaru = User::factory()->create(['name' => 'Siswa Baru', 'jurusan_id' => $this->jurusan->id]);
        $siswaBaru->assignRole($roleSiswa);

        $this->actingAs($this->guru)->get(route('guru.tugas-akhir.nilai', $baru))
            ->assertOk();

        $this->assertDatabaseHas('nilai_tugas', [
            'tugas_akhir_id' => $baru->id,
            'siswa_id' => $siswaBaru->id,
        ]);
    }

    public function test_otorisasi_guru_hanya_tugas_miliknya_admin_semua_siswa_dilarang(): void
    {
        // Siswa dilarang akses
        $this->actingAs($this->siswa)
            ->get(route('guru.nilai.index'))
            ->assertForbidden();

        $this->actingAs($this->siswa)
            ->get(route('guru.tugas-akhir.nilai', $this->tugasAkhir))
            ->assertForbidden();

        // Guru lain dilarang akses tugas milik guru utama
        $this->actingAs($this->guruLain)
            ->get(route('guru.tugas-akhir.nilai', $this->tugasAkhir))
            ->assertForbidden();

        // Guru pemilik tugas diizinkan
        $this->actingAs($this->guru)
            ->get(route('guru.tugas-akhir.nilai', $this->tugasAkhir))
            ->assertOk();

        // Admin diizinkan akses semua
        $this->actingAs($this->admin)
            ->get(route('admin.nilai.index'))
            ->assertOk();

        $this->actingAs($this->admin)
            ->get(route('admin.tugas-akhir.nilai', $this->tugasAkhir))
            ->assertOk();
    }

    public function test_nilai_terkunci_sebelum_siswa_menyelesaikan_tugas(): void
    {
        $nilai = NilaiTugas::firstOrCreate([
            'tugas_akhir_id' => $this->tugasAkhir->id,
            'siswa_id' => $this->siswa->id,
        ]);

        // Siswa belum completed, guru coba isi nilai
        $response = $this->actingAs($this->guru)->patchJson(route('guru.nilai.update', $nilai), [
            'nilai' => 85,
            'catatan' => 'Bagus',
        ]);

        $response->assertStatus(422)
            ->assertJson(['success' => false]);

        $this->assertNull($nilai->fresh()->nilai);

        // Siswa menyelesaikan tugas
        TugasAkhirProgressLog::create([
            'tugas_akhir_id' => $this->tugasAkhir->id,
            'siswa_id' => $this->siswa->id,
            'status' => 'completed',
            'notes' => 'Tugas sudah selesai',
        ]);

        // Guru isi nilai setelah selesai
        $responseSuccess = $this->actingAs($this->guru)->patchJson(route('guru.nilai.update', $nilai), [
            'nilai' => 90,
            'catatan' => 'Sangat memuaskan',
        ]);

        $responseSuccess->assertOk()
            ->assertJson(['success' => true]);

        $this->assertEquals(90, $nilai->fresh()->nilai);
        $this->assertEquals('Sangat memuaskan', $nilai->fresh()->catatan);
        $this->assertEquals($this->guru->id, $nilai->fresh()->dinilai_oleh);
    }

    public function test_validasi_nilai_harus_1_sampai_100(): void
    {
        $nilai = NilaiTugas::firstOrCreate([
            'tugas_akhir_id' => $this->tugasAkhir->id,
            'siswa_id' => $this->siswa->id,
        ]);

        TugasAkhirProgressLog::create([
            'tugas_akhir_id' => $this->tugasAkhir->id,
            'siswa_id' => $this->siswa->id,
            'status' => 'completed',
        ]);

        // Nilai > 100
        $this->actingAs($this->guru)->patchJson(route('guru.nilai.update', $nilai), [
            'nilai' => 105,
        ])->assertStatus(422);

        // Nilai < 1
        $this->actingAs($this->guru)->patchJson(route('guru.nilai.update', $nilai), [
            'nilai' => 0,
        ])->assertStatus(422);

        // Nilai valid
        $this->actingAs($this->guru)->patchJson(route('guru.nilai.update', $nilai), [
            'nilai' => 88,
        ])->assertOk();

        $this->assertEquals(88, $nilai->fresh()->nilai);
    }

    public function test_export_excel_dapat_diunduh_dan_berhasil(): void
    {
        NilaiTugas::firstOrCreate([
            'tugas_akhir_id' => $this->tugasAkhir->id,
            'siswa_id' => $this->siswa->id,
            'nilai' => 95,
            'catatan' => 'Karya istimewa',
            'dinilai_oleh' => $this->guru->id,
            'dinilai_at' => now(),
        ]);

        // Guru export
        $responseGuru = $this->actingAs($this->guru)
            ->get(route('guru.tugas-akhir.export-nilai', $this->tugasAkhir));

        $responseGuru->assertOk();
        $this->assertTrue(
            str_contains($responseGuru->headers->get('content-disposition') ?? '', '.xlsx') ||
            str_contains($responseGuru->headers->get('content-type') ?? '', 'spreadsheet')
        );

        // Admin export
        $responseAdmin = $this->actingAs($this->admin)
            ->get(route('admin.tugas-akhir.export-nilai', $this->tugasAkhir));

        $responseAdmin->assertOk();
    }
}
