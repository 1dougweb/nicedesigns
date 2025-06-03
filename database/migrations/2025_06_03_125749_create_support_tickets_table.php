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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Cliente
            $table->foreignId('client_project_id')->nullable()->constrained()->onDelete('set null'); // Projeto relacionado
            $table->foreignId('assigned_to')->nullable()->constrained('users')->onDelete('set null'); // Admin responsável
            
            // Informações do ticket
            $table->string('subject');
            $table->text('description');
            $table->enum('category', [
                'suporte_tecnico', 'bug_report', 'nova_funcionalidade', 
                'duvida', 'alteracao_projeto', 'financeiro', 'outro'
            ])->default('suporte_tecnico');
            
            // Status e prioridade
            $table->enum('status', ['aberto', 'em_andamento', 'aguardando_cliente', 'resolvido', 'fechado'])->default('aberto');
            $table->enum('priority', ['baixa', 'normal', 'alta', 'urgente'])->default('normal');
            
            // Tempos de resposta (SLA)
            $table->timestamp('first_response_at')->nullable();
            $table->timestamp('last_response_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamp('closed_at')->nullable();
            
            // Avaliação do atendimento
            $table->integer('satisfaction_rating')->nullable(); // 1-5
            $table->text('feedback')->nullable();
            
            // Anexos e referências
            $table->json('attachments')->nullable();
            $table->text('internal_notes')->nullable(); // Visível apenas para admins
            
            $table->timestamps();
            
            // Índices
            $table->index(['user_id', 'status']);
            $table->index(['status', 'priority']);
            $table->index('ticket_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
