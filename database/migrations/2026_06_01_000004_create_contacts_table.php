<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_group_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('legal_entity_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('phone', 20)->nullable();
            $table->string('whatsapp', 20)->unique()->nullable();
            $table->string('email')->nullable();
            $table->string('position')->nullable();
            $table->boolean('authorized_support')->default(false);
            $table->boolean('authorized_invoices')->default(false);
            $table->boolean('authorized_quotes')->default(false);
            $table->enum('type', ['employee', 'prospect', 'unknown'])->default('employee');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
