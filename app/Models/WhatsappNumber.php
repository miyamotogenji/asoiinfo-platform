<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WhatsappNumber extends Model
{
    protected $fillable = [
        'name', 'phone_number', 'phone_number_id', 'purpose', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }
}
