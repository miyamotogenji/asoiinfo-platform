<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccountReceivable extends Model
{
    protected $table = 'accounts_receivable';

    protected $fillable = [
        'invoice_id', 'business_group_id', 'legal_entity_id', 'branch_id',
        'amount', 'balance', 'due_date', 'days_overdue', 'status', 'observations',
    ];

    protected $casts = [
        'due_date' => 'date',
        'amount'   => 'decimal:2',
        'balance'  => 'decimal:2',
    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function businessGroup(): BelongsTo
    {
        return $this->belongsTo(BusinessGroup::class);
    }

    public function legalEntity(): BelongsTo
    {
        return $this->belongsTo(LegalEntity::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function updateDaysOverdue(): void
    {
        if ($this->due_date && $this->due_date->isPast()) {
            $this->days_overdue = $this->due_date->diffInDays(now());
            if ($this->status === 'pending') {
                $this->status = 'overdue';
            }
            $this->save();
        }
    }

    public function applyPayment(float $amount): void
    {
        $this->balance = max(0, $this->balance - $amount);
        if ($this->balance <= 0) {
            $this->status = 'paid';
        } elseif ($this->balance < $this->amount) {
            $this->status = 'partial';
        }
        $this->save();
    }
}
