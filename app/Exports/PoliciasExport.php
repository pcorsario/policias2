<?php

namespace App\Exports;

use App\Models\Policia;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PoliciasExport implements FromCollection, WithMapping, WithHeadings, WithColumnFormatting, WithStyles, ShouldAutoSize
{
    private $policias = [];
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $this->policias = Policia::with('rango')->get();
        return $this->policias;
    }

    public function headings(): array
    {
        return [
            'Grado',
            'Cédula',
            'Primer apellido',
            'Segundo apellido',
            'Nombres',
            'Numero celular',
            'Numero convencional',
            'Correo',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT
        ];
    }

    public function map($row): array
    {
        return [
            $row->rango->descripcion,
            $row->cedula,
            $row->apellido_paterno,
            $row->apellido_materno,
            $row->nombres,
            $row->celular,
            $row->convencional,
            $row->correo,
        ];
    }




    public function styles(Worksheet $sheet)
    {
        $cantidadRegistros = $this->policias->count() + 1;
        $rangoCeldas = "A1:H$cantidadRegistros";

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        $sheet->getStyle($rangoCeldas)->applyFromArray($styleArray);

        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
