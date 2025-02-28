@extends('layouts.template')
@section('judul', 'Dashboard')
@section('content')
    <script>
        $(function() {
            @if (session('type'))
                showMessage('{{ session('type') }}', '{{ session('text') }}');
            @endif
        });
    </script>
    <div class="row">
        @if (Auth::user()->role == 'SuperAdmin')
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Karyawan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_karyawan }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer p-0 text-center">
                        <a href="{{ url('karyawan') }}" style="text-decoration: none">
                            <span class="text-dark">Lihat Data</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Pengajuan Absen</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_absensi }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-0 text-center">
                    <a href="{{ url('absensi') }}" style="text-decoration: none">
                        <span class="text-dark">Lihat Data</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Total Pengajuan Overtime</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_overtime }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-0 text-center">
                    <a href="{{ url('overtime') }}" style="text-decoration: none">
                        <span class="text-dark">Lihat Data</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Sisa Cuti</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $sisa_cuti }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow mb-3">
        <div class="card-header" style="background-color:#4e73df;color:#fff">
            <h2 class="card-title mb-0" style="font-size: 20px">DATA ABSEN</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable1" class="table table-bordered show-data">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama Karyawan</th>
                            <th>Departemen</th>
                            <th>Jenis Absensi</th>
                            <th>Tanggal Absensi</th>
                            <th>Status</th>
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
                                    @elseif($item->status_pengajuan == 'Disetujui')
                                        <span class="badge bg-warning"
                                            style="text-align: left;font-size:12px;color:#fff !important">DISETUJUI</span>
                                    @elseif($item->status_pengajuan == 'Diverifikasi')
                                        <span class="badge bg-success"
                                            style="text-align: left;font-size:12px;color:#fff !important">DIVERIFIKASI</span>
                                    @elseif($item->status_pengajuan == 'Ditolak')
                                        <span class="badge bg-danger"
                                            style="text-align: left;font-size:12px;color:#fff !important">DITOLAK</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card shadow mb-3">
        <div class="card-header" style="background-color:#4e73df;color:#fff">
            <h2 class="card-title mb-0" style="font-size: 20px">DATA OVERTIME</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable2" class="table table-bordered show-data">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama Karyawan</th>
                            <th>Departemen</th>
                            <th>Tanggal Overtime</th>
                            <th>Jam Awal</th>
                            <th>Jam Akhir</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($overtime as $item)
                            <tr>
                                <td>{{ $item->nip }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nm_dept }}</td>
                                <td>{{ Carbon\Carbon::parse($item->tgl_ovt)->format('d-m-Y') }}</td>
                                <td>{{ $item->jam_awal }}</td>
                                <td>{{ $item->jam_akhir }}</td>
                                <td>
                                    @if ($item->status_pengajuan == 'Diproses')
                                        <span class="badge bg-warning"
                                            style="text-align: left;font-size:12px;color:#fff !important">DIPROSES</span>
                                    @elseif($item->status_pengajuan == 'Disetujui')
                                        <span class="badge bg-warning"
                                            style="text-align: left;font-size:12px;color:#fff !important">DISETUJUI</span>
                                    @elseif($item->status_pengajuan == 'Diverifikasi')
                                        <span class="badge bg-success"
                                            style="text-align: left;font-size:12px;color:#fff !important">DIVERIFIKASI</span>
                                    @elseif($item->status_pengajuan == 'Ditolak')
                                        <span class="badge bg-danger"
                                            style="text-align: left;font-size:12px;color:#fff !important">DITOLAK</span>
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
