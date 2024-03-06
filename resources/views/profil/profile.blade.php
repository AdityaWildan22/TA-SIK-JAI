@extends('layouts.template')

@section('judul', 'Data Profil')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- Main content -->
    <form action="{{ url('/profil/save/' . Auth::user()->id_karyawan) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header" style="background-color:#4e73df;color:#fff">
                        <h2 class="card-title mb-0" style="font-size: 20px">DATA PROFIL</h2>
                    </div>
                    <div class="card-body">
                        <table>
                            <tr>
                                <td>Nama</td>
                                <td>:</td>
                                <td>&nbsp;{{ Auth::user()->nama }} </td>
                            </tr>
                            <tr>
                                <td>Username</td>
                                <td>:</td>
                                <td>&nbsp;{{ Auth::user()->username }}</td>
                            </tr>
                            <tr>
                                <td>Tempat Lahir</td>
                                <td>:</td>
                                <td>&nbsp;{{ Auth::user()->tempat_lahir }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td>:</td>
                                <td>&nbsp;{{ Carbon\Carbon::parse(Auth::user()->tanggal_lahir)->format('d-m-Y') }} </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-1"></div>
            <div class="dt-update col-md-6">
                <div class="card mb-3">
                    <div class="card-header" style="background-color:#4e73df;color:#fff">
                        <h2 class="card-title mb-0" style="font-size: 20px">UPDATE PROFIL</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid  @enderror" id="nama"
                                name="nama" placeholder="Nama"
                                value="{{ old('nama') ? old('nama') : Auth::user()->nama }}">
                            @error('nama')
                                <span id="error-nama" class="error invalid-feedback">
                                    {{ $errors->first('nama') }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid  @enderror"
                                id="username" name="username" placeholder="username"
                                value="{{ old('username') ? old('username') : Auth::user()->username }}">
                            @error('email')
                                <span id="error-email" class="error invalid-feedback">
                                    {{ $errors->first('email') }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control  @error('password') is-invalid  @enderror"
                                id="password" name="password" placeholder="Masukkan Password" value="">
                            <input type="hidden" name="old_password" id="old_password"
                                value="{{ Auth::user()->password }}">
                            @error('password')
                                <span id="error-password" class="error invalid-feedback">
                                    {{ $errors->first('password') }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid  @enderror"
                                id="tempat_lahir" name="tempat_lahir" placeholder="tempat_lahir"
                                value="{{ old('tempat_lahir') ? old('tempat_lahir') : Auth::user()->tempat_lahir }}">
                            @error('tempat_lahir')
                                <span id="error-tempat_lahir" class="error invalid-feedback">
                                    {{ $errors->first('tempat_lahir') }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="text" class="form-control @error('tanggal_lahir') is-invalid  @enderror"
                                id="tanggal_lahir" name="tanggal_lahir" placeholder="tanggal_lahir"
                                value="{{ old('tanggal_lahir') ? old('tanggal_lahir') : Auth::user()->tanggal_lahir }}">
                            @error('tanggal_lahir')
                                <span id="error-tanggal_lahir" class="error invalid-feedback">
                                    {{ $errors->first('tanggal_lahir') }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-0" style="display: flex; justify-content:end">
                            <input type="submit" value="SIMPAN" class="btn btn-md btn-primary">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
