<?php

namespace App\Policies;

use App\Models\NilaiTugas;
use App\Models\TugasAkhir;
use App\Models\User;

class NilaiTugasPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasRole(['Admin', 'Guru']);
    }

    public function viewTugas(User $user, TugasAkhir $tugasAkhir): bool
    {
        if ($user->hasRole('Admin')) {
            return true;
        }

        if ($user->hasRole('Guru')) {
            return $tugasAkhir->guru_id === $user->id;
        }

        return false;
    }

    public function view(User $user, NilaiTugas $nilaiTugas): bool
    {
        if ($user->hasRole('Admin')) {
            return true;
        }

        if ($user->hasRole('Guru')) {
            return $nilaiTugas->tugasAkhir && $nilaiTugas->tugasAkhir->guru_id === $user->id;
        }

        return false;
    }

    public function update(User $user, NilaiTugas $nilaiTugas): bool
    {
        if ($user->hasRole('Admin')) {
            return true;
        }

        if ($user->hasRole('Guru')) {
            return $nilaiTugas->tugasAkhir && $nilaiTugas->tugasAkhir->guru_id === $user->id;
        }

        return false;
    }

    public function export(User $user, TugasAkhir $tugasAkhir): bool
    {
        return $this->viewTugas($user, $tugasAkhir);
    }
}
