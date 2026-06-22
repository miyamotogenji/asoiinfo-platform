<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'conversation_id', 'whatsapp_message_id', 'direction', 'type',
        'body', 'media_path', 'media_mime', 'is_internal_note',
        'is_read', 'sent_by', 'delivered_at', 'read_at',
    ];

    protected $casts = [
        'is_internal_note' => 'boolean',
        'is_read'          => 'boolean',
        'delivered_at'     => 'datetime',
        'read_at'          => 'datetime',
    ];

    public function conversation(): BelongsTo
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by');
    }
}
