<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Karyawan;
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
            'sect' => 'Mesin',
            'divisi' => 'Staff',
            'tempat_lahir' => 'Nganjuk',
            'tanggal_lahir' => Carbon::now(),
        ]);

        Karyawan::create([
            'nip' => 110203,
            'username' => 'Zubaidah',
            'password' => Hash::make(110203),
            'nama' => 'Zubaidah',
            'sect' => '',
            'divisi' => 'Staff HR',
            'tempat_lahir' => 'Malang',
            'tanggal_lahir' => Carbon::now(),
        ]);

        Karyawan::create([
            'nip' => 110204,
            'username' => 'Rizki',
            'password' => Hash::make(110204),
            'nama' => 'Rizki',
            'sect' => '',
            'divisi' => 'Atasan',
            'tempat_lahir' => 'Madiun',
            'tanggal_lahir' => Carbon::now(),
        ]);
    }
}