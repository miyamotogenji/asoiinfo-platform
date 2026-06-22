<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessGroup;
use App\Models\Branch;
use App\Models\AccountReceivable;
use App\Models\Payment;
use App\Models\Conversation;
use App\Models\ContractedService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $stats = [
            'groups'           => BusinessGroup::where('status', 'active')->count(),
            'branches'         => Branch::where('status', 'active')->count(),
            'overdue_clients'  => Branch::where('status', 'active')
                ->whereHas('accountsReceivable', fn($q) => $q->where('status', 'overdue'))->count(),
            'blocked_clients'  => Branch::where('status', 'blocked')->count(),
            'total_receivable' => AccountReceivable::whereIn('status', ['pending','partial','overdue'])->sum('balance'),
            'collected_month'  => Payment::where('status', 'approved')
                ->whereMonth('payment_date', $now->month)->sum('amount'),
            'pending_messages' => Conversation::where('queue', 'new_messages')->count(),
            'invoices_to_emit' => ContractedService::where('status', 'active')
                ->whereMonth('next_invoice_date', $now->month)->count(),
        ];

        $overdueClients = AccountReceivable::with(['branch', 'businessGroup', 'invoice'])
            ->whereIn('status', ['overdue', 'partial'])
            ->orderByDesc('days_overdue')
            ->limit(8)
            ->get();

        $recentConversations = Conversation::with(['messages' => fn($q) => $q->latest()->limit(1)])
            ->whereIn('queue', ['new_messages', 'in_progress'])
            ->latest()
            ->limit(6)
            ->get();

        return view('admin.dashboard', compact('stats', 'overdueClients', 'recentConversations'));
    }
}
