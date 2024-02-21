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
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            /* border: 1px solid #ccc; */
            /* border-radius: 10px; */
        }

        .header h2 {
            text-align: center;
            padding: 10px 0;
            margin: 0;
        }

        .content {
            margin-bottom: 20px;
            font-size: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
            font-size: 20px;
        }

        .details {
            margin-bottom: 20px;
            font-size: 20px;
        }

        .details p {
            margin: 5px 0;
        }

        .kop-surat img {
            margin-top: 3px;
            max-width: 180px;
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
            max-width: 570px;
            padding: 0;
            margin: 0;
        }

        .logo p {
            max-width: 570px;
            padding: 0;
            margin: 0;
            font-size: 15px;
        }

        .garis-bawah {
            border-bottom: 2px solid #000;
        }

        /* .tanda-tangan {
            display: flex;
            justify-content: center;
            gap: 100px;
        } */
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
            <h2>Surat Permohonan Izin Tidak Masuk Kerja</h2>
        </div>
        <div class="content">
            <p>Dengan hormat,
                <br>
                Yang mengajukan permohonan di bawah ini:
            </p>
            <div class="details">
                <table>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{ $absensi->nama }}</td>
                    </tr>
                    @if ($karyawan)
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td>{{ $karyawan->divisi }}</td>
                        </tr>
                    @else
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td></td>
                        </tr>
                    @endif
                </table>
            </div>
            <p>Dengan ini saya bermaksud untuk mengajukan permohonan izin tidak masuk kerja dengan rincian sebagai
                berikut:</p>
            <div class="details">
                <table>
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
                        <td>Sektor</td>
                        <td>:</td>
                        <td>{{ $absensi->sect }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Izin</td>
                        <td>:</td>
                        <td>{{ Carbon\Carbon::parse($absensi->tgl_absen)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Izin</td>
                        <td>:</td>
                        <td>{{ $absensi->jns_absen }}</td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <td>{{ $absensi->ket }}</td>
                    </tr>
                </table>
            </div>
            <p>Demikian permohonan izin tidak masuk kerja ini saya ajukan. Atas perhatian dan persetujuan dari pihak
                yang berwenang,
                saya mengucapkan terima kasih.</p>
        </div>
        <div class="footer">
            <h4 style="text-align: center">Yang Menyetujui</h4>
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