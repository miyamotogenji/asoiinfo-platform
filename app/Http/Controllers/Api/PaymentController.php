<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\AccountReceivable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Receive payment notification from bank/gateway webhook.
     */
    public function webhook(Request $request): JsonResponse
    {
        Log::info('Payment webhook received', $request->all());

        $payment = Payment::create([
            'amount'           => $request->amount ?? 0,
            'payment_date'     => $request->date ?? now()->toDateString(),
            'payment_method'   => $request->method ?? 'transfer',
            'bank'             => $request->bank,
            'reference_number' => $request->reference,
            'status'           => 'pending_review',
            'notes'            => 'Received via webhook: ' . json_encode($request->all()),
        ]);

        return response()->json(['received' => true, 'payment_id' => $payment->id]);
    }

    public function index(Request $request): JsonResponse
    {
        $payments = Payment::with(['businessGroup', 'invoice', 'approvedBy'])
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(25);

        return response()->json($payments);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'account_receivable_id' => 'required|exists:accounts_receivable,id',
            'amount'                => 'required|numeric|min:0.01',
            'payment_date'          => 'required|date',
            'payment_method'        => 'required|in:transfer,deposit,gateway,cash,check,manual',
            'bank'                  => 'nullable|string',
            'reference_number'      => 'nullable|string',
            'notes'                 => 'nullable|string',
        ]);

        $ar      = AccountReceivable::findOrFail($data['account_receivable_id']);
        $payment = Payment::create([
            ...$data,
            'business_group_id' => $ar->business_group_id,
            'legal_entity_id'   => $ar->legal_entity_id,
            'branch_id'         => $ar->branch_id,
            'invoice_id'        => $ar->invoice_id,
            'status'            => 'pending_review',
            'created_by'        => auth()->id(),
        ]);

        return response()->json($payment, 201);
    }

    public function approve(Payment $payment): JsonResponse
    {
        $payment->approve(auth()->id());
        return response()->json(['message' => 'Pago aprobado', 'payment' => $payment]);
    }

    public function reject(Request $request, Payment $payment): JsonResponse
    {
        $payment->update([
            'status'      => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'notes'       => $request->reason,
        ]);
        return response()->json(['message' => 'Pago rechazado']);
    }
}
