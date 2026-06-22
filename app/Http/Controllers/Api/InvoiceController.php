<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContractedService;
use App\Models\Invoice;
use App\Models\AccountReceivable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
     * Generate preview list of invoices to emit this month.
     */
    public function toEmitThisMonth(): JsonResponse
    {
        $services = ContractedService::with(['businessGroup', 'legalEntity', 'branch', 'plan'])
            ->where('status', 'active')
            ->whereMonth('next_invoice_date', now()->month)
            ->whereYear('next_invoice_date', now()->year)
            ->get();

        return response()->json($services->map(fn($s) => [
            'contracted_service_id' => $s->id,
            'client'                => $s->businessGroup->name,
            'ruc'                   => $s->legalEntity->ruc,
            'legal_name'            => $s->legalEntity->legal_name,
            'branch'                => $s->branch->name,
            'plan'                  => $s->plan->name,
            'period'                => $s->plan->period_label,
            'subtotal'              => $s->value,
            'iva'                   => $s->iva_amount,
            'total'                 => $s->total_value,
            'emission_date'         => now()->toDateString(),
            'due_date'              => now()->addDays(15)->toDateString(),
        ]));
    }

    /**
     * Emit a single invoice from a contracted service.
     */
    public function emit(Request $request): JsonResponse
    {
        $request->validate([
            'contracted_service_id' => 'required|exists:contracted_services,id',
        ]);

        $service = ContractedService::findOrFail($request->contracted_service_id);

        $invoice = Invoice::create([
            'number'                => (new Invoice)->generateNumber(),
            'business_group_id'     => $service->business_group_id,
            'legal_entity_id'       => $service->legal_entity_id,
            'branch_id'             => $service->branch_id,
            'contracted_service_id' => $service->id,
            'period_label'          => now()->format('F Y'),
            'issue_date'            => now(),
            'due_date'              => now()->addDays(15),
            'subtotal'              => $service->value,
            'iva_amount'            => $service->iva_amount,
            'total'                 => $service->total_value,
            'status'                => 'emitted',
            'emitted_by'            => auth()->id(),
        ]);

        AccountReceivable::create([
            'invoice_id'         => $invoice->id,
            'business_group_id'  => $invoice->business_group_id,
            'legal_entity_id'    => $invoice->legal_entity_id,
            'branch_id'          => $invoice->branch_id,
            'amount'             => $invoice->total,
            'balance'            => $invoice->total,
            'due_date'           => $invoice->due_date,
            'status'             => 'pending',
        ]);

        $service->advanceNextInvoiceDate();

        return response()->json($invoice->load(['businessGroup', 'legalEntity', 'branch']), 201);
    }

    /**
     * Emit multiple invoices at once.
     */
    public function emitBatch(Request $request): JsonResponse
    {
        $request->validate([
            'service_ids'   => 'required|array',
            'service_ids.*' => 'exists:contracted_services,id',
        ]);

        $emitted = [];
        foreach ($request->service_ids as $id) {
            $service = ContractedService::find($id);
            if (!$service || $service->status !== 'active') continue;

            $invoice = Invoice::create([
                'number'                => (new Invoice)->generateNumber(),
                'business_group_id'     => $service->business_group_id,
                'legal_entity_id'       => $service->legal_entity_id,
                'branch_id'             => $service->branch_id,
                'contracted_service_id' => $service->id,
                'period_label'          => now()->format('F Y'),
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
            $emitted[] = $invoice->number;
        }

        return response()->json(['emitted' => count($emitted), 'numbers' => $emitted]);
    }

    public function index(Request $request): JsonResponse
    {
        $invoices = Invoice::with(['businessGroup', 'legalEntity', 'branch'])
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->when($request->branch_id, fn($q, $id) => $q->where('branch_id', $id))
            ->when($request->group_id, fn($q, $id) => $q->where('business_group_id', $id))
            ->latest()
            ->paginate(25);

        return response()->json($invoices);
    }
}
