<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'business_group_id', 'legal_entity_id', 'branch_id',
        'invoice_id', 'account_receivable_id', 'amount', 'payment_date',
        'payment_method', 'bank', 'reference_number', 'voucher_path',
        'status', 'notes', 'approved_by', 'approved_at', 'created_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'approved_at'  => 'datetime',
        'amount'       => 'decimal:2',
    ];

    public function businessGroup(): BelongsTo
    {
        return $this->belongsTo(BusinessGroup::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function accountReceivable(): BelongsTo
    {
        return $this->belongsTo(AccountReceivable::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function approve(int $userId): void
    {
        $this->status      = 'approved';
        $this->approved_by = $userId;
        $this->approved_at = now();
        $this->save();

        if ($this->accountReceivable) {
            $this->accountReceivable->applyPayment($this->amount);
        }

        $br = $this->branch()->first();
        if ($br && $br->status === 'blocked') {
            $outstanding = $br->accountsReceivable()
                ->whereIn('status', ['pending', 'partial', 'overdue'])
                ->sum('balance');
            if ($outstanding <= 0) {
                $br->update(['status' => 'active']);
            }
        }
    }
}
