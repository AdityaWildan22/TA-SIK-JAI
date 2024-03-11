<?php

namespace App\Exports;

use App\Models\Overtime;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeWriting;
use Maatwebsite\Excel\Events\AfterSheet;


class OvertimeExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(DB::table('overtimes')
        ->join('departemens','overtimes.id_departemen','=','departemens.id_departemen')
        ->join('karyawans','overtimes.nip','=','karyawans.nip')
        ->join('jabatans','karyawans.id_jabatan','=','jabatans.id_jabatan')
        ->select('overtimes.nip','karyawans.nama','departemens.nm_dept','overtimes.tgl_ovt','overtimes.jam_awal','overtimes.jam_akhir','overtimes.ket','overtimes.status_pengajuan')
        ->get());
    }

    public function headings(): array
    {
        return [
            'NIP',
            'NAMA KARYAWAN',
            'DEPARTEMEN',
            'TANGGAL OVERTIME',
            'JAM AWAL',
            'JAM AKHIR',
            'KETERANGAN',
            'STATUS PENGAJUAN',
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
                        $data[$key][3] = date('d/m/Y', strtotime($row[3]));
                        $data[$key][4] = date('H:i', strtotime($row[4]));
                        $data[$key][5] = date('H:i', strtotime($row[5]));
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