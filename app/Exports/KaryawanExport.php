<?php

namespace App\Exports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\AfterSheet;

class KaryawanExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(DB::table('karyawans')
        ->join('departemens', 'karyawans.id_departemen', '=', 'departemens.id_departemen')
        ->join('jabatans', 'karyawans.id_jabatan', '=', 'jabatans.id_jabatan')
        ->join('sections','karyawans.id_section','=','sections.id_section')
        ->select('karyawans.nip','karyawans.nama', 'departemens.nm_dept','sections.nm_section', 'jabatans.nm_jabatan','karyawans.tempat_lahir','karyawans.tanggal_lahir','karyawans.jenis_kelamin')
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
            'TEMPAT LAHIR',
            'TANGGAL LAHIR',
            'JENIS KELAMIN',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->applyFromArray([
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
                        $data[$key][6] = date('d/m/Y', strtotime($row[6]));
                    }
                }

                $sheet->fromArray($data);
            },

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