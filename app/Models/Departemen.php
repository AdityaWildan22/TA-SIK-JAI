<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_departemen';

    protected $fillable = 
    [
        'nm_dept',
    ];

    public function sections()
    {
        return $this->hasMany(Section::class, 'id_departemen', 'id_departemen');
    }
}