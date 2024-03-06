<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Absensi</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        #header {
            position: relative;
        }

        #header img {
            width: 100%;
        }

        #data {
            position: relative;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        #data thead {
            background-color: burlywood;
        }

        #data thead tr th,
        #data tbody tr td {
            padding: 5px;
            text-align: center;
            color: #000;
            font-family: Arial;
            border: 1px solid #000;
        }

        #data tbody tr td {
            text-align: left;
        }

        #data tbody tr td.right {
            text-align: right;
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
            /* max-width: 700px; */
            padding: 0;
            margin: 0;
            font-size: 25px;
        }

        .logo p {
            /* max-width: 700px; */
            padding: 0;
            margin: 0;
            font-size: 18px;
        }

        .garis-bawah {
            border-bottom: 2px solid #000;
        }
    </style>
</head>

<body>
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
    @if (@$tgl_awal != '')
        <h3><strong>LAPORAN DATA ABSENSI PERIODE {{ Carbon\Carbon::parse($tgl_awal)->format('d/m/Y') }} -
                {{ Carbon\Carbon::parse($tgl_akhir)->format('d/m/Y') }}</strong></h3>
    @elseif(@$tgl_awal == '')
        <h3><strong>LAPORAN SELURUH DATA ABSENSI</strong></h3>
    @endif
    <table id="data" width="100%">
        <thead>
            <tr>
                <th rowspan="2" width="5px">NO.</th>
                <th rowspan="2">NIP</th>
                <th rowspan="2">NAMA</th>
                <th rowspan="2">DEPARTEMEN</th>
                <th rowspan="2">JABATAN</th>
                <th colspan="10">JENIS MENINGGALKAN PEKERJAAN</th>
                <th rowspan="2">TOTAL ABSENSI</th>
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
            @foreach ($absensi as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->nip }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->nm_dept }}</td>
                    <td>{{ $item->nm_jabatan }}</td>
                    <td>{{ $item->jumlah_S }}</td>
                    <td>{{ $item->jumlah_I }}</td>
                    <td>{{ $item->jumlah_IK }}</td>
                    <td>{{ $item->jumlah_C }}</td>
                    <td>{{ $item->jumlah_CK }}</td>
                    <td>{{ $item->jumlah_CH }}</td>
                    <td>{{ $item->jumlah_ITD }}</td>
                    <td>{{ $item->jumlah_ICP }}</td>
                    <td>{{ $item->jumlah_IKS }}</td>
                    <td>{{ $item->jumlah_DL }}</td>
                    <td>{{ $item->total_absensi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($absensi->isEmpty())
        <h4 style="margin-top: 20px; text-align:center">Data Absensi Kosong</h4>
    @endif
    </div>
    {{-- Print --}}
    <script>
        window.print();
    </script>
</body>

</html>
