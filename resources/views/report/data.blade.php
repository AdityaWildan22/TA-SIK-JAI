@extends('layouts.template')
@section('judul', 'Report')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="card-title mb-0" style="font-size:18px; color:#fff">Laporan Data Absensi Per Tanggal</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('/report/absensi/tanggal') }}" method="post" target="_blank">
                        @csrf
                        <div class="form-group">
                            <label for="tgl_absen">Tanggal Awal</label>
                            <input type="date" class="form-control form-control" id="tgl_absen" name="tgl_awal"
                                placeholder="Masukkan Tanggal Awal">
                        </div>
                        <div class="form-group">
                            <label for="tgl_absen">Tanggal Akhir</label>
                            <input type="date" class="form-control form-control" id="tgl_absen" name="tgl_akhir"
                                placeholder="Masukkan Tanggal Akhir">
                        </div>
                        <div class="form-group mb-0" style="display: flex; justify-content:end">
                            <input type="submit" value="TAMPILKAN" class="btn btn-md btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="card-title mb-0" style="font-size:18px; color:#fff">Laporan Data Overtime Per Tanggal</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('/report/overtime/tanggal') }}" method="post" target="_blank">
                        @csrf
                        <div class="form-group">
                            <label for="tgl_absen">Tanggal Awal</label>
                            <input type="date" class="form-control form-control" id="tgl_absen" name="tgl_awal"
                                placeholder="Masukkan Tanggal Awal">
                        </div>
                        <div class="form-group">
                            <label for="tgl_absen">Tanggal Akhir</label>
                            <input type="date" class="form-control form-control" id="tgl_absen" name="tgl_akhir"
                                placeholder="Masukkan Tanggal Akhir">
                        </div>
                        <div class="form-group mb-0" style="display: flex; justify-content:end">
                            <input type="submit" value="TAMPILKAN" class="btn btn-md btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5 mt-3">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="card-title mb-0" style="font-size:18px; color:#fff">Laporan Semua Data Absensi</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('report/absensi') }}" method="get" target="_blank">
                        @csrf
                        <div class="form-group mb-0" style="display: flex; justify-content:end">
                            <input type="submit" value="TAMPILKAN" class="btn btn-md btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-5 mt-3">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="card-title mb-0" style="font-size:18px; color:#fff">Laporan Semua Data Overtime</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('report/overtime') }}" method="get" target="_blank">
                        @csrf
                        <div class="form-group mb-0" style="display: flex; justify-content:end">
                            <input type="submit" value="TAMPILKAN" class="btn btn-md btn-primary">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
