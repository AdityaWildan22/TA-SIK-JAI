@extends('layouts.template')
@section('judul', 'Form Absensi')
@section('content')
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <form action="{{ url($routes->save) }}" method="POST">
                    @csrf
                    @if ($routes->is_update)
                        @method('PUT')
                    @endif
                    <div class="card">
                        <div class="card-header" style="background-color:#4e73df;color:#fff">
                            <h2 class="card-title mb-0" style="font-size: 20px">FORM DATA ABSENSI</h2>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="id_atasan">Nama Manager</label>
                                <select name="id_atasan" id="id_atasan"
                                    class="form-control @error('id_atasan') is-invalid  @enderror">
                                    <option value="" selected disabled="true">Pilih Nama Manager</option>
                                    @foreach ($manager as $item)
                                        <option value="{{ $item->nip }}"
                                            {{ (old('id_atasan') ? old('id_atasan') : @$absensi->id_atasan) == $item->nip ? 'selected' : '' }}>
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('id_atasan'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('id_atasan') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="id_staff_hr">Nama SPV</label>
                                <select name="id_staff_hr" id="id_staff_hr"
                                    class="form-control @error('id_staff_hr') is-invalid  @enderror">
                                    <option value="" selected disabled="true">Pilih Nama SPV</option>
                                    @foreach ($spv as $item)
                                        <option value="{{ $item->nip }}"
                                            {{ (old('id_staff_hr') ? old('id_staff_hr') : @$absensi->id_staff_hr) == $item->nip ? 'selected' : '' }}>
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('id_staff_hr'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('id_staff_hr') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="number" class="form-control @error('nip') is-invalid  @enderror"
                                    id="nip" name="nip" placeholder="Masukkan NIP"
                                    value="{{ old('nip') ? old('nip') : @$absensi->nip }}">
                                @if ($errors->has('nip'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nip') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control @error('nama') is-invalid  @enderror"
                                    id="nama" name="nama" placeholder="Masukkan Nama"
                                    value="{{ old('nama') ? old('nama') : @$absensi->nama }}">
                                @if ($errors->has('nama'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nama') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                {{-- {{ dd($karyawan->id_departemen) }} --}}
                                <label for="id_departemen">Departemen</label>
                                <select class="custom-select rounded-0  @error('id_departemen') is-invalid  @enderror"
                                    id="id_departemen" name="id_departemen">
                                    <option value="" selected="true" disabled>- Pilih Departemen -</option>
                                    @foreach ($departemen as $item)
                                        <option value="{{ $item->id_departemen }}"
                                            {{ (old('id_departemen') ? old('id_departemen') : @$absensi->id_departemen) == $item->id_departemen ? 'selected' : '' }}>
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
                                <label for="tgl_absen">Tanggal Absen</label>
                                <input type="date"
                                    class="form-control form-control @error('tgl_absen') is-invalid  @enderror"
                                    id="tgl_absen" name="tgl_absen" placeholder="Masukkan Tanggal Absen"
                                    value="{{ old('tgl_absen') ? old('tgl_absen') : @$absensi->tgl_absen }}">
                                @if ($errors->has('tgl_absen'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('tgl_absen') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="jns_absen">Jenis Absensi</label>
                                <select class="custom-select rounded-0  @error('jns_absen') is-invalid  @enderror"
                                    id="jns_absen" name="jns_absen">
                                    <option value="" selected="true" disabled>- Pilih Absensi -</option>
                                    <option {{ old('jns_absen', @$absensi->jns_absen) == 'Sakit' ? 'selected' : '' }}
                                        value="Sakit">Sakit
                                    </option>
                                    <option {{ old('jns_absen', @$absensi->jns_absen) == 'Izin' ? 'selected' : '' }}
                                        value="Izin">
                                        Izin
                                    </option>
                                    <option {{ old('jns_absen', @$absensi->jns_absen) == 'Izin Khusus' ? 'selected' : '' }}
                                        value="Izin Khusus">Izin Khusus
                                    </option>
                                    <option {{ old('jns_absen', @$absensi->jns_absen) == 'Cuti' ? 'selected' : '' }}
                                        value="Cuti">
                                        Cuti
                                    </option>
                                    <option
                                        {{ old('jns_absen', @$absensi->jns_absen) == 'Cuti Melahirkan' ? 'selected' : '' }}
                                        value="Cuti Melahirkan">Cuti Melahirkan
                                    </option>
                                    <option {{ old('jns_absen', @$absensi->jns_absen) == 'Cuti Haid' ? 'selected' : '' }}
                                        value="Cuti Haid">
                                        Cuti Haid
                                    </option>
                                    <option
                                        {{ old('jns_absen', @$absensi->jns_absen) == 'Izin Terlambat Datang' ? 'selected' : '' }}
                                        value="Izin Terlambat Datang">Izin Terlambat Datang
                                    </option>
                                    <option
                                        {{ old('jns_absen', @$absensi->jns_absen) == 'Izin Cepat Pulang' ? 'selected' : '' }}
                                        value="Izin Cepat Pulang">Izin Cepat Pulang
                                    </option>
                                    <option
                                        {{ old('jns_absen', @$absensi->jns_absen) == 'Izin Keluar Sementara' ? 'selected' : '' }}
                                        value="Izin Keluar Sementara">Izin Keluar Sementara
                                    </option>
                                    <option {{ old('jns_absen', @$absensi->jns_absen) == 'Dinas Luar' ? 'selected' : '' }}
                                        value="Dinas Luar">
                                        Dinas Luar
                                    </option>
                                </select>
                                @if ($errors->has('jns_absen'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('jns_absen') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="ket">Keterangan</label>
                                <input type="text" class="form-control @error('ket') is-invalid  @enderror"
                                    id="ket" name="ket" placeholder="Masukkan Keterangan"
                                    value="{{ old('ket') ? old('ket') : @$absensi->ket }}">
                                @if ($errors->has('ket'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('ket') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group mb-0" style="display: flex; justify-content:end">
                                <input type="submit" value="SIMPAN" class="btn btn-md btn-primary">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
