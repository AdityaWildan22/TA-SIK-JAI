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

    <form id="absen-form" action="{{ url($routes->save) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if ($routes->is_update)
            @method('PUT')
        @endif
        <div class="row justify-content-center">
            <div class="col-md-4" id="absen-photo-container">
                <img id="avatar" src="{{ @$absen->foto ? asset(@$absen->foto) : asset('img/no-images.jpg') }}"
                    alt="Lampiran Foto" class="img-thumbnail mb-3">
                <input type="file" class="file" name="file" id="file"
                    style="visibility:hidden; position:absolute;">

                <div id="file-error" class="hidden" style="color: red;">Lampiran file harus diisi</div>
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
            // Mendapatkan elemen
            var fileInput = document.getElementById('file');
            var fileError = document.getElementById('file-error');
            var nipInput = document.getElementById('nip');
            var namaInput = document.getElementById('nama');
            var departemenSelect = document.getElementById('id_departemen');
            var sectionSelect = document.getElementById('id_section');
            var jnsAbsen = document.getElementById('jns_absen');
            var tglAbsenAkhir = document.getElementById('tgl_absen_akhir');
            var tglAbsenLabel = document.getElementById('tgl_absen_label');
            var jamAwal = document.getElementById('jam_awal');
            var jamAkhir = document.getElementById('jam_akhir');
            var absenPhotoContainer = document.getElementById('absen-photo-container');

            // Initial hiding of elements
            tglAbsenAkhir.style.display = 'none';
            jamAwal.style.display = 'none';
            jamAkhir.style.display = 'none';
            absenPhotoContainer.style.display = 'none';
            fileError.style.display = 'none';

            // Define constants for different types of absences
            const jenisAbsenPerluTanggal = [
                'Sakit Dengan Surat Dokter', 'Cuti Melahirkan', 'Sakit Dengan Opname', 'Sakit', 'Izin',
                'Izin Khusus', 'Tanpa Keterangan', 'Cuti', 'Cuti Kelahiran/Keguguran', 'Cuti Haid',
                'Dinas Luar', 'Cuti Luar Tanggungan'
            ];

            const jenisAbsenPerluWaktu = [
                'Izin Terlambat Datang', 'Izin Cepat Pulang', 'Izin Keluar Sementara'
            ];

            const jenisAbsenPerluFile = [
                'Sakit Dengan Surat Dokter', 'Sakit Dengan Opname', 'Izin Khusus',
                'Cuti Kelahiran/Keguguran', 'Cuti Luar Tanggungan'
            ];

            // Handle change event on jenis absensi
            jnsAbsen.addEventListener('change', function() {
                var selectedOption = this.value;
                var labelText = 'Tanggal Absen';

                // Display elements based on selected absensi type
                if (jenisAbsenPerluTanggal.includes(selectedOption)) {
                    tglAbsenAkhir.style.display = 'block';
                    labelText += ' Awal';
                } else {
                    tglAbsenAkhir.style.display = 'none';
                }

                if (jenisAbsenPerluWaktu.includes(selectedOption)) {
                    jamAwal.style.display = 'block';
                    jamAkhir.style.display = 'block';
                } else {
                    jamAwal.style.display = 'none';
                    jamAkhir.style.display = 'none';
                }

                if (jenisAbsenPerluFile.includes(selectedOption)) {
                    absenPhotoContainer.style.display = 'block';
                    fileInput.style.visibility = 'visible'; // Make input file visible
                    fileInput.style.position = 'static'; // Ensure input is in normal layout
                    fileInput.required = true; // Set file input as required
                } else {
                    absenPhotoContainer.style.display = 'none';
                    fileInput.style.visibility = 'hidden'; // Hide input file
                    fileInput.style.position = 'absolute'; // Keep input file out of view
                    fileInput.required = false; // Remove required attribute
                }

                tglAbsenLabel.textContent = labelText;
            });

            // Handle NIP input to fetch employee details
            nipInput.addEventListener('input', function() {
                var nip = nipInput.value;

                if (nip) {
                    fetch(`/get-karyawan-by-nip?nip=${nip}`)
                        .then(response => response.json())
                        .then(data => {
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

            // Initialize flatpickr for date input
            flatpickr('#tgl_absen_akhir_input', {
                enableTime: false,
                dateFormat: "Y-m-d",
                locale: "id",
            });

            // Handle form submission to check for file input validation
            document.getElementById('absen-form').addEventListener('submit', function(event) {
                // Check if file is required and not selected
                if (fileInput.required && !fileInput.files.length) {
                    event.preventDefault(); // Prevent form submission
                    fileError.style.display = 'block'; // Display error
                } else {
                    fileError.style.display = 'none'; // Hide error if file is selected
                }
            });
        });
    </script>

@endsection
