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
    <div class="card">
        <div class="card-header bg-primary">
            <h2 class="card-title mb-0" style="font-size: 25px; color:#fff">DATA DETAIL OVERTIME
        </div>
        <div class="card-body">
            <table>
                @if ($overtime->nm_jabatan == 'SPV' || $overtime->nm_jabatan == 'HR')
                    <tr>
                        <td>Nama Manager</td>
                        <td>:</td>
                        <td>{{ $manager->nama }}</td>
                    </tr>
                @endif
                @if ($overtime->nm_jabatan != 'SPV' && $overtime->nm_jabatan != 'HR')
                    <tr>
                        <td>Nama SPV</td>
                        <td>:</td>
                        <td>{{ $spv->nama }}</td>
                    </tr>
                @endif
                <tr>
                    <td>Nama HR</td>
                    <td>:</td>
                    <td>{{ $hr->nama }}</td>
                </tr>
                <tr>
                    <td>NIP</td>
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
                        @elseif($overtime->status_pengajuan == 'Pending')
                            <span class="badge bg-warning"
                                style="text-align: left;font-size:12px;color:#fff !important">PENDING</span>
                        @elseif($overtime->status_pengajuan == 'Diterima')
                            <span class="badge bg-success"
                                style="text-align: left;font-size:12px;color:#fff !important">DITERIMA</span>
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
