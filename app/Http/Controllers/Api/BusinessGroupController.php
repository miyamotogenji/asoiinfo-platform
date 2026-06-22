<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BusinessGroup;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BusinessGroupController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = BusinessGroup::withCount(['legalEntities', 'branches', 'contacts'])
            ->when($request->search, fn($q, $s) => $q->where('name', 'ilike', "%{$s}%")
                ->orWhere('code', 'ilike', "%{$s}%"))
            ->when($request->status, fn($q, $s) => $q->where('status', $s));

        return response()->json($query->paginate(20));
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'code'         => 'required|string|max:50|unique:business_groups',
            'status'       => 'in:active,suspended,blocked,inactive',
            'observations' => 'nullable|string',
        ]);

        $group = BusinessGroup::create([...$data, 'created_by' => auth()->id()]);
        return response()->json($group, 201);
    }

    public function show(BusinessGroup $businessGroup): JsonResponse
    {
        $businessGroup->load(['legalEntities.branches', 'contacts']);
        $businessGroup->append('financial_status');
        return response()->json($businessGroup);
    }

    public function update(Request $request, BusinessGroup $businessGroup): JsonResponse
    {
        $data = $request->validate([
            'name'         => 'sometimes|string|max:255',
            'code'         => "sometimes|string|max:50|unique:business_groups,code,{$businessGroup->id}",
            'status'       => 'sometimes|in:active,suspended,blocked,inactive',
            'observations' => 'nullable|string',
        ]);

        $businessGroup->update($data);
        return response()->json($businessGroup);
    }

    public function destroy(BusinessGroup $businessGroup): JsonResponse
    {
        $businessGroup->delete();
        return response()->json(['message' => 'Grupo eliminado']);
    }

    public function overview(BusinessGroup $businessGroup): JsonResponse
    {
        $businessGroup->load([
            'legalEntities',
            'branches.accountsReceivable',
            'branches.contractedServices.plan',
            'contacts',
        ]);

        return response()->json([
            'group'            => $businessGroup,
            'financial_status' => $businessGroup->financial_status,
            'total_balance'    => $businessGroup->branches->sum('total_balance'),
            'services_count'   => $businessGroup->branches->sum(fn($b) => $b->contractedServices->where('status', 'active')->count()),
        ]);
    }
}
