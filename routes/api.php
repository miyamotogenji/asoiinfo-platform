<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\BusinessGroupController;
use App\Http\Controllers\Api\LegalEntityController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\ContractedServiceController;
use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\AccountReceivableController;
use App\Http\Controllers\Api\WhatsAppController;

// ─── WhatsApp Webhooks (public) ──────────────────────────────────────────────
Route::prefix('v1/whatsapp')->name('whatsapp.')->group(function () {
    Route::get( 'webhook', [WhatsAppController::class, 'verify'])->name('verify');
    Route::post('webhook', [WhatsAppController::class, 'receive'])->name('receive');
});

// ─── Payment Webhook (public) ────────────────────────────────────────────────
Route::post('v1/payments/webhook', [PaymentController::class, 'webhook'])->name('payments.webhook');

// ─── Auth ────────────────────────────────────────────────────────────────────
Route::prefix('v1/auth')->group(function () {
    Route::post('login',  [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get( 'me',     [AuthController::class, 'me']);
    });
});

// ─── Authenticated API ───────────────────────────────────────────────────────
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index']);

    // Multi-company structure
    Route::apiResource('business-groups', BusinessGroupController::class);
    Route::get('business-groups/{businessGroup}/overview', [BusinessGroupController::class, 'overview']);

    Route::apiResource('legal-entities', LegalEntityController::class);
    Route::apiResource('contacts',       ContactController::class);

    Route::apiResource('branches', BranchController::class);
    Route::post('branches/{branch}/block',   [BranchController::class, 'block']);
    Route::post('branches/{branch}/unblock', [BranchController::class, 'unblock']);
    Route::get( 'branches/{branch}/360',     [BranchController::class, 'view360']);

    // Plans & services
    Route::apiResource('plans',    PlanController::class);
    Route::apiResource('services', ContractedServiceController::class);

    // Invoicing
    Route::get( 'invoices/to-emit',    [InvoiceController::class, 'toEmitThisMonth']);
    Route::post('invoices/emit-batch', [InvoiceController::class, 'emitBatch']);
    Route::post('invoices/{invoice}/emit', [InvoiceController::class, 'emit']);
    Route::apiResource('invoices', InvoiceController::class)->only(['index', 'show']);

    // Accounts receivable
    Route::get('cxc/summary', [AccountReceivableController::class, 'summary']);
    Route::apiResource('cxc', AccountReceivableController::class)->only(['index', 'show', 'update']);

    // Payments
    Route::apiResource('payments', PaymentController::class)->only(['index', 'show', 'store']);
    Route::post('payments/{payment}/approve', [PaymentController::class, 'approve']);
    Route::post('payments/{payment}/reject',  [PaymentController::class, 'reject']);

    // WhatsApp chatbot
    Route::prefix('whatsapp')->group(function () {
        Route::get('inbox',                                              [WhatsAppController::class, 'inbox']);
        Route::post('send',                                             [WhatsAppController::class, 'send']);
        Route::post('conversations/{conversation}/attend',             [WhatsAppController::class, 'attend']);
        Route::post('conversations/{conversation}/close',              [WhatsAppController::class, 'close']);
        Route::post('conversations/{conversation}/transfer',           [WhatsAppController::class, 'transfer']);
        Route::get( 'conversations/{conversation}/messages',           [WhatsAppController::class, 'messages']);
    });
});
