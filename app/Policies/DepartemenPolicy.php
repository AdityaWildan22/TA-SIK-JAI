<?php

namespace App\Policies;

use App\Models\Departemen;
use App\Models\Karyawan;
use Illuminate\Auth\Access\Response;

class DepartemenPolicy
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
    public function view(Karyawan $karyawan, Departemen $departemen): bool
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
    public function update(Karyawan $karyawan, Departemen $departemen): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(Karyawan $karyawan, Departemen $departemen): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(Karyawan $karyawan, Departemen $departemen): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(Karyawan $karyawan, Departemen $departemen): bool
    {
        //
    }
}
