<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgressLogFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'tugas_akhir_progress_log_id',
        'path',
        'original_name',
        'size',
        'mime',
    ];

    protected $casts = [
        'size' => 'integer',
    ];

    public function progressLog()
    {
        return $this->belongsTo(TugasAkhirProgressLog::class, 'tugas_akhir_progress_log_id');
    }

    public function url(): string
    {
        return asset('storage/' . $this->path);
    }

    public function humanSize(): string
    {
        $bytes = $this->size;
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, $bytes < 10 ? 1 : 0) . ' ' . $units[$i];
    }
}
