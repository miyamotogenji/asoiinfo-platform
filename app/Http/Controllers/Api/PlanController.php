<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PlanController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $plans = Plan::when($request->type,   fn($q, $t) => $q->where('type', $t))
            ->when($request->period, fn($q, $p) => $q->where('period', $p))
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->when($request->search, fn($q, $s) =>
                $q->where('name', 'ilike', "%{$s}%")
                  ->orWhere('code', 'ilike', "%{$s}%"))
            ->get();

        return response()->json($plans);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'code'                   => 'required|string|max:50|unique:plans',
            'name'                   => 'required|string|max:255',
            'type'                   => 'required|in:recurring,one_time',
            'period'                 => 'required|in:monthly,annual,quarterly,biannual',
            'price_without_iva'      => 'required|numeric|min:0',
            'iva_rate'               => 'numeric|min:0|max:100',
            'billable_product'       => 'nullable|string',
            'auto_block'             => 'boolean',
            'grace_days'             => 'integer|min:0',
            'billing_day_suggestion' => 'nullable|integer|min:1|max:28',
            'status'                 => 'in:active,inactive',
            'description'            => 'nullable|string',
        ]);

        $plan = Plan::create($data);
        return response()->json($plan, 201);
    }

    public function show(Plan $plan): JsonResponse
    {
        $plan->loadCount('contractedServices');
        return response()->json($plan);
    }

    public function update(Request $request, Plan $plan): JsonResponse
    {
        $data = $request->validate([
            'code'              => "sometimes|string|max:50|unique:plans,code,{$plan->id}",
            'name'              => 'sometimes|string|max:255',
            'price_without_iva' => 'sometimes|numeric|min:0',
            'iva_rate'          => 'sometimes|numeric|min:0|max:100',
            'auto_block'        => 'boolean',
            'grace_days'        => 'integer|min:0',
            'status'            => 'in:active,inactive',
            'description'       => 'nullable|string',
        ]);

        $plan->update($data);
        return response()->json($plan);
    }

    public function destroy(Plan $plan): JsonResponse
    {
        if ($plan->contractedServices()->where('status', 'active')->exists()) {
            return response()->json(['error' => 'No se puede eliminar un plan con servicios activos'], 422);
        }
        $plan->delete();
        return response()->json(['message' => 'Plan eliminado']);
    }
}
