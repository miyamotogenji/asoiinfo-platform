<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index(Request $request)
    {
        $plans = Plan::withCount('contractedServices')
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->when($request->type,   fn($q, $t) => $q->where('type', $t))
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->orderBy('name')->paginate(20);

        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'                   => 'required|string|max:50|unique:plans',
            'name'                   => 'required|string|max:255',
            'type'                   => 'required|in:recurring,one_time',
            'period'                 => 'required|in:monthly,annual,quarterly,biannual',
            'price_without_iva'      => 'required|numeric|min:0',
            'iva_rate'               => 'required|numeric|min:0|max:100',
            'billable_product'       => 'nullable|string|max:255',
            'auto_block'             => 'boolean',
            'grace_days'             => 'integer|min:0',
            'billing_day_suggestion' => 'nullable|integer|min:1|max:28',
            'status'                 => 'in:active,inactive',
            'description'            => 'nullable|string',
        ]);

        Plan::create($data);
        return redirect()->route('admin.planes.index')->with('success', 'Plan creado.');
    }

    public function edit(Plan $plane)
    {
        return view('admin.plans.edit', ['plan' => $plane]);
    }

    public function update(Request $request, Plan $plane)
    {
        $data = $request->validate([
            'code'              => "required|string|max:50|unique:plans,code,{$plane->id}",
            'name'              => 'required|string|max:255',
            'price_without_iva' => 'required|numeric|min:0',
            'iva_rate'          => 'required|numeric|min:0|max:100',
            'auto_block'        => 'boolean',
            'grace_days'        => 'integer|min:0',
            'status'            => 'in:active,inactive',
            'description'       => 'nullable|string',
        ]);

        $plane->update($data);
        return redirect()->route('admin.planes.index')->with('success', 'Plan actualizado.');
    }

    public function destroy(Plan $plane)
    {
        if ($plane->contractedServices()->where('status', 'active')->exists()) {
            return back()->with('error', 'No se puede eliminar un plan con servicios activos.');
        }
        $plane->delete();
        return redirect()->route('admin.planes.index')->with('success', 'Plan eliminado.');
    }
}

