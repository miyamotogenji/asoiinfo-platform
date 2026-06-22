<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessGroup;
use Illuminate\Http\Request;

class BusinessGroupController extends Controller
{
    public function index(Request $request)
    {
        $groups = BusinessGroup::withCount(['legalEntities', 'branches', 'contacts'])
            ->when($request->search, fn($q, $s) =>
                $q->where('name', 'ilike', "%{$s}%")->orWhere('code', 'ilike', "%{$s}%"))
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest()->paginate(20);

        return view('admin.groups.index', compact('groups'));
    }

    public function create()
    {
        return view('admin.groups.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code'         => 'required|string|max:50|unique:business_groups',
            'name'         => 'required|string|max:255',
            'status'       => 'in:active,suspended,blocked,inactive',
            'observations' => 'nullable|string',
        ]);

        BusinessGroup::create([...$data, 'created_by' => auth()->id()]);
        return redirect()->route('admin.grupos.index')->with('success', 'Grupo creado correctamente.');
    }

    public function show(BusinessGroup $grupo)
    {
        $grupo->load([
            'legalEntities',
            'branches.accountsReceivable',
            'branches.contractedServices.plan',
            'contacts',
        ]);
        return view('admin.groups.show', ['group' => $grupo]);
    }

    public function edit(BusinessGroup $grupo)
    {
        return view('admin.groups.edit', ['group' => $grupo]);
    }

    public function update(Request $request, BusinessGroup $grupo)
    {
        $data = $request->validate([
            'code'         => "required|string|max:50|unique:business_groups,code,{$grupo->id}",
            'name'         => 'required|string|max:255',
            'status'       => 'in:active,suspended,blocked,inactive',
            'observations' => 'nullable|string',
        ]);

        $grupo->update($data);
        return redirect()->route('admin.grupos.show', $grupo)->with('success', 'Grupo actualizado.');
    }

    public function destroy(BusinessGroup $grupo)
    {
        $grupo->delete();
        return redirect()->route('admin.grupos.index')->with('success', 'Grupo eliminado.');
    }
}

