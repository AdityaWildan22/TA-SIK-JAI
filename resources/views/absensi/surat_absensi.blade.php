<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIK | CMP</title>
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            /* border: 1px solid #ccc; */
            /* border-radius: 10px; */
        }

        p {
            font-size: 20px;
        }

        .header h2 {
            text-align: center;
            padding: 10px 0;
            margin: 0;
        }

        .content {
            font-size: 20px;
        }

        .footer {
            text-align: center;
            margin: 0;
            font-size: 20px;
        }

        .details {
            margin: 0;
        }

        .kop-surat img {
            margin-top: 3px;
            max-width: 200px;
            margin-bottom: 5px;
            float: left;
            padding: 0;
        }

        .logo {
            display: block;
            line-height: 1;
            text-align: center;
        }

        .logo h3 {
            max-width: 700px;
            padding: 0;
            margin: 0;
            font-size: 25px;
        }

        .logo p {
            max-width: 700px;
            padding: 0;
            margin: 0;
            font-size: 18px;
        }

        .garis-bawah {
            border-bottom: 2px solid #000;
        }

        .dtabsen {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        .dtabsen th,
        .dtabsen td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            font-size: 12px;
        }

        .dtabsen th {
            background-color: #f2f2f2;
            text-align: center;
        }

        .cuti {
            border-collapse: collapse;
            border: 1px solid #000;
            margin-top: 20px;
        }

        .cuti th,
        .cuti td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            font-size: 14px;
        }

        .cuti th {
            background-color: #f2f2f2;
            text-align: center;
        }

        table th,
        td {
            font-size: 15px;
        }
    </style>
</head>

<body>
    {{-- <script>
        // Ketika dokumen sudah dimuat, arahkan ke pop-up print
        window.onload = function() {
            window.print();
        };
    </script> --}}
    <div class="container">
        <div class="kop-surat">
            <div class="logo">
                <img src="{{ asset('img/logo.png') }}" alt="Logo Perusahaan">
                <h3 style="padding-top: 10px">PT. Jatim Autocomp Indonesia</h3>
                <p>Jl. Wonoayu No.26, Wonoayu, Kec. Gempol, Pasuruan
                    <br>
                    Telp: (0343) 850921
                </p>
            </div>
            <div style="clear: both;"></div>
            <div class="garis-bawah"></div>
        </div>
        <div class="header">
            <h4 style="text-align: center; margin:10px 0 0 0">CATATAN MENINGGALKAN PEKERJAAN (CMP)</h4>
            <h4 style="text-align: center;margin:0 0 10px 0">TAHUN : <?php echo date('Y'); ?></h4>
        </div>
        <div class="details">
            <table style="width:100%;">
                <tr>
                    <td style="width:33.33%; text-align:right;"> <!-- Kolom kanan -->
                        <table>
                            <tr>
                                <td><strong>NIP</strong></td>
                                <td>:</td>
                                <td>{{ $absensi->nip }}</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:33.33%;"> <!-- Kolom tengah -->
                        <table>
                            <tr>
                                <td><strong>NAMA</strong></td>
                                <td>:</td>
                                <td>{{ strtoupper($absensi->nama) }}</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:33.33%"> <!-- Kolom kiri -->
                        <table style="float: right">
                            <tr>
                                <td><strong>DEPARTEMEN</strong></td>
                                <td>:</td>
                                <td>{{ strtoupper($absensi->departemen->nm_dept) }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </div>
        <div class="details">
            <table class="dtabsen" style="width: 100%; border:1px solid #000">
                <thead>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">TGL ABSEN</th>
                        <th colspan="10">JENIS MENINGGALKAN PEKERJAAN</th>
                        <th rowspan="2">KETERANGAN</th>
                        {{-- <th rowspan="2">MENYETUJUI ATASAN</th>
                        <th rowspan="2">MENGETAHUI HR</th> --}}
                    </tr>
                    <tr>
                        <th>S</th>
                        <th>I</th>
                        <th>IK</th>
                        <th>C</th>
                        <th>CK</th>
                        <th>CH</th>
                        <th>ITD</th>
                        <th>ICP</th>
                        <th>IKS</th>
                        <th>DL</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center">{{ $no1++ }}</td>
                        <td>{{ Carbon\Carbon::parse($absensi->tgl_absen)->format('d-m-Y') }}</td>
                        <td style="text-align: center"><i class="fas fa-check"></i></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td style="text-align: center"></td>
                        <td>{{ $absensi->ket }}</td>
                        {{-- <td> <img src="{{ $staff_hr->foto_ttd }}" alt="" style="width:25%"></td>
                        <td> <img src="{{ $atasan->foto_ttd }}" alt="" style="width:25%"></td> --}}
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="margin-top: 10px;">
            <table class="cuti" style="float: left">
                <!-- Isi tabel pertama -->
                <thead>
                    <tr>
                        <th rowspan="2">NO.</th>
                        <th colspan="2">PENGAMBILAN CUTI TAHUNAN</th>
                        <th rowspan="2">SISA CUTI</th>
                    </tr>
                    <tr>
                        <th>TGL</th>
                        <th>JUMLAH</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center">{{ $no2++ }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <table class="cuti" style="float: right">
                <thead>
                    <tr>
                        <th rowspan="2">NO.</th>
                        <th colspan="2">PENGAMBILAN CUTI HAID & MELAHIRKAN</th>
                        <th rowspan="2">SISA CUTI</th>
                    </tr>
                    <tr>
                        <th>TGL</th>
                        <th>JUMLAH</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: center">{{ $no3++ }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <div style="clear:both;"></div>
        </div>

    </div>
    <div class="footer">
        <h5 style="text-align: center; margin:0; padding:0">Disetujui Oleh,</h5>
        <table style="width: 100%; text-align: center;">
            <tr>
                <td style="width: 33%; text-align: center; padding-right: 20px;">
                    <p>{{ $staff_hr->nama }}</p>
                    @if ($absensi->status_pengajuan == 'Diterima')
                        <img src="{{ $staff_hr->foto_ttd }}" alt="" style="width:60%">
                    @endif
                    <p><strong>{{ $staff_hr->nm_jabatan }}</strong></p>
                </td>
                <td style="width: 33%;">
                    <p></p>
                </td>
                <td style="width: 33%; text-align: center; padding-left: 20px;">
                    <p>{{ $atasan->nama }}</p>
                    @if ($absensi->status_pengajuan == 'Diterima')
                        <img src="{{ $atasan->foto_ttd }}" alt="" style="width:60%">
                    @endif
                    <p><strong>{{ $atasan->nm_jabatan }}</strong></p>
                </td>
            </tr>
        </table>
    </div>
    </div>
</body>
{{-- @include('layouts.footer') --}}

</html>
