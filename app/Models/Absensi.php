<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_absen';
    protected $fillable =
    [
        'id_staff_hr',
        'id_atasan',
        'nip',
        'nama',
        'id_departemen',
        'jns_absen',
        'tgl_absen',
        'ket',
        'tgl_persetujuan_staff_hr',
        'tgl_persetujuan_atasan',
        'status_pengajuan',
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'id_departemen');
    }
}