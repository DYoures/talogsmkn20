<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{
    /** @use HasFactory<\Database\Factories\TugasAkhirFactory> */
    use HasFactory;

    protected $fillable = ['guru_id', 'jurusan_id', 'title', 'description'];

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
