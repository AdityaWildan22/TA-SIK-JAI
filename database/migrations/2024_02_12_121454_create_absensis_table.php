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
        Schema::create('absensis', function (Blueprint $table) {
            $table->increments('id_absen');
            $table->integer('id_manager')->nullable();
            $table->integer('id_hr')->nullable();
            $table->integer('id_spv')->nullable();
            $table->string('nip',50);
            $table->string('nama',100);
            $table->integer('id_departemen');
            $table->enum('jns_absen', ['Sakit', 'Izin' , 'Izin Khusus' , 'Cuti' , 'Cuti Melahirkan' , 'Cuti Haid' , 'Izin Terlambat Datang' , 'Izin Cepat Pulang' , 'Izin Keluar Sementara' ,'Dinas Luar']);
            $table->date('tgl_absen');
            $table->date('tgl_absen_akhir')->nullable();
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
        Schema::dropIfExists('absensis');
    }
};