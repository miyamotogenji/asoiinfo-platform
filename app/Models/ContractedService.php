<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class ContractedService extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'business_group_id', 'legal_entity_id', 'branch_id', 'plan_id',
        'start_date', 'period', 'value', 'iva_amount', 'total_value',
        'billing_day', 'next_invoice_date', 'status',
        'grace_days', 'auto_block', 'observations', 'created_by',
    ];

    protected $casts = [
        'start_date'        => 'date',
        'next_invoice_date' => 'date',
        'auto_block'        => 'boolean',
        'value'             => 'decimal:2',
        'iva_amount'        => 'decimal:2',
        'total_value'       => 'decimal:2',
    ];

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

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function getPeriodLabelAttribute(): string
    {
        return match($this->period) {
            'monthly'   => 'Mensual',
            'annual'    => 'Anual',
            'quarterly' => 'Trimestral',
            'biannual'  => 'Semestral',
            default     => $this->period,
        };
    }

    public function isDueThisMonth(): bool
    {
        if (!$this->next_invoice_date) return false;
        return $this->next_invoice_date->month === now()->month
            && $this->next_invoice_date->year === now()->year;
    }

    public function advanceNextInvoiceDate(): void
    {
        $this->next_invoice_date = match($this->period) {
            'monthly'   => $this->next_invoice_date->addMonth(),
            'annual'    => $this->next_invoice_date->addYear(),
            'quarterly' => $this->next_invoice_date->addMonths(3),
            'biannual'  => $this->next_invoice_date->addMonths(6),
            default     => $this->next_invoice_date->addMonth(),
        };
        $this->save();
    }
}
