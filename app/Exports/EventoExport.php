<?php

namespace App\Exports;

use App\Models\SillasPolicia;
use App\Services\AsignacionSillas\AsignacionSillaPorMesaService;
use App\Services\AsignacionSillas\FindAsignacionCompletaService;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EventoExport implements FromCollection, WithHeadings, WithColumnFormatting, ShouldAutoSize, WithMapping, WithStyles
{

    private Collection $invitaciones;

    const ESTADO_CONFIRMACION = [
        's' => 'Si',
        'n' => 'No',
        'i' => 'Rechazada'
    ];

    const ESTADO_ASISTENCIA = [
        's' => 'Asistió',
        'n' => 'No asistió'
    ];

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $this->invitaciones = (new AsignacionSillaPorMesaService)->execute();
        return $this->invitaciones;
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT
        ];
    }

    public function headings(): array
    {
        return [
            'Cuadrante',
            'Mesa',
            'Silla',
            'Grado',
            'Cédula',
            'Delegado',
            'Confirmación asistencia',
            'Asitencia al evento'
        ];
    }

    public function map($row): array
    {
        return [
            $row->cuadrante,
            $row->mesa,
            $row->silla,
            $row->rango,
            $row->cedula,
            $row->policia,
            self::ESTADO_CONFIRMACION[$row->confirmacion],
            self::ESTADO_ASISTENCIA[$row->asistencia]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $cantidadRegistros = $this->invitaciones->count() + 1;
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
