<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiTugas extends Model
{
    use HasFactory;

    protected $table = 'nilai_tugas';

    protected $fillable = [
        'tugas_akhir_id',
        'siswa_id',
        'nilai',
        'catatan',
        'dinilai_oleh',
        'dinilai_at',
    ];

    protected $casts = [
        'nilai' => 'integer',
        'dinilai_at' => 'datetime',
    ];

    public function tugasAkhir()
    {
        return $this->belongsTo(TugasAkhir::class);
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    public function penilai()
    {
        return $this->belongsTo(User::class, 'dinilai_oleh');
    }

    public function isStudentCompleted(): bool
    {
        return TugasAkhirProgressLog::where('tugas_akhir_id', $this->tugas_akhir_id)
            ->where('siswa_id', $this->siswa_id)
            ->where('status', 'completed')
            ->exists();
    }
}
