<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LegalEntity;
use App\Models\BusinessGroup;
use Illuminate\Http\Request;

class LegalEntityController extends Controller
{
    public function index(Request $request)
    {
        $entities = LegalEntity::with('businessGroup')
            ->when($request->search, fn($q, $s) =>
                $q->where('legal_name', 'like', "%{$s}%")->orWhere('ruc', 'like', "%{$s}%"))
            ->when($request->group_id, fn($q, $id) => $q->where('business_group_id', $id))
            ->latest()->paginate(20);

        $groups = BusinessGroup::where('status', 'active')->orderBy('name')->get();
        return view('admin.entities.index', compact('entities', 'groups'));
    }

    public function create()
    {
        $groups = BusinessGroup::where('status', 'active')->orderBy('name')->get();
        return view('admin.entities.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'business_group_id'   => 'required|exists:business_groups,id',
            'ruc'                 => 'required|string|size:13|unique:legal_entities',
            'legal_name'          => 'required|string|max:255',
            'trade_name'          => 'nullable|string|max:255',
            'address'             => 'nullable|string',
            'phone'               => 'nullable|string|max:20',
            'email'               => 'nullable|email',
            'required_accounting' => 'boolean',
            'taxpayer_type'       => 'in:natural,juridical,public',
            'status'              => 'in:active,suspended,blocked,inactive',
            'observations'        => 'nullable|string',
        ]);

        LegalEntity::create([...$data, 'created_by' => auth()->id()]);
        return redirect()->route('admin.empresas.index')->with('success', 'Empresa legal creada.');
    }

    public function edit(LegalEntity $empresa)
    {
        $groups = BusinessGroup::where('status', 'active')->orderBy('name')->get();
        return view('admin.entities.edit', ['entity' => $empresa, 'groups' => $groups]);
    }

    public function update(Request $request, LegalEntity $empresa)
    {
        $data = $request->validate([
            'ruc'                 => "required|string|size:13|unique:legal_entities,ruc,{$empresa->id}",
            'legal_name'          => 'required|string|max:255',
            'trade_name'          => 'nullable|string|max:255',
            'address'             => 'nullable|string',
            'phone'               => 'nullable|string|max:20',
            'email'               => 'nullable|email',
            'required_accounting' => 'boolean',
            'status'              => 'in:active,suspended,blocked,inactive',
            'observations'        => 'nullable|string',
        ]);

        $empresa->update($data);
        return redirect()->route('admin.empresas.index')->with('success', 'Empresa actualizada.');
    }

    public function destroy(LegalEntity $empresa)
    {
        $empresa->delete();
        return redirect()->route('admin.empresas.index')->with('success', 'Empresa eliminada.');
    }
}

