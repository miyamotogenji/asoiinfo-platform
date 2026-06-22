<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContractedService;
use App\Models\Plan;
use App\Models\Branch;
use App\Models\BusinessGroup;
use App\Models\LegalEntity;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ContractedServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = ContractedService::with(['businessGroup', 'legalEntity', 'branch', 'plan'])
            ->when($request->search,   fn($q, $s)  => $q->whereHas('branch', fn($b) => $b->where('name', 'like', "%{$s}%")))
            ->when($request->group_id, fn($q, $id) => $q->where('business_group_id', $id))
            ->when($request->status,   fn($q, $s)  => $q->where('status', $s))
            ->latest()->paginate(25);

        $groups = BusinessGroup::where('status', 'active')->orderBy('name')->get();
        return view('admin.services.index', compact('services', 'groups'));
    }

    public function create()
    {
        $groups   = BusinessGroup::where('status', 'active')->orderBy('name')->get();
        $entities = LegalEntity::where('status', 'active')->orderBy('legal_name')->get();
        $branches = Branch::where('status', 'active')->orderBy('name')->get();
        $plans    = Plan::where('status', 'active')->orderBy('name')->get();
        return view('admin.services.create', compact('groups', 'entities', 'branches', 'plans'));
    }

    public function store(Request $request)
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

        $plan    = Plan::findOrFail($data['plan_id']);
        $day     = $data['billing_day'] ?? $plan->billing_day_suggestion ?? 1;
        $start   = Carbon::parse($data['start_date']);
        $next    = $start->copy()->day($day);
        if ($next->lte($start)) $next->addMonth();

        ContractedService::create([
            ...$data,
            'period'            => $plan->period,
            'value'             => $plan->price_without_iva,
            'iva_amount'        => round($plan->price_without_iva * $plan->iva_rate / 100, 2),
            'total_value'       => $plan->total_price,
            'billing_day'       => $day,
            'next_invoice_date' => $next,
            'grace_days'        => $plan->grace_days,
            'auto_block'        => $plan->auto_block,
            'status'            => 'active',
            'created_by'        => auth()->id(),
        ]);

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio contratado creado.');
    }

    public function update(Request $request, ContractedService $servicio)
    {
        $data = $request->validate([
            'status'       => 'required|in:active,suspended,blocked,cancelled,installing,trial,payment_agreement',
            'billing_day'  => 'integer|min:1|max:28',
            'observations' => 'nullable|string',
        ]);

        $servicio->update($data);
        return redirect()->route('admin.servicios.index')->with('success', 'Servicio actualizado.');
    }

    public function destroy(ContractedService $servicio)
    {
        $servicio->update(['status' => 'cancelled']);
        return redirect()->route('admin.servicios.index')->with('success', 'Servicio cancelado.');
    }
}

