<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BusinessGroup;
use App\Models\Branch;
use App\Models\AccountReceivable;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Conversation;
use App\Models\ContractedService;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $now = Carbon::now();

        return response()->json([
            'groups'           => BusinessGroup::where('status', 'active')->count(),
            'branches'         => Branch::where('status', 'active')->count(),
            'overdue_clients'  => Branch::where('status', 'active')
                ->whereHas('accountsReceivable', fn($q) => $q->where('status', 'overdue'))
                ->count(),
            'blocked_clients'  => Branch::where('status', 'blocked')->count(),
            'total_receivable' => AccountReceivable::whereIn('status', ['pending','partial','overdue'])->sum('balance'),
            'collected_month'  => Payment::where('status', 'approved')
                ->whereMonth('payment_date', $now->month)
                ->whereYear('payment_date', $now->year)
                ->sum('amount'),
            'pending_messages' => Conversation::where('queue', 'new_messages')->count(),
            'invoices_to_emit' => ContractedService::where('status', 'active')
                ->whereMonth('next_invoice_date', $now->month)
                ->whereYear('next_invoice_date', $now->year)
                ->count(),
            'payments_pending' => Payment::where('status', 'pending_review')->count(),
            'mrr'              => ContractedService::where('status', 'active')
                ->where('period', 'monthly')
                ->sum('total_value'),
        ]);
    }
}
