<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->increments('id_karyawan');
            $table->string('nip',50);
            $table->string('username',100);
            $table->string('password',100);
            // $table->integer('nik');
            $table->string('nama',100);
            $table->integer('id_departemen');
            $table->integer('id_section');
            $table->integer('id_jabatan');
            $table->string('tempat_lahir',25);
            $table->date('tanggal_lahir');
            $table->enum('role',['SuperAdmin','Admin','Manager','SPV','Staff']);
            $table->enum('jenis_kelamin',['Laki-laki','Perempuan']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};