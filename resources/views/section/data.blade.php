@extends('layouts.template')
@section('judul', 'Data Departemen')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary">
                    <h1 class="card-title mb-0" style="font-size:18px; color:#fff">FORM DATA SECTION</h1>
                </div>
                <div class="card-body">
                    <form action="{{ url($routes->save) }}" method="POST">
                        @csrf
                        @if ($routes->is_update)
                            @method('PUT')
                        @endif
                        <div class="form-group">
                            <label for="id_departemen">Departemen</label>
                            <select class="custom-select rounded-0 @error('id_departemen') is-invalid @enderror"
                                id="id_departemen" name="id_departemen">
                                <option value="" selected="true" disabled>- Pilih Departemen -</option>
                                @foreach ($departemen as $item)
                                    <option value="{{ $item->id_departemen }}"
                                        {{ (old('id_departemen') ?? ($section->id_departemen ?? '')) == $item->id_departemen ? 'selected' : '' }}>
                                        {{ $item->nm_dept }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_departemen')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="nm_section">Nama Section</label>
                            <input type="text" class="form-control @error('nm_section') is-invalid @enderror"
                                id="nm_section" name="nm_section" placeholder="Nama Section"
                                value="{{ old('nm_section') ?? ($section->nm_section ?? '') }}">
                            @error('nm_section')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
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
                @elseif(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card-header bg-primary">
                    <h1 class="card-title mb-0" style="color: #fff; font-size:18px">DATA SECTION</h1>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable3" class="table table-bordered show-data">
                            <thead>
                                <tr>
                                    <th>Nama Departemen</th>
                                    <th>Nama Section</th>
                                    <th width="21%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sections as $item)
                                    <tr>
                                        <td>{{ $item->departemen->nm_dept ?? 'N/A' }}</td>
                                        <td>{{ $item->nm_section }}</td>
                                        <td>
                                            <a href="{{ url($routes->index . $item->id_section . '/edit') }}"
                                                class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top"
                                                title="Edit"><i class="fas fa-pen"></i></a>
                                            <form class="d-inline-block"
                                                action="{{ route('section.destroy', $item->id_section) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                    data-placement="top" title="Hapus"><i
                                                        class="fas fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
