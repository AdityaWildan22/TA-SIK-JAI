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
        <h3 style="text-align: center"><strong>LAPORAN DATA ABSENSI PERIODE
                {{ Carbon\Carbon::parse($tgl_awal)->format('d/m/Y') }} -
                {{ Carbon\Carbon::parse($tgl_akhir)->format('d/m/Y') }}</strong></h3>
    @elseif(@$tgl_awal == '')
        <h3 style="text-align: center"><strong>LAPORAN SELURUH DATA ABSENSI</strong></h3>
    @endif
    <table id="data" width="100%">
        <thead>
            <tr>
                <th width="5px">NO.</th>
                <th>NIK</th>
                <th>NAMA</th>
                <th>DEPARTEMEN</th>
                <th>SECTION</th>
                <th>JABATAN</th>
                <th>JENIS ABSEN</th>
                <th>TANGGAL AWAL</th>
                <th>TANGGAL AKHIR</th>
                <th>TOTAL JAM</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absensi as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nip }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->nm_dept }}</td>
                    <td>{{ $item->nm_section }}</td>
                    <td>{{ $item->nm_jabatan }}</td>
                    <td>{{ $item->jns_absen }}</td>
                    <td>{{ Carbon\Carbon::parse($item->tgl_absen)->format('d-m-Y') }}</td>
                    <td>
                        @if (!empty($item->tgl_absen_akhir))
                            {{ Carbon\Carbon::parse($item->tgl_absen_akhir)->format('d-m-Y') }}
                        @else
                            &nbsp;
                        @endif
                    </td>
                    <td>
                        @if (!empty($item->total_jam))
                            {{ Carbon\Carbon::parse($item->total_jam)->format('h:i') }}
                        @else
                            &nbsp;
                        @endif
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($absensi->isEmpty())
        <h4 style="margin-top: 20px; text-align:center">DATA ABSENSI KOSONG</h4>
    @endif
    </div>
    {{-- Print --}}
    <script>
        window.print();
    </script>
</body>

</html>
