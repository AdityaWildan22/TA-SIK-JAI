<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use App\Models\Jabatan;
use App\Models\Section;
use App\Models\Karyawan;
use App\Models\Departemen;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'id_section' => 1,
            'role' => 'SuperAdmin',
            'tempat_lahir' => 'Nganjuk',
            'tanggal_lahir' => Carbon::now(),
            'jenis_kelamin' => 'Laki-laki',
        ]);

        Karyawan::create([
            'nip' => 112233,
            'username' => 'Aisyah',
            'password' => Hash::make(112233),
            'nama' => 'Aisyah',
            'id_departemen' => 1,
            'id_jabatan' => 1,
            'id_section' => 1,
            'role' => 'Staff',
            'tempat_lahir' => 'Nganjuk',
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

        Section::create([
            'id_departemen'=>1,
            'nm_section'=>'HR',
        ]);
    }
}