@extends('layouts.template')
@section('judul', 'Detail Absensi')
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
            <h2 class="card-title mb-0" style="font-size: 25px; color:#fff">DATA DETAIL ABSENSI
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <td>Nama Manager</td>
                    <td>:</td>
                    <td>{{ $atasan->nama }}</td>
                </tr>
                <tr>
                    <td>Nama SPV</td>
                    <td>:</td>
                    <td>{{ $staff_hr->nama }}</td>
                </tr>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td>{{ $absensi->nip }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $absensi->nama }}</td>
                </tr>
                <tr>
                    <td>Departemen</td>
                    <td>:</td>
                    <td>{{ $absensi->nm_dept }}</td>
                </tr>
                <tr>
                    <td>Jenis Absen</td>
                    <td>:</td>
                    <td>{{ $absensi->jns_absen }}</td>
                </tr>
                <tr>
                    <td>Tanggal Absen</td>
                    <td>:</td>
                    <td>{{ Carbon\Carbon::parse($absensi->tgl_absen)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>:</td>
                    <td>{{ $absensi->ket }}</td>
                </tr>
                <tr>
                    <td>Status Pengajuan</td>
                    <td>:</td>
                    <td>
                        @if ($absensi->status_pengajuan == 'Diproses')
                            <span class="badge bg-warning"
                                style="text-align: left;font-size:12px;color:#fff !important">DIPROSES</span>
                        @elseif($absensi->status_pengajuan == 'Pending')
                            <span class="badge bg-warning"
                                style="text-align: left;font-size:12px;color:#fff !important">PENDING</span>
                        @elseif($absensi->status_pengajuan == 'Diterima')
                            <span class="badge bg-success"
                                style="text-align: left;font-size:12px;color:#fff !important">DITERIMA</span>
                        @elseif($absensi->status_pengajuan == 'Ditolak')
                            <span class="badge bg-danger"
                                style="text-align: left;font-size:12px;color:#fff !important">DITOLAK</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
@endsection
