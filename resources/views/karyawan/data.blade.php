@extends('layouts.template')
@section('judul', 'Data Karyawan')

@section('content')
    <script>
        $(function() {
            @if (session('type'))
                showMessage('{{ session('type') }}', '{{ session('text') }}');
            @endif
        });
    </script>
    <div class="card-shadow">
        <a href="{{ url($routes->add) }}" class="btn btn-primary h-20 mb-3" style="margin-left:25px">
            <i class="fas fa-plus"> Tambah Data</i><br>
        </a>

        @if (Auth::user()->role == 'SuperAdmin')
            <a href="{{ route('export-karyawan') }}" class="btn btn-success h-20 mb-3" style="margin-left:25px">
                <i class="fas fa-file-excel"> Export Excel</i><br>
            </a>
        @endif
    </div>
    <div class="card shadow mb-3">
        <div class="card-header" style="background-color:#4e73df;color:#fff">
            <h2 class="card-title mb-0" style="font-size: 20px">DATA KARYAWAN</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered show-data">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama Staff</th>
                            <th>Departemen</th>
                            <th>Jabatan</th>
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th width="20%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($karyawan as $item)
                            <tr>
                                <td>{{ $item->nip }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->nm_dept }}</td>
                                <td>{{ $item->nm_jabatan }}</td>
                                <td>{{ $item->tempat_lahir }}</td>
                                <td>{{ Carbon\Carbon::parse($item->tanggal_lahir)->format('d-m-Y') }}</td>
                                <td>
                                    <a href="{{ url($routes->index . $item->id_karyawan) }}" class="btn btn-success btn-sm"
                                        data-toggle="tooltip" data-placement="top" title="Lihat Data"><i
                                            class="fas fa-eye"></i></a>
                                    <a href="{{ url($routes->index . $item->id_karyawan . '/edit') }}"
                                        class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                                        title="Edit"><i class="fas fa-pen"></i></a>
                                    <form class="d-inline-block" action="{{ url($routes->index . $item->id_karyawan) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip"
                                            data-placement="top" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
