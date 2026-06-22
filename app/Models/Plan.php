<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'name', 'type', 'period', 'price_without_iva',
        'iva_rate', 'billable_product', 'auto_block', 'grace_days',
        'billing_day_suggestion', 'status', 'description',
    ];

    protected $casts = [
        'auto_block'       => 'boolean',
        'price_without_iva' => 'decimal:2',
        'iva_rate'         => 'decimal:2',
        'total_price'      => 'decimal:2',
    ];

    public function contractedServices(): HasMany
    {
        return $this->hasMany(ContractedService::class);
    }

    public function getTotalPriceAttribute(): float
    {
        return round($this->price_without_iva * (1 + $this->iva_rate / 100), 2);
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
}
