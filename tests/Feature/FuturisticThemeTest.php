<?php

namespace Tests\Feature;

use App\Models\Jurusan;
use Database\Seeders\JurusanSeeder;
use Database\Seeders\RolesAndAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FuturisticThemeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndAdminSeeder::class);
        $this->seed(JurusanSeeder::class);
    }

    public function test_can_switch_to_futuristic_theme_and_sets_session(): void
    {
        $response = $this->get('/theme/switch/futuristic');
        $response->assertRedirect(route('home'));
        $this->assertEquals('futuristic', session('talog_theme'));
    }

    public function test_beranda_renders_futuristic_view_when_session_is_futuristic(): void
    {
        $response = $this->withSession(['talog_theme' => 'futuristic'])->get('/beranda');
        $response->assertStatus(200);
        $response->assertSee('DIGITAL CYBER');
        $response->assertSee('Luncurkan 3D Cyber Core');
        $response->assertSee('SHOWCASE PROYEK TUGAS AKHIR');
        $response->assertSee('PROTOKOL ALUR KERJA TALOG20');
        $response->assertSee('Tema:');
        $response->assertSee('Edukasi');
    }

    public function test_futuristic_jurusan_index_renders_cyber_matrix(): void
    {
        $response = $this->withSession(['talog_theme' => 'futuristic'])->get('/jurusan');
        $response->assertStatus(200);
        $response->assertSee('MATRIX KONSENTRASI');
        $response->assertSee('SMKN 20 CYBER CORE');

        $jurusans = Jurusan::all();
        foreach ($jurusans as $j) {
            $response->assertSee($j->kode);
        }
    }

    public function test_futuristic_tentang_renders_cyber_dossier(): void
    {
        $response = $this->withSession(['talog_theme' => 'futuristic'])->get('/tentang');
        $response->assertStatus(200);
        $response->assertSee('DOSSIER SMKN 20');
        $response->assertSee('ARSITEKTUR PLATFORM TALOG20');
        $response->assertSee('NODE://SMKN20_JKT');
    }

    public function test_futuristic_navbar_active_state_switches_correctly(): void
    {
        // 1. On Home: Beranda has cyber active class
        $homeRes = $this->withSession(['talog_theme' => 'futuristic'])->get('/');
        $homeRes->assertStatus(200);
        $homeRes->assertSee('// BERANDA');
        $homeRes->assertSee('text-cyan-300 bg-cyan-500/15 border border-cyan-500/30', false);

        // 2. On Jurusan: Jurusan is active
        $jurusanRes = $this->withSession(['talog_theme' => 'futuristic'])->get('/jurusan');
        $jurusanRes->assertStatus(200);
        $jurusanRes->assertSee('// JURUSAN');

        // 3. On Tentang: Tentang is active
        $tentangRes = $this->withSession(['talog_theme' => 'futuristic'])->get('/tentang');
        $tentangRes->assertStatus(200);
        $tentangRes->assertSee('// TENTANG');
    }

    public function test_futuristic_3d_experience_renders_with_canvas_and_hud(): void
    {
        $response = $this->get('/futuristic/3d');
        $response->assertStatus(200);
        $response->assertSee('cyber-canvas');
        $response->assertSee('btn-beranda-cyber');
        $response->assertSee('TALOG20_DATA');
        $response->assertSee('majors-stream');
        $response->assertSee('stream-card');
        $response->assertSee('stream-drawer');
        $response->assertSee('BUKA DETAIL JURUSAN');

        $jurusans = Jurusan::all();
        foreach ($jurusans as $j) {
            $response->assertSee($j->kode);
            $response->assertSee($j->name);
        }
    }

    public function test_can_switch_back_to_education_theme(): void
    {
        $response = $this->withSession(['talog_theme' => 'futuristic'])->get('/theme/switch/education');
        $response->assertRedirect(route('home'));
        $this->assertEquals('education', session('talog_theme'));
    }
}
