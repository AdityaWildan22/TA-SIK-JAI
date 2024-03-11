@extends('layouts.template')
@section('judul', 'Report')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header bg-primary">
                    <h2 class="card-title mb-0" style="font-size:18px; color:#fff">Laporan Data Absensi Per Tanggal</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url('/report/absensi/tanggal') }}" method="post" target="_blank" id="absensiForm">
                        @csrf
                        <div class="form-group">
                            <label for="tgl_awal">Tanggal Awal</label>
                            <input type="date" class="form-control" id="tgl_awal" name="tgl_awal"
                                placeholder="Pilih Tanggal Awal">
                        </div>
                        <div class="form-group">
                            <label for="tgl_akhir">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir"
                                placeholder="Pilih Tanggal Akhir">
                        </div>
                        <div class="form-group mb-0"
                            style="display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <a href="#" class="btn btn-md btn-success" id="exportButtonLeft"><i
                                        class="fas fa-file-excel"></i> Export Excel</a>
                            </div>
                            <button type="submit" class="btn btn-md btn-primary">
                                <i class="fas fa-print"></i> Cetak
                            </button>
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
                    <form action="{{ url('/report/overtime/tanggal') }}" method="post" target="_blank" id="overtimeForm">
                        @csrf
                        <div class="form-group">
                            <label for="tgl_awal">Tanggal Awal</label>
                            <input type="date" class="form-control" id="tgl_awal_input" name="tgl_awal"
                                placeholder="Pilih Tanggal Awal">
                        </div>
                        <div class="form-group">
                            <label for="tgl_akhir">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="tgl_akhir_input" name="tgl_akhir"
                                placeholder="Pilih Tanggal Akhir">
                        </div>
                        <div class="form-group mb-0"
                            style="display: flex; justify-content: space-between; align-items: center;">
                            <a href="#" class="btn btn-md btn-success" id="exportButtonOvertimeLeft"><i
                                    class="fas fa-file-excel"></i> Export Excel</a>
                            <button type="submit" class="btn btn-md btn-primary">
                                <i class="fas fa-print"></i> Cetak
                            </button>
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
                <div class="card-body" style="display: flex; justify-content: space-between;">
                    <a href="{{ route('export_absensi_all') }}" class="btn btn-success h-20">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <form action="{{ url('report/absensi') }}" method="get" target="_blank">
                        @csrf
                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-md btn-primary">
                                <i class="fas fa-print"></i> Cetak
                            </button>
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
                <div class="card-body" style="display: flex; justify-content: space-between;">
                    <a href="{{ route('export_overtime_all') }}" class="btn btn-success h-20">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <form action="{{ url('report/overtime') }}" method="get" target="_blank">
                        @csrf
                        <div class="form-group mb-0" style="display: flex; justify-content:end">
                            <button type="submit" class="btn btn-md btn-primary">
                                <i class="fas fa-print"></i> Cetak
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('exportButtonLeft').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default action of anchor click

            var tgl_awal = document.getElementById('tgl_awal').value;
            var tgl_akhir = document.getElementById('tgl_akhir').value;

            var exportLink = "{{ route('export_absensi_pertanggal') }}?tgl_awal=" + tgl_awal + "&tgl_akhir=" +
                tgl_akhir;
            window.location.href = exportLink;
        });
    </script>
    <script>
        document.getElementById('exportButtonOvertimeLeft').addEventListener('click', function(event) {
            event
                .preventDefault(); // Mencegah perilaku default dari tombol (mengarahkan ke URL yang ditentukan di atribut href)

            // Mengambil nilai tanggal awal dan akhir dari input
            var tanggalAwal = document.getElementById('tgl_awal_input').value;
            var tanggalAkhir = document.getElementById('tgl_akhir_input').value;

            // Kirimkan permintaan GET ke URL export dengan parameter tgl_awal dan tgl_akhir
            window.location.href = "{{ route('export_overtime_pertanggal') }}?tgl_awal=" + tanggalAwal +
                "&tgl_akhir=" + tanggalAkhir;
        });
    </script>
@endsection
