<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class BranchController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $branches = Branch::with(['legalEntity', 'businessGroup'])
            ->when($request->group_id,  fn($q, $id) => $q->where('business_group_id', $id))
            ->when($request->entity_id, fn($q, $id) => $q->where('legal_entity_id', $id))
            ->when($request->status,    fn($q, $s)  => $q->where('status', $s))
            ->when($request->search,    fn($q, $s)  =>
                $q->where('name', 'ilike', "%{$s}%")
                  ->orWhere('code', 'ilike', "%{$s}%")
                  ->orWhere('city', 'ilike', "%{$s}%"))
            ->paginate(25);

        return response()->json($branches);
    }

    public function store(Request $request): JsonResponse
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

        $data['next_billing_date'] = Carbon::now()->startOfMonth()->day($data['billing_day'] ?? 1);
        if ($data['next_billing_date']->isPast()) {
            $data['next_billing_date']->addMonth();
        }

        $branch = Branch::create([...$data, 'created_by' => auth()->id()]);
        return response()->json($branch->load(['legalEntity', 'businessGroup']), 201);
    }

    public function show(Branch $branch): JsonResponse
    {
        $branch->load([
            'legalEntity', 'businessGroup', 'contacts',
            'contractedServices.plan', 'accountsReceivable',
        ]);
        $branch->append(['financial_status', 'total_balance']);
        return response()->json($branch);
    }

    public function update(Request $request, Branch $branch): JsonResponse
    {
        $data = $request->validate([
            'name'             => 'sometimes|string|max:255',
            'address'          => 'nullable|string',
            'city'             => 'nullable|string|max:100',
            'phone'            => 'nullable|string|max:20',
            'whatsapp'         => 'nullable|string|max:20',
            'responsible_name' => 'nullable|string',
            'billing_day'      => 'sometimes|integer|min:1|max:28',
            'status'           => 'sometimes|in:active,suspended,blocked,closed',
            'observations'     => 'nullable|string',
        ]);

        $branch->update($data);
        return response()->json($branch);
    }

    public function destroy(Branch $branch): JsonResponse
    {
        $branch->delete();
        return response()->json(['message' => 'Sucursal eliminada']);
    }

    public function block(Branch $branch): JsonResponse
    {
        $branch->update(['status' => 'blocked']);
        return response()->json(['message' => 'Sucursal bloqueada', 'branch' => $branch]);
    }

    public function unblock(Branch $branch): JsonResponse
    {
        $branch->update(['status' => 'active']);
        return response()->json(['message' => 'Sucursal desbloqueada', 'branch' => $branch]);
    }

    public function view360(Branch $branch): JsonResponse
    {
        $branch->load([
            'legalEntity.businessGroup',
            'contacts',
            'contractedServices.plan',
            'accountsReceivable' => fn($q) => $q->whereIn('status', ['pending','partial','overdue']),
        ]);

        return response()->json([
            'branch'           => $branch,
            'financial_status' => $branch->financial_status,
            'total_balance'    => $branch->total_balance,
            'active_services'  => $branch->contractedServices->where('status', 'active')->values(),
            'pending_invoices' => $branch->accountsReceivable->values(),
        ]);
    }
}
