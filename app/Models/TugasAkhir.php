<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{
    /** @use HasFactory<\Database\Factories\TugasAkhirFactory> */
    use HasFactory;

    protected $fillable = [
        'guru_id',
        'jurusan_id',
        'title',
        'description',
        'file_path',
        'file_original_name',
        'file_size',
        'file_mime',
    ];

    protected $casts = [
        'file_size' => 'integer',
    ];

    public function fileUrl(): ?string
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    public function humanFileSize(): ?string
    {
        if (! $this->file_size) {
            return null;
        }

        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, $bytes < 10 ? 1 : 0) . ' ' . $units[$i];
    }

    public function guru()
    {
        return $this->belongsTo(User::class, 'guru_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function progressLogs()
    {
        return $this->hasMany(TugasAkhirProgressLog::class);
    }
}
