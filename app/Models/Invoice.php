<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'number', 'business_group_id', 'legal_entity_id', 'branch_id',
        'contracted_service_id', 'period_label', 'issue_date', 'due_date',
        'subtotal', 'iva_amount', 'total', 'status',
        'electronic_auth', 'pdf_path', 'xml_path',
        'whatsapp_sent', 'email_sent', 'observations', 'emitted_by',
    ];

    protected $casts = [
        'issue_date'    => 'date',
        'due_date'      => 'date',
        'subtotal'      => 'decimal:2',
        'iva_amount'    => 'decimal:2',
        'total'         => 'decimal:2',
        'whatsapp_sent' => 'boolean',
        'email_sent'    => 'boolean',
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

    public function contractedService(): BelongsTo
    {
        return $this->belongsTo(ContractedService::class);
    }

    public function accountReceivable(): HasOne
    {
        return $this->hasOne(AccountReceivable::class);
    }

    public function emittedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'emitted_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft'             => 'Borrador',
            'pending_emission'  => 'Pendiente emisión',
            'emitted'           => 'Emitida',
            'sent'              => 'Enviada',
            'paid'              => 'Pagada',
            'partial'           => 'Pago parcial',
            'overdue'           => 'Vencida',
            'cancelled'         => 'Anulada',
            'excluded'          => 'Excluida',
            default             => $this->status,
        };
    }

    public function generateNumber(): string
    {
        $last = static::withTrashed()->whereNotNull('number')->max('number');
        $next = $last ? (int) substr($last, -6) + 1 : 1;
        return 'FAC-' . now()->year . '-' . str_pad($next, 6, '0', STR_PAD_LEFT);
    }
}
