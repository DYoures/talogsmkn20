<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasAkhirProgressLog extends Model
{
    /** @use HasFactory<\Database\Factories\TugasAkhirProgressLogFactory> */
    use HasFactory;

    protected $fillable = ['tugas_akhir_id', 'siswa_id', 'notes', 'photo_path', 'status'];

    public function tugasAkhir()
    {
        return $this->belongsTo(TugasAkhir::class);
    }

    public function siswa()
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
