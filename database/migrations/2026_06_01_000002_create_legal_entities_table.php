<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('legal_entities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_group_id')->constrained()->cascadeOnDelete();
            $table->string('ruc', 13)->unique();
            $table->string('legal_name');
            $table->string('trade_name')->nullable();
            $table->text('address')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->boolean('required_accounting')->default(false);
            $table->enum('taxpayer_type', ['natural', 'juridical', 'public'])->default('juridical');
            $table->enum('status', ['active', 'suspended', 'blocked', 'inactive'])->default('active');
            $table->text('observations')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('legal_entities');
    }
};
