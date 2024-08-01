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
            /* max-width: 900px; */
            margin: 0 auto;
            padding: 0 20px;
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
            max-width: 1050px;
            padding: 0;
            margin: 0;
            font-size: 25px;
        }

        .logo p {
            max-width: 1050px;
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
                                <td>{{ $absensi->first()->nip }}</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:33.33%;"> <!-- Kolom tengah -->
                        <table>
                            <tr>
                                <td><strong>NAMA</strong></td>
                                <td>:</td>
                                <td>{{ strtoupper($absensi->first()->nama) }}</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:33.33%"> <!-- Kolom kiri -->
                        <table style="float: right">
                            <tr>
                                <td><strong>DEPARTEMEN</strong></td>
                                <td>:</td>
                                <td>{{ strtoupper($absensi->first()->nm_dept) }}</td>
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
                        <th colspan="14">JENIS MENINGGALKAN PEKERJAAN</th>
                        <th rowspan="2">KETERANGAN</th>
                    </tr>
                    <tr>
                        <th>SD</th>
                        <th>SO</th>
                        <th>S</th>
                        <th>I</th>
                        <th>IK</th>
                        <th>TK</th>
                        <th>C</th>
                        <th>CK</th>
                        <th>CH</th>
                        <th>ITD</th>
                        <th>ICP</th>
                        <th>IKS</th>
                        <th>DL</th>
                        <th>CLT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($absensi as $absen)
                        <tr>
                            <td style="text-align: center">{{ $loop->iteration }}</td>
                            <td>{{ Carbon\Carbon::parse($absen->tgl_absen)->format('d-m-Y') }}</td>
                            @foreach (['Sakit Dengan Surat Dokter', 'Sakit Dengan Opname', 'Sakit', 'Izin', 'Izin Khusus', 'Tanpa Keterangan', 'Cuti', 'Cuti Kelahiran/Keguguran', 'Cuti Haid', 'Izin Terlambat Datang', 'Izin Cepat Pulang', 'Izin Keluar Sementara', 'Dinas Luar', 'Cuti Luar Tanggungan'] as $absensiType)
                                <td style="text-align: center">
                                    @if ($absen->jns_absen == $absensiType)
                                        <i class="fas fa-check"></i>
                                    @endif
                                </td>
                            @endforeach
                            <td>{{ $absen->ket }}</td>
                        </tr>
                    @endforeach
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
                        <th>KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sisaCuti = env('BATAS_CUTI');
                    @endphp
                    @foreach ($absensiCuti as $index => $item)
                        <tr>
                            <td style="text-align: center">{{ $index + 1 }}</td>
                            <td>{{ Carbon\Carbon::parse($item->tgl_absen)->format('d-m-Y') }}</td>
                            <td>{{ $item->ket }}</td>
                            @php
                                $sisaCuti -= 1;
                            @endphp
                            <td>{{ max(0, $sisaCuti) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="cuti" style="float: right">
                <thead>
                    <tr>
                        <th rowspan="2">NO.</th>
                        <th colspan="3">PENGAMBILAN CUTI HAID & MELAHIRKAN</th>
                    </tr>
                    <tr>
                        <th>TGL IZIN AWAL</th>
                        <th>TGL IZIN AKHIR</th>
                        <th>KETERANGAN</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sisaCuti = env('BATAS_CUTI');
                    @endphp
                    @foreach ($absensiCutiWanita as $index => $item)
                        <tr>
                            <td style="text-align: center">{{ $index + 1 }}</td>
                            <td>{{ Carbon\Carbon::parse($item->tgl_absen)->format('d-m-Y') }}</td>
                            @if ($item->tgl_absen_akhir != '')
                                <td>{{ Carbon\Carbon::parse($item->tgl_absen_akhir)->format('d-m-Y') }}</td>
                            @elseif($item->tgl_absen_akhir == '')
                                <td></td>
                            @endif
                            <td>{{ $item->ket }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="clear:both;"></div>
        </div>
    </div>
    <script>
        window.print();
    </script>
</body>

</html>
