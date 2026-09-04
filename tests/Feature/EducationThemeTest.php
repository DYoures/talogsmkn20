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

    public function test_majors_page_renders_all_seeded_jurusan(): void
    {
        $response = $this->get('/jurusan-smkn20');
        $response->assertStatus(200);
        $response->assertSee('Konsentrasi Keahlian');

        $jurusans = Jurusan::all();
        foreach ($jurusans as $j) {
            $response->assertSee($j->kode);
        }
    }
}
