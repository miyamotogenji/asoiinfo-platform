<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone_number');
            $table->string('phone_number_id')->unique();
            $table->enum('purpose', ['support', 'sales', 'billing', 'general'])->default('support');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('whatsapp_number_id')->constrained()->cascadeOnDelete();
            $table->string('contact_phone', 20);
            $table->string('contact_name')->nullable();
            $table->foreignId('contact_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('branch_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('business_group_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assigned_agent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('queue', ['new_messages', 'in_progress', 'new_prospects', 'closed'])->default('new_messages');
            $table->enum('financial_status', ['current', 'due_soon', 'overdue', 'blocked', 'unknown'])->default('unknown');
            $table->string('subject')->nullable();
            $table->timestamp('attended_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            $table->integer('response_time_minutes')->nullable();
            $table->text('outcome_notes')->nullable();
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained()->cascadeOnDelete();
            $table->string('whatsapp_message_id')->nullable()->unique();
            $table->enum('direction', ['inbound', 'outbound'])->default('inbound');
            $table->enum('type', ['text', 'image', 'document', 'audio', 'video', 'template', 'note'])->default('text');
            $table->text('body')->nullable();
            $table->string('media_path')->nullable();
            $table->string('media_mime')->nullable();
            $table->boolean('is_internal_note')->default(false);
            $table->boolean('is_read')->default(false);
            $table->foreignId('sent_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('conversations');
        Schema::dropIfExists('whatsapp_numbers');
    }
};
