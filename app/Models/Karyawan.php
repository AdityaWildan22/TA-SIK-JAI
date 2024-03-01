<?php

// namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Auth\Authenticatable as AuthenticableTrait;
// use Illuminate\Notifications\Notifiable;

// class Karyawan extends Model
// {
//     use HasFactory, Notifiable, AuthenticableTrait;
//     protected $primaryKey = 'id_karyawan';
//     protected $fillable =
//     [
//         'nip',
//         'username',
//         'password',
//         'nama',
//         'sect',
//         'divisi',
//         'tempat_lahir',
//         'tanggal_lahir',
//     ];
//     protected $table = 'karyawans';
//     protected $hidden = [
//         'password',
//     ];   
// }

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Karyawan extends Authenticatable
{
    use Notifiable;

    protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'nip',
        'username',
        'password',
        'nama',
        'id_departemen',
        'id_jabatan',
        'tempat_lahir',
        'tanggal_lahir',
        'foto_ttd',
        'jenis_kelamin',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * Validate the user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validateCredentials(array $credentials)
    {
        $plain = $credentials['password'];

        return password_verify($plain, $this->getAuthPassword());
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

        public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }
}