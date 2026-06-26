<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{AccountReceivable, Payment, Conversation, Branch, ContractedService};
use App\Exports\{FinancialReportExport, InvoicesExport};
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function financial()
    {
        $now = Carbon::now();

        $data = [
            'total_receivable'    => AccountReceivable::whereIn('status', ['pending','partial','overdue'])->sum('balance'),
            'total_overdue'       => AccountReceivable::where('status', 'overdue')->sum('balance'),
            'total_pending'       => AccountReceivable::where('status', 'pending')->sum('balance'),
            'collected_month'     => Payment::where('status', 'approved')->whereMonth('payment_date', $now->month)->sum('amount'),
            'collected_year'      => Payment::where('status', 'approved')->whereYear('payment_date', $now->year)->sum('amount'),
            'blocked_clients'     => Branch::where('status', 'blocked')->count(),
            'overdue_clients'     => Branch::where('status', 'active')
                ->whereHas('accountsReceivable', fn($q) => $q->where('status', 'overdue'))->count(),
            'mrr'                 => ContractedService::where('status', 'active')->where('period', 'monthly')->sum('total_value'),
            'arr'                 => ContractedService::where('status', 'active')->where('period', 'annual')->sum('total_value'),
            'payments_pending'    => Payment::where('status', 'pending_review')->count(),
            'payments_pending_amount' => Payment::where('status', 'pending_review')->sum('amount'),
        ];

        $monthlyHistory = collect(range(5, 0))->map(function ($i) use ($now) {
            $month = $now->copy()->subMonths($i);
            return [
                'month'     => $month->format('M Y'),
                'collected' => Payment::where('status', 'approved')
                    ->whereMonth('payment_date', $month->month)
                    ->whereYear('payment_date', $month->year)
                    ->sum('amount'),
            ];
        });

        $overdueList = AccountReceivable::with(['branch', 'businessGroup', 'invoice'])
            ->whereIn('status', ['overdue', 'partial'])
            ->orderByDesc('days_overdue')
            ->limit(20)->get();

        if (request('export') === 'excel') {
            return (new FinancialReportExport)->download();
        }
        if (request('export') === 'pdf') {
            $pdf = Pdf::loadView('admin.reports.financial-pdf', compact('data','monthlyHistory','overdueList'))
                ->setPaper('a4','landscape');
            return $pdf->download('reporte-financiero-'.now()->format('Ymd').'.pdf');
        }

        return view('admin.reports.financial', compact('data', 'monthlyHistory', 'overdueList'));
    }

    public function support()
    {
        $now = Carbon::now();

        $data = [
            'total_conversations'   => Conversation::whereMonth('created_at', $now->month)->count(),
            'attended'              => Conversation::whereMonth('created_at', $now->month)->whereNotNull('attended_at')->count(),
            'pending'               => Conversation::where('queue', 'new_messages')->count(),
            'avg_response_minutes'  => Conversation::whereNotNull('response_time_minutes')->avg('response_time_minutes'),
            'prospects'             => Conversation::where('queue', 'new_prospects')->count(),
            'closed_today'          => Conversation::where('queue', 'closed')->whereDate('closed_at', today())->count(),
        ];

        $agentStats = \App\Models\User::whereHas('conversations', fn($q) =>
            $q->whereMonth('attended_at', $now->month)
        )->withCount(['conversations as attended_this_month' => fn($q) =>
            $q->whereMonth('attended_at', $now->month)
        ])->get();

        $recentConversations = Conversation::with(['contact', 'assignedAgent', 'branch'])
            ->where('queue', 'closed')
            ->latest('closed_at')
            ->limit(15)
            ->get();

        return view('admin.reports.support', compact('data', 'agentStats', 'recentConversations'));
    }
}
