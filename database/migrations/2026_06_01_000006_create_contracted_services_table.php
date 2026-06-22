<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracted_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('legal_entity_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('plan_id')->constrained()->cascadeOnDelete();
            $table->date('start_date');
            $table->enum('period', ['monthly', 'annual', 'quarterly', 'biannual'])->default('monthly');
            $table->decimal('value', 10, 2);
            $table->decimal('iva_amount', 10, 2);
            $table->decimal('total_value', 10, 2);
            $table->integer('billing_day')->default(1);
            $table->date('next_invoice_date');
            $table->enum('status', [
                'active', 'suspended', 'blocked', 'cancelled',
                'installing', 'trial', 'payment_agreement'
            ])->default('active');
            $table->integer('grace_days')->default(5);
            $table->boolean('auto_block')->default(false);
            $table->text('observations')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracted_services');
    }
};
