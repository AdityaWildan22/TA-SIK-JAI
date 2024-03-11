@extends('layouts.template')
@section('judul', 'Data Jabatan')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h1 class="card-title mb-0" style="font-size:18px; color:#fff">FORM DATA JABATAN</h1>
                </div>
                <div class="card-body">
                    <form action="{{ url($routes->save) }}" method="POST">
                        @csrf
                        @if ($routes->is_update)
                            @method('PUT')
                        @endif
                        <div class="form-group">
                            <label for="nm_jabatan">Nama Jabatan</label>
                            <input type="text" class="form-control @error('nm_jabatan') is-invalid  @enderror"
                                id="nm_jabatan" name="nm_jabatan" placeholder="Nama Jabatan"
                                value="{{ @$jab->nm_jabatan }}">
                            @error('nm_jabatan')
                                @if ($errors->has('nm_jabatan'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nm_jabatan') }}
                                    </div>
                                @endif
                            @enderror
                        </div>
                        <div class="form-group mb-0" style="display: flex; justify-content:end">
                            <button type="submit" class="btn btn-md btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card-header bg-primary">
                    <h1 class="card-title mb-0" style="color: #fff; font-size:18px">DATA JABATAN</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable3" class="table table-bordered show-data">
                            <thead>
                                <tr>
                                    {{-- <th>Departemen</th> --}}
                                    <th>Nama Jabatan</th>
                                    <th width="21%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jabatan as $item)
                                    <tr>
                                        {{-- <td>{{ $item->nm_dept }}</td> --}}
                                        <td>{{ $item->nm_jabatan }}</td>
                                        <td>
                                            <a href="{{ url($routes->index . $item->id_jabatan . '/edit') }}"
                                                class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                                                title="Edit"><i class="fas fa-pen"></i></a>
                                            <form class="d-inline-block"
                                                action="{{ route('jabatan.destroy', $item->id_jabatan) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                    data-placement="top" title="Hapus"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
