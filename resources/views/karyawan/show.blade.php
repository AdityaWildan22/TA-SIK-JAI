@extends('layouts.template')
@section('judul', 'Detail Karyawan')
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
            <h2 class="card-title mb-0" style="font-size: 25px; color:#fff">DATA DETAIL KARYAWAN
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td>{{ $karyawan->nip }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $karyawan->nama }}</td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td>:</td>
                    <td>{{ $karyawan->username }}</td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>:</td>
                    <td>{{ $karyawan->password }}</td>
                </tr>
                <tr>
                    <td>Departemen</td>
                    <td>:</td>
                    <td>{{ $karyawan->nm_dept }}</td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>{{ $karyawan->nm_jabatan }}</td>
                </tr>
                <tr>
                    <td>Role</td>
                    <td>:</td>
                    <td>{{ $karyawan->role }}</td>
                </tr>
                <tr>
                    <td>Tempat Lahir</td>
                    <td>:</td>
                    <td>{{ $karyawan->tempat_lahir }}</td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td>:</td>
                    <td>{{ Carbon\Carbon::parse($karyawan->tanggal_lahir)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td>{{ $karyawan->jenis_kelamin }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
