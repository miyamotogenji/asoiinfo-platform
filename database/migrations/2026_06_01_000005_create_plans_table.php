<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->enum('type', ['recurring', 'one_time'])->default('recurring');
            $table->enum('period', ['monthly', 'annual', 'quarterly', 'biannual'])->default('monthly');
            $table->decimal('price_without_iva', 10, 2);
            $table->decimal('iva_rate', 5, 2)->default(15.00);
            $table->decimal('total_price', 10, 2)->storedAs('price_without_iva * (1 + iva_rate / 100)');
            $table->string('billable_product')->nullable();
            $table->boolean('auto_block')->default(false);
            $table->integer('grace_days')->default(5);
            $table->integer('billing_day_suggestion')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
