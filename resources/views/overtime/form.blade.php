@extends('layouts.template')
@section('judul', 'Form Overtime')
@section('content')
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
                            <h2 class="card-title mb-0" style="font-size: 20px">FORM DATA OVERTIME</h2>
                        </div>
                        <div class="card-body">
                            @if (Auth::user()->jabatan->nm_jabatan == 'SPV' || Auth::user()->jabatan->nm_jabatan == 'HR')
                                <div class="form-group">
                                    <label for="id_manager">Nama Manager</label>
                                    <select name="id_manager" id="id_manager"
                                        class="form-control
                                    @error('id_manager') is-invalid  @enderror">
                                        <option value="" selected disabled="true">Pilih Nama Manager</option>
                                        @foreach ($manager as $item)
                                            <option value="{{ $item->nip }}"
                                                {{ (old('id_manager') ? old('id_manager') : @$overtime->id_manager) == $item->nip ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('id_manager'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('id_manager') }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                            @if (Auth::user()->jabatan->nm_jabatan != 'SPV' && Auth::user()->jabatan->nm_jabatan != 'HR')
                                <div class="form-group">
                                    <label for="id_spv">Nama SPV</label>
                                    <select name="id_spv" id="id_spv"
                                        class="form-control @error('id_spv') is-invalid  @enderror">
                                        <option value="" selected disabled="true">Pilih Nama SPV</option>
                                        @foreach ($spv as $item)
                                            <option value="{{ $item->nip }}"
                                                {{ (old('id_spv') ? old('id_spv') : @$overtime->id_spv) == $item->nip ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('id_spv'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('id_spv') }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="id_hr">Nama HR</label>
                                <select name="id_hr" id="id_hr"
                                    class="form-control @error('id_hr') is-invalid  @enderror">
                                    <option value="" selected disabled="true">Pilih Nama HR</option>
                                    @foreach ($hr as $item)
                                        <option value="{{ $item->nip }}"
                                            {{ (old('id_hr') ? old('id_hr') : @$overtime->id_hr) == $item->nip ? 'selected' : '' }}>
                                            {{ $item->nama }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('id_hr'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('id_hr') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="nip">NIP</label>
                                <input type="number" class="form-control @error('nip') is-invalid  @enderror"
                                    id="nip" name="nip" placeholder="Masukkan NIP"
                                    value="{{ old('nip') ? old('nip') : @$overtime->nip }}">
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
                                    value="{{ old('nama') ? old('nama') : @$overtime->nama }}">
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
                                            {{ (old('id_departemen') ? old('id_departemen') : @$overtime->id_departemen) == $item->id_departemen ? 'selected' : '' }}>
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
                                <label for="tgl_ovt">Tanggal Overtime</label>
                                <input type="date" class="form-control @error('tgl_ovt') is-invalid  @enderror"
                                    id="tgl_ovt" name="tgl_ovt" placeholder="Masukkan Tanggal Overtime"
                                    value="{{ old('tgl_ovt') ? old('tgl_ovt') : @$overtime->tgl_ovt }}">
                                @if ($errors->has('tgl_absen'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('tgl_absen') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="jam_awal">Jam Awal</label>
                                <input type="time" class="form-control @error('jam_awal') is-invalid  @enderror"
                                    id="jam" name="jam_awal" placeholder="Masukkan Jam Awal"
                                    value="{{ old('jam_awal') ? old('jam_awal') : @$overtime->jam_awal }}">
                                @if ($errors->has('jam_awal'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('jam_awal') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="jam_akhir">Jam Akhir</label>
                                <input type="time" class="form-control @error('jam_akhir') is-invalid  @enderror"
                                    id="jam" name="jam_akhir" placeholder="Masukkan Jam Akhir"
                                    value="{{ old('jam_akhir') ? old('jam_akhir') : @$overtime->jam_akhir }}">
                                @if ($errors->has('jam_akhir'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('jam_akhir') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="ket">Keterangan</label>
                                <input type="text" class="form-control @error('ket') is-invalid  @enderror"
                                    id="ket" name="ket" placeholder="Masukkan Keterangan"
                                    value="{{ old('ket') ? old('ket') : @$overtime->ket }}">
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
