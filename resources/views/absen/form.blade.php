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
                            <h2 class="card-title mb-0" style="font-size: 20px">FORM DATA ABSEN</h2>
                        </div>
                        <div class="card-body">
                            @if (Auth::user()->jabatan->nm_jabatan == 'SPV' || Auth::user()->jabatan->nm_jabatan == 'HR')
                                <div class="form-group">
                                    <label for="id_manager">Nama Manager</label>
                                    <select name="id_manager" id="id_manager"
                                        class="form-control @error('id_manager') is-invalid  @enderror">
                                        <option value="" selected disabled="true">Pilih Nama Manager</option>
                                        @foreach ($manager as $item)
                                            <option value="{{ $item->nip }}"
                                                {{ (old('id_manager') ? old('id_manager') : @$absensi->id_manager) == $item->nip ? 'selected' : '' }}>
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
                                                {{ (old('id_spv') ? old('id_spv') : @$absensi->id_spv) == $item->nip ? 'selected' : '' }}>
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
                                    value="{{ old('nama') ? old('nama') : @$absensi->nama }}" readonly>
                                @if ($errors->has('nama'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nama') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="id_departemen">Departemen</label>
                                <input type="text" class="form-control @error('id_departemen') is-invalid  @enderror"
                                    id="id_departemen" name="id_departemen" placeholder="Departemen"
                                    value="{{ old('id_departemen') ? old('id_departemen') : @$absensi->id_departemen }}" readonly>
                                @if ($errors->has('id_departemen'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('id_departemen') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="id_section">Section</label>
                                <input type="text" class="form-control @error('id_section') is-invalid  @enderror"
                                    id="id_section" name="id_section" placeholder="Section"
                                    value="{{ old('id_section') ? old('id_section') : @$absensi->id_section }}" readonly>
                                @if ($errors->has('id_section'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('id_section') }}
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
                                    @if (Auth::user()->jenis_kelamin == 'Perempuan')
                                        <option
                                            {{ old('jns_absen', @$absensi->jns_absen) == 'Cuti Melahirkan' ? 'selected' : '' }}
                                            value="Cuti Melahirkan">Cuti Melahirkan
                                        </option>
                                        <option
                                            {{ old('jns_absen', @$absensi->jns_absen) == 'Cuti Haid' ? 'selected' : '' }}
                                            value="Cuti Haid">
                                            Cuti Haid
                                        </option>
                                    @endif
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
                                <label id="tgl_absen_label" for="tgl_absen">Tanggal Absen</label>
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
                            <div class="form-group" id="tgl_absen_akhir">
                                <label for="tgl_absen_akhir">Tanggal Absen Akhir</label>
                                <input type="date"
                                    class="form-control form-control @error('tgl_absen_akhir') is-invalid  @enderror"
                                    id="tgl_absen_akhir_input" name="tgl_absen_akhir"
                                    placeholder="Masukkan Tanggal Absen"
                                    value="{{ old('tgl_absen_akhir') ? old('tgl_absen_akhir') : @$absensi->tgl_absen_akhir }}">
                                @if ($errors->has('tgl_absen_akhir'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('tgl_absen_akhir') }}
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
            var jns_absen = document.getElementById('jns_absen');
            var tgl_absen_akhir = document.getElementById('tgl_absen_akhir');

            tgl_absen_akhir.style.display = 'block';

            if (jns_absen.value !== 'Cuti Melahirkan') {
                tgl_absen_akhir.style.display = 'none';
            }

            jns_absen.addEventListener('change', function() {
                if (this.value == 'Cuti Melahirkan') {
                    tgl_absen_akhir.style.display = 'block';
                } else {
                    tgl_absen_akhir.style.display = 'none';
                }
            });

            nipInput.addEventListener('input', function() {
                var nip = nipInput.value;

                if (nip) {
                    fetch(`/get-karyawan-by-nip?nip=${nip}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data); // Debug: lihat struktur data yang diterima
                            if (data.success && data.data) {
                                namaInput.value = data.data.nama || '';
                                departemenInput.value = data.data.nm_dept || '';
                                sectionInput.value = data.data.nm_section || '';
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
