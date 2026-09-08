<?php

namespace Tests\Feature;

use App\Models\Jurusan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminJurusanAccentColorTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'Admin']);
        $this->admin = User::factory()->create();
        $this->admin->assignRole('Admin');
    }

    public function test_admin_can_view_jurusan_create_page_with_preset_colors(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.jurusan.create'));

        $response->assertStatus(200);
        $response->assertSee('Warna Aksen Identitas');
        $response->assertSee('Electric Violet');
        $response->assertSee('#8B5CF6');
        $response->assertSee('Cyber Cyan');
        $response->assertSee('#06B6D4');
    }

    public function test_admin_can_create_jurusan_with_custom_accent_color(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.jurusan.store'), [
            'name'         => 'Desain Komunikasi Visual',
            'kode'         => 'DKV',
            'accent_color' => '#EC4899', // Cyber Fuchsia
            'description'  => 'Kompetensi keahlian desain kreatif.',
            'akreditasi'   => 'A',
        ]);

        $response->assertRedirect(route('admin.jurusan.index'));
        $this->assertDatabaseHas('jurusans', [
            'name'         => 'Desain Komunikasi Visual',
            'kode'         => 'DKV',
            'accent_color' => '#EC4899',
        ]);

        $jurusan = Jurusan::where('kode', 'DKV')->firstOrFail();
        $this->assertEquals('#EC4899', $jurusan->accent_color);
        $this->assertEquals([236, 72, 153], $jurusan->accent_rgb);
        $this->assertEquals('rgba(236, 72, 153, 0.5)', $jurusan->accentRgba(0.5));
    }

    public function test_accent_color_validation_rejects_invalid_hex(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.jurusan.store'), [
            'name'         => 'Teknik Otomasi',
            'kode'         => 'TO',
            'accent_color' => 'invalid-color-rgb',
        ]);

        $response->assertSessionHasErrors(['accent_color']);
        $this->assertDatabaseMissing('jurusans', ['kode' => 'TO']);
    }

    public function test_admin_can_update_jurusan_accent_color(): void
    {
        $jurusan = Jurusan::create([
            'name'         => 'Broadcasting',
            'kode'         => 'BC',
            'slug'         => 'broadcasting',
            'accent_color' => '#8B5CF6',
            'description'  => 'Penyiaran dan media massa.',
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.jurusan.update', $jurusan), [
            'name'         => 'Broadcasting',
            'kode'         => 'BC',
            'accent_color' => '#FF6B00', // Sunset Coral
            'description'  => 'Penyiaran dan media modern.',
            'akreditasi'   => 'A',
        ]);

        $response->assertRedirect(route('admin.jurusan.index'));
        $this->assertDatabaseHas('jurusans', [
            'id'           => $jurusan->id,
            'accent_color' => '#FF6B00',
        ]);
    }

    public function test_public_views_render_custom_accent_color(): void
    {
        $jurusan = Jurusan::create([
            'name'         => 'Kecerdasan Buatan',
            'kode'         => 'AI',
            'slug'         => 'kecerdasan-buatan',
            'accent_color' => '#14B8A6', // Matrix Teal
            'description'  => 'Teknologi AI masa depan.',
            'akreditasi'   => 'A',
        ]);

        // Education Jurusan Index
        $responseIndex = $this->get(route('jurusan.index'));
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee('#14B8A6');

        // Education Jurusan Detail
        $responseDetail = $this->get(route('jurusan.detail', $jurusan->slug));
        $responseDetail->assertStatus(200);
        $responseDetail->assertSee('#14B8A6');

        // Futuristic 3D Experience
        $responseFuturistic3D = $this->get(route('experience.futuristic-3d'));
        $responseFuturistic3D->assertStatus(200);
        $responseFuturistic3D->assertSee('#14B8A6');
    }
}
