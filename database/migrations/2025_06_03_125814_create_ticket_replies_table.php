<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ticket_replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('support_ticket_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Quem respondeu
            
            // Conteúdo da resposta
            $table->text('message');
            $table->json('attachments')->nullable();
            
            // Tipo de resposta
            $table->enum('type', ['reply', 'internal_note', 'status_change'])->default('reply');
            $table->boolean('is_internal')->default(false); // Visível apenas para admins
            
            // Timestamps
            $table->timestamp('read_at')->nullable(); // Quando foi lida
            
            $table->timestamps();
            
            // Índices
            $table->index(['support_ticket_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_replies');
    }
};
