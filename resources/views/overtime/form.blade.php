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
                                        class="form-control @error('id_manager') is-invalid @enderror">
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
                                        class="form-control @error('id_spv') is-invalid @enderror">
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
                                <label for="nip">NIP</label>
                                <input type="number" class="form-control @error('nip') is-invalid @enderror"
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
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                    id="nama" name="nama" placeholder="Nama"
                                    value="{{ old('nama') ? old('nama') : @$overtime->nama }}" readonly>
                                @if ($errors->has('nama'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nama') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="id_departemen">Departemen</label>
                                <input type="text" class="form-control @error('id_departemen') is-invalid @enderror"
                                    id="id_departemen" name="id_departemen" placeholder="Departemen"
                                    value="{{ old('id_departemen') ? old('id_departemen') : @$overtime->nm_dept }}" readonly>
                                @if ($errors->has('id_departemen'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('id_departemen') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="id_section">Section</label>
                                <input type="text" class="form-control @error('id_section') is-invalid @enderror"
                                    id="id_section" name="id_section" placeholder="Section"
                                    value="{{ old('id_section') ? old('id_section') : @$overtime->nm_section }}" readonly>
                                @if ($errors->has('id_section'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('id_section') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="tgl_ovt">Tanggal Overtime</label>
                                <input type="date" class="form-control @error('tgl_ovt') is-invalid @enderror"
                                    id="tgl_ovt" name="tgl_ovt" placeholder="Masukkan Tanggal Overtime"
                                    value="{{ old('tgl_ovt') ? old('tgl_ovt') : @$overtime->tgl_ovt }}">
                                @if ($errors->has('tgl_ovt'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('tgl_ovt') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="jam_awal">Jam Awal</label>
                                <input type="time" class="form-control @error('jam_awal') is-invalid @enderror"
                                    id="jam_awal" name="jam_awal" placeholder="Masukkan Jam Awal"
                                    value="{{ old('jam_awal') ? old('jam_awal') : @$overtime->jam_awal }}">
                                @if ($errors->has('jam_awal'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('jam_awal') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="jam_akhir">Jam Akhir</label>
                                <input type="time" class="form-control @error('jam_akhir') is-invalid @enderror"
                                    id="jam_akhir" name="jam_akhir" placeholder="Masukkan Jam Akhir"
                                    value="{{ old('jam_akhir') ? old('jam_akhir') : @$overtime->jam_akhir }}">
                                @if ($errors->has('jam_akhir'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('jam_akhir') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="ket">Keterangan</label>
                                <input type="text" class="form-control @error('ket') is-invalid @enderror"
                                    id="ket" name="ket" placeholder="Masukkan Keterangan"
                                    value="{{ old('ket') ? old('ket') : @$overtime->ket }}">
                                @if ($errors->has('ket'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('ket') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group mb-0" style="display: flex; justify-content:end">
                                <button type="submit" class="btn btn-md btn-primary">
                                    <i class="fas fa-save"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var nipInput = document.getElementById('nip');
            var namaInput = document.getElementById('nama');
            var departemenInput = document.getElementById('id_departemen');
            var sectionInput = document.getElementById('id_section');

            nipInput.addEventListener('input', function() {
                var nip = nipInput.value;

                if (nip) {
                    fetch(`/get-karyawan-by-nip?nip=${nip}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.data) {
                                namaInput.value = data.data.nama;
                                departemenInput.value = data.data.nm_dept;
                                sectionInput.value = data.data.nm_section;
                            } else {
                                namaInput.value = '';
                                departemenInput.value = '';
                                sectionInput.value = '';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching employee:', error);
                        });
                } else {
                    namaInput.value = '';
                    departemenInput.value = '';
                    sectionInput.value = '';
                }
            });
        });
    </script>
@endsection
