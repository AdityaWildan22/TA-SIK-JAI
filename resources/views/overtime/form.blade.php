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
                            <div class="form-group">
                                <label for="id_atasan">Nama Atasan</label>
                                <select name="id_atasan" id="id_atasan"
                                    class="form-control
                                    @error('id_atasan') is-invalid  @enderror">
                                    <option value="" selected disabled="true">Pilih Nama Atasan</option>
                                    @foreach ($atasan as $item)
                                        <option value="{{ $item->nip }}"
                                            {{ (old('id_atasan') ? old('id_atasan') : @$overtime->id_atasan) == $item->nip ? 'selected' : '' }}>
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
                                <label for="id_staff_hr">Nama Staff HR</label>
                                <select name="id_staff_hr" id="id_staff_hr"
                                    class="form-control @error('id_staff_hr') is-invalid  @enderror">
                                    <option value="" selected disabled="true">Pilih Nama HR</option>
                                    @foreach ($staff_hr as $item)
                                        <option value="{{ $item->nip }}"
                                            {{ (old('id_staff_hr') ? old('id_staff_hr') : @$overtime->id_staff_hr) == $item->nip ? 'selected' : '' }}>
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
                                <label for="sect">Sektor</label>
                                <input type="text" class="form-control @error('sect') is-invalid  @enderror"
                                    id="sect" name="sect" placeholder="Masukkan Sektor"
                                    value="{{ old('sect') ? old('sect') : @$overtime->sect }}">
                                @if ($errors->has('sect'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('sect') }}
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
