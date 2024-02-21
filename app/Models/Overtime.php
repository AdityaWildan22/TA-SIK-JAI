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
        
        'id_staff_hr',
        'id_atasan',
        'nip',
        'nama',
        'sect',
        'tgl_ovt',
        'jam_awal',
        'jam_akhir',
        'ket',
        'tgl_persetujuan_staff_hr',
        'tgl_persetujuan_atasan',
        'status_pengajuan'
    ];
}