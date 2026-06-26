<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\{Auth, Request};

class AuditLog extends Model
{
    protected $fillable = ['user_id','action','model_type','model_id','old_values','new_values','ip_address','user_agent'];
    protected $casts    = ['old_values'=>'array','new_values'=>'array'];

    public function user(): BelongsTo { return $this->belongsTo(User::class); }

    public static function log(string $action, string $modelType = '', int $modelId = 0, array $old = [], array $new = []): void
    {
        static::create([
            'user_id'    => Auth::id(),
            'action'     => $action,
            'model_type' => $modelType,
            'model_id'   => $modelId ?: null,
            'old_values' => $old ?: null,
            'new_values' => $new ?: null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
