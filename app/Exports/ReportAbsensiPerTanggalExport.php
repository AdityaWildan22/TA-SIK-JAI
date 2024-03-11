<?php

namespace App\Exports;

use App\Models\Overtime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportAbsensiPerTanggalExport implements FromCollection, WithHeadings, WithStyles, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $tgl_awal;
    protected $tgl_akhir;

    public function __construct($tgl_awal, $tgl_akhir)
    {
        // dd($tgl_awal, $tgl_akhir);
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function collection()
    {

        $tgl_awal = $this->tgl_awal;
        $tgl_akhir = $this->tgl_akhir;

        return DB::table('absensis')
        ->join('departemens', 'absensis.id_departemen', '=', 'departemens.id_departemen')
        ->join('karyawans', 'absensis.nip', '=', 'karyawans.nip')
        ->join('jabatans', 'karyawans.id_jabatan', '=', 'jabatans.id_jabatan')
        ->select(
            'absensis.nip',
            'karyawans.nama',
            'departemens.nm_dept',
            'jabatans.nm_jabatan',
            DB::raw('COUNT(CASE WHEN jns_absen = "Sakit" THEN 1 END) AS jumlah_S'),
            DB::raw('COUNT(CASE WHEN jns_absen = "Izin" THEN 1 END) AS jumlah_I'),
            DB::raw('COUNT(CASE WHEN jns_absen = "Izin Khusus" THEN 1 END) AS jumlah_IK'),
            DB::raw('COUNT(CASE WHEN jns_absen = "Cuti" THEN 1 END) AS jumlah_C'),
            DB::raw('COUNT(CASE WHEN jns_absen = "Cuti Melahirkan" THEN 1 END) AS jumlah_CK'),
            DB::raw('COUNT(CASE WHEN jns_absen = "Cuti Haid" THEN 1 END) AS jumlah_CH'),
            DB::raw('COUNT(CASE WHEN jns_absen = "Izin Terlambat Datang" THEN 1 END) AS jumlah_ITD'),
            DB::raw('COUNT(CASE WHEN jns_absen = "Izin Cepat Pulang" THEN 1 END) AS jumlah_ICP'),
            DB::raw('COUNT(CASE WHEN jns_absen = "Izin Keluar Sementara" THEN 1 END) AS jumlah_IKS'),
            DB::raw('COUNT(CASE WHEN jns_absen = "Dinas Luar" THEN 1 END) AS jumlah_DL'),
            DB::raw('COUNT(*) AS total_absensi')
        )
        ->whereBetween('absensis.tgl_absen', [$tgl_awal, $tgl_akhir])

        // ->whereBetween(DB::raw("DATE_FORMAT(absensis.tgl_absen,'%Y-%m-%d')"), [$this->tgl_awal, $this->tgl_akhir])

        ->where('status_pengajuan', 'Diterima')
        ->groupBy('absensis.nip')
        ->get();
    }

    public function headings(): array
    {
        return [
            ['NIP', 'NAMA', 'DEPARTEMEN', 'JABATAN', 'JENIS MENINGGALKAN PEKERJAAN', '', '', '', '', '', '', '', '', '', 'TOTAL ABSENSI'],
            ['', '', '', '', 'S', 'I', 'IK', 'C', 'CK', 'CH', 'ITD', 'ICP', 'IKS', 'DL', ''],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:O2')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Mengatur lebar kolom
        $sheet->getColumnDimension('A')->setWidth(15); // NIP
        $sheet->getColumnDimension('B')->setWidth(20); // NAMA
        $sheet->getColumnDimension('C')->setWidth(20); // DEPARTEMEN
        $sheet->getColumnDimension('D')->setWidth(20); // JABATAN
        $sheet->getColumnDimension('O')->setWidth(20); // TOTAL ABSENSI

        // Mengatur style untuk subjudul
        $sheet->getStyle('E1:O1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // Mengatur mergeCells() untuk bagian yang perlu digabungkan
        $sheet->mergeCells('A1:A2');
        $sheet->mergeCells('B1:B2');
        $sheet->mergeCells('C1:C2');
        $sheet->mergeCells('D1:D2');
        $sheet->mergeCells('E1:N1'); // Kolom JENIS MENINGGALKAN PEKERJAAN
        $sheet->mergeCells('O1:O2'); // Kolom TOTAL ABSENSI
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Dapatkan objek sheet dari event
                $sheet = $event->sheet;

                // Mengatur tinggi baris agar lebih sesuai dengan desain HTML
                $sheet->getRowDimension(1)->setRowHeight(30);
                $sheet->getRowDimension(2)->setRowHeight(25);
            },
        ];
    }
}