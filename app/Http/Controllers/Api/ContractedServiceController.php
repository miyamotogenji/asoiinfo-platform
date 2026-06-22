<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContractedService;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class ContractedServiceController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $services = ContractedService::with(['businessGroup', 'legalEntity', 'branch', 'plan'])
            ->when($request->group_id,  fn($q, $id) => $q->where('business_group_id', $id))
            ->when($request->branch_id, fn($q, $id) => $q->where('branch_id', $id))
            ->when($request->status,    fn($q, $s)  => $q->where('status', $s))
            ->paginate(25);

        return response()->json($services);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'business_group_id' => 'required|exists:business_groups,id',
            'legal_entity_id'   => 'required|exists:legal_entities,id',
            'branch_id'         => 'required|exists:branches,id',
            'plan_id'           => 'required|exists:plans,id',
            'start_date'        => 'required|date',
            'billing_day'       => 'integer|min:1|max:28',
            'observations'      => 'nullable|string',
        ]);

        $plan = Plan::findOrFail($data['plan_id']);

        $billingDay = $data['billing_day'] ?? $plan->billing_day_suggestion ?? 1;
        $start      = Carbon::parse($data['start_date']);
        $nextDate   = $start->copy()->day($billingDay);
        if ($nextDate->lte($start)) {
            $nextDate->addMonth();
        }

        $service = ContractedService::create([
            ...$data,
            'period'            => $plan->period,
            'value'             => $plan->price_without_iva,
            'iva_amount'        => round($plan->price_without_iva * $plan->iva_rate / 100, 2),
            'total_value'       => $plan->total_price,
            'billing_day'       => $billingDay,
            'next_invoice_date' => $nextDate,
            'grace_days'        => $plan->grace_days,
            'auto_block'        => $plan->auto_block,
            'status'            => 'active',
            'created_by'        => auth()->id(),
        ]);

        return response()->json($service->load(['plan', 'branch', 'businessGroup']), 201);
    }

    public function show(ContractedService $contractedService): JsonResponse
    {
        $contractedService->load(['businessGroup', 'legalEntity', 'branch', 'plan', 'invoices']);
        return response()->json($contractedService);
    }

    public function update(Request $request, ContractedService $contractedService): JsonResponse
    {
        $data = $request->validate([
            'status'       => 'sometimes|in:active,suspended,blocked,cancelled,installing,trial,payment_agreement',
            'billing_day'  => 'sometimes|integer|min:1|max:28',
            'value'        => 'sometimes|numeric|min:0',
            'grace_days'   => 'sometimes|integer|min:0',
            'auto_block'   => 'boolean',
            'observations' => 'nullable|string',
        ]);

        $contractedService->update($data);
        return response()->json($contractedService);
    }

    public function destroy(ContractedService $contractedService): JsonResponse
    {
        $contractedService->update(['status' => 'cancelled']);
        return response()->json(['message' => 'Servicio cancelado']);
    }
}
