@extends('layouts.template')
@section('judul', 'Detail Absensi')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 5px;
        text-align: left;
    }

    tr {
        width: 100%;
    }
</style>
@section('content')
    <div class="card-shadow">
        <a href="{{ url('/absensi') }}" class="btn btn-lg btn-primary h-20 mb-3" style="margin-left:25px; font-size:medium">
            <i class="fas fa-arrow-left"> Kembali</i><br>
        </a>
    </div>
    <div class="card">
        <div class="card-header bg-primary">
            <h2 class="card-title mb-0" style="font-size: 20px; color:#fff">DATA DETAIL ABSEN
        </div>
        <div class="card-body">
            <table>
                @if ($absensi->nm_jabatan == 'SPV' || $absensi->nm_jabatan == 'HR')
                    <tr>
                        <td>Nama Manager</td>
                        <td>:</td>
                        <td>{{ $manager->nama }}</td>
                    </tr>
                @endif
                @if ($absensi->nm_jabatan != 'SPV' && $absensi->nm_jabatan != 'HR')
                    <tr>
                        <td>Nama SPV</td>
                        <td>:</td>
                        <td>{{ $spv->nama }}</td>
                    </tr>
                @endif
                <tr>
                    <td>NIP</td>
                    <td>:</td>
                    <td>{{ $absensi->nip }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $absensi->nama }}</td>
                </tr>
                <tr>
                    <td>Departemen</td>
                    <td>:</td>
                    <td>{{ $absensi->nm_dept }}</td>
                </tr>
                <tr>
                    <td>Jenis Absen</td>
                    <td>:</td>
                    <td>{{ $absensi->jns_absen }}</td>
                </tr>
                <tr id="tgl_awal_absen">
                    <td id="label_tgl_awal">Tanggal Absen Awal</td>
                    <td>:</td>
                    <td>{{ Carbon\Carbon::parse($absensi->tgl_absen)->format('d-m-Y') }}</td>
                </tr>
                <tr id="tgl_akhir_absen">
                    <td>Tanggal Absen Akhir</td>
                    <td>:</td>
                    <td>{{ $absensi->tgl_absen_akhir ? Carbon\Carbon::parse($absensi->tgl_absen_akhir)->format('d-m-Y') : '' }}
                    </td>
                </tr>
                <tr id="jam_awal_absen">
                    <td>Jam Absen Awal</td>
                    <td>:</td>
                    <td>{{ $absensi->jam_awal }}</td>
                </tr>
                <tr id="jam_akhir_absen">
                    <td>Jam Absen Akhir</td>
                    <td>:</td>
                    <td>{{ $absensi->jam_akhir }}</td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td>:</td>
                    <td>{{ $absensi->ket }}</td>
                </tr>
                <tr>
                    <td>Status Pengajuan</td>
                    <td>:</td>
                    <td>
                        @if ($absensi->status_pengajuan == 'Diproses')
                            <span class="badge bg-warning"
                                style="text-align: left;font-size:12px;color:#fff !important">DIPROSES</span>
                        @elseif($absensi->status_pengajuan == 'Pending')
                            <span class="badge bg-warning"
                                style="text-align: left;font-size:12px;color:#fff !important">PENDING</span>
                        @elseif($absensi->status_pengajuan == 'Diterima')
                            <span class="badge bg-success"
                                style="text-align: left;font-size:12px;color:#fff !important">DITERIMA</span>
                        @elseif($absensi->status_pengajuan == 'Ditolak')
                            <span class="badge bg-danger"
                                style="text-align: left;font-size:12px;color:#fff !important">DITOLAK</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td>Lampiran Foto</td>
                    <td>:</td>
                    <td>
                        @if ($absensi->foto)
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                data-target="#notaModal" data-toggle="tooltip" data-placement="top" title="Lihat Foto">
                                <i class="fas fa-eye"></i>
                            </button>
                        @else
                            <span>N/A</span>
                        @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <div class="modal fade" id="notaModal" tabindex="-1" role="dialog" aria-labelledby="notaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notaModalLabel">Lampiran Foto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset($absensi->foto) }}" alt="Nota" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i
                            class="fas fa-xmark"></i>
                        Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#notaModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var notaImage = "{{ asset($absensi->foto) }}";
                var modal = $(this);
                modal.find('.modal-body img').attr('src', notaImage);
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisAbsenPerluTanggal = [
                'Sakit Dengan Surat Dokter', 'Sakit Dengan Opname', 'Sakit', 'Izin',
                'Izin Khusus',
                'Tanpa Keterangan', 'Cuti', 'Cuti Kelahiran/Keguguran', 'Cuti Haid', 'Dinas Luar',
                'Cuti Luar Tanggungan'
            ];
            const jenisAbsenPerluWaktu = [
                'Izin Terlambat Datang', 'Izin Cepat Pulang', 'Izin Keluar Sementara'
            ];

            const jnsAbsen = '{{ $absensi->jns_absen }}';
            const tglAwal = document.getElementById('tgl_awal_absen');
            const tglAkhir = document.getElementById('tgl_akhir_absen');
            const jamAwal = document.getElementById('jam_awal_absen');
            const jamAkhir = document.getElementById('jam_akhir_absen');
            const labelTglAwal = document.getElementById('label_tgl_awal');

            function toggleFields(jnsAbsen) {
                if (jnsAbsen === 'Cuti') {
                    labelTglAwal.textContent = 'Tanggal Cuti';
                    tglAwal.style.display = '';
                    tglAkhir.style.display = 'none';
                    jamAwal.style.display = 'none';
                    jamAkhir.style.display = 'none';
                } else if (jenisAbsenPerluTanggal.includes(jnsAbsen)) {
                    labelTglAwal.textContent = 'Tanggal Absen Awal';
                    tglAwal.style.display = '';
                    tglAkhir.style.display = '';
                    jamAwal.style.display = 'none';
                    jamAkhir.style.display = 'none';
                } else if (jenisAbsenPerluWaktu.includes(jnsAbsen)) {
                    labelTglAwal.textContent = 'Tanggal';
                    tglAwal.style.display = '';
                    jamAwal.style.display = '';
                    jamAkhir.style.display = '';
                    tglAkhir.style.display = 'none';
                } else {
                    labelTglAwal.textContent = 'Tanggal';
                    tglAwal.style.display = '';
                    tglAkhir.style.display = 'none';
                    jamAwal.style.display = 'none';
                    jamAkhir.style.display = 'none';
                }
            }


            toggleFields(jnsAbsen);

            const jnsAbsenSelect = document.getElementById('jns_absen');
            if (jnsAbsenSelect) {
                jnsAbsenSelect.addEventListener('change', function() {
                    toggleFields(this.value);
                });
            }
        });
    </script>
@endsection
