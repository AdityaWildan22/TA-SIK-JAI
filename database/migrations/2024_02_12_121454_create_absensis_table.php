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
            $table->integer('id_staff_hr');
            $table->integer('id_atasan');
            $table->string('nip',50);
            $table->string('nama',100);
            $table->string('sect',25);
            $table->enum('jns_absen', ['Sakit', 'Izin' , 'Izin Khusus' , 'Cuti' , 'Cuti Melahirkan' , 'Cuti Haid' , 'Izin Terlambat Datang' , 'Izin Cepat Pulang' , 'Izin Keluar Sementara' ,'Dinas Luar']);
            $table->date('tgl_absen');
            $table->mediumText('ket');
            $table->dateTime('tgl_persetujuan_staff_hr');
            $table->dateTime('tgl_persetujuan_atasan');
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