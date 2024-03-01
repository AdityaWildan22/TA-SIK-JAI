<?php

namespace App\Policies;

use App\Models\Jabatan;
use App\Models\Karyawan;
use Illuminate\Auth\Access\Response;

class JabatanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(Karyawan $karyawan): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(Karyawan $karyawan, Jabatan $jabatan): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(Karyawan $karyawan): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(Karyawan $karyawan, Jabatan $jabatan): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Karyawan $karyawan, Jabatan $jabatan): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Karyawan $karyawan, Jabatan $jabatan): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Karyawan $karyawan, Jabatan $jabatan): bool
    {
        //
    }
}
