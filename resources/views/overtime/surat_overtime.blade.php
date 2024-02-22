<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIK | SPL</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }

        .header h2 {
            text-align: center;
            padding: 5px;
            margin: 0;
        }

        .content {
            /* margin-bottom: 20px; */
            font-size: 20px;
        }

        .footer {
            text-align: center;
            font-size: 20px;
            margin: 0;
            padding: 0;
        }

        .dtlembur {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #000;
        }

        .dtlembur th,
        .dtlembur td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        .dtlembur th {
            background-color: #f2f2f2;
            text-align: center;
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
            max-width: 650px;
            padding: 0;
            margin: 0;
            font-size: 25px;
        }

        .logo p {
            max-width: 650px;
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
            <h2>Surat Perintah Kerja Lembur</h2>
        </div>
        <div class="content">
            <div class="details">
                <table>
                    <tr>
                        <td>Tanggal</td>
                        <td>:</td>
                        <td>{{ Carbon\Carbon::parse($overtime->tgl_ovt)->format('d-m-Y') }} </td>
                    </tr>
                    <tr>
                        <td>Sektor</td>
                        <td>:</td>
                        <td>{{ $overtime->sect }}</td>
                    </tr>
                    <tr>
                        <td>Keterangan Lembur</td>
                        <td>:</td>
                        <td>{{ $overtime->ket }}</td>
                    </tr>
                </table>
            </div>
            <p>Dengan surat ini menugaskan karyawan dibawah ini untuk melakukan pekerjaan lembur :</p>
            <div class="details">
                <table class="dtlembur" style="width: 100%; border:1px solid #000">
                    <thead>
                        <tr>
                            <th>NIP</th>
                            <th>Nama</th>
                            <th>Sektor</th>
                            <th>Jam Mulai</th>
                            <th>Jam Selesai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $overtime->nip }}</td>
                            <td>{{ $overtime->nama }}</td>
                            <td>{{ $overtime->sect }}</td>
                            <td>{{ Carbon\Carbon::parse($overtime->jam_awal)->format('H:i') }}</td>
                            <td>{{ Carbon\Carbon::parse($overtime->jam_akhir)->format('H:i') }}</td>
                        </tr>
                    </tbody>
                </table>
                <p style="margin: 0; padding:5px">Demikian Surat Perintah Kerja Lembur ini dibuat. Untuk dipergunakan
                    sebagaimana mestinya.</p>
            </div>
        </div>
        <div class="footer mt-0">
            <h5>Disetujui Oleh</h5>
            <table style="width: 100%; text-align: center;">
                <tr>
                    <td style="width: 33%; text-align: center; padding-left: 20px;">
                        <p>{{ $staff_hr->nama }}</p>
                        @if ($overtime->status_pengajuan == 'Diterima')
                            <img src="{{ $staff_hr->foto_ttd }}" alt="" style="width:70%">
                        @endif
                        <p><strong>{{ $staff_hr->divisi }}</strong></p>
                    </td>
                    <td style="width: 33%;">
                        <p></p>
                    </td>
                    <td style="width: 33%; text-align: center; padding-right: 20px;">
                        <p>{{ $atasan->nama }}</p>
                        @if ($overtime->status_pengajuan == 'Diterima')
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
