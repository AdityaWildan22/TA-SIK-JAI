<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIK | SCMP</title>
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
        }

        .dtabsen th {
            background-color: #f2f2f2;
            text-align: center;
        }

        table th,
        td {
            font-size: 18px;
        }
    </style>
</head>

<body>
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
            <h2>Surat Catatan Meninggalkan Pekerjaan</h2>
        </div>
        <div class="details">
            <table>
                <tr>
                    <td>Tanggal</td>
                    <td>:</td>
                    <td>{{ Carbon\Carbon::parse($absensi->tgl_absen)->format('d-m-Y') }} </td>
                </tr>
                <tr>
                    <td>Sektor</td>
                    <td>:</td>
                    <td>{{ $absensi->sect }}</td>
                </tr>
                <tr>
                    <td>Keterangan Izin</td>
                    <td>:</td>
                    <td>{{ $absensi->ket }}</td>
                </tr>
            </table>
        </div>
        <p>Dengan surat ini mengajukan permohonan untuk meninggalkan pekerjaan:</p>
        <div class="details">
            <table class="dtabsen" style="width: 100%; border:1px solid #000">
                <thead>
                    <tr>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Sektor</th>
                        <th>Jenis Absen</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $absensi->nip }}</td>
                        <td>{{ $absensi->nama }}</td>
                        <td>{{ $absensi->sect }}</td>
                        <td>{{ $absensi->jns_absen }}</td>
                        <td>{{ $absensi->ket }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <p>Demikian surat ini saya ajukan. Atas perhatian dan persetujuan dari pihak
            yang berwenang,
            saya mengucapkan terima kasih.</p>
    </div>
    <div class="footer">
        <h4 style="text-align: center; margin:0; padding:0">Disetujui</h4>
        <table style="width: 100%; text-align: center;">
            <tr>
                <td style="width: 33%; text-align: center; padding-right: 20px;">
                    <p>{{ $staff_hr->nama }}</p>
                    @if ($absensi->status_pengajuan == 'Diterima')
                        <img src="{{ $staff_hr->foto_ttd }}" alt="" style="width:70%">
                    @endif
                    <p><strong>{{ $staff_hr->divisi }}</strong></p>
                </td>
                <td style="width: 33%;">
                    <p></p>
                </td>
                <td style="width: 33%; text-align: center; padding-left: 20px;">
                    <p>{{ $atasan->nama }}</p>
                    @if ($absensi->status_pengajuan == 'Diterima')
                        <img src="{{ $atasan->foto_ttd }}" alt="" style="width:70%">
                    @endif
                    <p><strong>{{ $atasan->divisi }}</strong></p>
                </td>
            </tr>
        </table>
    </div>
    </div>
</body>

</html>
