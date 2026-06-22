<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accounts_receivable', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
            $table->foreignId('business_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('legal_entity_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 10, 2);
            $table->decimal('balance', 10, 2);
            $table->date('due_date');
            $table->integer('days_overdue')->default(0);
            $table->enum('status', [
                'pending', 'paid', 'partial', 'overdue',
                'in_agreement', 'cancelled', 'under_review'
            ])->default('pending');
            $table->text('observations')->nullable();
            $table->timestamps();
        });

        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_group_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('legal_entity_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('account_receivable_id')->nullable()->constrained('accounts_receivable')->nullOnDelete();
            $table->decimal('amount', 10, 2);
            $table->date('payment_date');
            $table->enum('payment_method', ['transfer', 'deposit', 'gateway', 'cash', 'check', 'manual'])->default('transfer');
            $table->string('bank')->nullable();
            $table->string('reference_number')->nullable();
            $table->string('voucher_path')->nullable();
            $table->enum('status', ['pending_review', 'approved', 'rejected', 'under_observation'])->default('pending_review');
            $table->text('notes')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('accounts_receivable');
    }
};
