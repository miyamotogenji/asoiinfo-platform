<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Conversation extends Model
{
    protected $fillable = [
        'whatsapp_number_id', 'contact_phone', 'contact_name',
        'contact_id', 'branch_id', 'business_group_id', 'assigned_agent_id',
        'queue', 'financial_status', 'subject',
        'attended_at', 'closed_at', 'response_time_minutes', 'outcome_notes',
    ];

    protected $casts = [
        'attended_at' => 'datetime',
        'closed_at'   => 'datetime',
    ];

    public function whatsappNumber(): BelongsTo
    {
        return $this->belongsTo(WhatsappNumber::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    public function businessGroup(): BelongsTo
    {
        return $this->belongsTo(BusinessGroup::class);
    }

    public function assignedAgent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_agent_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage(): HasMany
    {
        return $this->hasMany(Message::class)->latest()->limit(1);
    }

    public function attend(int $agentId): void
    {
        $this->queue             = 'in_progress';
        $this->assigned_agent_id = $agentId;
        $this->attended_at       = now();
        $this->save();
    }

    public function close(string $notes = ''): void
    {
        $this->queue             = 'closed';
        $this->closed_at         = now();
        $this->outcome_notes     = $notes;
        if ($this->attended_at) {
            $this->response_time_minutes = $this->attended_at->diffInMinutes(now());
        }
        $this->save();
    }

    public function resolveFinancialStatus(): string
    {
        if (!$this->branch_id) return 'unknown';
        return $this->branch->financial_status;
    }
}
