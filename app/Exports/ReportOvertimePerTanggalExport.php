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
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Events\BeforeWriting;

class ReportOvertimePerTanggalExport implements FromCollection, WithHeadings, WithStyles, WithEvents, ShouldAutoSize
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

        return collect(DB::table('overtimes')
        ->join('departemens', 'overtimes.id_departemen', '=', 'departemens.id_departemen')
        ->join('karyawans', 'overtimes.nip','=','karyawans.nip')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->join('sections', 'karyawans.id_section', '=', 'sections.id_section')
        ->select('overtimes.nip','karyawans.nama', 'departemens.nm_dept','sections.nm_section','jabatans.nm_jabatan','overtimes.tgl_ovt','overtimes.jam_awal','overtimes.jam_akhir')
        ->selectRaw('TIMEDIFF(overtimes.jam_akhir, overtimes.jam_awal) AS total_jam')
        ->whereBetween('overtimes.tgl_ovt', [$tgl_awal, $tgl_akhir])
        ->where('status_pengajuan','Diverifikasi')
        // ->groupBy('overtimes.nip')
        ->get());
    }

    public function headings(): array
    {
        return [
            'NIP',
            'NAMA KARYAWAN',
            'DEPARTEMEN',
            'SECTION',
            'JABATAN',
            'TANGGAL OVERTIME',
            'JAM AWAL',
            'JAM AKHIR',
            'TOTAL JAM',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:I1')->applyFromArray([
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
                        $data[$key][5] = date('d/m/Y', strtotime($row[5]));
                        $data[$key][6] = date('H:i', strtotime($row[6]));
                        $data[$key][7] = date('H:i', strtotime($row[7]));
                        $data[$key][8] = date('H:i', strtotime($row[8]));
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