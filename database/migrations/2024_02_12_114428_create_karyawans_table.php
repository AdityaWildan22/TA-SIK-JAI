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
            $table->integer('nip');
            $table->string('username',100);
            $table->string('password',100);
            // $table->integer('nik');
            $table->string('nama',100);
            $table->string('sect',25);
            $table->enum('divisi', ['Staff','Staff HR', 'Atasan']);
            $table->string('tempat_lahir',25);
            $table->date('tanggal_lahir');
            $table->longText('foto_ttd');
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