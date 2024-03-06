<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overtime extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_ovt';
    protected $fillable = 
    [
        
        'id_manager',
        'id_spv',
        'id_hr',
        'nip',
        'nama',
        'id_departemen',
        'tgl_ovt',
        'jam_awal',
        'jam_akhir',
        'ket',
        'tgl_persetujuan_spv',
        'tgl_persetujuan_manager',
        'status_pengajuan'
    ];
}