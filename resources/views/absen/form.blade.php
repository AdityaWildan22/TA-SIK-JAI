@extends('layouts.template')
@section('judul', 'Form Absensi')
@section('content')
    <style>
        .select-readonly {
            pointer-events: none;
            background-color: #e9ecef;
        }
    </style>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <form action="{{ url($routes->save) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($routes->is_update)
            @method('PUT')
        @endif
        <div class="row justify-content-center">
            <div class="col-md-4">
                <img id="avatar" src="{{ @$absen->foto ? asset(@$absen->foto) : asset('img/no-images.jpg') }}"
                    alt="Lampiran Foto" class="img-thumbnail">
                <input type="file" class="file" name="file" id="file" style="display:none">
            </div>
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card">
                        <div class="card-header" style="background-color:#4e73df;color:#fff">
                            <h2 class="card-title mb-0" style="font-size: 20px">FORM DATA ABSEN</h2>
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
                                        class="form-control @error('id_spv') is-invalid @enderror">
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
                                <input type="number" class="form-control @error('nip') is-invalid @enderror" id="nip"
                                    name="nip" placeholder="Masukkan NIP"
                                    value="{{ old('nip') ? old('nip') : @$absensi->nip }}">
                                @if ($errors->has('nip'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nip') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror"
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
                                <select
                                    class="custom-select rounded-0 select-readonly @error('id_departemen') is-invalid @enderror"
                                    id="id_departemen" name="id_departemen">
                                    <option value="" selected disabled>- Pilih Departemen -</option>
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
                                <label for="id_section">Section</label>
                                <select
                                    class="custom-select rounded-0 select-readonly @error('id_section') is-invalid @enderror"
                                    id="id_section" name="id_section">
                                    <option value="" selected disabled>- Pilih Section -</option>
                                    @foreach ($section as $item)
                                        <option value="{{ $item->id_section }}"
                                            {{ (old('id_section') ? old('id_section') : @$absensi->id_section) == $item->id_section ? 'selected' : '' }}>
                                            {{ $item->nm_section }}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('id_section'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('id_section') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="jns_absen">Jenis Absensi</label>
                                <select class="custom-select rounded-0 @error('jns_absen') is-invalid @enderror"
                                    id="jns_absen" name="jns_absen">
                                    <option value="" selected disabled>- Pilih Absensi -</option>
                                    <option
                                        {{ old('jns_absen', @$absensi->jns_absen) == 'Sakit Dengan Surat Dokter' ? 'selected' : '' }}
                                        value="Sakit Dengan Surat Dokter">Sakit Dengan Surat Dokter
                                    </option>
                                    <option
                                        {{ old('jns_absen', @$absensi->jns_absen) == 'Sakit Dengan Opname' ? 'selected' : '' }}
                                        value="Sakit Dengan Opname">Sakit Dengan Opname
                                    </option>
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
                                    <option
                                        {{ old('jns_absen', @$absensi->jns_absen) == 'Tanpa Keterangan' ? 'selected' : '' }}
                                        value="Tanpa Keterangan">Tanpa Keterangan
                                    </option>
                                    <option {{ old('jns_absen', @$absensi->jns_absen) == 'Cuti' ? 'selected' : '' }}
                                        value="Cuti">
                                        Cuti
                                    </option>
                                    @if (Auth::user()->jenis_kelamin == 'Perempuan')
                                        <option
                                            {{ old('jns_absen', @$absensi->jns_absen) == 'Cuti Kelahiran/Keguguran' ? 'selected' : '' }}
                                            value="Cuti Kelahiran/Keguguran">Cuti Kelahiran/Keguguran
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
                                    <option
                                        {{ old('jns_absen', @$absensi->jns_absen) == 'Cuti Luar Tanggungan' ? 'selected' : '' }}
                                        value="Cuti Luar Tanggungan">
                                        Cuti Luar Tanggungan
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
                                    class="form-control form-control @error('tgl_absen') is-invalid @enderror"
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
                                    class="form-control form-control @error('tgl_absen_akhir') is-invalid @enderror"
                                    id="tgl_absen_akhir_input" name="tgl_absen_akhir"
                                    placeholder="Masukkan Tanggal Absen"
                                    value="{{ old('tgl_absen_akhir') ? old('tgl_absen_akhir') : @$absensi->tgl_absen_akhir }}">
                                @if ($errors->has('tgl_absen_akhir'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('tgl_absen_akhir') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group" id="jam_awal">
                                <label for="jam_awal">Jam Awal</label>
                                <input type="time" class="form-control @error('jam_awal') is-invalid @enderror"
                                    id="jam_awal" name="jam_awal" placeholder="Masukkan Jam Awal"
                                    value="{{ old('jam_awal') ? old('jam_awal') : @$absensi->jam_awal }}">
                                @if ($errors->has('jam_awal'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('jam_awal') }}
                                    </div>
                                @endif
                            </div>
                            <div class="form-group" id="jam_akhir">
                                <label for="jam_akhir">Jam Akhir</label>
                                <input type="time" class="form-control @error('jam_akhir') is-invalid @enderror"
                                    id="jam_akhir" name="jam_akhir" placeholder="Masukkan Jam Akhir"
                                    value="{{ old('jam_akhir') ? old('jam_akhir') : @$absensi->jam_akhir }}">
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
                </div>
            </div>
        </div>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var nipInput = document.getElementById('nip');
            var namaInput = document.getElementById('nama');
            var departemenSelect = document.getElementById('id_departemen');
            var sectionSelect = document.getElementById('id_section');
            var jns_absen = document.getElementById('jns_absen');
            var tgl_absen_akhir = document.getElementById('tgl_absen_akhir');
            var tgl_absen_label = document.getElementById('tgl_absen_label');
            var jam_awal = document.getElementById('jam_awal');
            var jam_akhir = document.getElementById('jam_akhir');

            tgl_absen_akhir.style.display = 'block';
            jam_awal.style.display = 'block';
            jam_akhir.style.display = 'block';

            const jenisAbsenPerluTanggal = [
                'Sakit Dengan Surat Dokter', 'Cuti Melahirkan', 'Sakit Dengan Opname', 'Sakit', 'Izin',
                'Izin Khusus',
                'Tanpa Keterangan', 'Cuti', 'Cuti Kelahiran/Keguguran', 'Cuti Haid', 'Dinas Luar',
                'Cuti Luar Tanggungan'
            ];

            const jenisAbsenPerluWaktu = [
                'Izin Terlambat Datang', 'Izin Cepat Pulang', 'Izin Keluar Sementara'
            ];

            if (!jenisAbsenPerluTanggal.includes(jns_absen.value)) {
                tgl_absen_akhir.style.display = 'none';
            }

            jns_absen.addEventListener('change', function() {
                if (jenisAbsenPerluTanggal.includes(this.value)) {
                    tgl_absen_akhir.style.display = 'block';
                } else {
                    tgl_absen_akhir.style.display = 'none';
                }
            });

            if (!jenisAbsenPerluWaktu.includes(jns_absen.value)) {
                jam_awal.style.display = 'none';
                jam_akhir.style.display = 'none';
            }

            jns_absen.addEventListener('change', function() {
                if (jenisAbsenPerluWaktu.includes(this.value)) {
                    jam_awal.style.display = 'block';
                    jam_akhir.style.display = 'block';
                } else {
                    jam_awal.style.display = 'none';
                    jam_akhir.style.display = 'none';
                }
            });

            nipInput.addEventListener('input', function() {
                var nip = nipInput.value;

                if (nip) {
                    fetch(`/get-karyawan-by-nip?nip=${nip}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            if (data.success && data.data) {
                                namaInput.value = data.data.nama || '';
                                departemenSelect.value = data.data.id_departemen || '';
                                sectionSelect.value = data.data.id_section || '';
                            } else {
                                namaInput.value = '';
                                departemenSelect.value = '';
                                sectionSelect.value = '';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching employee:', error);
                        });
                } else {
                    namaInput.value = '';
                    departemenSelect.value = '';
                    sectionSelect.value = '';
                }
            });

            jns_absen.addEventListener('change', function() {
                var selectedOption = this.value;
                var labelText = 'Tanggal Absen';

                if (jenisAbsenPerluTanggal.includes(selectedOption)) {
                    labelText += ' Awal';
                }

                tgl_absen_label.textContent = labelText;
            });
            flatpickr(tgl_absen_akhir_input, {
                enableTime: false,
                dateFormat: "Y-m-d",
                locale: "id",
            });
        });
    </script>
@endsection
