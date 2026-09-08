<?php

namespace Tests\Feature;

use App\Models\Jurusan;
use Database\Seeders\JurusanSeeder;
use Database\Seeders\RolesAndAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EducationThemeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndAdminSeeder::class);
        $this->seed(JurusanSeeder::class);
    }

    public function test_beranda_page_renders_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('SMKN 20 Jakarta');
        $response->assertSee('Karya Nyata');
        $response->assertSee('Buka Buku Interaktif 3D');
        $response->assertSee('Karya Tugas Akhir Unggulan');
        $response->assertSee('Alur Kerja Kolaboratif TALOG20');

        $berandaResponse = $this->get('/beranda');
        $berandaResponse->assertStatus(200);
    }

    public function test_loading_screen_renders_successfully(): void
    {
        $response = $this->get('/loading');
        $response->assertStatus(200);
        $response->assertSee('SMKN 20 Jakarta');
        $response->assertSee('loadingBar');
    }

    public function test_3d_experience_renders_with_book_canvas_and_data(): void
    {
        $response = $this->get('/3d-experience');
        $response->assertStatus(200);
        $response->assertSee('book-canvas');
        $response->assertSee('btn-beranda');
        $response->assertSee('TALOG20_DATA');
    }

    public function test_majors_legacy_redirect(): void
    {
        $response = $this->get('/jurusan-smkn20');
        $response->assertRedirect('/jurusan');
    }

    public function test_jurusan_index_page_renders_all_seeded_jurusan(): void
    {
        $response = $this->get('/jurusan');
        $response->assertStatus(200);
        $response->assertSee('Konsentrasi Keahlian');

        $jurusans = Jurusan::all();
        foreach ($jurusans as $j) {
            $response->assertSee($j->kode);
        }
    }

    public function test_tentang_page_renders_successfully(): void
    {
        $response = $this->get('/tentang');
        $response->assertStatus(200);
        $response->assertSee('SMKN 20 Jakarta');
        $response->assertSee('TALOG20');
        $response->assertSee('Visi & Misi', false);
    }

    public function test_education_navbar_active_state_switches_correctly(): void
    {
        // 1. On Home: Beranda is active
        $homeRes = $this->get('/');
        $homeRes->assertStatus(200);
        $homeRes->assertSee('class="edu-nav-link active">Beranda</a>', false);
        $homeRes->assertDontSee('class="edu-nav-link active">Jurusan</a>', false);
        $homeRes->assertDontSee('class="edu-nav-link active">Tentang</a>', false);

        // 2. On Jurusan: Jurusan is active, Beranda is not active
        $jurusanRes = $this->get('/jurusan');
        $jurusanRes->assertStatus(200);
        $jurusanRes->assertSee('class="edu-nav-link active">Jurusan</a>', false);
        $jurusanRes->assertDontSee('class="edu-nav-link active">Beranda</a>', false);
        $jurusanRes->assertDontSee('class="edu-nav-link active">Tentang</a>', false);

        // 3. On Tentang: Tentang is active, Beranda is not active
        $tentangRes = $this->get('/tentang');
        $tentangRes->assertStatus(200);
        $tentangRes->assertSee('class="edu-nav-link active">Tentang</a>', false);
        $tentangRes->assertDontSee('class="edu-nav-link active">Beranda</a>', false);
        $tentangRes->assertDontSee('class="edu-nav-link active">Jurusan</a>', false);
    }
}
