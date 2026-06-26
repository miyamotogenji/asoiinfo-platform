<?php
namespace App\Exports;

use App\Models\Invoice;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\{Fill, Alignment, Border};

class InvoicesExport
{
    public function __construct(private $filters = []) {}

    public function download(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $invoices = Invoice::with(['businessGroup','legalEntity','branch'])
            ->when($this->filters['status'] ?? null, fn($q,$s) => $q->where('status',$s))
            ->when($this->filters['from']   ?? null, fn($q,$d) => $q->whereDate('issue_date','>=',$d))
            ->when($this->filters['to']     ?? null, fn($q,$d) => $q->whereDate('issue_date','<=',$d))
            ->latest()->get();

        $ss  = new Spreadsheet();
        $ws  = $ss->getActiveSheet();
        $ws->setTitle('Facturas');

        // Header row
        $headers = ['N° Factura','Período','Grupo Empresarial','Empresa','Sucursal','F. Emisión','F. Vencimiento','Subtotal','IVA 12%','Total','Estado'];
        foreach ($headers as $col => $h) {
            $cell = chr(65 + $col).'1';
            $ws->setCellValue($cell, $h);
            $ws->getStyle($cell)->applyFromArray([
                'font' => ['bold'=>true,'color'=>['rgb'=>'FFFFFF']],
                'fill' => ['fillType'=>Fill::FILL_SOLID,'startColor'=>['rgb'=>'1D4ED8']],
                'alignment' => ['horizontal'=>Alignment::HORIZONTAL_CENTER],
            ]);
        }

        // Data rows
        foreach ($invoices as $i => $inv) {
            $row = $i + 2;
            $ws->setCellValue("A{$row}", $inv->number);
            $ws->setCellValue("B{$row}", $inv->period_label);
            $ws->setCellValue("C{$row}", $inv->businessGroup?->name ?? '—');
            $ws->setCellValue("D{$row}", $inv->legalEntity?->name ?? '—');
            $ws->setCellValue("E{$row}", $inv->branch?->name ?? '—');
            $ws->setCellValue("F{$row}", $inv->issue_date?->format('d/m/Y'));
            $ws->setCellValue("G{$row}", $inv->due_date?->format('d/m/Y'));
            $ws->setCellValue("H{$row}", number_format($inv->subtotal, 2));
            $ws->setCellValue("I{$row}", number_format($inv->iva_amount, 2));
            $ws->setCellValue("J{$row}", number_format($inv->total, 2));
            $ws->setCellValue("K{$row}", ucfirst($inv->status));
            if ($row % 2 === 0) {
                $ws->getStyle("A{$row}:K{$row}")->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F8FAFC');
            }
        }

        foreach (range('A','K') as $col) { $ws->getColumnDimension($col)->setAutoSize(true); }

        $writer = new Xlsx($ss);
        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, 'facturas-'.now()->format('Ymd').'.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
