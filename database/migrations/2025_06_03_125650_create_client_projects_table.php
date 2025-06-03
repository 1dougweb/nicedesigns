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
        Schema::create('client_projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Cliente
            $table->foreignId('project_id')->nullable()->constrained()->onDelete('set null'); // Projeto público (opcional)
            
            // Informações básicas
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('requirements')->nullable();
            $table->decimal('budget', 10, 2)->nullable();
            $table->string('currency', 3)->default('BRL');
            
            // Status e progresso
            $table->enum('status', [
                'aguardando_aprovacao', 'em_andamento', 'pausado', 
                'aguardando_cliente', 'em_revisao', 'concluido', 'cancelado'
            ])->default('aguardando_aprovacao');
            $table->integer('progress_percentage')->default(0); // 0-100
            
            // Etapas do projeto
            $table->json('stages')->nullable(); // Array com etapas e status
            $table->string('current_stage')->nullable();
            
            // Tecnologias e tags
            $table->json('technologies')->nullable(); // Array de tecnologias
            $table->json('tags')->nullable(); // Tags adicionais
            
            // Datas importantes
            $table->date('start_date')->nullable();
            $table->date('estimated_completion')->nullable();
            $table->date('actual_completion')->nullable();
            $table->date('deadline')->nullable();
            
            // URLs e arquivos
            $table->string('preview_url')->nullable();
            $table->string('live_url')->nullable();
            $table->string('repository_url')->nullable();
            $table->json('files')->nullable(); // Array de arquivos
            
            // Informações de contrato
            $table->text('contract_details')->nullable();
            $table->enum('priority', ['baixa', 'normal', 'alta', 'urgente'])->default('normal');
            
            // Comunicação
            $table->text('last_update')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            
            // Avaliação (após conclusão)
            $table->integer('rating')->nullable(); // 1-5 estrelas
            $table->text('client_feedback')->nullable();
            
            $table->timestamps();
            
            // Índices
            $table->index(['user_id', 'status']);
            $table->index(['status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_projects');
    }
};
