<?php

namespace App\Exports;

use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportAbsensiAllExport implements FromCollection, WithHeadings, WithStyles, WithEvents, ShouldAutoSize
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if (Auth::user()->role == "SuperAdmin") {
            return DB::table('absensis')
                ->join('departemens', 'absensis.id_departemen', '=', 'departemens.id_departemen')
                ->join('karyawans', 'absensis.nip', '=', 'karyawans.nip')
                ->join('jabatans', 'karyawans.id_jabatan', '=', 'jabatans.id_jabatan')
                ->select(
                    'absensis.nip',
                    'karyawans.nama',
                    'departemens.nm_dept',
                    'jabatans.nm_jabatan',
                    DB::raw('COUNT(CASE WHEN jns_absen = "Sakit Dengan Surat Dokter" THEN 1 END) AS jumlah_SD'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Sakit Dengan Opname" THEN 1 END) AS jumlah_SO'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Sakit" THEN 1 END) AS jumlah_S'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Izin" THEN 1 END) AS jumlah_I'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Izin Khusus" THEN 1 END) AS jumlah_IK'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Tanpa Keterangan" THEN 1 END) AS jumlah_TK'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Cuti" THEN 1 END) AS jumlah_C'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Cuti Kelahiran/Keguguran" THEN 1 END) AS jumlah_CK'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Cuti Haid" THEN 1 END) AS jumlah_CH'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Izin Terlambat Datang" THEN 1 END) AS jumlah_ITD'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Izin Cepat Pulang" THEN 1 END) AS jumlah_ICP'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Izin Keluar Sementara" THEN 1 END) AS jumlah_IKS'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Dinas Luar" THEN 1 END) AS jumlah_DL'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Cuti Luar Tanggungan" THEN 1 END) AS jumlah_CLT'),
                    DB::raw('COUNT(*) AS total_absensi')
                )
                ->where('status_pengajuan', 'Diterima')
                ->groupBy('absensis.nip')
                ->get();
        } else {
            return DB::table('absensis')
                ->join('departemens', 'absensis.id_departemen', '=', 'departemens.id_departemen')
                ->join('karyawans', 'absensis.nip', '=', 'karyawans.nip')
                ->join('jabatans', 'karyawans.id_jabatan', '=', 'jabatans.id_jabatan')
                ->select(
                    'absensis.nip',
                    'karyawans.nama',
                    'departemens.nm_dept',
                    'jabatans.nm_jabatan',
                    DB::raw('COUNT(CASE WHEN jns_absen = "Sakit Dengan Surat Dokter" THEN 1 END) AS jumlah_SD'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Sakit Dengan Opname" THEN 1 END) AS jumlah_SO'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Sakit" THEN 1 END) AS jumlah_S'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Izin" THEN 1 END) AS jumlah_I'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Izin Khusus" THEN 1 END) AS jumlah_IK'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Tanpa Keterangan" THEN 1 END) AS jumlah_TK'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Cuti" THEN 1 END) AS jumlah_C'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Cuti Kelahiran/Keguguran" THEN 1 END) AS jumlah_CK'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Cuti Haid" THEN 1 END) AS jumlah_CH'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Izin Terlambat Datang" THEN 1 END) AS jumlah_ITD'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Izin Cepat Pulang" THEN 1 END) AS jumlah_ICP'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Izin Keluar Sementara" THEN 1 END) AS jumlah_IKS'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Dinas Luar" THEN 1 END) AS jumlah_DL'),
                    DB::raw('COUNT(CASE WHEN jns_absen = "Cuti Luar Tanggungan" THEN 1 END) AS jumlah_CLT'),
                    DB::raw('COUNT(*) AS total_absensi')
                )
                ->where('status_pengajuan', 'Diterima')
                ->where('departemens.id_departemen', Auth::user()->id_departemen)
                ->groupBy('absensis.nip')
                ->get();
        }
    }

    public function headings(): array
    {
        return [
            ['NIP', 'NAMA', 'DEPARTEMEN', 'JABATAN', 'JENIS MENINGGALKAN PEKERJAAN', '', '', '', '', '', '', '', '', '', '', '', '','', 'TOTAL ABSENSI'],
            ['', '', '', '', 'SD', 'SO', 'S', 'I', 'IK', 'TK', 'C', 'CK', 'CH', 'ITD', 'ICP', 'IKS', 'DL', 'CLT', ''],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:S2')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
    
        $sheet->getColumnDimension('A')->setWidth(15);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('S')->setWidth(20);
    
        $sheet->getStyle('E1:R1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);
    
        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:C2');
        $sheet->mergeCells('D1:D2');
        $sheet->mergeCells('E1:R1');
        $sheet->mergeCells('S1:S2');
    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;
    
                $sheet->getRowDimension(1)->setRowHeight(30);
                $sheet->getRowDimension(2)->setRowHeight(25);
            },
        ];
    }
}