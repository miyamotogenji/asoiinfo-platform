<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BusinessGroupController;
use App\Http\Controllers\Admin\LegalEntityController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\ContractedServiceController;
use App\Http\Controllers\Admin\CxcController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ComingSoonController;
use App\Http\Controllers\Admin\UserController;

// ─── Public ──────────────────────────────────────────────────────────────────
Route::get('/',      fn() => redirect()->route('login'));
Route::get('/admin', fn() => redirect()->route('admin.dashboard'));
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login',[LoginController::class, 'login'])->name('login.post');
Route::post('/logout',[LoginController::class,'logout'])->name('logout');

// ─── Admin — authenticated ───────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // ══════════════════════════════════════════════════════════════════════════
    // PHASE 1 — ACTIVE (Demo today)
    // ══════════════════════════════════════════════════════════════════════════

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRM
    Route::resource('grupos',    BusinessGroupController::class);
    Route::resource('empresas',  LegalEntityController::class);
    Route::resource('contactos', ContactController::class);

    // Branches
    Route::resource('sucursales', BranchController::class);
    Route::get( 'sucursales/{branch}/360',     [BranchController::class, 'view360'])->name('sucursales.360');
    Route::post('sucursales/{branch}/block',   [BranchController::class, 'block'])->name('sucursales.block');
    Route::post('sucursales/{branch}/unblock', [BranchController::class, 'unblock'])->name('sucursales.unblock');

    // Plans & contracted services
    Route::resource('planes',    PlanController::class);
    Route::resource('servicios', ContractedServiceController::class)->except(['show','edit','update']);
    Route::put('servicios/{servicio}', [ContractedServiceController::class, 'update'])->name('servicios.update');

    // Reports
    Route::get('reportes/financiero', [ReportController::class, 'financial'])->name('reports.financial');
    Route::get('reportes/soporte',    [ReportController::class, 'support'])->name('reports.support');

    // Users & Roles (M1)
    Route::resource('usuarios', UserController::class)->except(['show']);

    // Milestone Excel download
    Route::get('milestone-plan', [ComingSoonController::class, 'downloadMilestone'])->name('milestone-download');

    // ══════════════════════════════════════════════════════════════════════════
    // PHASE 2 — Coming Soon (Billing & Accounts Receivable)
    // ══════════════════════════════════════════════════════════════════════════

    Route::get('facturas/emitir',       [ComingSoonController::class, 'billing'])->name('invoices.to-emit');
    Route::get('facturas',              [ComingSoonController::class, 'billing'])->name('invoices.index');
    Route::post('facturas/emitir-batch',fn() => back())->name('invoices.emit-batch');
    Route::get('cxc',                   [ComingSoonController::class, 'billing'])->name('cxc.index');
    Route::post('cxc/registrar-pago',   fn() => back())->name('cxc.store-payment');
    Route::get('pagos',                 [ComingSoonController::class, 'billing'])->name('payments.index');
    Route::post('pagos/{payment}/aprobar', fn() => back())->name('cxc.approve-payment');
    Route::post('pagos/{payment}/rechazar',fn() => back())->name('cxc.reject-payment');

    // Block/unblock from CxC (still works in phase 1 from branch view)
    Route::post('sucursales/{branch}/bloquear',   [CxcController::class, 'blockBranch'])->name('cxc.block-branch');
    Route::post('sucursales/{branch}/desbloquear',[CxcController::class, 'unblockBranch'])->name('cxc.unblock-branch');

    // ══════════════════════════════════════════════════════════════════════════
    // PHASE 3 — Coming Soon (WhatsApp Omnichannel)
    // ══════════════════════════════════════════════════════════════════════════

    Route::get('chatbot', [ComingSoonController::class, 'whatsapp'])->name('chatbot.index');
    Route::post('chatbot/{conversation}/attend',  fn() => back())->name('chatbot.attend');
    Route::post('chatbot/{conversation}/close',   fn() => back())->name('chatbot.close');
    Route::post('chatbot/{conversation}/send',    fn() => back())->name('chatbot.send');
    Route::post('chatbot/{conversation}/convert', fn() => back())->name('chatbot.convert');
    Route::post('chatbot/{conversation}/transfer',fn() => back())->name('chatbot.transfer');

    // ══════════════════════════════════════════════════════════════════════════
    // PHASE 4 — Coming Soon (AI & SRI)
    // ══════════════════════════════════════════════════════════════════════════

    Route::get('integraciones', [ComingSoonController::class, 'ai'])->name('integrations.index');
});
