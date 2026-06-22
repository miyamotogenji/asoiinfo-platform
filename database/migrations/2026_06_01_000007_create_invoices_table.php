<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique()->nullable();
            $table->foreignId('business_group_id')->constrained()->cascadeOnDelete();
            $table->foreignId('legal_entity_id')->constrained()->cascadeOnDelete();
            $table->foreignId('branch_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contracted_service_id')->nullable()->constrained()->nullOnDelete();
            $table->string('period_label')->nullable();
            $table->date('issue_date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('iva_amount', 10, 2);
            $table->decimal('total', 10, 2);
            $table->enum('status', [
                'draft', 'pending_emission', 'emitted', 'sent',
                'paid', 'partial', 'overdue', 'cancelled', 'excluded'
            ])->default('draft');
            $table->string('electronic_auth')->nullable();
            $table->string('pdf_path')->nullable();
            $table->string('xml_path')->nullable();
            $table->boolean('whatsapp_sent')->default(false);
            $table->boolean('email_sent')->default(false);
            $table->text('observations')->nullable();
            $table->foreignId('emitted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
