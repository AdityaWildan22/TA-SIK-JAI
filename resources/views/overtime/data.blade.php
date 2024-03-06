@extends('layouts.template')
@section('judul', 'Data Overtime')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card-shadow">
        @if (Auth::user()->role != 'Admin')
            <a href="{{ url($routes->add) }}" class="btn btn-primary h-20 mb-3" style="margin-left:25px">
                <i class="fas fa-plus"> Tambah Data</i><br>
            </a>
        @endif
    </div>
    <div class="card shadow mb-3">
        <div class="card-header" style="background-color:#4e73df;color:#fff">
            <h2 class="card-title mb-0" style="font-size: 20px">DATA OVERTIME</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered show-data">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama Staff</th>
                            <th>Departemen</th>
                            <th>Tanggal Overtime</th>
                            <th>Jam Awal</th>
                            <th>Jam Akhir</th>
                            <th>Status</th>
                            <th width="21%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($overtime as $item)
                            <tr>
                                <td>{{ $item->nip }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nm_dept }}</td>
                                <td>{{ Carbon\Carbon::parse($item->tgl_ovt)->format('d-m-Y') }}</td>
                                <td>{{ Carbon\Carbon::parse($item->jam_awal)->format('H:i') }}</td>
                                <td>{{ Carbon\Carbon::parse($item->jam_akhir)->format('H:i') }}</td>
                                <td>
                                    @if ($item->status_pengajuan == 'Diproses')
                                        <span class="badge bg-warning"
                                            style="text-align: left;font-size:12px;color:#fff !important">DIPROSES</span>
                                    @elseif($item->status_pengajuan == 'Pending')
                                        <span class="badge bg-warning"
                                            style="text-align: left;font-size:12px;color:#fff !important">PENDING</span>
                                    @elseif($item->status_pengajuan == 'Diterima')
                                        <span class="badge bg-success"
                                            style="text-align: left;font-size:12px;color:#fff !important">DITERIMA</span>
                                    @elseif($item->status_pengajuan == 'Ditolak')
                                        <span class="badge bg-danger"
                                            style="text-align: left;font-size:12px;color:#fff !important">DITOLAK</span>
                                    @endif
                                </td>
                                <td>
                                    @if (
                                        (Auth::user()->jabatan->nm_jabatan == 'SPV' &&
                                            $item->status_pengajuan != 'Diterima' &&
                                            $item->nm_jabatan == 'Staff') ||
                                            ($item->nm_jabatan == 'Admin' &&
                                                Auth::user()->jabatan->nm_jabatan != 'Manager' &&
                                                Auth::user()->jabatan->nm_jabatan != 'Admin'))
                                        <a href="{{ url('/overtime/persetujuan_hr/' . $item->id_ovt) }}"
                                            class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Setujui Permohonan"><i class="fas fa-check"></i></a>
                                    @endif
                                    @if (
                                        (Auth::user()->jabatan->nm_jabatan == 'SPV' &&
                                            $item->status_pengajuan == 'Diterima' &&
                                            $item->nm_jabatan == 'Staff') ||
                                            ($item->nm_jabatan == 'Admin' &&
                                                Auth::user()->jabatan->nm_jabatan != 'Manager' &&
                                                Auth::user()->jabatan->nm_jabatan != 'Admin'))
                                        <a href="{{ url('/overtime/penolakan_hr/' . $item->id_ovt) }}"
                                            class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Tolak Permohonan"><i class="fas fa-times"></i></a>
                                    @endif
                                    @if (Auth::user()->jabatan->nm_jabatan == 'Manager' &&
                                            $item->status_pengajuan != 'Diterima' &&
                                            $item->nm_jabatan == 'SPV')
                                        <a href="{{ url('/overtime/persetujuan_atasan/' . $item->id_ovt) }}"
                                            class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Setujui Permohonan"><i class="fas fa-check"></i></a>
                                    @endif
                                    @if (Auth::user()->jabatan->nm_jabatan == 'Manager' &&
                                            $item->status_pengajuan != 'Ditolak' &&
                                            $item->status_pengajuan != 'Diproses')
                                        <a href="{{ url('/overtime/penolakan_atasan/' . $item->id_ovt) }}"
                                            class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Tolak Permohonan"><i class="fas fa-times"></i></a>
                                    @endif
                                    <a href="{{ url($routes->index . $item->id_ovt) }}" class="btn btn-success btn-sm"
                                        data-toggle="tooltip" data-placement="top" title="Lihat Data"><i
                                            class="fas fa-eye"></i></a>
                                    @if ($item->status_pengajuan == 'Diproses' && Auth::user()->jabatan->nm_jabatan != 'Admin')
                                        <a href="{{ url($routes->index . $item->id_ovt . '/edit') }}"
                                            class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Edit"><i class="fas fa-pen"></i></a>
                                    @endif
                                    @if ($item->status_pengajuan == 'Diterima')
                                        <a href="{{ url($routes->index . 'surat_overtime/' . $item->id_ovt) }}"
                                            class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Print"><i class="fas fa-print"></i></a>
                                    @endif
                                    @if ($item->status_pengajuan == 'Diproses' && Auth::user()->jabatan->nm_jabatan != 'Admin')
                                        <form class="d-inline-block" action="{{ url($routes->index . $item->id_ovt) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
