<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Jurusan extends Model
{
    /** @use HasFactory<\Database\Factories\JurusanFactory> */
    use HasFactory;

    public const PRESET_COLORS = [
        ['name' => 'Electric Violet', 'hex' => '#8B5CF6', 'desc' => 'Ungu (Bisnis Retail - BR)'],
        ['name' => 'Cyber Cyan',      'hex' => '#06B6D4', 'desc' => 'Cyan (Bisnis Digital - BD)'],
        ['name' => 'Royal Azure',     'hex' => '#3B82F6', 'desc' => 'Biru (Rekayasa Perangkat Lunak - RPL)'],
        ['name' => 'Neo Emerald',     'hex' => '#10B981', 'desc' => 'Hijau (Layanan Perbankan Syariah - LPS)'],
        ['name' => 'Radiant Amber',   'hex' => '#F59E0B', 'desc' => 'Amber (Akuntansi & Keuangan Lembaga - AKL)'],
        ['name' => 'Cyber Fuchsia',   'hex' => '#EC4899', 'desc' => 'Pink (Manajemen Perkantoran & Layanan Bisnis - MPLB)'],
        ['name' => 'Sunset Coral',    'hex' => '#FF6B00', 'desc' => 'Oranye Edukasi'],
        ['name' => 'Matrix Teal',     'hex' => '#14B8A6', 'desc' => 'Toska Cybernetics'],
    ];

    protected $fillable = [
        'name',
        'kode',
        'slug',
        'accent_color',
        'description',
        'kurikulum',
        'prospek_karir',
        'tools_industri',
        'akreditasi',
    ];

    /**
     * Get accent color with safe fallback.
     */
    public function getAccentColorAttribute($value): string
    {
        return $value ?: '#8B5CF6';
    }

    /**
     * Get RGB triplet array [r, g, b] from hex accent color.
     */
    public function getAccentRgbAttribute(): array
    {
        $hex = ltrim($this->accent_color, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }
        return [
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2)),
        ];
    }

    /**
     * Get CSS rgba string.
     */
    public function accentRgba(float $opacity = 1.0): string
    {
        [$r, $g, $b] = $this->accent_rgb;
        return "rgba({$r}, {$g}, {$b}, {$opacity})";
    }

    protected $casts = [
        'kurikulum'      => 'array',
        'prospek_karir'  => 'array',
        'tools_industri' => 'array',
    ];

    /**
     * Auto-generate slug from name on create/update if not set.
     */
    protected static function booted(): void
    {
        static::saving(function (Jurusan $jurusan) {
            if (empty($jurusan->slug)) {
                $jurusan->slug = Str::slug($jurusan->name);
            }
        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function tugasAkhirs()
    {
        return $this->hasMany(TugasAkhir::class);
    }
}
