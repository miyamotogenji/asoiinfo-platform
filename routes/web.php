<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\{
    DashboardController, BusinessGroupController, LegalEntityController,
    BranchController, ContactController, PlanController,
    ContractedServiceController, CxcController, ReportController,
    ComingSoonController, UserController, InvoiceController,
    AuditLogController
};

// ─── Public ───────────────────────────────────────────────────────────────────
Route::get('/',      fn() => redirect()->route('login'));
Route::get('/admin', fn() => redirect()->route('admin.dashboard'));
Route::get('/login',    [LoginController::class,    'showLoginForm'])->name('login');
Route::post('/login',   [LoginController::class,    'login'])->name('login.post');
Route::post('/logout',  [LoginController::class,    'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register',[RegisterController::class, 'register'])->name('register.post');

// ─── Admin — authenticated ────────────────────────────────────────────────────
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {

    // ── Dashboard ────────────────────────────────────────────────────────────
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── CRM ──────────────────────────────────────────────────────────────────
    Route::resource('grupos',    BusinessGroupController::class);
    Route::resource('empresas',  LegalEntityController::class);
    Route::resource('contactos', ContactController::class);

    // ── Branches ─────────────────────────────────────────────────────────────
    Route::resource('sucursales', BranchController::class);
    Route::get( 'sucursales/{branch}/360',      [BranchController::class, 'view360'])->name('sucursales.360');
    Route::post('sucursales/{branch}/block',    [BranchController::class, 'block'])->name('sucursales.block');
    Route::post('sucursales/{branch}/unblock',  [BranchController::class, 'unblock'])->name('sucursales.unblock');
    Route::post('sucursales/{branch}/bloquear', [CxcController::class, 'blockBranch'])->name('cxc.block-branch');
    Route::post('sucursales/{branch}/desbloquear',[CxcController::class,'unblockBranch'])->name('cxc.unblock-branch');

    // ── Plans & Services ─────────────────────────────────────────────────────
    Route::resource('planes',    PlanController::class);
    Route::resource('servicios', ContractedServiceController::class)->except(['show','edit','update']);
    Route::put('servicios/{servicio}', [ContractedServiceController::class, 'update'])->name('servicios.update');

    // ── M2: Billing & Invoicing (ACTIVE) ─────────────────────────────────────
    Route::get( 'facturas',              [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get( 'facturas/emitir',       [InvoiceController::class, 'toEmit'])->name('invoices.to-emit');
    Route::post('facturas/emitir-batch', [InvoiceController::class, 'emitBatch'])->name('invoices.emit-batch');
    Route::post('facturas/emitir',       [InvoiceController::class, 'emit'])->name('invoices.emit');
    Route::get( 'facturas/{invoice}',    [InvoiceController::class, 'show'])->name('invoices.show');

    // Accounts Receivable & Payments
    Route::get( 'cxc',                             [CxcController::class, 'index'])->name('cxc.index');
    Route::post('cxc/registrar-pago',              [CxcController::class, 'storePayment'])->name('cxc.store-payment');
    Route::get( 'pagos',                           [CxcController::class, 'payments'])->name('payments.index');
    Route::post('pagos/{payment}/aprobar',         [CxcController::class, 'approvePayment'])->name('cxc.approve-payment');
    Route::post('pagos/{payment}/rechazar',        [CxcController::class, 'rejectPayment'])->name('cxc.reject-payment');

    // ── M4: Reports (Excel + PDF) ─────────────────────────────────────────────
    Route::get('reportes/financiero', [ReportController::class, 'financial'])->name('reports.financial');
    Route::get('reportes/soporte',    [ReportController::class, 'support'])->name('reports.support');

    // ── M5: Audit Log ────────────────────────────────────────────────────────
    Route::get('auditoria', [AuditLogController::class, 'index'])->name('audit.index');

    // ── Users & Roles ────────────────────────────────────────────────────────
    Route::resource('usuarios', UserController::class)->except(['show']);

    // Milestone Excel download
    Route::get('milestone-plan', [ComingSoonController::class, 'downloadMilestone'])->name('milestone-download');

    // ── M3: WhatsApp (Coming Soon) ────────────────────────────────────────────
    Route::get('chatbot', [ComingSoonController::class, 'whatsapp'])->name('chatbot.index');
    Route::post('chatbot/{conversation}/attend',   fn() => back())->name('chatbot.attend');
    Route::post('chatbot/{conversation}/close',    fn() => back())->name('chatbot.close');
    Route::post('chatbot/{conversation}/send',     fn() => back())->name('chatbot.send');
    Route::post('chatbot/{conversation}/convert',  fn() => back())->name('chatbot.convert');
    Route::post('chatbot/{conversation}/transfer', fn() => back())->name('chatbot.transfer');

    // ── Integraciones ─────────────────────────────────────────────────────────
    Route::get('integraciones', [ComingSoonController::class, 'ai'])->name('integrations.index');
});
