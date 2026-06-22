<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'business_group_id', 'legal_entity_id', 'branch_id',
        'name', 'phone', 'whatsapp', 'email', 'position',
        'authorized_support', 'authorized_invoices', 'authorized_quotes',
        'type', 'status', 'notes', 'created_by',
    ];

    protected $casts = [
        'authorized_support'  => 'boolean',
        'authorized_invoices' => 'boolean',
        'authorized_quotes'   => 'boolean',
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

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public static function findByWhatsapp(string $phone): ?self
    {
        return static::where('whatsapp', $phone)->first();
    }
}
