@extends('layouts.template')
@section('judul', 'Form Karyawan')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-4 card-with-image">
            <div class="card">
                <form action="{{ url($routes->save) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if ($routes->is_update)
                        @method('PUT')
                    @endif
                    <div class="card-header" style="background-color:#4e73df;color:#fff">
                        <h2 class="card-title mb-0" style="font-size: 20px">UPLOAD TTD</h2>
                    </div>
                    <div class="card-body">
                        <img id="avatar"
                            src="{{ @$karyawan->foto_ttd != '' ? @$karyawan->foto_ttd : asset('img/no-images.jpg') }}"
                            alt="">
                        <input type="file" class="foto_ttd" name="foto_ttd" id="foto_ttd" style="display:none"
                            value="{{ old('foto_ttd') ? old('foto_ttd') : @$karyawan->foto_ttd }}">
                        <textarea name="foto" id="foto" cols="30" rows="10" style="display:none">{{ @$karyawan->foto }}</textarea>
                    </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card">
                    <div class="card-header" style="background-color:#4e73df;color:#fff">
                        <h2 class="card-title mb-0" style="font-size: 20px">FORM DATA KARYAWAN</h2>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nip">NIP</label>
                            <input type="number" class="form-control @error('nip') is-invalid  @enderror" id="nip"
                                name="nip" placeholder="Masukkan NIP"
                                value="{{ old('nip') ? old('nip') : @$karyawan->nip }}">
                            @if ($errors->has('nip'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nip') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid  @enderror"
                                id="username" name="username" placeholder="Masukkan Username"
                                value="{{ old('username') ? old('username') : @$karyawan->username }}">
                            @if ($errors->has('username'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('username') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control  @error('password') is-invalid  @enderror"
                                id="password" name="password" placeholder="Masukkan Password" value="">
                            <input type="hidden" name="old_password" id="old_password" value="{{ @$karyawan->password }}">
                            @if ($errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('password') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control @error('nama') is-invalid  @enderror" id="nama"
                                name="nama" placeholder="Masukkan Nama"
                                value="{{ old('nama') ? old('nama') : @$karyawan->nama }}">
                            @if ($errors->has('nama'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('nama') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="sect">Sektor</label>
                            <input type="text" class="form-control @error('sect') is-invalid  @enderror" id="sect"
                                name="sect" placeholder="Masukkan Sektor"
                                value="{{ old('sect') ? old('sect') : @$karyawan->sect }}">
                            @if ($errors->has('sect'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sect') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="divisi">Jabatan</label>
                            <select class="custom-select rounded-0  @error('divisi') is-invalid  @enderror" id="divisi"
                                name="divisi">
                                <option value="" selected="true" disabled>- Pilih Jabatan -</option>
                                <option {{ old('divisi', @$karyawan->divisi) == 'Staff' ? 'selected' : '' }}
                                    value="Staff">Staff
                                </option>
                                <option {{ old('divisi', @$karyawan->divisi) == 'Staff HR' ? 'selected' : '' }}
                                    value="Staff HR">Staff
                                    HR
                                </option>
                                <option {{ old('divisi', @$karyawan->divisi) == 'Atasan' ? 'selected' : '' }}
                                    value="Atasan">Atasan
                                </option>
                            </select>
                            @if ($errors->has('divisi'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('divisi') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="tempat_lahir">Tempat Lahir</label>
                            <input type="text" class="form-control @error('tempat_lahir') is-invalid  @enderror"
                                id="tempat_lahir" name="tempat_lahir" placeholder="Masukkan Tempat Lahir"
                                value="{{ old('tempat_lahir') ? old('tempat_lahir') : @$karyawan->tempat_lahir }}">
                            @if ($errors->has('tempat_lahir'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tempat_lahir') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control @error('tanggal_lahir') is-invalid  @enderror"
                                id="tanggal_lahir" name="tanggal_lahir" placeholder="Masukkan Tempat Lahir"
                                value="{{ old('tanggal_lahir') ? old('tanggal_lahir') : @$karyawan->tanggal_lahir }}">
                            @if ($errors->has('tanggal_lahir'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tanggal_lahir') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-0" style="display: flex; justify-content:end">
                            <input type="submit" value="SIMPAN" class="btn btn-md btn-primary">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
