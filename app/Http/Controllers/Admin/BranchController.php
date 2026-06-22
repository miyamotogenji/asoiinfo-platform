<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\LegalEntity;
use App\Models\BusinessGroup;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BranchController extends Controller
{
    public function index(Request $request)
    {
        $branches = Branch::with(['legalEntity', 'businessGroup'])
            ->when($request->search, fn($q, $s) =>
                $q->where('name', 'like', "%{$s}%")->orWhere('code', 'like', "%{$s}%"))
            ->when($request->group_id, fn($q, $id) => $q->where('business_group_id', $id))
            ->when($request->status,   fn($q, $s)  => $q->where('status', $s))
            ->latest()->paginate(25);

        $groups = BusinessGroup::where('status', 'active')->orderBy('name')->get();
        return view('admin.branches.index', compact('branches', 'groups'));
    }

    public function create()
    {
        $groups   = BusinessGroup::where('status', 'active')->orderBy('name')->get();
        $entities = LegalEntity::where('status', 'active')->orderBy('legal_name')->get();
        return view('admin.branches.create', compact('groups', 'entities'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'legal_entity_id'    => 'required|exists:legal_entities,id',
            'business_group_id'  => 'required|exists:business_groups,id',
            'code'               => 'required|string|max:50|unique:branches',
            'name'               => 'required|string|max:255',
            'address'            => 'nullable|string',
            'city'               => 'nullable|string|max:100',
            'phone'              => 'nullable|string|max:20',
            'whatsapp'           => 'nullable|string|max:20',
            'responsible_name'   => 'nullable|string|max:255',
            'billing_day'        => 'integer|min:1|max:28',
            'service_start_date' => 'nullable|date',
            'observations'       => 'nullable|string',
        ]);

        $day  = $data['billing_day'] ?? 1;
        $next = Carbon::now()->startOfMonth()->day($day);
        if ($next->isPast()) $next->addMonth();
        $data['next_billing_date'] = $next;
        $data['created_by']        = auth()->id();

        Branch::create($data);
        return redirect()->route('admin.sucursales.index')->with('success', 'Sucursal creada.');
    }

    public function show(Branch $sucursale)
    {
        return redirect()->route('admin.sucursales.360', $sucursale);
    }

    public function edit(Branch $sucursale)
    {
        $groups   = BusinessGroup::where('status', 'active')->orderBy('name')->get();
        $entities = LegalEntity::where('status', 'active')->orderBy('legal_name')->get();
        return view('admin.branches.edit', ['branch' => $sucursale, 'groups' => $groups, 'entities' => $entities]);
    }

    public function update(Request $request, Branch $sucursale)
    {
        $data = $request->validate([
            'name'             => 'required|string|max:255',
            'address'          => 'nullable|string',
            'city'             => 'nullable|string|max:100',
            'phone'            => 'nullable|string|max:20',
            'whatsapp'         => 'nullable|string|max:20',
            'responsible_name' => 'nullable|string|max:255',
            'billing_day'      => 'integer|min:1|max:28',
            'status'           => 'in:active,suspended,blocked,closed',
            'observations'     => 'nullable|string',
        ]);

        $sucursale->update($data);
        return redirect()->route('admin.sucursales.index')->with('success', 'Sucursal actualizada.');
    }

    public function destroy(Branch $sucursale)
    {
        $sucursale->delete();
        return redirect()->route('admin.sucursales.index')->with('success', 'Sucursal eliminada.');
    }

    public function block(Branch $branch)
    {
        $branch->update(['status' => 'blocked']);
        return back()->with('success', "Sucursal {$branch->name} bloqueada.");
    }

    public function unblock(Branch $branch)
    {
        $branch->update(['status' => 'active']);
        return back()->with('success', "Sucursal {$branch->name} desbloqueada.");
    }

    public function view360(Branch $branch)
    {
        $branch->load([
            'legalEntity.businessGroup',
            'contacts',
            'contractedServices.plan',
            'accountsReceivable.invoice',
            'conversations' => fn($q) => $q->latest()->limit(5),
        ]);
        return view('admin.branches.360', ['branch' => $branch]);
    }
}

