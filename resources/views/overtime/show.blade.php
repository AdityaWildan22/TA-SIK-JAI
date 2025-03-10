@extends('layouts.template')
@section('judul', 'Detail Overtime')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 5px;
        text-align: left;
    }

    tr {
        width: 100%;
    }
</style>
@section('content')
    <div class="card-shadow">
        <a href="{{ url('/overtime') }}" class="btn btn-lg btn-primary h-20 mb-3" style="margin-left:25px; font-size:medium">
            <i class="fas fa-arrow-left"> Kembali</i><br>
        </a>
    </div>
    <div class="card">
        <div class="card-header bg-primary">
            <h2 class="card-title mb-0" style="font-size: 20px; color:#fff">DATA DETAIL OVERTIME
        </div>
        <div class="card-body">
            <table>
                {{-- @if ($overtime->nm_jabatan == 'SPV' || $overtime->nm_jabatan == 'HR')
                    <tr>
                        <td>Nama Manager</td>
                        <td>:</td>
                        <td>{{ $manager->nama }}</td>
                    </tr>
                @endif --}}
                @if ($overtime->nm_jabatan != 'SPV' && $overtime->nm_jabatan != 'HR')
                    <tr>
                        <td>Nama SPV</td>
                        <td>:</td>
                        <td>{{ isset($spv->nama) && !empty($spv->nama) ? $spv->nama : 'N/A' }}</td>
                    </tr>
                @endif
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td>{{ $overtime->nip }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $overtime->nama }}</td>
                </tr>
                <tr>
                    <td>Departemen</td>
                    <td>:</td>
                    <td>{{ $overtime->nm_dept }}</td>
                </tr>
                <tr>
                    <td>Section</td>
                    <td>:</td>
                    <td>{{ $overtime->nm_section }}</td>
                </tr>
                <tr>
                    <td>Tanggal Overtime</td>
                    <td>:</td>
                    <td>{{ Carbon\Carbon::parse($overtime->tgl_ovt)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td>Jam Awal</td>
                    <td>:</td>
                    <td>{{ Carbon\Carbon::parse($overtime->jam_awal)->format('H:i') }}</td>
                </tr>
                <tr>
                    <td>Jam Akhir</td>
                    <td>:</td>
                    <td>{{ Carbon\Carbon::parse($overtime->jam_akhir)->format('H:i') }}</td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>:</td>
                    <td>{{ $overtime->ket }}</td>
                </tr>
                <tr>
                    <td>Status Pengajuan</td>
                    <td>:</td>
                    <td>
                        @if ($overtime->status_pengajuan == 'Diproses')
                            <span class="badge bg-warning"
                                style="text-align: left;font-size:12px;color:#fff !important">DIPROSES</span>
                        @elseif($overtime->status_pengajuan == 'Disetujui')
                            <span class="badge bg-warning"
                                style="text-align: left;font-size:12px;color:#fff !important">DISETUJUI</span>
                        @elseif($overtime->status_pengajuan == 'Diverifikasi')
                            <span class="badge bg-success"
                                style="text-align: left;font-size:12px;color:#fff !important">DIVERIFIKASI</span>
                        @elseif($overtime->status_pengajuan == 'Ditolak')
                            <span class="badge bg-danger"
                                style="text-align: left;font-size:12px;color:#fff !important">DITOLAK</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
