<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Invoice, ContractedService, AccountReceivable, AuditLog};
use App\Exports\InvoicesExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    public function toEmit(Request $request)
    {
        $now = Carbon::now();
        $services = ContractedService::with(['businessGroup', 'legalEntity', 'branch', 'plan'])
            ->where('status', 'active')
            ->whereMonth('next_invoice_date', $now->month)
            ->whereYear('next_invoice_date', $now->year)
            ->when($request->group_id, fn($q, $id) => $q->where('business_group_id', $id))
            ->get();

        return view('admin.invoices.to-emit', compact('services', 'now'));
    }

    public function emit(Request $request)
    {
        $request->validate([
            'service_ids'   => 'required|array',
            'service_ids.*' => 'exists:contracted_services,id',
        ]);

        $count = 0;
        foreach ($request->service_ids as $id) {
            $service = ContractedService::find($id);
            if (!$service || $service->status !== 'active') continue;

            $invoice = Invoice::create([
                'number'                => (new Invoice)->generateNumber(),
                'business_group_id'     => $service->business_group_id,
                'legal_entity_id'       => $service->legal_entity_id,
                'branch_id'             => $service->branch_id,
                'contracted_service_id' => $service->id,
                'period_label'          => Carbon::now()->locale('es')->isoFormat('MMMM YYYY'),
                'issue_date'            => now(),
                'due_date'              => now()->addDays(15),
                'subtotal'              => $service->value,
                'iva_amount'            => $service->iva_amount,
                'total'                 => $service->total_value,
                'status'                => 'emitted',
                'emitted_by'            => auth()->id(),
            ]);

            AccountReceivable::create([
                'invoice_id'        => $invoice->id,
                'business_group_id' => $invoice->business_group_id,
                'legal_entity_id'   => $invoice->legal_entity_id,
                'branch_id'         => $invoice->branch_id,
                'amount'            => $invoice->total,
                'balance'           => $invoice->total,
                'due_date'          => $invoice->due_date,
                'status'            => 'pending',
            ]);

            $service->advanceNextInvoiceDate();
            $count++;
        }

        return redirect()->route('admin.invoices.index')
            ->with('success', "{$count} factura(s) emitida(s) correctamente.");
    }

    public function emitBatch(Request $request)
    {
        return $this->emit($request);
    }

    public function index(Request $request)
    {
        $invoices = Invoice::with(['businessGroup', 'legalEntity', 'branch'])
            ->when($request->status,   fn($q, $s)  => $q->where('status', $s))
            ->when($request->group_id, fn($q, $id) => $q->where('business_group_id', $id))
            ->when($request->search,   fn($q, $s)  =>
                $q->where('number', 'ilike', "%{$s}%")
                  ->orWhereHas('branch', fn($b) => $b->where('name', 'ilike', "%{$s}%")))
            ->latest()->paginate(25);

        if (request('export') === 'excel') {
            return (new InvoicesExport(request()->only('status','from','to')))->download();
        }

        return view('admin.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['businessGroup','legalEntity','branch','contractedService.plan']);
        if (request('export') === 'pdf') {
            $pdf = Pdf::loadView('admin.invoices.pdf', compact('invoice'))->setPaper('a4');
            return $pdf->download('factura-'.$invoice->number.'.pdf');
        }
        return view('admin.invoices.show', compact('invoice'));
    }
}

