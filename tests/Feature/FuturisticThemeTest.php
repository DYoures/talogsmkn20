<?php

namespace Tests\Feature;

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
        $response->assertRedirect(route('theme.loading', ['target' => 'futuristic']));
        $this->assertEquals('futuristic', session('talog_theme'));
    }

    public function test_theme_loading_screen_renders_for_futuristic(): void
    {
        $response = $this->get('/theme/loading/futuristic');
        $response->assertStatus(200);
        $response->assertSee('MEMUAT FUTURISTIC DIGITAL');
        $response->assertSee('pBar');
    }

    public function test_beranda_renders_futuristic_view_when_session_is_futuristic(): void
    {
        $response = $this->withSession(['talog_theme' => 'futuristic'])->get('/beranda');
        $response->assertStatus(200);
        $response->assertSee('DIGITAL CYBER');
        $response->assertSee('Luncurkan 3D Cyber Core');
        $response->assertSee('Tema:');
        $response->assertSee('Edukasi');
    }

    public function test_futuristic_3d_experience_renders_with_canvas_and_hud(): void
    {
        $response = $this->get('/futuristic/3d');
        $response->assertStatus(200);
        $response->assertSee('cyber-canvas');
        $response->assertSee('btn-beranda-cyber');
        $response->assertSee('TALOG20_DATA');
    }

    public function test_can_switch_back_to_education_theme(): void
    {
        $response = $this->withSession(['talog_theme' => 'futuristic'])->get('/theme/switch/education');
        $response->assertRedirect(route('theme.loading', ['target' => 'education']));
        $this->assertEquals('education', session('talog_theme'));
    }
}
