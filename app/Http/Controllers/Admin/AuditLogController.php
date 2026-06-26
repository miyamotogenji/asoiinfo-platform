<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = AuditLog::with('user')
            ->when($request->user_id,   fn($q,$id) => $q->where('user_id',$id))
            ->when($request->action,    fn($q,$a)  => $q->where('action',$a))
            ->when($request->model,     fn($q,$m)  => $q->where('model_type','like',"%{$m}%"))
            ->when($request->from,      fn($q,$d)  => $q->whereDate('created_at','>=',$d))
            ->when($request->to,        fn($q,$d)  => $q->whereDate('created_at','<=',$d))
            ->orderByDesc('created_at')
            ->paginate(50)->withQueryString();

        $actions = AuditLog::select('action')->distinct()->pluck('action');

        return view('admin.audit.index', compact('logs','actions'));
    }
}
