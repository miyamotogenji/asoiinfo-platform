<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessGroup extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code', 'name', 'status', 'observations', 'created_by',
    ];

    public function legalEntities(): HasMany
    {
        return $this->hasMany(LegalEntity::class);
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function contractedServices(): HasMany
    {
        return $this->hasMany(ContractedService::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getFinancialStatusAttribute(): string
    {
        $overdue = $this->branches()
            ->where('status', 'blocked')->count();
        if ($overdue > 0) return 'blocked';

        $due = AccountReceivable::whereHas('branch', fn($q) => $q->where('business_group_id', $this->id))
            ->where('status', 'overdue')->exists();
        if ($due) return 'overdue';

        return 'current';
    }
}
