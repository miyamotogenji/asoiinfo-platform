<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LegalEntity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'business_group_id', 'ruc', 'legal_name', 'trade_name',
        'address', 'phone', 'email', 'required_accounting',
        'taxpayer_type', 'status', 'observations', 'created_by',
    ];

    protected $casts = [
        'required_accounting' => 'boolean',
    ];

    public function businessGroup(): BelongsTo
    {
        return $this->belongsTo(BusinessGroup::class);
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
