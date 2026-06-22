<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AccountReceivable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AccountReceivableController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $records = AccountReceivable::with(['invoice', 'businessGroup', 'legalEntity', 'branch'])
            ->when($request->status,    fn($q, $s)  => $q->where('status', $s))
            ->when($request->group_id,  fn($q, $id) => $q->where('business_group_id', $id))
            ->when($request->branch_id, fn($q, $id) => $q->where('branch_id', $id))
            ->when($request->overdue,   fn($q)      => $q->where('days_overdue', '>', 0))
            ->when($request->search,    fn($q, $s)  =>
                $q->whereHas('branch', fn($b) => $b->where('name', 'ilike', "%{$s}%"))
                  ->orWhereHas('invoice', fn($i) => $i->where('number', 'ilike', "%{$s}%")))
            ->orderByDesc('days_overdue')
            ->paginate(25);

        // Update days overdue for each record
        $records->each(fn($ar) => $ar->updateDaysOverdue());

        return response()->json($records);
    }

    public function show(AccountReceivable $accountReceivable): JsonResponse
    {
        $accountReceivable->load(['invoice', 'businessGroup', 'legalEntity', 'branch', 'payments']);
        $accountReceivable->updateDaysOverdue();
        return response()->json($accountReceivable);
    }

    public function update(Request $request, AccountReceivable $accountReceivable): JsonResponse
    {
        $data = $request->validate([
            'status'       => 'sometimes|in:pending,paid,partial,overdue,in_agreement,cancelled,under_review',
            'observations' => 'nullable|string',
        ]);

        $accountReceivable->update($data);
        return response()->json($accountReceivable);
    }

    public function summary(): JsonResponse
    {
        return response()->json([
            'total_receivable' => AccountReceivable::whereIn('status', ['pending','partial','overdue'])->sum('balance'),
            'total_overdue'    => AccountReceivable::where('status', 'overdue')->sum('balance'),
            'total_pending'    => AccountReceivable::where('status', 'pending')->sum('balance'),
            'count_overdue'    => AccountReceivable::where('status', 'overdue')->count(),
            'count_blocked'    => \App\Models\Branch::where('status', 'blocked')->count(),
        ]);
    }
}
