<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    /** @use HasFactory<\Database\Factories\JurusanFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function tugasAkhirs()
    {
        return $this->hasMany(TugasAkhir::class);
    }
}
