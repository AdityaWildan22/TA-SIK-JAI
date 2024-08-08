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

class ReportOvertimeAllExport implements FromCollection, WithHeadings, WithStyles, WithEvents, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection 
    */
    public function collection()
    {
        if (Auth::user()->role == "SuperAdmin") {
        return collect(DB::table('overtimes')
            ->join('departemens', 'overtimes.id_departemen', '=', 'departemens.id_departemen')
            ->join('karyawans', 'overtimes.nip','=','karyawans.nip')
            ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
            ->join('sections', 'karyawans.id_section', '=', 'sections.id_section')
            ->select('overtimes.nip','karyawans.nama', 'departemens.nm_dept','jabatans.nm_jabatan')
            ->selectRaw('COUNT(*) AS total_overtime')
            ->where('status_pengajuan','Diterima')
            ->groupBy('overtimes.nip')
            ->get());
        }else{
            return collect(DB::table('overtimes')
            ->join('departemens', 'overtimes.id_departemen', '=', 'departemens.id_departemen')
            ->join('karyawans', 'overtimes.nip','=','karyawans.nip')
            ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
            ->join('sections', 'karyawans.id_section', '=', 'sections.id_section')
            ->select('overtimes.nip','karyawans.nama', 'departemens.nm_dept','jabatans.nm_jabatan')
            ->selectRaw('COUNT(*) AS total_overtime')
            ->where('status_pengajuan','Diterima')
            ->where('sections.id_section',Auth::user()->id_section)
            ->groupBy('overtimes.nip')
            ->get());
        }
    }

    public function headings(): array
    {
        return [
            'NIP',
            'NAMA KARYAWAN',
            'DEPARTEMEN',
            'JABATAN',
            'TOTAL OVERTIME',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
    } 

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Dapatkan objek sheet dari event
                $sheet = $event->sheet;

                // Tentukan range untuk judul kolom
                $range = 'A1:' . \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($this->headings()) - 1) . '1';

                // Terapkan penyesuaian gaya agar judul kolom menjadi terpusat
                $sheet->getStyle($range)->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            },
        ];
    }
}