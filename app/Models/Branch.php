<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Branch extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'legal_entity_id', 'business_group_id', 'code', 'name',
        'address', 'city', 'phone', 'whatsapp', 'responsible_name',
        'status', 'service_start_date', 'billing_day', 'next_billing_date',
        'observations', 'created_by',
    ];

    protected $casts = [
        'service_start_date' => 'date',
        'next_billing_date' => 'date',
    ];

    public function businessGroup(): BelongsTo
    {
        return $this->belongsTo(BusinessGroup::class);
    }

    public function legalEntity(): BelongsTo
    {
        return $this->belongsTo(LegalEntity::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function contractedServices(): HasMany
    {
        return $this->hasMany(ContractedService::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function accountsReceivable(): HasMany
    {
        return $this->hasMany(AccountReceivable::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public function getFinancialStatusAttribute(): string
    {
        $overdue = $this->accountsReceivable()
            ->whereIn('status', ['overdue', 'pending'])
            ->where('due_date', '<', now())
            ->exists();

        if ($this->status === 'blocked') return 'blocked';
        if ($overdue) return 'overdue';

        $dueSoon = $this->accountsReceivable()
            ->where('status', 'pending')
            ->whereBetween('due_date', [now(), now()->addDays(5)])
            ->exists();

        if ($dueSoon) return 'due_soon';
        return 'current';
    }

    public function getTotalBalanceAttribute(): float
    {
        return $this->accountsReceivable()
            ->whereIn('status', ['pending', 'partial', 'overdue'])
            ->sum('balance');
    }
}
