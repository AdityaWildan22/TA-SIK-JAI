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
        Schema::create('overtimes', function (Blueprint $table) {
            $table->increments('id_ovt');
            $table->integer('id_manager')->nullable();
            $table->integer('id_hr')->nullable();
            $table->integer('id_spv')->nullable();
            $table->string('nip',50);
            $table->string('nama',100);
            $table->integer('id_departemen');
            $table->date('tgl_ovt');
            $table->time('jam_awal');
            $table->time('jam_akhir');
            $table->mediumText('ket')->nullable();
            $table->dateTime('tgl_persetujuan_spv')->nullable();
            $table->dateTime('tgl_persetujuan_manager')->nullable();
            $table->enum('status_pengajuan', ['Diproses','Pending','Diterima','Ditolak']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('overtimes');
    }
};