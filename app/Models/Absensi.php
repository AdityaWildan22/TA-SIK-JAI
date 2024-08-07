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
        'id_manager',
        'id_hr',
        'id_spv',
        'nip',
        'nama',
        'id_departemen',
        'id_section',
        'jns_absen',
        'tgl_absen',
        'tgl_absen_akhir',
        'jam_awal',
        'jam_akhir',
        'ket',
        'tgl_persetujuan_spv',
        'tgl_persetujuan_manager',
        'status_pengajuan',
        'foto',
    ];

    public function departemen()
    {
        return $this->belongsTo(Departemen::class, 'id_departemen');
    }
    
}