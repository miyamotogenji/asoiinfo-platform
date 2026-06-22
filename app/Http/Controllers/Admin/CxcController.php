<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AccountReceivable;
use App\Models\Branch;
use App\Models\Payment;
use Illuminate\Http\Request;

class CxcController extends Controller
{
    public function index(Request $request)
    {
        $accounts = AccountReceivable::with(['invoice', 'businessGroup', 'legalEntity', 'branch'])
            ->when($request->status,   fn($q, $s)  => $q->where('status', $s))
            ->when($request->group_id, fn($q, $id) => $q->where('business_group_id', $id))
            ->when($request->branch_id,fn($q, $id) => $q->where('branch_id', $id))
            ->when($request->search,   fn($q, $s)  =>
                $q->whereHas('branch', fn($b) => $b->where('name', 'ilike', "%{$s}%"))
                  ->orWhereHas('invoice', fn($i) => $i->where('number', 'ilike', "%{$s}%")))
            ->orderByDesc('days_overdue')
            ->paginate(25);

        // Refresh days_overdue
        $accounts->each(fn($ar) => $ar->updateDaysOverdue());

        $totals = [
            'total_receivable' => AccountReceivable::whereIn('status', ['pending','partial','overdue'])->sum('balance'),
            'overdue'          => AccountReceivable::where('status', 'overdue')->sum('balance'),
            'pending'          => AccountReceivable::where('status', 'pending')->sum('balance'),
            'paid_month'       => Payment::where('status', 'approved')
                ->whereMonth('payment_date', now()->month)->sum('amount'),
        ];

        return view('admin.cxc.index', compact('accounts', 'totals'));
    }

    public function payments(Request $request)
    {
        $payments = Payment::with(['businessGroup', 'invoice', 'approvedBy', 'branch'])
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest()->paginate(25);

        return view('admin.payments.index', compact('payments'));
    }

    public function approvePayment(Request $request, Payment $payment)
    {
        $payment->approve(auth()->id());
        return back()->with('success', "Pago de \${$payment->amount} aprobado y aplicado.");
    }

    public function rejectPayment(Request $request, Payment $payment)
    {
        $payment->update([
            'status'      => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'notes'       => $request->reason ?? 'Rechazado por administrador',
        ]);
        return back()->with('success', 'Pago rechazado.');
    }

    public function storePayment(Request $request)
    {
        $data = $request->validate([
            'account_receivable_id' => 'required|exists:account_receivables,id',
            'amount'                => 'required|numeric|min:0.01',
            'payment_date'          => 'required|date',
            'payment_method'        => 'required|in:transfer,deposit,cash,check,manual,card',
            'bank'                  => 'nullable|string|max:100',
            'reference_number'      => 'nullable|string|max:100',
            'notes'                 => 'nullable|string',
        ]);

        $ar = AccountReceivable::findOrFail($data['account_receivable_id']);

        Payment::create([
            'business_group_id'     => $ar->business_group_id,
            'legal_entity_id'       => $ar->legal_entity_id,
            'branch_id'             => $ar->branch_id,
            'invoice_id'            => $ar->invoice_id,
            'account_receivable_id' => $ar->id,
            'amount'                => $data['amount'],
            'payment_date'          => $data['payment_date'],
            'payment_method'        => $data['payment_method'],
            'bank'                  => $data['bank'] ?? null,
            'reference_number'      => $data['reference_number'] ?? null,
            'notes'                 => $data['notes'] ?? null,
            'status'                => 'pending',
            'created_by'            => auth()->id(),
        ]);

        return redirect()->route('admin.payments.index')
            ->with('success', "Pago de \${$data['amount']} registrado. Pendiente de aprobación.");
    }

    public function blockBranch(Request $request, Branch $branch)
    {
        $branch->update(['status' => 'blocked']);
        return back()->with('success', "Sucursal '{$branch->name}' bloqueada.");
    }

    public function unblockBranch(Request $request, Branch $branch)
    {
        $branch->update(['status' => 'active']);
        return back()->with('success', "Sucursal '{$branch->name}' desbloqueada.");
    }
}

