@extends('layouts.template')
@section('judul', 'Data Absensi')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="card-shadow">
        <a href="{{ url($routes->add) }}" class="btn btn-primary h-20 mb-3" style="margin-left:25px">
            <i class="fas fa-plus"> Tambah Data</i><br>
        </a>
    </div>
    <div class="card shadow mb-3">
        <div class="card-header" style="background-color:#4e73df;color:#fff">
            <h2 class="card-title mb-0" style="font-size: 20px">DATA ABSENSI</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered show-data">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama Staff</th>
                            <th>Departemen</th>
                            <th>Jenis Absensi</th>
                            <th>Tanggal Absensi</th>
                            <th>Status</th>
                            <th width="22%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($absensi as $item)
                            <tr>
                                <td>{{ $item->nip }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nm_dept }}</td>
                                <td>{{ $item->jns_absen }}</td>
                                <td>{{ Carbon\Carbon::parse($item->tgl_absen)->format('d-m-Y') }}</td>
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
                                    @if (Auth::user()->divisi == 'Staff HR' && $item->status_pengajuan != 'Pending')
                                        <a href="{{ url('/absensi/persetujuan_hr/' . $item->id_absen) }}"
                                            class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Setujui Permohonan"><i class="fas fa-check"></i></a>
                                    @endif
                                    @if (Auth::user()->divisi == 'Staff HR' && $item->status_pengajuan != 'Ditolak')
                                        <a href="{{ url('/absensi/penolakan_hr/' . $item->id_absen) }}"
                                            class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Tolak Permohonan"><i class="fas fa-times"></i></a>
                                    @endif
                                    @if (Auth::user()->divisi == 'Atasan' && $item->status_pengajuan != 'Diterima')
                                        <a href="{{ url('/absensi/persetujuan_atasan/' . $item->id_absen) }}"
                                            class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Setujui Permohonan"><i class="fas fa-check"></i></a>
                                    @endif
                                    @if (Auth::user()->divisi == 'Atasan' && $item->status_pengajuan != 'Ditolak')
                                        <a href="{{ url('/absensi/penolakan_atasan/' . $item->id_absen) }}"
                                            class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Tolak Permohonan"><i class="fas fa-times"></i></a>
                                    @endif
                                    <a href="{{ url($routes->index . $item->id_absen) }}" class="btn btn-success btn-sm"
                                        data-toggle="tooltip" data-placement="top" title="Lihat Data"><i
                                            class="fas fa-eye"></i></a>
                                    @if ($item->status_pengajuan == 'Diproses')
                                        <a href="{{ url($routes->index . $item->id_absen . '/edit') }}"
                                            class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Edit"><i class="fas fa-pen"></i></a>
                                    @endif
                                    @if ($item->status_pengajuan == 'Diterima')
                                        <a href="{{ url($routes->index . 'surat_absensi/' . $item->id_absen) }}"
                                            class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top"
                                            title="Print"><i class="fas fa-print"></i></a>
                                    @endif
                                    @if ($item->status_pengajuan == 'Diproses')
                                        <form class="d-inline-block" action="{{ url($routes->index . $item->id_absen) }}"
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
