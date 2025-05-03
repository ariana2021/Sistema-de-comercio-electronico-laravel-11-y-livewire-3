<?php

namespace App\Exports;

use App\Models\Business;
use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithProperties;

class SalesExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles, WithColumnFormatting, ShouldAutoSize, WithProperties
{
    public $search, $fromDate, $toDate;

    // Constructor para recibir los filtros
    public function __construct($search, $fromDate, $toDate)
    {
        $this->search = $search;
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;
    }

    // Filtra las ventas según los criterios de búsqueda
    public function collection()
    {
        $searchTerm = '%' . $this->search . '%';

        return Sale::with(['client'])
            ->where('status', 'Activo')
            ->when($this->fromDate, function ($query) {
                $query->whereDate('date', '>=', $this->fromDate);
            })
            ->when($this->toDate, function ($query) {
                $query->whereDate('date', '<=', $this->toDate);
            })
            ->where(function($query) use ($searchTerm) {
                $query->where('date', 'like', $searchTerm)
                      ->orWhereHas('client', function($q) use ($searchTerm) {
                          $q->where('name', 'like', $searchTerm);
                      });
            })
            ->get();
    }

    // Definir los encabezados de la tabla en el Excel
    public function headings(): array
    {
        $bussinne = Business::first();
        return [
            [$bussinne->business_name, $bussinne->address, 'Teléfono: ' . $bussinne->phone], // Datos de la empresa
            ['Reporte de Ventas', '', 'Fecha de generación: ' . now()->format('d/m/Y')],
            ['ID', 'Fecha', 'Total', 'Cliente', 'Forma de Pago'] // Encabezados
        ];
    }

    // Definir cómo mapear las filas de datos a las columnas del Excel
    public function map($sale): array
    {
        return [
            $sale->id,
            \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(\Carbon\Carbon::parse($sale->date)), // Formato de fecha
            $sale->total,
            optional($sale->client)->name ?? '',
            optional($sale->paymentMethod)->name ?? ''
        ];
    }

    // Título de la hoja en Excel
    public function title(): string
    {
        return 'Ventas';
    }

    // Estilos para las celdas
    public function styles($sheet)
    {
        // Fijamos las filas de encabezado
        $sheet->getStyle('A1:E3')->getFont()->setBold(true);
        $sheet->getStyle('A1:E3')->getFont()->setSize(12);
        $sheet->getStyle('A1:E3')->getAlignment()->setHorizontal('center');

        // Bordes para las celdas
        $sheet->getStyle('A5:E' . ($sheet->getHighestRow()))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Color de fondo para las celdas de encabezado
        $sheet->getStyle('A5:E5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A5:E5')->getFill()->getStartColor()->setRGB('CCCCCC');

        // Tamaño de las celdas para los encabezados
        $sheet->getColumnDimension('A')->setWidth(10);
        $sheet->getColumnDimension('B')->setWidth(15);
        $sheet->getColumnDimension('C')->setWidth(15);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
    }

    // Formateo de columnas
    public function columnFormats(): array
    {
        return [
            'B' => 'dd/mm/yyyy', // Formato de fecha
            'C' => '#,##0.00',    // Formato de número para el total
        ];
    }

    // Autoajuste de las columnas
    public function autoSize()
    {
        return true;
    }

    // Datos del archivo
    public function properties(): array
    {
        return [
            'creator' => 'Empresa XYZ',
            'title' => 'Reporte de Ventas',
            'description' => 'Reporte de ventas filtrado por fecha y cliente.',
            'subject' => 'Ventas',
        ];
    }
}