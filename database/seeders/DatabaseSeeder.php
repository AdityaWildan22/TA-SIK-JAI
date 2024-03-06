<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Departemen;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Karyawan::create([
            'nip' => 110202,
            'username' => 'Firdaus',
            'password' => Hash::make(110202),
            'nama' => 'Firdaus',
            'id_departemen' => 1,
            'id_jabatan' => 1,
            'role' => 'SuperAdmin',
            'tempat_lahir' => 'Nganjuk',
            'tanggal_lahir' => Carbon::now(),
            'jenis_kelamin' => 'Laki-laki',
        ]);

        Karyawan::create([
            'nip' => 110203,
            'username' => 'Zubaidah',
            'password' => Hash::make(110203),
            'nama' => 'Zubaidah',
            'id_departemen' => 1,
            'id_jabatan' => 2,
            'role' => 'Admin',
            'tempat_lahir' => 'Malang',
            'tanggal_lahir' => Carbon::now(),
            'jenis_kelamin' => 'Perempuan',
        ]);

        Karyawan::create([
            'nip' => 110204,
            'username' => 'Rizki',
            'password' => Hash::make(110204),
            'nama' => 'Rizki',
            'id_departemen' => 1,
            'id_jabatan' => 3,
            'role' => 'SPV',
            'tempat_lahir' => 'Madiun',
            'tanggal_lahir' => Carbon::now(),
            'jenis_kelamin' => 'Laki-laki',
        ]);

        Karyawan::create([
            'nip' => 110205,
            'username' => 'Wildansyah',
            'password' => Hash::make(110205),
            'nama' => 'Wildansyah',
            'id_departemen' => 1,
            'id_jabatan' => 4,
            'role' => 'Staff',
            'tempat_lahir' => 'Magetan',
            'tanggal_lahir' => Carbon::now(),
            'jenis_kelamin' => 'Laki-laki',
        ]);

        Karyawan::create([
            'nip' => 110206,
            'username' => 'Aisyah',
            'password' => Hash::make(110206),
            'nama' => 'Aisyah',
            'id_departemen' => 1,
            'id_jabatan' => 4,
            'role' => 'Staff',
            'tempat_lahir' => 'Surabaya',
            'tanggal_lahir' => Carbon::now(),
            'jenis_kelamin' => 'Perempuan',
        ]);

        Karyawan::create([
            'nip' => 110207,
            'username' => 'Imelda',
            'password' => Hash::make(110206),
            'nama' => 'Imelda',
            'id_departemen' => 1,
            'id_jabatan' => 5,
            'role' => 'Admin',
            'tempat_lahir' => 'Pasuruan',
            'tanggal_lahir' => Carbon::now(),
            'jenis_kelamin' => 'Perempuan',
        ]);
        
        Jabatan::create([
            'nm_jabatan' => 'Manager',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'HR',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'SPV',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'Staff',
        ]);

        Jabatan::create([
            'nm_jabatan' => 'Admin HR',
        ]);

        Departemen::create([
            'nm_dept' => 'PGA',
        ]);
    }
}