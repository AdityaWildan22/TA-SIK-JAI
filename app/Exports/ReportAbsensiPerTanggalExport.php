<?php

namespace App\Exports;

use App\Models\Overtime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeWriting;
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
        ->join('sections', 'karyawans.id_section', '=', 'sections.id_section')
        ->select(
            'absensis.nip',
            'karyawans.nama',
            'departemens.nm_dept',
            'sections.nm_section',
            'jabatans.nm_jabatan',
            'absensis.jns_absen',
            'absensis.tgl_absen',
            'absensis.tgl_absen_akhir',
            'absensis.jam_awal',
            'absensis.jam_akhir',
            DB::raw('TIMEDIFF(absensis.jam_akhir, absensis.jam_awal) AS total_jam'),
        )
        ->where('status_pengajuan', 'Diterima')
        ->whereBetween('absensis.tgl_absen', [$tgl_awal, $tgl_akhir])
        ->get();
    }

    public function headings(): array
    {
        return [
            ['NIP', 'NAMA', 'DEPARTEMEN', 'SECTION', 'JABATAN', 'JENIS ABSEN', 'TANGGAL ABSEN AWAL', 'TANGGAL ABSEN AKHIR', 'JAM AWAL', 'JAM AKHIR', 'TOTAL JAM']
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:L1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
    }
    
    public function registerEvents(): array
    {
        return [
            BeforeWriting::class => function (BeforeWriting $event) {
                $writer = $event->getWriter();
                $sheet = $writer->getActiveSheet();

                $data = $sheet->toArray();

                foreach ($data as $key => $row) {
                    if ($key > 0) {
                        $data[$key][6] = !empty($row[6]) ? date('d/m/Y', strtotime($row[6])) : '';
                        $data[$key][7] = !empty($row[7]) ? date('d/m/Y', strtotime($row[7])) : '';
                        $data[$key][8] = !empty($row[8]) ? date('H:i', strtotime($row[8])) : '';
                        $data[$key][9] = !empty($row[9]) ? date('H:i', strtotime($row[9])) : '';
                        $data[$key][10] = !empty($row[10]) ? date('H:i', strtotime($row[10])) : '';
                    }
                }

                $sheet->fromArray($data);
            },
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                $range = 'A1:' . \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($this->headings()) - 1) . '1';

                $sheet->getStyle($range)->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            },
        ];
    }
}