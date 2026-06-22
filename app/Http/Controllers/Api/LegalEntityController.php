<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LegalEntity;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class LegalEntityController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $entities = LegalEntity::with('businessGroup')
            ->when($request->group_id, fn($q, $id) => $q->where('business_group_id', $id))
            ->when($request->search, fn($q, $s) =>
                $q->where('legal_name', 'ilike', "%{$s}%")
                  ->orWhere('ruc', 'ilike', "%{$s}%")
                  ->orWhere('trade_name', 'ilike', "%{$s}%"))
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->paginate(20);

        return response()->json($entities);
    }

    public function store(Request $request): JsonResponse
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

        $entity = LegalEntity::create([...$data, 'created_by' => auth()->id()]);
        return response()->json($entity->load('businessGroup'), 201);
    }

    public function show(LegalEntity $legalEntity): JsonResponse
    {
        $legalEntity->load(['businessGroup', 'branches.contractedServices.plan', 'contacts']);
        return response()->json($legalEntity);
    }

    public function update(Request $request, LegalEntity $legalEntity): JsonResponse
    {
        $data = $request->validate([
            'ruc'                 => "sometimes|string|size:13|unique:legal_entities,ruc,{$legalEntity->id}",
            'legal_name'          => 'sometimes|string|max:255',
            'trade_name'          => 'nullable|string|max:255',
            'address'             => 'nullable|string',
            'phone'               => 'nullable|string|max:20',
            'email'               => 'nullable|email',
            'required_accounting' => 'boolean',
            'taxpayer_type'       => 'in:natural,juridical,public',
            'status'              => 'in:active,suspended,blocked,inactive',
            'observations'        => 'nullable|string',
        ]);

        $legalEntity->update($data);
        return response()->json($legalEntity);
    }

    public function destroy(LegalEntity $legalEntity): JsonResponse
    {
        $legalEntity->delete();
        return response()->json(['message' => 'Empresa eliminada']);
    }
}
