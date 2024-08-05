@extends('layouts.template')
@section('judul', 'Data Departemen')

@section('content')
    <script>
        $(function() {
            @if (session('type'))
                showMessage('{{ session('type') }}', '{{ session('text') }}');
            @endif
        });
    </script>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h1 class="card-title mb-0" style="font-size:18px; color:#fff">FORM DATA DEPARTEMEN</h1>
                </div>
                <div class="card-body">
                    <form action="{{ url($routes->save) }}" method="POST">
                        @csrf
                        @if ($routes->is_update)
                            @method('PUT')
                        @endif
                        <div class="form-group">
                            <label for="nm_dept">Nama Departemen</label>
                            <input type="text" class="form-control @error('nm_dept') is-invalid  @enderror"
                                id="nm_dept" name="nm_dept" placeholder="Nama Departemen" value="{{ @$dept->nm_dept }}">
                            @error('nm_dept')
                                @if ($errors->has('nm_dept'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nm_dept') }}
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
                <div class="card-header bg-primary">
                    <h1 class="card-title mb-0" style="color: #fff; font-size:18px">DATA DEPARTEMEN</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable3" class="table table-bordered show-data">
                            <thead>
                                <tr>
                                    <th>Nama Departemen</th>
                                    <th width="21%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($departemen as $item)
                                    <tr>
                                        <td>{{ $item->nm_dept }}</td>
                                        <td>
                                            <a href="{{ url($routes->index . $item->id_departemen . '/edit') }}"
                                                class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                                                title="Edit"><i class="fas fa-pen"></i></a>
                                            <form class="d-inline-block"
                                                action="{{ route('departemen.destroy', $item->id_departemen) }}"
                                                method="POST">
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
