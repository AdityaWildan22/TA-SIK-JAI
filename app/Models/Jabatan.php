<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_jabatan';
    protected $fillable =
    [
        'id_dept',
        'nm_jabatan'
    ];
}