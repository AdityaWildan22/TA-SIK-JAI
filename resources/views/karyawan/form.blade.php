@extends('layouts.template')
@section('judul', 'Form Karyawan')
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header" style="background-color:#4e73df;color:#fff">
                    <h2 class="card-title mb-0" style="font-size: 20px">FORM DATA KARYAWAN</h2>
                </div>
                <div class="card-body">
                    <form action="{{ url($routes->save) }}" method="POST">
                        @csrf
                        @if ($routes->is_update)
                            @method('PUT')
                        @endif
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
                            <label for="id_departemen">Departemen</label>
                            <select class="custom-select rounded-0  @error('id_departemen') is-invalid  @enderror"
                                id="id_departemen" name="id_departemen">
                                <option value="" selected="true" disabled>- Pilih Departemen -</option>
                                @foreach ($departemen as $item)
                                    <option value="{{ $item->id_departemen }}"
                                        {{ (old('id_departemen') ? old('id_departemen') : @$karyawan->id_departemen) == $item->id_departemen ? 'selected' : '' }}>
                                        {{ $item->nm_dept }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('id_departemen'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('id_departemen') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="id_jabatan">Jabatan</label>
                            <select class="custom-select rounded-0  @error('id_jabatan') is-invalid  @enderror"
                                id="id_jabatan" name="id_jabatan">
                                <option value="" selected="true" disabled>- Pilih Jabatan -</option>
                                @foreach ($jabatan as $item)
                                    <option value="{{ $item->id_jabatan }}"
                                        {{ (old('id_jabatan') ? old('id_jabatan') : @$karyawan->id_jabatan) == $item->id_jabatan ? 'selected' : '' }}>
                                        {{ $item->nm_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('id_jabatan'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('id_jabatan') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="custom-select rounded-0  @error('role') is-invalid  @enderror" id="role"
                                name="role">
                                <option value="" selected="true" disabled>- Pilih Role -</option>
                                <option {{ old('role', @$karyawan->role) == 'SuperAdmin' ? 'selected' : '' }}
                                    value="SuperAdmin">SuperAdmin
                                </option>
                                <option {{ old('role', @$karyawan->role) == 'Admin' ? 'selected' : '' }} value="Admin">
                                    Admin
                                </option>
                                <option {{ old('role', @$karyawan->role) == 'Manager' ? 'selected' : '' }} value="Manager">
                                    Manager
                                </option>
                                <option {{ old('role', @$karyawan->role) == 'SPV' ? 'selected' : '' }} value="SPV">
                                    SPV
                                </option>
                                <option {{ old('role', @$karyawan->role) == 'Staff' ? 'selected' : '' }} value="Staff">
                                    Staff
                                </option>
                            </select>
                            @if ($errors->has('role'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('role') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="jenis_kelamin">Jenis Kelamin</label>
                            <select class="custom-select rounded-0  @error('jenis_kelamin') is-invalid  @enderror"
                                id="jenis_kelamin" name="jenis_kelamin">
                                <option value="" selected="true" disabled>- Pilih Jenis Kelamin -</option>
                                <option
                                    {{ old('jenis_kelamin', @$karyawan->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}
                                    value="Laki-laki">Laki-laki
                                </option>
                                <option
                                    {{ old('jenis_kelamin', @$karyawan->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}
                                    value="Perempuan">Perempuan
                                </option>
                            </select>
                            @if ($errors->has('jenis_kelamin'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('jenis_kelamin') }}
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
                                id="tanggal_lahir" name="tanggal_lahir" placeholder="Masukkan Tanggal Lahir"
                                value="{{ old('tanggal_lahir') ? old('tanggal_lahir') : @$karyawan->tanggal_lahir }}">
                            @if ($errors->has('tanggal_lahir'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('tanggal_lahir') }}
                                </div>
                            @endif
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
    </div>
@endsection
