<?php
namespace App\Exports;

use App\Models\{AccountReceivable, Payment, ContractedService};
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class FinancialReportExport
{
    public function download(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $ss = new Spreadsheet();
        $now = Carbon::now();

        // ── Sheet 1: Summary ─────────────────────────────────────────
        $ws = $ss->getActiveSheet()->setTitle('Resumen');
        $ws->setCellValue('A1', 'REPORTE FINANCIERO — '.strtoupper($now->locale('es')->isoFormat('MMMM YYYY')));
        $ws->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $ws->setCellValue('A3', 'Indicador'); $ws->setCellValue('B3', 'Valor');
        $ws->getStyle('A3:B3')->getFont()->setBold(true);

        $rows = [
            ['Total por Cobrar',        AccountReceivable::whereIn('status',['pending','partial','overdue'])->sum('balance')],
            ['Cartera Vencida',         AccountReceivable::where('status','overdue')->sum('balance')],
            ['Cobrado Este Mes',        Payment::where('status','approved')->whereMonth('payment_date',$now->month)->sum('amount')],
            ['Cobrado Este Año',        Payment::where('status','approved')->whereYear('payment_date',$now->year)->sum('amount')],
            ['MRR (Servicios Mensual)', ContractedService::where('status','active')->where('period','monthly')->sum('total_value')],
            ['ARR (Servicios Anual)',   ContractedService::where('status','active')->where('period','annual')->sum('total_value')],
        ];
        foreach ($rows as $i => [$label,$val]) {
            $row = $i + 4;
            $ws->setCellValue("A{$row}", $label);
            $ws->setCellValue("B{$row}", '$ '.number_format($val, 2));
        }
        $ws->getColumnDimension('A')->setWidth(30);
        $ws->getColumnDimension('B')->setWidth(20);

        // ── Sheet 2: Overdue ─────────────────────────────────────────
        $ws2 = $ss->createSheet()->setTitle('Cartera Vencida');
        $headers = ['Grupo','Empresa','Sucursal','Factura','Monto','Saldo','Días Vencida','Estado'];
        foreach ($headers as $ci => $h) {
            $c = chr(65+$ci).'1';
            $ws2->setCellValue($c,$h);
            $ws2->getStyle($c)->getFont()->setBold(true);
            $ws2->getStyle($c)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('DC2626');
            $ws2->getStyle($c)->getFont()->getColor()->setRGB('FFFFFF');
        }
        $overdue = AccountReceivable::with(['businessGroup','legalEntity','branch','invoice'])->whereIn('status',['overdue','partial'])->orderByDesc('days_overdue')->get();
        foreach ($overdue as $i => $ar) {
            $row = $i+2;
            $ws2->setCellValue("A{$row}", $ar->businessGroup?->name);
            $ws2->setCellValue("B{$row}", $ar->legalEntity?->name);
            $ws2->setCellValue("C{$row}", $ar->branch?->name);
            $ws2->setCellValue("D{$row}", $ar->invoice?->number);
            $ws2->setCellValue("E{$row}", '$ '.number_format($ar->amount,2));
            $ws2->setCellValue("F{$row}", '$ '.number_format($ar->balance,2));
            $ws2->setCellValue("G{$row}", $ar->days_overdue.' días');
            $ws2->setCellValue("H{$row}", ucfirst($ar->status));
        }
        foreach(range('A','H') as $col) { $ws2->getColumnDimension($col)->setAutoSize(true); }

        $writer = new Xlsx($ss);
        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, 'reporte-financiero-'.now()->format('Ymd').'.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
