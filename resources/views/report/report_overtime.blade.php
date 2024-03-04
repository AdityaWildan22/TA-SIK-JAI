<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Data Overtime</title>
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
    <h3><strong>Laporan Data Overtime</strong></h3>
    <table id="data" width="100%">
        <thead>
            <tr>
                <th width="5px">NO.</th>
                <th>NIP</th>
                <th>NAMA</th>
                <th>DEPARTEMEN</th>
                <th>JABATAN</th>
                <th>TOTAL OVERTIME</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($overtime as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->nip }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->nm_dept }}</td>
                    <td>{{ $item->nm_jabatan }}</td>
                    <td>{{ $item->total_overtime }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($overtime->isEmpty())
        <h4 style="margin-top: 20px; text-align:center">Data Overtime Kosong</h4>
    @endif
    </div>
    {{-- Print --}}
    <script>
        window.print();
    </script>
</body>

</html>
